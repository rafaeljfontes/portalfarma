<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


// ACESSO RESTRITO / LOGIN

class Login extends CI_Controller {
	
	public function __construct()
    {
        parent::__construct();

    }

	public function index()
	{
		//echo "aquiii";exit;
		$this->load->view('login');	
	}
	
	public function entrar() {
	
		$this->load->library('session');
		$this->load->library('user_agent');
		//$this->load->helper('message');
	
		if ( ! $this->input->post()) {
			$this->session->set_flashdata('erro', 'Informe seu usuário e senha para entrar.');
			redirect('login');
        }else{
		
		
            $rules = [
                'usuario' => 'required|min_length[3]|max_length[255]',
                'senha'   => 'required|min_length[3]|max_length[255]',
            ];

            $messages   = [
                'usuario' => [
                    'required' => 'Campo obrigatório.',
                    'min_length' => 'A quantidade de caracteres informada está menor que o permitido.',
                    'max_length' => 'A quantidade de caracteres informada está maior que o permitido.',
                ],
                'senha' => [
                    'required' => 'Campo obrigatório.',
                    'min_length' => 'A quantidade de caracteres informada está menor que o permitido.',
                    'max_length' => 'A quantidade de caracteres informada está maior que o permitido.',
                ],
            ];

            
            $curl = curl_init();
			curl_setopt( $curl, CURLOPT_URL, 'http://api.crfmg.org.br/apildap/sessions/login' );
			curl_setopt( $curl, CURLOPT_POST, true );
			curl_setopt( $curl, CURLOPT_POSTFIELDS, array(
				'usuario' =>  $this->input->post('usuario'),
				'senha'   =>  $this->input->post('senha'),
			));
			curl_setopt( $curl, CURLOPT_RETURNTRANSFER, true );
			curl_setopt( $curl, CURLOPT_CONNECTTIMEOUT, 5 );
			curl_setopt( $curl, CURLOPT_TIMEOUT, 15 );
			$response = json_decode( curl_exec( $curl ), true);
			curl_close($curl);
			//var_dump($response);

			if ( ! $response ){
				$this->session->set_flashdata('erro', 'O serviço de autenticação está indisponível. Tente novamente mais tarde.');
				redirect('login');
			}

			if ( $response['type'] == "error"){
                $this->session->set_flashdata('erro', $response['message']);
				redirect('login');
			}

            
           // Cria ou atualiza usuário
            $dados_bd = [
                'nome'  	=> $response['nome'],
                'login' 	=> $response['usuario'],
                'setor' 	=> $response['setor'],
                'type' 		=> $response['type'],
                'message' 	=> $response['message'],
            ];

            
            // Criar sessão de LOGIN
            $session = [
                'usuario_logado'  => [
                    'nome'      => $dados_bd['nome'],
                    'login'     => $dados_bd['login'],
                    'type'      => $dados_bd['type'],
                    'message'    => $dados_bd['message'],
                    'setor'  	=> $dados_bd['setor'],
                ]
            ]; 
			
			
				// Busca no banco o usuário
				try {
					$this->load->model('usuarios', 'usuarios', TRUE);
					$usuario = $this->usuarios->userlogin($session['usuario_logado']['login']);
				} catch (mysqli_sql_exception $error) {
					log_message('error', 'Banco de usuários indisponível durante o login restrito.');
					$this->session->set_flashdata('erro', 'Não foi possível consultar seu acesso. O banco de dados está indisponível. Verifique a conexão com a rede interna ou VPN e tente novamente.');
					redirect('login');
					return;
				}
				//var_dump($usuario);
				
				if (!$usuario) {
					show_error('Usuário não encontrado no banco.');
				}

				if (isset($usuario->status) && (int) $usuario->status !== 1) {
					show_error('Usuário inativo. Entre em contato com o administrador.', 403);
				}

				// verifica todas as permissões
				$permissoes = portalfarma_permissoes($usuario->permissao);
				// Mantém o formato esperado pelas páginas antigas, mesmo quando o banco usa JSON.
				$session['permissao'] = implode(', ', $permissoes);
				$session['usuario_logado']['id'] = (int) $usuario->id;
		
			//var_dump($session);
			//print_r('<br>Bora entrar!');
			//print_r($session['usuario_logado']['login']);
			//exit;
            $session['ultima_atividade_restrito'] = time();
            $this->session->set_userdata($session);
			redirect('restrito/inicio');
        }
    }

    public function sair() {
        $this->session->sess_destroy();
        redirect('restrito/login/entrar');
    }
	
	
	
	public function recuperarSenha(){
		
		$dados = array();
		
		if($this->input->post()){
			
			$this->load->model('login_model', 'login_model', TRUE);
				
			$email =  $this->input->post('txtEmail');
				
			//VERIFICAR LOGIN
			$result = $this->login_model->verificarEmail($email);
			
			if($result){

				
				$gerarNovaSenha ;

				// gravarNovaSenha em password_hash
				
				// enviar por email senha explicita;
				
				$dados = array('resposta' => 'Uma nova senha foi enviada para o e-mail: <strong>'.$email.'</strong> <br>');
				
			}else{
				$dados = array('resposta' => 'E-mail inválido ou não encontrado na base de dados. ');
			}
			
		}

		 $this->load->view('login', $dados);
		
	}
	
}
