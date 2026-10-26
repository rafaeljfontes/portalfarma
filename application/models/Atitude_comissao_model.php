<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Atitude_comissao_model extends CI_Model
{
    public function membro($email)
    {
        $debug = $this->db->db_debug; $this->db->db_debug = false;
        try {
            $q = $this->db->query('SELECT id, nome, email, ativo FROM web_site.tbl_atitude_comissao_membro WHERE email = ? AND ativo = 1', array($email));
            return $q ? ($q->row() ?: false) : null;
        } finally { $this->db->db_debug = $debug; }
    }

    public function listar_membros()
    {
        $debug = $this->db->db_debug; $this->db->db_debug = false;
        try {
            $q = $this->db->query('SELECT id, nome, email, ativo FROM web_site.tbl_atitude_comissao_membro ORDER BY nome, id');
            return $q ? $q->result() : null;
        } finally { $this->db->db_debug = $debug; }
    }

    public function salvar_membro($nome, $email, $ativo)
    {
        $debug = $this->db->db_debug; $this->db->db_debug = false;
        try {
            return $this->db->query('INSERT INTO web_site.tbl_atitude_comissao_membro (nome, email, ativo) VALUES (?, ?, ?)
                ON DUPLICATE KEY UPDATE nome = VALUES(nome), ativo = VALUES(ativo)', array($nome, $email, $ativo));
        } finally { $this->db->db_debug = $debug; }
    }

    public function registrar($email, $notas)
    {
        $debug = $this->db->db_debug;
        $this->db->db_debug = false;
        $iniciada = false;
        try {
            if (!$this->db->trans_begin()) return 'banco';
            $iniciada = true;
            $membro = $this->db->query('SELECT id FROM web_site.tbl_atitude_comissao_membro WHERE email = ? AND ativo = 1 FOR UPDATE', array($email));
            if (!$membro) return 'banco';
            if (!$membro->num_rows()) return 'autorizacao';
            $idMembro = (int) $membro->row()->id;
            $existente = $this->db->query('SELECT id FROM web_site.tbl_atitude_comissao_avaliacao WHERE id_membro = ? LIMIT 1', array($idMembro));
            if (!$existente) return 'banco';
            if ($existente->num_rows()) return 'duplicado';
            $consulta = $this->db->query('SELECT id FROM web_site.tbl_atitudefarmaceutica_inscricao WHERE status = 1 ORDER BY id FOR UPDATE');
            if (!$consulta) return 'banco';
            $ids = array_map(function ($projeto) { return (int) $projeto->id; }, $consulta->result());
            $this->load->library('Atitude_avaliacao');
            $linhas = $this->atitude_avaliacao->preparar($notas, $ids);
            if ($linhas === null) return 'notas';
            foreach ($linhas as &$linha) $linha['id_membro'] = $idMembro;
            unset($linha);
            if ($this->db->insert_batch('web_site.tbl_atitude_comissao_avaliacao', $linhas) === false || !$this->db->trans_status()) {
                $erro = $this->db->error();
                return (int) $erro['code'] === 1062 ? 'duplicado' : 'banco';
            }
            if (!$this->db->trans_commit()) return 'banco';
            $iniciada = false;
            return null;
        } catch (Throwable $erro) {
            log_message('error', 'Falha ao registrar avaliação da comissão Atitude Farmacêutica.');
            return 'banco';
        } finally {
            if ($iniciada) $this->db->trans_rollback();
            $this->db->db_debug = $debug;
        }
    }
}
