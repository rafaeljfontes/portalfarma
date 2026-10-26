<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Recuperar extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
		$this->load->model('Moodle_model');
		$this->load->model('Moodle_api');
		$this->load->model('Password_model');
		$this->load->library('email');
        $this->load->helper(['url', 'form']);
    }

    public function index()
    {
        $this->load->view('recuperar_senha');
    }
	
	public function trocar_senha()
    {
        $this->load->view('trocar_senha');
    }
	
	public function resetarSenhaMoodle()
    {
        // 1. Recebe os dados via POST (ou ajuste conforme sua necessidade)
        $username = $this->input->post('usuario');
        $email    = $this->input->post('email');

        if (empty($username) || empty($email)) {
			echo json_encode([
					'status'=> 'error',
					'msg'=> 'Usuário e E-mail são obrigatórios.'
				]);
        }

        // 2. Conecta ao banco (mude para 'default' se o Moodle estiver no mesmo banco)
        $user = $this->Moodle_model->buscar_usuario_por_username($username);
		
		$idMoodle = $user['data']['id'];
		
        if ($user) {
            // 4. Gera o Hash da senha (o Moodle usa password_hash do PHP)
            // Aqui definimos que a nova senha será igual ao nome do usuário
            $novaSenhaHash = password_hash($username, PASSWORD_DEFAULT);

            // 5. Atualiza o registro
            //$resultado = $builder->where('id', $user->id)
            //                     ->update(['password' => $novaSenhaHash]);
								 
		
			$sucesso = $this->Moodle_api->atualizarSenhaMoodle($idMoodle, $novaSenhaHash);

			if ($sucesso) {
                echo json_encode([
					'status'=> 'success',
					'msg'=> 'Senha resetada para ser novamente seu CPF'
				]);
            } else {
				echo json_encode([
					'status'=> 'error',
					'msg'=> 'Usuário não encontrado ou dados incorretos.'
				]);
			}
        }

        // Caso não encontre ou falhe
		 
        /*return $this->response->setJSON([
            'status' => 'error',
            'title'  => 'Ops!',
            'text'   => 'Usuário não encontrado ou dados incorretos.'
        ]);*/
    }

    public function enviar()
    {

        $usuario = $this->input->post('usuario');
		
		
		if(filter_var($usuario, FILTER_VALIDATE_EMAIL)){

			$user = $this->Moodle_model->buscarUsuarioEmail($usuario);

		}else{

			$usuario = preg_replace('/[^0-9]/','',$usuario);
			
			$user = $this->Moodle_model->buscar_usuario_por_username($usuario);

		}
		

        if(!$user){
            echo json_encode([
                'status' => false,
                'msg' => 'Usuário não encontrado'
            ]);
            return;
        }

        $token = $this->gerarSenha();
		
		$userid 	= $user['data']['id'];
		$nome 		= $user['data']['fullname'];
		$email 		= $user['data']['email'];
		
		$data = [
			'userid' 	=> $userid,
			'email' 	=> $email,
			'token' 	=> $token,
			'data_solicitacao' => date('Y-m-d H:i:s'),
			'expiracao' => date('Y-m-d H:i:s', strtotime('+1 hour'))
		];

		$this->Password_model->inserir_pass($data);

        //$hash = password_hash($novaSenha, PASSWORD_DEFAULT);

        //$this->Moodle_model->salvarSenha($userid,$hash);

        if (!$this->enviarEmail($nome,$email,$token)) {
            echo json_encode(array('status' => false, 'msg' => 'Não foi possível enviar o e-mail de recuperação. Tente novamente mais tarde.'));
            return;
        }

		$email_mascarado = $this->mascararEmail($email);
        
		echo json_encode([
            'status'=>true,
            'msg'=>'Token enviado para o e-mail cadastrado <br>'.$email_mascarado
        ]);

    }

    private function gerarSenha($tamanho=8)
    {
        $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        return substr(str_shuffle($chars),0,$tamanho);
    }

    private function enviarEmail($nome,$email,$senha)
    {

        $this->email->from('noreply@crfmg.org.br', 'Portal Farma');
        $this->email->to($email);

        $this->email->subject('Recuperar Senha');

        $this->email->message("
            <style>

			body{
				margin:0;
				padding:0;
				background:#f2f2f2;
				font-family: Arial, Helvetica, sans-serif;
			}

			.container{
				width:800px;
				margin:auto;
				background:#ffffff;
				border:1px solid #dcdcdc;
				border-radius:8px;
			}

			.header{
				padding:20px;
				border-bottom:1px solid #e5e5e5;
			}

			.header-table{
				width:100%;
			}

			.logo-left{
				text-align:left;
				max-height: 40px !important;
			}

			.logo-right{
				text-align:right;
				max-height:30px !important;
			}

			.content{
				padding:40px 60px;
				text-align:center;
			}

			.titulo{
				font-size:22px;
				font-weight:bold;
				margin-bottom:15px;
			}

			.texto{
				font-size:14px;
				color:#333;
			}

			.codigo-box{
				display:inline-block;
				margin:30px 0;
				padding:20px 40px;
				font-size:32px;
				letter-spacing:6px;
				color:#1e6bd6;
				border:2px solid #1e6bd6;
				border-radius:10px;
				font-weight:bold;
			}

			.codigo-texto{
				font-size:14px;
				color:#1e6bd6;
			}
			
			
			.title-curse{
				color: #12455e;
				font-size:14px;
			}

			.importante{
				color:#d80000;
				font-size:13px;
				margin-top:10px;
			}

			.footer{
				margin-top:40px;
				padding:30px;
				background:#f7f7f7;
				text-align:center;
				font-size:13px;
				color:#555;
			}

			.footer strong{
				display:block;
				margin-bottom:8px;
			}

			</style>
			<div class='container'>

				<!-- HEADER -->
				<div class='header'>
					<table class='header-table'>
						<tr>
							<td class='logo-left'>
								<img src='https://www.crfmg.org.br/portalfarma/assets/img/logo/logo_portalfarma_60.png' alt='Portal Farma' style='max-height: 40px !important'>
							</td>

							<td class='logo-right'>
								<img src='https://www.crfmg.org.br/portalfarma/assets/img/logo/logo_crfmg_comprido_80.png' alt='Logo CRFMG' style='max-height: 40px !important'>
							</td>
						</tr>
					</table>
				</div>


				<!-- CONTEÚDO -->
				<div class='content'>

					<div class='titulo'>
						Olá, {$nome}
					</div>

					<div class='texto'>
						Seu token de acesso é:  <strong class='title-curse'>{$senha}</strong>
					</div>
					
					<div class='texto' style='margin-top:15px;'>
						Acesse o link para redefinir sua senha
						<br><br>
						<a hre='https://www.crfmg.org.br/portalfarma/trocar_senha'> https://www.crfmg.org.br/portalfarma/trocar_senha </a>
					</div>
					
					<div class='texto' style='margin-top:15px;'>
						Após 1(uma) hora do recebimento deste e-mail, este código será invalidado, sendo necessário solicitar o reenvio do e-mail.
						<br><br>
						Caso você não tenha solicitado a redefinição de senha, ignore este e-mail.
					</div>

					<div class='texto' style='margin-top:20px;'>
						Atenciosamente,<br>
						<strong>CRFMG</strong>
					</div>

				</div>


				<!-- FOOTER -->
				<div class='footer'>

					<strong>Conselho Regional de Farmácia de Minas Gerais</strong>

					Rua Rodrigues Caldas, 493 &nbsp; CEP 30190-120 &nbsp; Belo Horizonte/MG<br><br>

					Telefone: (31) 3218-1026 |
					E-mail: capacifar@crfmg.org.br<br><br>

					Horário: segunda a sexta, das 08h às 17h

				</div>

			</div>
        ");

        $this->email->set_mailtype("html");
        return $this->email->send();
        
    }
	
	/*function mascararEmail($email){

		$partes = explode('@', $email);

		$usuario = $partes[0];
		$dominio = $partes[1];

		$inicio = substr($usuario, 0, 3);

		$mascara = str_repeat('*', strlen($usuario) - 3);

		return $inicio . $mascara . '@' . $dominio;

	}*/
	
	private function mascararEmail($email)
	{

		list($usuario,$dominio) = explode('@',$email);

		$inicio = substr($usuario,0,3);
		$fim = substr($usuario,-2);

		$mascara = str_repeat('*', strlen($usuario)-5);

		return $inicio.$mascara.$fim.'@'.$dominio;

	}
	
	public function salvar_nova_senha(){

		$token = $this->input->post('token');
		$senha = $this->input->post('senha');
		
		$reset = $this->Password_model->buscarTokenValido($token);
		
		if(!$reset){
			echo json_encode([
				'status'=>true,
				'msg'=>'Token invalido ou expirado'
			]);
		}

		//var_dump($reset['userid']);exit;
		
		$userid = $reset['id'];

		// atualizar senha via API
		$this->Moodle_model->salvarSenha($userid, $senha);

		// marcar token como usado
		$reset = $this->Password_model->marcarComoUsado($token);

		echo json_encode([
            'status'=>true,
            'msg'=>'Senha alterada com sucesso!'
        ]);
	}

}
