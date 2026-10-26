<?php

class Recuperar_model extends CI_Model{

    public function buscarUsuario($usuario)
    {

        $this->db->where('username',$usuario);
        $this->db->or_where('email',$usuario);

        return $this->db->get('mdl_user')->row();

    }

    public function salvarSenha($id,$senha)
    {

        $this->db->where('id',$id);

        return $this->db->update('mdl_user',[
            'password'=>$senha
        ]);

    }

}