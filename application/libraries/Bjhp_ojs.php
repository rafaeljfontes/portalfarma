<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Bjhp_ojs
{
    private $config;

    public function __construct($config = array()) { $this->config = $config; }

    protected function request($path, $query = array())
    {
        $base = rtrim($this->config['ojs_url'], '/');
        if (parse_url($base, PHP_URL_SCHEME) !== 'https' || empty($this->config['ojs_token'])) {
            throw new RuntimeException('Configure a URL HTTPS e o token da API OJS no servidor.');
        }
        if (!function_exists('curl_init')) throw new RuntimeException('A extensão cURL não está disponível.');
        if (!preg_match('~/api/v1$~', $base)) {
            throw new RuntimeException('A URL da OJS deve terminar em /api/v1. Verifique BJHP_OJS_URL.');
        }
        $query['apiToken'] = $this->config['ojs_token'];
        $curl = curl_init($base . '/' . $path . '?' . http_build_query($query));
        curl_setopt_array($curl, array(CURLOPT_RETURNTRANSFER => true, CURLOPT_CONNECTTIMEOUT => 10,
            CURLOPT_TIMEOUT => 45, CURLOPT_FOLLOWLOCATION => false, CURLOPT_SSL_VERIFYPEER => true,
            CURLOPT_SSL_VERIFYHOST => 2, CURLOPT_HTTPHEADER => array('Accept: application/json')));
        if (!empty($this->config['ojs_ca_bundle'])) {
            if (!is_readable($this->config['ojs_ca_bundle'])) {
                curl_close($curl);
                throw new RuntimeException('Arquivo de certificados HTTPS indisponível. Verifique BJHP_OJS_CA_BUNDLE.');
            }
            curl_setopt($curl, CURLOPT_CAINFO, $this->config['ojs_ca_bundle']);
        }
        $body = curl_exec($curl);
        $status = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        $errno = curl_errno($curl);
        curl_close($curl);
        if ($body === false || $status === 0) {
            $causes = array(
                6 => 'Não foi possível resolver o endereço da OJS. Verifique o DNS e a URL.',
                7 => 'Não foi possível conectar à OJS. Verifique a rede e o firewall.',
                28 => 'A conexão com a OJS excedeu o tempo limite. Tente novamente.',
                35 => 'Falha na negociação HTTPS com a OJS.',
                60 => 'Não foi possível validar o certificado HTTPS da OJS. Verifique o arquivo de autoridades certificadoras.',
                77 => 'Não foi possível ler o arquivo de certificados HTTPS.'
            );
            // Não expõe curl_error ou a URL completa, que pode conter o token.
            throw new RuntimeException(($causes[$errno] ?? 'Falha de transporte ao consultar a OJS.') . ' (cURL ' . $errno . ').');
        }
        if ($status < 200 || $status >= 300) {
            throw new RuntimeException('Não foi possível consultar a OJS (HTTP ' . (int) $status . ').');
        }
        $data = json_decode($body, true);
        if (!is_array($data) || json_last_error() !== JSON_ERROR_NONE) throw new RuntimeException('Resposta inválida da OJS.');
        return $data;
    }

    public function collection($path, $query = array())
    {
        $result = array();
        for ($offset = 0, $page = 0; $page < 1000; $page++) {
            $data = $this->request($path, array_merge($query, array('count' => 100, 'offset' => $offset)));
            if (!isset($data['items'], $data['itemsMax']) || !is_array($data['items']) || !is_numeric($data['itemsMax'])) {
                throw new RuntimeException('Paginação inválida na resposta da OJS.');
            }
            foreach ($data['items'] as $item) {
                if (!is_array($item) || empty($item['id']) || !ctype_digit((string) $item['id']) || isset($result[$item['id']])) {
                    throw new RuntimeException('Registro inválido ou repetido na paginação da OJS.');
                }
                $result[$item['id']] = $item;
            }
            $offset += count($data['items']);
            if ($offset >= (int) $data['itemsMax']) return array_values($result);
            if (!$data['items']) throw new RuntimeException('A OJS retornou uma página incompleta.');
        }
        throw new RuntimeException('Limite de páginas da OJS excedido.');
    }

    private function localized($value)
    {
        if (is_string($value)) return $value;
        if (!is_array($value)) return '';
        $preferred = $value[$this->config['ojs_locale']] ?? null;
        if (is_string($preferred) && $preferred !== '') return $preferred;
        foreach ($value as $text) if (is_string($text) && $text !== '') return $text;
        return '';
    }

    public function fetch()
    {
        $contextsResponse = $this->request('contexts', array('count' => 100));
        $contexts = $contextsResponse['items'] ?? (isset($contextsResponse['id']) ? array($contextsResponse) : array());
        $currentIssueId = 0;
        foreach ($contexts as $context) {
            if (!is_array($context)) continue;
            if (($context['urlPath'] ?? $context['path'] ?? '') === 'crfmg' || count($contexts) === 1) {
                $currentIssueId = (int) ($context['currentIssueId'] ?? 0);
                break;
            }
        }
        if ($currentIssueId < 1) throw new RuntimeException('A API do OJS não informou a edição atual da revista.');

        $issues = $this->collection('issues', array('isPublished' => 'true'));
        $edicoes = array();
        $currentIssueFound = false;
        foreach ($issues as $issue) {
            $isCurrent = (int) $issue['id'] === $currentIssueId;
            if ($isCurrent) $currentIssueFound = true;
            $published = !empty($issue['datePublished']) ? strtotime($issue['datePublished']) : false;
            $cover = $issue['coverImageUrl'] ?? '';
            $edicoes[] = array('ojs_issue_id' => (int) $issue['id'], 'titulo' => $this->localized($issue['title'] ?? ''),
                'identificacao' => $this->localized($issue['identification'] ?? '') ?: trim('v. ' . ($issue['volume'] ?? '') . ' n. ' . ($issue['number'] ?? '') . ' (' . ($issue['year'] ?? '') . ')'),
                'data_publicacao' => $published !== false ? date('Y-m-d H:i:s', $published) : null,
                'edicao_atual' => $isCurrent ? 1 : 0,
                'currentIssueId' => $isCurrent ? 1 : 0,
                'descricao' => $this->localized($issue['description'] ?? ''),
                'capa_url' => $this->localized($cover), 'edicao_url' => (string) ($issue['publishedUrl'] ?? ($issue['urlPublished'] ?? '')),
                'pdf_url' => $this->pdf_url($issue));
        }
        if (!$currentIssueFound) throw new RuntimeException('A edição atual informada pelo OJS não apareceu entre as edições publicadas.');
        $artigos = array();
        foreach ($this->collection('submissions', array('status' => 3)) as $submission) {
            $id = (int) ($submission['currentPublicationId'] ?? 0);
            if (!$id) throw new RuntimeException('Artigo sem publicação atual na OJS.');
            $publication = $this->request('submissions/' . (int) $submission['id'] . '/publications/' . $id);
            if ((int) ($publication['id'] ?? 0) !== $id || (int) ($publication['status'] ?? 0) !== 3) {
                throw new RuntimeException('Publicação inválida ou alterada durante a importação. Tente novamente.');
            }
            $title = $this->localized($publication['fullTitle'] ?? ($publication['title'] ?? ''));
            if ($title === '') throw new RuntimeException('Artigo sem título na OJS.');
            $authors = array();
            foreach (($publication['authors'] ?? array()) as $author) {
                $authors[] = trim($this->localized($author['givenName'] ?? '') . ' ' . $this->localized($author['familyName'] ?? ''));
            }
            $artigos[] = array('ojs_article_id' => (int) $submission['id'],
                'edicao_ojs_id' => !empty($publication['issueId']) ? (int) $publication['issueId'] : null,
                'titulo' => $title, 'autores' => implode('; ', array_filter($authors)),
                'doi' => (string) ($publication['pub-id::doi'] ?? ($publication['doiObject']['doi'] ?? '')),
                'paginas' => (string) ($publication['pages'] ?? ''),
                'artigo_url' => (string) ($publication['urlPublished'] ?? ($submission['urlPublished'] ?? '')),
                'pdf_url' => $this->pdf_url($publication));
        }
        return array('edicoes' => $edicoes, 'artigos' => $artigos);
    }

    private function pdf_url($record)
    {
        foreach (($record['galleys'] ?? array()) as $galley) {
            if (($galley['file']['mimetype'] ?? '') === 'application/pdf' || strtoupper((string) ($galley['label'] ?? '')) === 'PDF') {
                return (string) ($galley['urlPublished'] ?? '');
            }
        }
        return '';
    }
}
