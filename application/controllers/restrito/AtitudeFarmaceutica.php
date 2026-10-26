<?php
defined('BASEPATH') or exit('No direct script access allowed');

class AtitudeFarmaceutica extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $ajax = $this->input->is_ajax_request();
        if (!$this->session->userdata('usuario_logado')) {
            if ($ajax) {
                $this->resposta(401, false, 'Sua sessão expirou. Entre novamente.');
                exit;
            }
            redirect('login');
            exit;
        }
        if (!in_array('atitudes', portalfarma_permissoes($this->session->userdata('permissao')), true)) {
            if ($ajax) {
                $this->resposta(403, false, 'Sem permissão para gerenciar Atitude Farmacêutica.');
                exit;
            }
            show_error('Sem permissão para acessar esta página.', 403);
            exit;
        }
        $this->load->database();
        $this->load->model('Atitude_farmaceutica_model', 'atitudes');
    }

    public function index()
    {
        $pagina = max(1, (int) $this->input->get('pagina'));
        $total = $this->atitudes->total();
        $paginas = max(1, (int) ceil($total / 20));
        $pagina = min($pagina, $paginas);
        $token = $this->session->userdata('atitudes_token');
        if (!$token) {
            $token = bin2hex(random_bytes(32));
            $this->session->set_userdata('atitudes_token', $token);
        }
        $dados = array(
            'projetos' => $this->atitudes->listar(20, ($pagina - 1) * 20),
            'total' => $total, 'pagina' => $pagina, 'paginas' => $paginas,
            'statusDisponivel' => $this->atitudes->campos_status_disponiveis(),
            'faseEvento' => $this->atitudes->obter_fase(),
            'limiteProjetosVotacao' => $this->atitudes->obter_limite_votacao(),
            'token' => $token
        );
        $this->load->view('restrito/fixo/cabecalho');
        $this->load->view('restrito/atitude_farmaceutica_listar', $dados);
        $this->load->view('restrito/fixo/rodape');
    }

    public function alterar_status()
    {
        if ($this->input->method() !== 'post') {
            return $this->resposta(405, false, 'Utilize POST para atualizar o projeto.');
        }
        $token = $this->input->post('token');
        $esperado = $this->session->userdata('atitudes_token');
        if (!is_string($token) || !is_string($esperado) || !hash_equals($esperado, $token)) {
            return $this->resposta(403, false, 'Atualize a página e tente novamente.');
        }
        $id = $this->input->post('id');
        $status = $this->input->post('status');
        $anterior = $this->input->post('status_atual');
        $motivo = $this->input->post('motivo');
        if (!is_string($id) || !ctype_digit($id) || (int) $id <= 0 ||
            !in_array($status, array('1', '2'), true) || !in_array($anterior, array('0', '1', '2'), true) ||
            ($motivo !== null && !is_string($motivo))) {
            return $this->resposta(422, false, 'Dados da decisão inválidos.');
        }
        $motivo = trim((string) $motivo);
        if ($status === '2' && ($motivo === '' || mb_strlen($motivo, 'UTF-8') > 4000)) {
            return $this->resposta(422, false, 'Informe um motivo de recusa com até 4000 caracteres.');
        }
        if (!$this->atitudes->campos_status_disponiveis()) {
            return $this->resposta(503, false, 'Aplique a migração de status da Atitude Farmacêutica no banco.');
        }
        if ($status === '2' && !$this->atitudes->campo_motivo_disponivel()) {
            return $this->resposta(503, false, 'O campo de motivo da recusa ainda não está disponível no banco.');
        }
        if ($anterior !== '0') {
            return $this->resposta(422, false, 'Somente projetos pendentes podem ser analisados.');
        }
        $registro = $this->atitudes->buscar((int) $id);
        if (!$registro) {
            return $this->resposta(404, false, 'Projeto não encontrado.');
        }
        if ((string) $registro->status !== $anterior) {
            return $this->resposta(409, false, 'O projeto foi atualizado por outro usuário. Atualize a página.');
        }
        if ($status === $anterior) {
            return $this->resposta(422, false, 'O projeto já está nesse status.');
        }
        if (!$this->atitudes->decidir((int) $id, (int) $status, $motivo, (int) $anterior)) {
            return $this->resposta(409, false, 'Não foi possível salvar a decisão. Atualize a página e tente novamente.');
        }
        return $this->resposta(200, true, $status === '1' ? 'Projeto foi habilitado.' : 'Projeto recusado com sucesso!',
            array('id' => (int) $id, 'status_projeto' => (int) $status, 'motivo_recusa' => $status === '2' ? $motivo : ''));
    }

    public function comissao()
    {
        $this->load->model('Atitude_comissao_model', 'comissao');
        $token = $this->session->userdata('atitudes_token');
        if (!$token) { $token = bin2hex(random_bytes(32)); $this->session->set_userdata('atitudes_token', $token); }
        $this->load->view('restrito/fixo/cabecalho');
        $this->load->view('restrito/atitude_comissao', array('membros' => $this->comissao->listar_membros(), 'token' => $token));
        $this->load->view('restrito/fixo/rodape');
    }

    public function salvar_membro_comissao()
    {
        if ($this->input->method() !== 'post') return $this->resposta(405, false, 'Utilize POST para salvar.');
        $token = $this->input->post('token'); $esperado = $this->session->userdata('atitudes_token');
        if (!is_string($token) || !is_string($esperado) || !hash_equals($esperado, $token)) return $this->resposta(403, false, 'Atualize a página e tente novamente.');
        $nome = $this->input->post('nome'); $email = $this->input->post('email'); $ativo = $this->input->post('ativo');
        if (!is_string($nome) || trim($nome) === '' || mb_strlen(trim($nome), 'UTF-8') > 150 || !is_string($email) || strlen(trim($email)) > 254 || !filter_var(trim($email), FILTER_VALIDATE_EMAIL) || !in_array($ativo, array('0', '1'), true)) return $this->resposta(422, false, 'Informe nome, e-mail válido e situação do membro.');
        $this->load->model('Atitude_comissao_model', 'comissao');
        if (!$this->comissao->salvar_membro(trim($nome), strtolower(trim($email)), (int) $ativo)) return $this->resposta(503, false, 'Não foi possível salvar o membro.');
        return $this->resposta(200, true, 'Cadastro da comissão atualizado!');
    }

    public function alterar_fase()
    {
        if ($this->input->method() !== 'post') return $this->resposta(405, false, 'Utilize POST para alterar a fase.');
        $token = $this->input->post('token');
        $esperado = $this->session->userdata('atitudes_token');
        if (!is_string($token) || !is_string($esperado) || !hash_equals($esperado, $token)) {
            return $this->resposta(403, false, 'Atualize a página e tente novamente.');
        }
        $fase = $this->input->post('fase');
        $anterior = $this->input->post('fase_atual');
        if (!in_array($fase, array('inscricao', 'votacao', 'encerrado'), true) || !in_array($anterior, array('inscricao', 'votacao', 'encerrado'), true) || $fase === $anterior) {
            return $this->resposta(422, false, 'Selecione uma nova fase válida.');
        }
        if (!$this->atitudes->salvar_fase($fase, $anterior)) {
            return $this->resposta(409, false, 'Não foi possível salvar a fase. Atualize a página e verifique a permissão de escrita do arquivo de configuração.');
        }
        $mensagens = array('votacao' => 'Votação aberta. Inscrições encerradas.', 'inscricao' => 'Inscrições abertas. Votação fechada.', 'encerrado' => 'Inscrições e votação encerradas.');
        return $this->resposta(200, true, $mensagens[$fase], array('fase' => $fase));
    }

    public function salvar_limite_votacao()
    {
        if ($this->input->method() !== 'post') return $this->resposta(405, false, 'Utilize POST para alterar o limite.');
        $token = $this->input->post('token'); $esperado = $this->session->userdata('atitudes_token');
        if (!is_string($token) || !is_string($esperado) || !hash_equals($esperado, $token)) return $this->resposta(403, false, 'Atualize a página e tente novamente.');
        $limite = $this->input->post('limite'); $anterior = $this->input->post('limite_atual');
        if (!is_string($limite) || !is_string($anterior) || !preg_match('/\A[1-9][0-9]{0,2}\z/', $limite) || !preg_match('/\A[1-9][0-9]{0,2}\z/', $anterior) || (int) $limite > 100 || (int) $anterior > 100) return $this->resposta(422, false, 'Informe um limite entre 1 e 100 projetos.');
        $this->load->library('Atitude_evento');
        if (!$this->atitude_evento->salvar_limite_votacao((int) $limite, (int) $anterior)) return $this->resposta(409, false, 'Não foi possível salvar o limite. Atualize a página e tente novamente.');
        return $this->resposta(200, true, 'Limite da votação popular atualizado!', array('limite' => (int) $limite));
    }

    public function resultados()
    {
        if ($this->input->method() !== 'get') return $this->resposta(405, false, 'Utilize GET para consultar os resultados.');
        $dados = $this->atitudes->resultados_votacao();
        if ($dados === null) return $this->resposta(503, false, 'Não foi possível apurar os resultados. Verifique as tabelas de avaliações da comissão e da votação popular.');
        return $this->resposta(200, true, 'Resultados atualizados.', $dados);
    }

    private function resposta($codigo, $sucesso, $mensagem, $dados = array())
    {
        $dados = array_merge($dados, array('success' => $sucesso, 'message' => $mensagem,
            'csrf_name' => $this->security->get_csrf_token_name(), 'csrf_hash' => $this->security->get_csrf_hash()));
        return $this->output->set_status_header($codigo)->set_content_type('application/json', 'utf-8')
            ->set_output(json_encode($dados, JSON_UNESCAPED_UNICODE));
    }
}
