<?php
class Plenarias_model extends CI_Model {

    protected $tabela = 'tbl_portalfarma_plenaria_tecnica';

    // Busca uma plenária pelo ID (Retorna array com objeto para bater com a View)
    public function getById($id) {
        $this->db->where('id', $id);
        $res = $this->db->get($this->tabela)->result();
        return (!empty($res)) ? $res : false;
    }

    // Insere novo registro
    public function insert($dados) {
        if (!$this->db->insert($this->tabela, $dados)) {
            return false;
        }
        return $this->db->insert_id();
    }

    // Atualiza registro existente
    public function update($id, $dados) {
        $this->db->where('id', $id);
        return $this->db->update($this->tabela, $dados);
    }
	
	public function delete($id) {
		$this->db->where('id', $id);
		return $this->db->delete('tbl_portalfarma_plenaria_tecnica');
	}
}
