<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Atitude_farmaceutica_model extends CI_Model
{
    private $tabela = 'web_site.tbl_atitudefarmaceutica_inscricao';

    public function resultados_votacao()
    {
        $debug = $this->db->db_debug;
        $this->db->db_debug = false;
        try {
            $validas = 'relevancia BETWEEN 1 AND 5 AND impacto BETWEEN 1 AND 5 AND pessoas BETWEEN 1 AND 5 AND duracao BETWEEN 1 AND 5 AND beneficios BETWEEN 1 AND 5';
            $consulta = $this->db->query('SELECT p.id, p.nome_projeto,
                COALESCE(v.total, 0) AS votos, COALESCE(v.avaliacoes, 0) AS avaliacoes_populares,
                COALESCE(v.soma_notas, 0) AS soma_popular,
                COALESCE(c.total, 0) AS avaliacoes_comissao,
                COALESCE(c.soma_centavos, 0) AS soma_comissao_centavos,
                COALESCE(c.soma_duracao, 0) AS soma_duracao,
                COALESCE(c.soma_impacto, 0) AS soma_impacto,
                COALESCE(c.soma_pessoas, 0) AS soma_pessoas,
                COALESCE(c.soma_beneficios, 0) AS soma_beneficios,
                COALESCE(c.soma_relevancia, 0) AS soma_relevancia
                FROM web_site.tbl_atitudefarmaceutica_inscricao p
                LEFT JOIN (
                    SELECT id_proejto, COUNT(*) AS total,
                        SUM(CASE WHEN ' . $validas . ' THEN 1 ELSE 0 END) AS avaliacoes,
                        SUM(CASE WHEN ' . $validas . ' THEN relevancia + impacto + pessoas + duracao + beneficios ELSE 0 END) AS soma_notas
                    FROM web_site.tbl_atitude_votacao GROUP BY id_proejto
                ) v ON v.id_proejto = p.id
                LEFT JOIN (
                    SELECT id_projeto, COUNT(*) AS total, SUM(CAST(nota_final * 100 AS UNSIGNED)) AS soma_centavos,
                        SUM(duracao) AS soma_duracao, SUM(impacto) AS soma_impacto,
                        SUM(pessoas) AS soma_pessoas, SUM(beneficios) AS soma_beneficios, SUM(relevancia) AS soma_relevancia
                    FROM web_site.tbl_atitude_comissao_avaliacao
                    WHERE ' . $validas . ' AND nota_final BETWEEN 1 AND 5 GROUP BY id_projeto
                ) c ON c.id_projeto = p.id
                WHERE p.status = 1 ORDER BY p.id');
            if (!$consulta) return null;
            $this->load->library('Atitude_apuracao');
            return $this->atitude_apuracao->calcular($consulta->result());
        } catch (Throwable $erro) {
            log_message('error', 'Falha na apuração dos resultados Atitude Farmacêutica.');
            return null;
        } finally { $this->db->db_debug = $debug; }
    }

    public function projeto_disponivel_votacao($id)
    {
        $debug = $this->db->db_debug;
        $this->db->db_debug = false;
        try {
            $consulta = $this->db->query('SELECT id FROM web_site.tbl_atitudefarmaceutica_inscricao WHERE id = ? AND status = 1', array($id));
            return $consulta ? $consulta->num_rows() === 1 : null;
        } finally { $this->db->db_debug = $debug; }
    }

    public function email_ja_votou($email)
    {
        $debug = $this->db->db_debug; $this->db->db_debug = false;
        try {
            $consulta = $this->db->query('SELECT id FROM web_site.tbl_atitude_votacao WHERE email = ? LIMIT 1', array($email));
            return $consulta ? $consulta->num_rows() > 0 : null;
        } finally { $this->db->db_debug = $debug; }
    }

    public function registrar_votos($email, $codigo, $ids, $notas = null, $ip = null)
    {
        $debug = $this->db->db_debug;
        $this->db->db_debug = false;
        $iniciada = false; $travasAdquiridas = array();
        try {
            $this->load->library('Atitude_voto_popular');
            $ip = $this->atitude_voto_popular->normalizar_ip($ip);
            if ($ip === null) return 'ip';
            $linhas = $this->atitude_voto_popular->preparar($ids, $notas, $this->obter_limite_votacao());
            if ($linhas === null) return 'notas';
            // Bloqueia o mesmo e-mail ou IP entre sessões concorrentes, sem
            // limitar as várias linhas de projetos pertencentes ao mesmo voto.
            $travas = array('atitude_email_' . sha1($email), 'atitude_ip_' . sha1($ip));
            sort($travas);
            foreach ($travas as $trava) {
                $lock = $this->db->query('SELECT GET_LOCK(?, 5) AS adquirido', array($trava));
                if (!$lock || (int) $lock->row()->adquirido !== 1) return 'banco';
                $travasAdquiridas[] = $trava;
            }
            if (!$this->db->trans_begin()) return 'banco';
            $iniciada = true;
            if ($this->obter_fase() !== 'votacao') return 'fase';
            $jaVotou = $this->email_ja_votou($email);
            if ($jaVotou === null) return 'banco';
            if ($jaVotou) return 'duplicado';
            $votoIp = $this->db->query('SELECT id FROM web_site.tbl_atitude_votacao WHERE ip_votante = ? LIMIT 1', array($ip));
            if (!$votoIp) return 'banco';
            if ($votoIp->num_rows()) return 'ip_duplicado';
            $marcadores = implode(',', array_fill(0, count($ids), '?'));
            $projetos = $this->db->query('SELECT id FROM web_site.tbl_atitudefarmaceutica_inscricao WHERE status = 1 AND id IN (' . $marcadores . ') ORDER BY id FOR UPDATE', $ids);
            if (!$projetos) return 'banco';
            if ($projetos->num_rows() !== count($ids)) return 'projeto';
            if (count($ids) !== $this->obter_limite_votacao()) return 'notas';
            foreach ($linhas as &$linha) { $linha['email'] = $email; $linha['codigo'] = $codigo; $linha['ip_votante'] = $ip; }
            unset($linha);
            if ($this->db->insert_batch('web_site.tbl_atitude_votacao', $linhas) === false || !$this->db->trans_status()) {
                $erro = $this->db->error();
                return (int) $erro['code'] === 1062 ? 'duplicado' : 'banco';
            }
            if (!$this->db->trans_commit()) return 'banco';
            $iniciada = false;
            return null;
        } catch (Throwable $erro) {
            log_message('error', 'Falha ao registrar avaliação popular Atitude Farmacêutica.');
            return 'banco';
        } finally {
            if ($iniciada) $this->db->trans_rollback();
            foreach (array_reverse($travasAdquiridas) as $trava) $this->db->query('SELECT RELEASE_LOCK(?)', array($trava));
            $this->db->db_debug = $debug;
        }
    }

    public function obter_limite_votacao()
    {
        $this->load->library('Atitude_evento');
        return $this->atitude_evento->obter_limite_votacao();
    }

    public function obter_fase()
    {
        $this->load->library('Atitude_evento');
        return $this->atitude_evento->obter_fase();
    }

    public function salvar_fase($fase, $faseAtual)
    {
        $this->load->library('Atitude_evento');
        return $this->atitude_evento->salvar_fase($fase, $faseAtual);
    }

    public function listar_aceitos()
    {
        return $this->db->select('id, nome_projeto, resumo_projeto, descricao_projeto, eixo_projeto, cidade_projeto, local_projeto, data_inicio, numero_pessoas, recursos, justificativa, pessoas_alcancadas, beneficios_alcancados, objetivos_alcancados, imagem_principal, imagens')
            ->where('status', 1)->order_by('data_inicio', 'DESC')->order_by('id', 'DESC')
            ->get($this->tabela)->result();
    }

    public function listar($limite, $offset)
    {
        return $this->db->order_by('criado_em', 'DESC')->order_by('id', 'DESC')
            ->get($this->tabela, $limite, $offset)->result();
    }

    public function total()
    {
        return $this->db->count_all($this->tabela);
    }

    public function campos_status_disponiveis()
    {
        $campos = $this->db->list_fields($this->tabela);
        return in_array('status', $campos, true);
    }

    public function campo_motivo_disponivel()
    {
        return in_array('motivo_recusa', $this->db->list_fields($this->tabela), true);
    }

    public function buscar($id)
    {
        return $this->db->where('id', $id)->get($this->tabela)->row();
    }

    public function decidir($id, $status, $motivo, $statusAtual)
    {
        $debug = $this->db->db_debug;
        $this->db->db_debug = false;
        try {
            $dados = array('status' => $status);
            if ($this->campo_motivo_disponivel()) {
                $dados['motivo_recusa'] = $status === 2 ? $motivo : null;
            }
            $ok = $this->db->where('id', $id)->where('status', $statusAtual)
                ->update($this->tabela, $dados);
            return $ok && $this->db->affected_rows() === 1;
        } finally {
            $this->db->db_debug = $debug;
        }
    }
}
