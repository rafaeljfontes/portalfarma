<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Bjhp extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $user = $this->session->userdata('usuario_logado');
        if (!$user) {
            if ($this->input->is_ajax_request()) { $this->json(array('message' => 'Sua sessão expirou. Entre novamente.'), 401); exit; }
            redirect('login');
        }
        // Consulta atualizada: a revogação também vale para sessões já abertas.
        $this->load->database();
        $this->load->model('Usuarios', 'bjhp_usuarios');
        $current = $this->bjhp_usuarios->userlogin($user['login'] ?? '');
        if (!$current || (int) $current->status !== 1 || !in_array('BJHP', portalfarma_permissoes($current->permissao), true)) {
            if ($this->input->is_ajax_request()) { $this->json(array('message' => 'Acesso negado. É necessária a permissão BJHP.'), 403); exit; }
            show_error('Acesso negado. É necessária a permissão BJHP.', 403);
        }
        $this->load->model('Bjhp_model', 'bjhp');
        if (!$this->session->userdata('bjhp_csrf')) $this->session->set_userdata('bjhp_csrf', bin2hex(random_bytes(32)));
    }

    private function json($data, $status = 200)
    {
        return $this->output->set_status_header($status)->set_content_type('application/json')->set_output(json_encode($data, JSON_UNESCAPED_UNICODE));
    }

    private function check_post()
    {
        if ($this->input->method(true) !== 'POST') { $this->json(array('message' => 'Método não permitido.'), 405); return false; }
        $token = (string) $this->input->post('bjhp_csrf');
        if (!hash_equals((string) $this->session->userdata('bjhp_csrf'), $token)) {
            $this->json(array('message' => 'Formulário expirado. Atualize a página.'), 403); return false;
        }
        return true;
    }

    public function index() { $this->importar(); }

    public function importar()
    {
        $data = array('historico' => null, 'erro' => null);
        try { $data['historico'] = $this->bjhp->ultimo(); }
        catch (RuntimeException $e) { $data['erro'] = $e->getMessage(); }
        $this->load->view('restrito/fixo/cabecalho');
        $this->load->view('restrito/bjhp/importar', $data);
        $this->load->view('restrito/fixo/rodape');
    }

    public function importar_api()
    {
        if (!$this->check_post()) return;
        $user = $this->session->userdata('usuario_logado');
        // Libera a sessão para outras abas durante a chamada externa.
        session_write_close();
        try {
            $this->config->load('bjhp', true);
            $this->load->library('Bjhp_ojs', $this->config->item('bjhp'));
            $history = $this->bjhp->importar($this->bjhp_ojs, $user);
            return $this->json(array('message' => 'Importação concluída com sucesso.', 'historico' => $history));
        } catch (RuntimeException $e) {
            return $this->json(array('message' => $e->getMessage()), 502);
        } catch (Throwable $e) {
            log_message('error', 'Falha interna na importação BJHP: ' . get_class($e));
            return $this->json(array('message' => 'Não foi possível concluir a importação. Tente novamente.'), 500);
        }
    }

    public function editorial()
    {
        $id = $this->input->get('id');
        if ($id !== null && (!is_string($id) || !ctype_digit($id) || (int) $id < 1)) show_404();
        $data = array('categorias' => $this->bjhp->categorias_editorial(), 'membro' => null);
        if ($id !== null) {
            try { $data['membro'] = $this->bjhp->obter_editorial((int) $id); }
            catch (RuntimeException $e) { show_error('Não foi possível carregar o membro do corpo editorial.', 500); return; }
            if (!$data['membro']) show_404();
        }
        $this->load->view('restrito/fixo/cabecalho');
        $this->load->view('restrito/bjhp/editorial', $data);
        $this->load->view('restrito/fixo/rodape');
    }

    public function corpo_editorial()
    {
        $data = array('membros' => array(), 'categorias' => $this->bjhp->categorias_editorial(), 'erro' => null);
        try { $data['membros'] = $this->bjhp->listar_corpo_editorial(); }
        catch (RuntimeException $e) { $data['erro'] = $e->getMessage(); }
        $this->load->view('restrito/fixo/cabecalho');
        $this->load->view('restrito/bjhp/corpo_editorial', $data);
        $this->load->view('restrito/fixo/rodape');
    }

    public function salvar_editorial()
    {
        if (!$this->check_post()) return;
        $id = $this->input->post('id');
        if (!is_string($id) || !ctype_digit($id)) return $this->json(array('message' => 'Cadastro inválido.'), 422);
        $id = (int) $id;
        $dados = array();
        $limites = array('categoria' => 50, 'nome' => 255, 'titulacao' => 100, 'instituicao' => 500,
            'cidade' => 150, 'estado' => 150, 'pais' => 100, 'orcid_url' => 255,
            'mini_curriculo' => 65535, 'email' => 255, 'ordem_exibicao' => 5, 'status' => 7);
        foreach ($limites as $campo => $limite) {
            $valor = $this->input->post($campo);
            if ($valor !== null && !is_string($valor)) return $this->json(array('message' => 'Valor inválido para ' . $campo . '.'), 422);
            $valor = trim((string) $valor);
            if (mb_strlen($valor, 'UTF-8') > $limite || ($campo === 'mini_curriculo' && strlen($valor) > 65535)) {
                return $this->json(array('message' => 'O campo ' . $campo . ' excede o tamanho permitido.'), 422);
            }
            $dados[$campo] = $valor === '' ? null : $valor;
        }
        if (!$dados['nome'] || !isset($this->bjhp->categorias_editorial()[$dados['categoria'] ?? '']) ||
            !in_array($dados['status'], array('ativo', 'inativo'), true)) {
            return $this->json(array('message' => 'Informe nome, categoria e status válidos.'), 422);
        }
        if ($dados['ordem_exibicao'] === null || !ctype_digit($dados['ordem_exibicao']) || (int) $dados['ordem_exibicao'] > 65535) {
            return $this->json(array('message' => 'A ordem de exibição deve ser um inteiro entre 0 e 65535.'), 422);
        }
        $dados['ordem_exibicao'] = (int) $dados['ordem_exibicao'];
        if ($dados['email'] !== null && !filter_var($dados['email'], FILTER_VALIDATE_EMAIL)) {
            return $this->json(array('message' => 'Informe um e-mail válido.'), 422);
        }
        if ($dados['orcid_url'] !== null && (!filter_var($dados['orcid_url'], FILTER_VALIDATE_URL) ||
            strtolower((string) parse_url($dados['orcid_url'], PHP_URL_SCHEME)) !== 'https' ||
            strtolower((string) parse_url($dados['orcid_url'], PHP_URL_HOST)) !== 'orcid.org')) {
            return $this->json(array('message' => 'Informe uma URL válida do ORCID (https://orcid.org/...).'), 422);
        }
        $fotoPath = null;
        if ($id === 0) $dados['foto'] = null;
        try {
            if (isset($_FILES['foto']) && ($_FILES['foto']['error'] ?? UPLOAD_ERR_NO_FILE) !== UPLOAD_ERR_NO_FILE) {
                if (!isset($_FILES['foto']['error']) || is_array($_FILES['foto']['error']) || $_FILES['foto']['error'] !== UPLOAD_ERR_OK) {
                    return $this->json(array('message' => 'Não foi possível receber a foto. Envie um PNG ou JPG de até 2 MB.'), 422);
                }
                $tmp = $_FILES['foto']['tmp_name'];
                $extension = strtolower(pathinfo($_FILES['foto']['name'], PATHINFO_EXTENSION));
                if (!is_uploaded_file($tmp) || filesize($tmp) > 2 * 1024 * 1024 || !in_array($extension, array('png', 'jpg', 'jpeg'), true)) {
                    return $this->json(array('message' => 'Envie uma foto PNG ou JPG de até 2 MB.'), 422);
                }
                $image = @getimagesize($tmp);
                if (!$image || !in_array($image[2], array(IMAGETYPE_PNG, IMAGETYPE_JPEG), true)) {
                    return $this->json(array('message' => 'A foto deve ser uma imagem PNG ou JPG válida.'), 422);
                }
                $folder = FCPATH . 'uploads/bjhp/corpo-editorial/';
                if (!is_dir($folder) && !mkdir($folder, 0755, true) && !is_dir($folder)) {
                    throw new RuntimeException('Não foi possível preparar a pasta das fotos.');
                }
                $mime = (new finfo(FILEINFO_MIME_TYPE))->file($tmp);
                if (!in_array($mime, array('image/png', 'image/jpeg'), true)) {
                    return $this->json(array('message' => 'O conteúdo do arquivo deve ser PNG ou JPG.'), 422);
                }
                $filename = bin2hex(random_bytes(24)) . ($image[2] === IMAGETYPE_PNG ? '.png' : '.jpg');
                $fotoPath = $folder . $filename;
                if (!move_uploaded_file($tmp, $fotoPath)) throw new RuntimeException('Não foi possível salvar a foto.');
                $dados['foto'] = 'uploads/bjhp/corpo-editorial/' . $filename;
            }
            if ($id > 0) $this->bjhp->atualizar_editorial($id, $dados);
            else $this->bjhp->salvar_editorial($dados);
            $fotoPath = null; // O arquivo agora pertence ao cadastro persistido.
            return $this->json(array(
                'message' => $id > 0 ? 'Membro do corpo editorial atualizado com sucesso.' : 'Membro do corpo editorial cadastrado com sucesso.',
                'redirect' => $id > 0 ? base_url('restrito/bjhp/corpo_editorial') : null
            ));
        } catch (RuntimeException $e) { return $this->json(array('message' => $e->getMessage()), 500); }
        finally { if ($fotoPath !== null && is_file($fotoPath)) unlink($fotoPath); }
    }
}
