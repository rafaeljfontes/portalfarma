<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Gerenciar_usuarios extends CI_Controller
{
	private $permissoesPermitidas = array(
		'admin', 'dashboard', 'capacifar', 'atitudes', 'tragadevolta', 'receitas', 'cientificos', 'BJHP'
	);

	public function __construct()
	{
		parent::__construct();

		if (!$this->session->userdata('usuario_logado')) {
			redirect('login');
		}

		if (!in_array('admin', portalfarma_permissoes($this->session->userdata('permissao')), true)) {
			$this->load->view('restrito/acesso_negado');
			exit;
		}

		$this->load->model('usuarios', 'usuarios_model', true);
	}

	public function index()
	{
		$dados = array(
			'usuarios' => $this->usuarios_model->listar_portalfarma(),
			'permissoesPermitidas' => $this->permissoesPermitidas
		);

		$this->load->view('restrito/fixo/cabecalho');
		$this->load->view('restrito/usuarios_listar', $dados);
		$this->load->view('restrito/fixo/rodape');
	}

	public function novo()
	{
		$this->load->view('restrito/fixo/cabecalho');
		$this->load->view('restrito/usuario_form', array(
			'permissoesPermitidas' => $this->permissoesPermitidas
		));
		$this->load->view('restrito/fixo/rodape');
	}

	public function salvar()
	{
		if (strtoupper($this->input->method()) !== 'POST') {
			show_error('Método não permitido', 405);
		}

		$nome = trim((string) $this->input->post('nome'));
		$usuario = trim((string) $this->input->post('user'));
		$selecionadas = $this->input->post('permissoes');
		$selecionadas = is_array($selecionadas) ? $selecionadas : array();
		$selecionadas = array_values(array_intersect($this->permissoesPermitidas, $selecionadas));
		$status = (int) $this->input->post('status') === 1 ? 1 : 0;

		$this->session->set_flashdata('usuario_form_dados', array(
			'nome' => $nome,
			'user' => $usuario,
			'permissoes' => $selecionadas,
			'status' => $status
		));

		if ($nome === '') {
			$this->session->set_flashdata('usuario_form_erro', 'Informe o nome.');
			redirect('restrito/usuarios/novo');
		}

		if (mb_strlen($nome, 'UTF-8') > 255) {
			$this->session->set_flashdata('usuario_form_erro', 'O nome deve ter no máximo 255 caracteres.');
			redirect('restrito/usuarios/novo');
		}

		if ($usuario === '') {
			$this->session->set_flashdata('usuario_form_erro', 'Informe o usuário.');
			redirect('restrito/usuarios/novo');
		}

		if (strlen($usuario) > 255) {
			$this->session->set_flashdata('usuario_form_erro', 'O usuário deve ter no máximo 255 caracteres.');
			redirect('restrito/usuarios/novo');
		}

		if ($this->usuarios_model->buscar_por_usuario($usuario)) {
			$this->session->set_flashdata('usuario_form_erro', 'Este usuário já está cadastrado.');
			redirect('restrito/usuarios/novo');
		}

		if (!$this->usuarios_model->criar_portalfarma($usuario, $selecionadas, $status, $nome)) {
			$this->session->set_flashdata('usuario_form_erro', 'Não foi possível cadastrar o usuário.');
			redirect('restrito/usuarios/novo');
		}

		$this->session->set_flashdata('usuarios_sucesso', 'Usuário cadastrado com sucesso.');
		redirect('restrito/usuarios');
	}

	public function permissoes()
	{
		if (strtoupper($this->input->method()) !== 'POST') {
			show_error('Método não permitido', 405);
		}

		$id = (int) $this->input->post('id');
		$selecionadas = $this->input->post('permissoes');
		$selecionadas = is_array($selecionadas) ? $selecionadas : array();
		$selecionadas = array_values(array_intersect($this->permissoesPermitidas, $selecionadas));
		$status = (int) $this->input->post('status') === 1 ? 1 : 0;
		$redirecionamento = 'restrito/usuarios';

		if ($id <= 0) {
			$this->session->set_flashdata('usuarios_erro', 'Usuário inválido.');
			redirect('restrito/usuarios');
		}

		$usuarioAtual = $this->session->userdata('usuario_logado');
		if ((int) ($usuarioAtual['id'] ?? 0) === $id && $status === 0) {
			$this->session->set_flashdata('usuarios_erro', 'Você não pode inativar o próprio usuário.');
			redirect('restrito/usuarios');
		}

		if ($this->usuarios_model->atualizar_acesso($id, $selecionadas, $status)) {
			if ((int) ($usuarioAtual['id'] ?? 0) === $id) {
				$this->session->set_userdata('permissao', implode(', ', $selecionadas));
				if (!in_array('admin', $selecionadas, true)) {
					$redirecionamento = 'restrito/calendario';
				}
			}
			$this->session->set_flashdata('usuarios_sucesso', 'Acesso do usuário atualizado com sucesso.');
		} else {
			$this->session->set_flashdata('usuarios_erro', 'Não foi possível atualizar as permissões.');
		}

		redirect($redirecionamento);
	}
}
