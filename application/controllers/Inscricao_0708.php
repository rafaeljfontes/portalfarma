<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Inscricao extends CI_Controller {

    //private $course_id = 123; // ID do curso no Moodle

    public function __construct() {
        parent::__construct();
		$dados = array();
        $this->load->model('Moodle_model');
		$this->load->model('Moodle_api');
        $this->load->library('email');
        $this->load->helper(['url', 'form']);
    }

   /* public function index() {
        $this->load->view('inscricao');
    }*/

    public function salvar() {

        $retorno = [];

        $retorno['type']    = "";
        $retorno['message'] = "";


        $nome   	= $this->input->post('nome');
        $cpf    	= preg_replace('/\D/', '', $this->input->post('cpf'));
        $cidade 	= $this->input->post('cidade');
        $email  	= $this->input->post('email');
        $crfmg  	= $this->input->post('crfmg');
        $telefone  	= $this->input->post('telefone');
        $course_id  = $this->input->post('course_id');
        $curso  	= $this->input->post('curso_titulo');
        $evento  	= $this->input->post('campo_evento');
        $pais  		= 'BR';

        $username  = $cpf;
        // $senhaTemp = $this->gerarSenha();
        $senhaTemp = $cpf;
        

        // verifica se o usuário ja existe e pega os dados
        $usuario_existe = $this->Moodle_model->usuario_existe($username);
        
		//echo 'Usuário Existe';
		//print_r($usuario_existe);exit;

        if( $usuario_existe['ok'] && !empty($usuario_existe['data']['id']) ) {
            
            $userid 	= $usuario_existe['data']['id'] ?? 0;
            $nome 		= trim(($usuario_existe['data']['firstname'] ?? '') . ' ' . str_replace('-', '', $usuario_existe['data']['lastname'] ?? ''));
            $email 		= $usuario_existe['data']['email'] ?? $email;
            $cidade 	= $usuario_existe['data']['city'] ?? $cidade;
            $telefone 	= $usuario_existe['data']['phone1'] ?? $telefone;
            $crfmg 		= $usuario_existe['data']['idnumber'] ?? $crfmg;
			$pais 		= $usuario_existe['data']['country'] ?? 'BR';

        }else{

            // se não existir criar um novo usuário
            $user = $this->Moodle_model->criar_usuario(
                $username, $senhaTemp, $nome, $email, $cidade, $crfmg, $telefone, $pais
            );
            $error = false;

            if (is_array($user) && $user['ok'] == false) {
                $raw = json_decode($user['error']['raw'], true);
                $error = [
                    'ok'   => false,
                    'data' => null,
                    'error' => [
                        'code'      => $raw['errorcode'] ?? 'moodle_exception',
                        'message'   => $raw['message'] ?? 'Erro no Moodle WebService.',
                        'debug'     => $raw['debuginfo'] ?? null,
                        'message'   => $raw['debuginfo'] ?? null,
                        'http_code' => $user['error']['http_code'] ?? null,
                        'raw'       => $user['error']['raw'] ?? null,
                    ],
                ];
            }

            if( !empty($error) ) {

                $retorno['type']    = "danger";
                $retorno['message'] = 'Erro ao criar usuário no Moodle: ' . $error['error']['message'] ?? '';

                $this->session->set_flashdata('type', $retorno['type']);
                $this->session->set_flashdata('message', $retorno['message']);
                redirect($rotaRetorno);
            }

            $userid = $user['data'][0]['id'] ?? 0;
        }

        if( empty($userid) ) {
            $retorno['type']    = "danger";
            $retorno['message'] = 'Erro ao obter ID do usuário no Moodle.';

            $this->session->set_flashdata('type', $retorno['type']);
            $this->session->set_flashdata('message', $retorno['message']);
            redirect($rotaRetorno);
        }

        // verifica se o usuário já está inscrito no curso
        $esta_matriculado = $this->Moodle_model->esta_matriculado($userid, $course_id);
        
        $inscrito = false;
        if( $esta_matriculado['data']['enrolled'] == false ) {

            // usuário não está inscrito - deve matricular usuário no curso
            $inscrever = $this->Moodle_model->inscrever_curso($userid, $course_id);
            $inscrito = true;   

	}else{
            $inscrito = true;
        }

        #echo "<pre>";
        #var_dump($esta_matriculado, $inscrito);
        #die;

        // envia email
        $this->enviar_email($nome, $email, $username, $senhaTemp, $curso, $evento);

        //$retorno['type']    = "success";
        //$retorno['message'] = "Inscrição realizada com sucesso!<br>Clique aqui para <a href='https://portalfarma.crfmg.org.br/moodle/login/index.php' target='_blank'>Acessar Moodle</a>. <br> Use seu CPF como usuário e senha.";
		
		$this->session->set_flashdata('type', 'success');
		$this->session->set_flashdata('message', 'Inscrição realizada com sucesso!');
		
        //$this->session->set_flashdata('type', $retorno['type']);
        //$this->session->set_flashdata('message', $retorno['message']);
        redirect($rotaRetorno);
    }

     public function stranger_save() {

        $retorno = [];

        $retorno['type']    = "";
        $retorno['message'] = "";


	//teste print_r($this->input->post());exit;

        $nome   	= $this->input->post('nome');
        $cpf    	= preg_replace('/\D/', '', $this->input->post('pass'));
        $cidade 	= $this->input->post('cidade');
        $email  	= $this->input->post('email');
        $crfmg  	= $this->input->post('crfmg');
        $telefone  	= $this->input->post('telefone');
        $course_id  = $this->input->post('course_id');
        $curso  	= $this->input->post('curso_titulo');
        $evento  	= $this->input->post('campo_evento');
		$pais  		= $this->input->post('pais');

        $username  = $cpf;
        // $senhaTemp = $this->gerarSenha();
        $senhaTemp = $cpf;
        

        // verifica se o usuário ja existe e pega os dados
        $usuario_existe = $this->Moodle_model->usuario_existe($username);
        
		//echo 'Usuário Existe';
		//print_r($usuario_existe);exit;

        if( $usuario_existe['ok'] && !empty($usuario_existe['data']['id']) ) {
            
            $userid 	= $usuario_existe['data']['id'] ?? 0;
            $nome 		= trim(($usuario_existe['data']['firstname'] ?? '') . ' ' . str_replace('-', '', $usuario_existe['data']['lastname'] ?? ''));
            $email 		= $usuario_existe['data']['email'] ?? $email;
            $cidade 	= $usuario_existe['data']['city'] ?? $cidade;
            $telefone 	= $usuario_existe['data']['phone1'] ?? $telefone;
            $crfmg 		= $usuario_existe['data']['idnumber'] ?? $crfmg;
			$pais 		= $usuario_existe['data']['country'] ?? 'BR';

        }else{

            // se não existir criar um novo usuário
            $user = $this->Moodle_model->criar_usuario(
                $username, $senhaTemp, $nome, $email, $cidade, $crfmg, $telefone, $pais
            );
            $error = false;

			//print_r($user);exit;

            if (is_array($user) && $user['ok'] == false) {
                $raw = json_decode($user['error']['raw'], true);
                $error = [
                    'ok'   => false,
                    'data' => null,
                    'error' => [
                        'code'      => $raw['errorcode'] ?? 'moodle_exception',
                        'message'   => $raw['message'] ?? 'Erro Moodle WebService.',
                        'debug'     => $raw['debuginfo'] ?? null,
                        'message'   => $raw['debuginfo'] ?? null,
                        'http_code' => $user['error']['http_code'] ?? null,
                        'raw'       => $user['error']['raw'] ?? null,
                    ],
                ];
            }

            if( !empty($error) ) {

                $retorno['type']    = "danger";
                $retorno['message'] = 'Erro ao criar usuário no Moodle: ' . $error['error']['message'] ?? '';

                $this->session->set_flashdata('type', $retorno['type']);
                $this->session->set_flashdata('message', $retorno['message']);
                redirect('curso/inscricao/'.$course_id);
            }

            $userid = $user['data'][0]['id'] ?? 0;
        }

        if( empty($userid) ) {
            $retorno['type']    = "danger";
            $retorno['message'] = 'Erro ao obter ID do usuário no Moodle.';

            $this->session->set_flashdata('type', $retorno['type']);
            $this->session->set_flashdata('message', $retorno['message']);
            redirect('curso/inscricao/'.$course_id);
        }

        // verifica se o usuário já está inscrito no curso
        $esta_matriculado = $this->Moodle_model->esta_matriculado($userid, $course_id);
        
        $inscrito = false;
        if( $esta_matriculado['data']['enrolled'] == false ) {

            // usuário não está inscrito - deve matricular usuário no curso
            $inscrever = $this->Moodle_model->inscrever_curso($userid, $course_id);
            $inscrito = true;   

	}else{
            $inscrito = true;
        }

        #echo "<pre>";
        #var_dump($esta_matriculado, $inscrito);
        #die;

        // envia email
        $this->enviar_email($nome, $email, $username, $senhaTemp, $curso, $evento);

        //$retorno['type']    = "success";
        //$retorno['message'] = "Inscrição realizada com sucesso!<br>Clique aqui para <a href='https://portalfarma.crfmg.org.br/moodle/login/index.php' target='_blank'>Acessar Moodle</a>. <br> Use seu CPF como usuário e senha.";
		
		$this->session->set_flashdata('type', 'success');
		$this->session->set_flashdata('message', 'Registration successfully completed!');
		$this->session->set_flashdata('yourpass', $username);
		
        //$this->session->set_flashdata('type', $retorno['type']);
        //$this->session->set_flashdata('message', $retorno['message']);
        redirect('curso/inscricao_teste/'.$course_id);
    }
	
	private function gerarSenha($tamanho = 10) {
        return substr(str_shuffle('ABCDEFGHJKLMNPQRSTUVWXYZabcdefghijkmnopqrstuvwxyz23456789@!'), 0, $tamanho);
    }

    private function gerarCodigoEstrangeiro($email) {
        $emailNormalizado = trim(strtolower((string) $email));
        $valor = hexdec(substr(hash('sha256', $emailNormalizado), 0, 12));
        return str_pad((string) ($valor % 100000000000), 11, '0', STR_PAD_LEFT);
    }

    private function enviar_email($nome, $email, $usuario, $senha, $curso, $evento) {

        $this->email->from('noreply@crfmg.org.br', 'Portal Farma');
        $this->email->to($email);

        $this->email->subject('Acesso ao curso');

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
						Sua inscrição foi realizada com sucesso no curso  <strong class='title-curse'>{$curso}</strong>
					</div>

					<div class='texto' style='margin-top:15px;'>
						Acesse o <a hfer='https://portalfarma.crfmg.org.br/moodle/'>portalfarma - Aulas</a> para visualizar o conteúdo dos cursos
						</div>
					
					<div class='importante'>
						<strong>Importante:</strong>
						<p><strong>Usuário:</strong> {$usuario}<br>
						<strong>Senha temporária:</strong> {$senha}</p>
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
	
	public function salvar_teste() {
	
		var_dump($this->input->post());
		var_dump($this->input->post('publico_alvo'));
		var_dump($this->input->post('cpf'));
		
		/*
		APENAS TESTE
		*/
		exit;
	
        $this->load->view('inscricao_teste');
    }
	
	
	public function verifica_inscrito()
    {
		
		
		$cpf = $this->input->post('cpf');

        $cpf = preg_replace('/[^0-9]/', '', $cpf);

        header('Content-Type: application/json');

        if (strlen($cpf) !== 11) {
            echo json_encode([
                'encontrado' => false,
                'message' => 'CPF invÃ¡lido.'
            ]);
            exit;
        }
		
		$usuario = $this->Moodle_api->get_user_entrol($cpf);

		// 1. Verifica se $usuario é uma array, se não está vazia e se a posição 0 existe e é um objeto
		if (is_array($usuario) && !empty($usuario[0]) && is_object($usuario[0])) {
			
			$dados = $usuario[0]; // Captura o objeto do usuário

			// 2. Verifica se o ID existe, não está vazio e é diferente de zero
			if (!empty($dados->id) && $dados->id != 0) {
				
				echo json_encode([
					'encontrado' => true,
					'usuario' => [
						'id'       => $dados->id,
						'nome'     => isset($dados->Nome_Completo) ? trim(str_replace('-', '', $dados->Nome_Completo)) : '',
						'email'    => $dados->Email ?? '',
						'cidade'   => $dados->city ?? '',
						'telefone' => $dados->Telefone ?? '',
						'crfmg'    => $dados->idnumber ?? ''
					]
				], JSON_UNESCAPED_UNICODE); // Mantém a acentuação correta no JSON
				
				exit; // Interrompe a execução para não cair no bloco de "não encontrado"
			}
		}

		// Se falhar em qualquer uma das validações acima, retorna falso
		echo json_encode(['encontrado' => false]);

        exit;
		
    }
	
	public function verifica_farmaceutico()
    {
        
		
		$cpf = $this->input->post('cpf');

        $cpf = preg_replace('/[^0-9]/', '', $cpf);

        $return = $this->Moodle_api->verifica_farma_sys($cpf);
		
		// converter JSON para array
		$farma = json_decode($return, true);

		// pegar apenas o message
		$pf = $farma['message'] ?? 'não encontrado';

		
		header('Content-Type: application/json');
		echo json_encode($pf);
		exit;
    }
	
}
?>
