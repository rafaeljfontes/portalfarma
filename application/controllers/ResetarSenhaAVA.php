<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class RecuperaSenhaAva extends MY_Controller {

	public function __construct() {
		parent::__construct();
	}

	public function index()
	{
		$this->load->view('fixo/cabecalho');
		$this->load->view('resetar_senha_ava');
		$this->load->view('fixo/rodape');
	}

	public function resetarSenha()
	{
		$retorno = [];

		try {
			$email = trim((string) $this->input->post('email'));
			$cpf = preg_replace('/[^0-9]/', '', (string) $this->input->post('cpf'));

			if (empty($email) || empty($cpf)) {
				$retorno['type'] = 'danger';
				$retorno['title'] = 'Dados obrigatorios.';
				$retorno['message'] = 'Informe o e-mail e o CPF para redefinir a senha.';

				echo json_encode($retorno);
				exit;
			}

			$this->load->model('Moodle_model');
			$this->load->model('Moodle_api');

			$usuario = $this->Moodle_model->buscar_usuario_por_username($cpf);
			$dadosUsuario = isset($usuario['data']) ? $usuario['data'] : null;

			if (empty($usuario['ok']) || empty($dadosUsuario)) {
				$retorno['type'] = 'danger';
				$retorno['title'] = 'Usuario nao encontrado.';
				$retorno['message'] = 'Verifique o CPF informado.';

				echo json_encode($retorno);
				exit;
			}

			if (strtolower(trim($dadosUsuario['email'])) !== strtolower($email)) {
				$retorno['type'] = 'danger';
				$retorno['title'] = 'Dados nao conferem.';
				$retorno['message'] = 'O e-mail informado nao confere com o CPF.';

				echo json_encode($retorno);
				exit;
			}

			$novaSenhaHash = password_hash($cpf, PASSWORD_DEFAULT);
			$sucesso = $this->Moodle_api->atualizarSenhaMoodle($dadosUsuario['id'], $novaSenhaHash);

			if (!$sucesso) {
				$retorno['type'] = 'danger';
				$retorno['title'] = 'Falha ao redefinir senha.';
				$retorno['message'] = 'Nao foi possivel atualizar a senha no Moodle.';

				echo json_encode($retorno);
				exit;
			}

			$retorno['type'] = 'success';
			$retorno['title'] = 'Tudo certo.';
			$retorno['message'] = 'Senha redefinida para o CPF informado.';

			echo json_encode($retorno);
			exit;
		} catch (Exception $e) {
			echo json_encode([
				'type' => 'danger',
				'title' => 'Erro ao redefinir senha.',
				'message' => $e->getMessage()
			]);
		}
	}
}
