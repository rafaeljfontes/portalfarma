<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Designacoes_model extends CI_Model
{
    private $estrutura;

    public function disponivel()
    {
        if ($this->estrutura === null) $this->estrutura = $this->db->table_exists('tbl_portalfarma_func_designado');
        return $this->estrutura;
    }

    public function usuario_sessao()
    {
        $sessao = (array) $this->session->userdata('usuario_logado');
        $id = (int) ($sessao['id'] ?? 0);
        if ($id > 0) return $id;
        $login = $sessao['login'] ?? '';
        if (!is_string($login) || $login === '') return 0;
        $usuario = $this->db->select('id')->where('user', $login)->where('status', 1)->get('tbl_portalfarma_user')->row();
        return $usuario ? (int) $usuario->id : 0;
    }

    public function usuarios_ativos()
    {
        $nome = "COALESCE(NULLIF(TRIM(nome), ''), 'Nome não informado')";
        $foto = 'NULL';
        foreach (['foto', 'foto_url', 'avatar'] as $campoFoto) {
            if ($this->db->field_exists($campoFoto, 'tbl_portalfarma_user')) { $foto = $campoFoto; break; }
        }
        return $this->db->select('id, '.$nome.' AS nome, '.$foto.' AS foto', false)->where('status', 1)->order_by('nome')->get('tbl_portalfarma_user')->result();
    }

    public function condicao_usuario($alias, $idUsuario)
    {
        if ((int) $idUsuario <= 0 || !$this->disponivel()) return '1 = 0';
        return 'EXISTS (SELECT 1 FROM tbl_portalfarma_func_designado fd_usuario WHERE fd_usuario.courseid = '.$alias.'.courseid AND fd_usuario.id_usuario = '.(int) $idUsuario.')';
    }

    public function join_listagem()
    {
        $nome = $this->db->field_exists('nome', 'tbl_portalfarma_user') ? "COALESCE(NULLIF(u.nome, ''), u.user)" : 'u.user';
        return " LEFT JOIN (SELECT fd.courseid,
            GROUP_CONCAT(DISTINCT fd.id_usuario ORDER BY fd.id_usuario) AS designados_ids,
            GROUP_CONCAT(DISTINCT ".$nome." ORDER BY ".$nome." SEPARATOR '\\n') AS designados_nomes
            FROM tbl_portalfarma_func_designado fd
            LEFT JOIN tbl_portalfarma_user u ON u.id = fd.id_usuario
            GROUP BY fd.courseid) designados ON designados.courseid = tpf.courseid ";
    }

    public function salvar($courseid, array $ids)
    {
        if (!$this->disponivel()) throw new RuntimeException('A tabela de designações ainda não foi instalada.');
        $ids = array_values(array_unique(array_map('intval', $ids)));
        $debug = $this->db->db_debug;
        $this->db->db_debug = false;
        try {
            if (!$this->db->trans_begin()) throw new RuntimeException('Não foi possível iniciar a transação.');
            // Serializa alterações simultâneas para o mesmo curso.
            $curso = $this->db->query('SELECT courseid FROM tbl_portalfarma WHERE courseid = ? FOR UPDATE', [$courseid]);
            if (!$curso || !$curso->row()) throw new InvalidArgumentException('Curso não encontrado.');
            if ($ids) {
                $usuarios = $this->db->query('SELECT id FROM tbl_portalfarma_user WHERE status = 1 AND id IN ('.implode(',', array_fill(0, count($ids), '?')).') FOR UPDATE', $ids);
                if (!$usuarios || count($usuarios->result()) !== count($ids)) throw new InvalidArgumentException('Selecione apenas usuários ativos existentes.');
            }
            $sqlRemover = 'DELETE FROM tbl_portalfarma_func_designado WHERE courseid = ?';
            if ($ids) $sqlRemover .= ' AND id_usuario NOT IN ('.implode(',', array_fill(0, count($ids), '?')).')';
            if (!$this->db->query($sqlRemover, array_merge([$courseid], $ids))) throw new RuntimeException('Falha ao remover os vínculos anteriores.');
            foreach ($ids as $id) {
                if (!$this->db->query('INSERT INTO tbl_portalfarma_func_designado (courseid, id_usuario) VALUES (?, ?) ON DUPLICATE KEY UPDATE id_usuario = VALUES(id_usuario)', [$courseid, $id])) throw new RuntimeException('Falha ao gravar as designações.');
            }
            if (!$this->db->trans_status() || !$this->db->trans_commit()) throw new RuntimeException('Não foi possível confirmar as designações.');
        } catch (Throwable $e) {
            $this->db->trans_rollback();
            throw $e;
        } finally {
            $this->db->db_debug = $debug;
        }
    }
}
