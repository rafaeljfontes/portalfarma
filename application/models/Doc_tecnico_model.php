<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Doc_tecnico_model extends CI_Model {
    private $tabela = 'tbl_portalfarma_doc_tecnico';

    public function listar() {
        return $this->db->order_by('data_criacao', 'DESC')->get($this->tabela)->result();
    }

    public function buscar($id) {
        return $this->db->where('id', (int) $id)->get($this->tabela)->row();
    }

    public function salvar($dados, $id = null) {
        if ($id) {
            return $this->db->where('id', (int) $id)->update($this->tabela, $dados);
        }
        return $this->db->insert($this->tabela, $dados);
    }

    public function excluir($id) {
        return $this->db->where('id', (int) $id)->delete($this->tabela);
    }

    public function incrementar_acesso($id) {
        return $this->db->set('acesso', 'acesso + 1', false)
            ->where('id', (int) $id)
            ->update($this->tabela);
    }
}
