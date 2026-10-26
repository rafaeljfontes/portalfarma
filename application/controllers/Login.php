<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

	public function index()
	{
		$this->load->view('login');
	}

	public function entrar()
	{
		$config = array(
            array(
                'field' => 'usuario',
                'label' => 'Usuário',
                'rules' => "required",
                'errors' => array(
                    'required' => 'Campo obrigatório',
                ),
            ),
            array(
                'field' => 'senha',
                'label' => 'Senha',
                'rules' => "required",
                'errors' => array(
                    'required' => 'Campo obrigatório',
                ),
            )
        );

        $this->form_validation->set_rules($config);

        if ($this->form_validation->run() == FALSE) {

            $this->index();

        }else{

			$curl = curl_init();
			curl_setopt( $curl, CURLOPT_URL, 'http://api.crfmg.org.br/apildap/sessions/login' );
			curl_setopt( $curl, CURLOPT_POST, true );
			curl_setopt( $curl, CURLOPT_POSTFIELDS, array(
				'usuario' =>  $this->input->post('usuario'),
				'senha'   =>  $this->input->post('senha'),
			));
			curl_setopt( $curl, CURLOPT_RETURNTRANSFER, true );
			$response = json_decode( curl_exec( $curl ), true);
			curl_close($curl);

            if ( ! $response ){
				$this->session->set_flashdata( getMessageFail('sweetalert', ['title' => 'Falha no login', 'text' => 'Falha ao comunicar com o servidor [API]']) );
				redirect('login');
			}

			if ( $response['type'] == "error"){
				$this->session->set_flashdata( getMessageFail('toast', ['title' => 'Falha no login', 'text' => $response['message']]) );
				redirect('login');
			}

			// Criar sessão de LOGIN
			$session = [
				'usuario_logado'  => [
					'usuario'    => $response['usuario'],
					'setor'      => $response['setor'],
					'nome'       => $response['nome'],
				]
			]; 
       
            $this->session->set_userdata($session);
			
			$this->session->set_flashdata( getMessageSucess() );

			redirect('restrito');
		}
	}

	public function sair()
	{
		$this->session->sess_destroy();
        redirect('login');
	}
	
}
