<?php
	
class Password_model extends CI_Model {

    public function __construct(){
        parent::__construct();
        $this->load->database();
    }

    // inserir token de recuperação
    public function inserir_pass($data){

        $this->db->insert('tbl_password_resets', $data);

        if($this->db->affected_rows() > 0){
            return $this->db->insert_id();
        }

        return false;
    }

    // buscar token válido
    public function buscarTokenValido($token){

        $this->db->where('token', $token);
        $this->db->where('status', 0);
        $this->db->where('expiracao >=', date('Y-m-d H:i:s'));

        return $this->db->get('tbl_password_resets')->row_array();
    }

    // marcar token como usado
    public function marcarComoUsado($token){

        $this->db->where('token', $token);

        return $this->db->update('tbl_password_resets', [
            'status' => 1
        ]);
    }

}