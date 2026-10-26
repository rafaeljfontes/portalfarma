<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Usuarios extends CI_Model
{
    protected $DBGroup          = 'portalfarma';
    protected $table            = 'usuarios';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = true;
    protected $protectFields    = false;
    protected $allowedFields    = [];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [
        'nome'  => 'required|min_length[3]|max_length[255]',
        'login' => 'required|min_length[3]|max_length[100]',
    ];
    protected $validationMessages   = [
        'nome' => [
            'required' => 'Campo obrigatório.',
            'min_length' => 'A quantidade de caracteres informada está menor que o permitido.',
            'max_length' => 'A quantidade de caracteres informada está maior que o permitido.',
        ],
        'login' => [
            'required'   => 'Campo obrigatório.',
            'min_length' => 'A quantidade de caracteres informada está menor que o permitido.',
            'max_length' => 'A quantidade de caracteres informada está maior que o permitido.',
        ],
    ];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = ['userCreated'];
    protected $afterInsert    = [];
    protected $beforeUpdate   = ['userUpdated'];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = ['userDeleted'];
    protected $afterDelete    = [];

    public function userlogin($sessionuser) {
        return $this->db
			->where('user', $sessionuser)
			->get('tbl_portalfarma_user')
			->row();
    }
	
    public function listar_portalfarma() {
        return $this->db
            ->select('id, user, permissao, status')
            ->order_by('user', 'ASC')
            ->get('tbl_portalfarma_user')
            ->result();
    }

    public function buscar_por_usuario($usuario) {
        return $this->userlogin($usuario);
    }

    public function criar_portalfarma($usuario, array $permissoes, $status, $nome) {
        return $this->db->insert('tbl_portalfarma_user', array(
            'nome' => $nome,
            'user' => $usuario,
            'permissao' => implode(', ', $permissoes),
            'status' => (int) $status === 1 ? 1 : 0
        ));
    }

    public function atualizar_acesso($id, array $permissoes, $status) {
        if ((int) $id <= 0) {
            return false;
        }

        return $this->db
            ->where('id', (int) $id)
            ->update('tbl_portalfarma_user', array(
                'permissao' => implode(', ', $permissoes),
                'status' => (int) $status === 1 ? 1 : 0
            ));
    }

    protected function userCreated($data) {
        $data['data']['user_created'] = 1; 
        return $data;
    }

    protected function userUpdated($data) {
        $data['data']['user_updated'] = 1; 
        return $data;
    }

    protected function userDeleted($data) {
        $data['data']['user_deleted'] = 1; 
        return $data;
    }

}
