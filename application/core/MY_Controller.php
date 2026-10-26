<?php

class MY_Controller extends CI_Controller
{
    protected $menuCursos = [];

    public function __construct()
    {
        parent::__construct();

        $this->load->database();
        $this->load->model('capacifar_model', 'capacifar_model', TRUE);

        $queryMenu = "
            SELECT *
            FROM web_site.tbl_portalfarma
            WHERE status = 1
            ORDER BY data_fim DESC
        ";

        $this->menuCursos = $this->capacifar_model->query($queryMenu);
    }

    protected function carregarCabecalho($dados = [])
    {
        $dados['tabelaCursoMenu'] = $this->menuCursos;
        $this->load->view('fixo/cabecalho', $dados);
    }


    public function validate_sesssion($data = null)
    {

        if (!$this->session->LOGIN) {
            if (isset($data)) {
                foreach ($data as $key => $value) {
                    ${$key} = $value;
                }
            }

            if (!isset($type)) {
                $type = "error";
            }

            if (!isset($message)) {
                $message = "<b>Serviço disponível somente para usuários logados</b><br>Entre com seu usário e senha e acesse a página.";
            }

            if (!isset($current_url)) {
                $current_url = "";
            }

            if (!isset($cpf)) {
                $cpf = "";
            }

            if (!isset($cnpj)) {
                $cnpj = "";
            }

            if (!isset($matricula)) {
                $matricula = "";
            }

            $return['toast_type']    = $type;
            $return['toast_message'] = $message;

            $return['current_url']   = $current_url;
            $return['cpf']           = $cpf;
            $return['cnpj']          = $cnpj;
            $return['matricula']     = $matricula;

            $this->session->set_flashdata($return);
            redirect(base_system() . "login");
        }

        return true;
    }


    public function check_permission($modulos = null)
    {
        if (empty($modulos)) {
            return false;
        }

        foreach ($modulos as $key_modulo => $value_modulo) {
            foreach ($this->session->PERMISSAO as $permissao_usuario) {
                if ($value_modulo == $permissao_usuario->id_permissao || $permissao_usuario->id_permissao == 9999) {
                    return true;
                }
            }
        }

        $return['toast_type']    = "warning";
        $return['toast_title']   = "Acesso Negado!";
        $return['toast_message'] = "Você não tem permissões para acessar essa página<br>Verifique com o administrador do sistema.";

        $this->session->set_flashdata($return);
        redirect(base_url());

        return false;
    }
}
