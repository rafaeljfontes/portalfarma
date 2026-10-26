<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class AtitudeFarmaceutica extends CI_Controller {
    public function index() {
        $this->load->database();
        $this->load->model('Atitude_farmaceutica_model', 'atitudes');
        $dados['projetosAceitos'] = $this->atitudes->listar_aceitos();
        $dados['faseEvento'] = $this->atitudes->obter_fase();
        $this->load->model('capacifar_model');
        $dados['tabelaCursoMenu'] = $this->capacifar_model->query('SELECT * FROM web_site.tbl_portalfarma WHERE status = 1 ORDER BY data_fim DESC');
        $this->load->view('atitude-farmaceutica/atitude_farmacêutica', $dados);
    }

    public function inscricao() {
        $this->load->database();
        $this->load->model('capacifar_model');
        $dados['tabelaCursoMenu'] = $this->capacifar_model->query('SELECT * FROM web_site.tbl_portalfarma WHERE status = 1 ORDER BY data_fim DESC');
        $this->load->library('Atitude_evento');
        $dados['dataInicioMaxima'] = self::dataInicioMaxima();
        $dados['cidades_mineiras'] = $this->cidadesMineiras();
        $this->load->view($this->atitude_evento->obter_fase() === 'inscricao' ? 'atitude-farmaceutica/inscricao_view' : 'atitude-farmaceutica/inscricao_encerrada', $dados);
    }

    private static function dataInicioMaxima($hoje = null) {
        $hoje = $hoje ?? new DateTimeImmutable('today', new DateTimeZone('America/Sao_Paulo'));
        $mes = $hoje->modify('first day of this month')->modify('-6 months');
        $dia = min((int) $hoje->format('j'), (int) $mes->format('t'));
        return $mes->setDate((int) $mes->format('Y'), (int) $mes->format('n'), $dia)->format('Y-m-d');
    }

    private function cidadesMineiras() {
        require APPPATH . 'views/estados_cidades.php';
        return $cidades_mineiras;
    }

    public function votacao() {
        $this->load->database();
        $this->load->model('Atitude_farmaceutica_model', 'atitudes');
        $this->load->model('capacifar_model');
        $token = $this->session->userdata('atitude_voto_token');
        if (!$token) {
            $token = bin2hex(random_bytes(32));
            $this->session->set_userdata('atitude_voto_token', $token);
        }
        $aberta = $this->atitudes->obter_fase() === 'votacao';
        $this->load->library('Atitude_voto_popular');
        $this->load->view('atitude-farmaceutica/votacao', array(
            'votacaoAberta' => $aberta,
            'projetosAceitos' => $aberta ? $this->atitudes->listar_aceitos() : array(),
            'tokenVoto' => $token,
            'limiteProjetosVotacao' => $this->atitudes->obter_limite_votacao(),
            'criteriosVotacao' => $this->atitude_voto_popular->criterios(),
            'tabelaCursoMenu' => $this->capacifar_model->query('SELECT * FROM web_site.tbl_portalfarma WHERE status = 1 ORDER BY data_fim DESC')
        ));
    }

    public function votacao_comissao() {
        $this->load->database();
        $this->load->model('Atitude_farmaceutica_model', 'atitudes');
        $this->load->model('capacifar_model');
        $this->load->model('Atitude_comissao_model', 'comissao');
        $emailMembro = $this->session->userdata('atitude_comissao_email');
        $membro = is_string($emailMembro) ? $this->comissao->membro($emailMembro) : false;
        $token = $this->session->userdata('atitude_comissao_token');
        if (!$token) {
            $token = bin2hex(random_bytes(32));
            $this->session->set_userdata('atitude_comissao_token', $token);
        }
        $this->load->view('atitude-farmaceutica/votacao_comissao', array(
            'projetosAceitos' => $membro ? $this->atitudes->listar_aceitos() : array(),
            'membroComissao' => $membro,
            'tokenComissao' => $token,
            'tabelaCursoMenu' => $this->capacifar_model->query('SELECT * FROM web_site.tbl_portalfarma WHERE status = 1 ORDER BY data_fim DESC')
        ));
    }

    public function identificar_comissao() {
        if ($this->input->method() !== 'post') return $this->resposta(405, false, 'Utilize POST para se identificar.');
        $token = $this->input->post('token'); $esperado = $this->session->userdata('atitude_comissao_token');
        if (!is_string($token) || !is_string($esperado) || !hash_equals($esperado, $token)) return $this->resposta(403, false, 'Atualize a página e tente novamente.');
        $this->session->unset_userdata('atitude_comissao_email');
        $email = $this->input->post('email');
        if (!is_string($email) || strlen(trim($email)) > 254 || !filter_var(trim($email), FILTER_VALIDATE_EMAIL)) return $this->resposta(422, false, 'Informe um e-mail válido.');
        $email = strtolower(trim($email));
        $this->load->database(); $this->load->model('Atitude_comissao_model', 'comissao');
        $membro = $this->comissao->membro($email);
        if ($membro === null) return $this->resposta(503, false, 'Não foi possível consultar o cadastro. Tente novamente.');
        if (!$membro) return $this->resposta(403, false, 'Este e-mail não está autorizado a votar pela comissão.');
        $this->session->set_userdata('atitude_comissao_email', $email);
        return $this->resposta(200, true, 'Cadastro localizado. Votação liberada.');
    }

    public function salvar_comissao() {
        if ($this->input->method() !== 'post') return $this->resposta(405, false, 'Utilize POST para enviar a avaliação.');
        $token = $this->input->post('token');
        $esperado = $this->session->userdata('atitude_comissao_token');
        if (!is_string($token) || !is_string($esperado) || !hash_equals($esperado, $token)) {
            return $this->resposta(403, false, 'Atualize a página e tente novamente.');
        }
        $email = $this->input->post('email');
        if (!is_string($email) || strlen(trim($email)) > 254 || !filter_var(trim($email), FILTER_VALIDATE_EMAIL)) {
            return $this->resposta(422, false, 'Informe um e-mail válido.');
        }
        $email = strtolower(trim($email));
        if ($this->session->userdata('atitude_comissao_email') !== $email) return $this->resposta(403, false, 'Identifique-se com um e-mail cadastrado na comissão antes de votar.');
        $notas = $this->input->post('notas');
        if (!is_array($notas) || !$notas) return $this->resposta(422, false, 'Avalie todos os critérios de todos os projetos.');
        $this->load->database();
        $this->load->model('Atitude_comissao_model', 'comissao');
        $erro = $this->comissao->registrar(strtolower(trim($email)), $notas);
        if ($erro === 'autorizacao') return $this->resposta(403, false, 'Seu cadastro não está autorizado a votar pela comissão.');
        if ($erro === 'duplicado') return $this->resposta(409, false, 'Este e-mail já enviou uma avaliação da comissão.');
        if ($erro === 'notas') return $this->resposta(422, false, 'Avalie todos os projetos aprovados nos cinco critérios, com notas de 1 a 5. Se a lista mudou, atualize a página.');
        if ($erro !== null) return $this->resposta(503, false, 'Não foi possível registrar a avaliação. Tente novamente mais tarde.');
        return $this->resposta(200, true, 'Voto registrado com sucesso!');
    }

    private function dados_voto() {
        if ($this->input->method() !== 'post') { $this->resposta(405, false, 'Utilize POST para votar.'); return null; }
        $token = $this->input->post('token');
        $esperado = $this->session->userdata('atitude_voto_token');
        if (!is_string($token) || !is_string($esperado) || !hash_equals($esperado, $token)) {
            $this->resposta(403, false, 'Atualize a página de votação e tente novamente.'); return null;
        }
        $email = $this->input->post('email');
        $ids = $this->input->post('projetos');
        if (!is_string($email) || strlen(trim($email)) > 254 || !filter_var(trim($email), FILTER_VALIDATE_EMAIL)) {
            $this->resposta(422, false, 'Informe um e-mail válido.'); return null;
        }
        $this->load->library('Atitude_evento');
        $this->load->library('Atitude_voto_popular');
        $limite = $this->atitude_evento->obter_limite_votacao();
        $linhas = $this->atitude_voto_popular->preparar($ids, $this->input->post('notas'), $limite);
        if ($linhas === null) {
            $this->resposta(422, false, 'Selecione exatamente ' . $limite . ' projeto(s) distinto(s) e atribua notas de 1 a 5 aos cinco critérios de cada um. Se o limite mudou, atualize a página.'); return null;
        }
        $email = strtolower(trim($email));
        return array('email' => $email, 'ids' => array_column($linhas, 'id_proejto'), 'notas' => $this->input->post('notas'));
    }

    public function solicitar_codigo() {
        return $this->resposta(410, false, 'A votação não utiliza mais código por e-mail. Atualize a página e envie sua avaliação diretamente.');
    }

    public function votar() {
        $dados = $this->dados_voto();
        if ($dados === null) return;
        $ip = $this->atitude_voto_popular->normalizar_ip($this->input->ip_address());
        if ($ip === null) return $this->resposta(422, false, 'Não foi possível identificar seu endereço IP para registrar o voto.');
        $this->load->database();
        $this->load->model('Atitude_farmaceutica_model', 'atitudes');
        $codigo = strtoupper(bin2hex(random_bytes(8)));
        $erro = $this->atitudes->registrar_votos($dados['email'], $codigo, $dados['ids'], $dados['notas'], $ip);
        $mensagens = array(
            'fase' => array(409, 'A votação está fechada.'),
            'projeto' => array(422, 'Um dos projetos selecionados não está mais disponível para votação. Atualize a página.'),
            'duplicado' => array(409, 'Este e-mail já participou da votação.'),
            'ip_duplicado' => array(409, 'Já foi registrado um voto neste endereço IP. É permitido apenas um envio por IP.'),
            'ip' => array(422, 'Não foi possível identificar seu endereço IP para registrar o voto.'),
            'notas' => array(422, 'O limite de projetos ou as notas são inválidos. Atualize a página e confira sua avaliação.'),
            'banco' => array(503, 'Não foi possível registrar os votos. Tente novamente mais tarde.')
        );
        if ($erro !== null) {
            $mensagem = $mensagens[$erro] ?? $mensagens['banco'];
            return $this->resposta($mensagem[0], false, $mensagem[1]);
        }
        $this->session->unset_userdata('atitude_voto_confirmacao');
        return $this->resposta(200, true, 'Voto registrado com sucesso!', array('codigo' => $codigo, 'total' => count($dados['ids'])));
    }
    public function salvar() {
        if ($this->input->method() !== 'post') {
            return $this->resposta(405, false, 'Utilize POST para enviar a inscrição.');
        }
        $this->load->library('Atitude_evento');
        if ($this->atitude_evento->obter_fase() !== 'inscricao') {
            return $this->resposta(409, false, 'As inscrições estão encerradas. Agradecemos o seu interesse!');
        }
        $this->load->library('form_validation');
        $this->load->library('Atitude_solicitante');
        $verificado = $this->session->userdata('atitude_solicitante_verificado');
        if (!$this->atitude_solicitante->confirmado($verificado, $this->input->post('tipo_solicitante'), $this->input->post('numero_crf'))) {
            return $this->resposta(403, false, 'É necessário localizar o cadastro do solicitante na base do CRF/MG antes de realizar a inscrição.');
        }
        $campos = array(
            'cpf' => array('CPF', 'exact_length[11]|numeric'),
            'tipo_solicitante' => array('Tipo de solicitante', 'required|in_list[farmaceutico,empresa]'),
            'nome' => array('Nome do solicitante', 'required|max_length[255]'),
            'numero_crf' => array('Número do CRF', 'required|max_length[50]|numeric'),
            'email' => array('Email', 'valid_email|max_length[254]'),
            'celular' => array('Celular', 'required|max_length[20]'),
            'cidade_farmaceutico' => array('Cidade do solicitante', 'required|max_length[150]'),
            'nome_projeto' => array('Nome do projeto', 'required|max_length[150]'),
            'eixo_projeto' => array('Eixo do projeto', 'required|max_length[150]'),
            'numero_pessoas' => array('Número de pessoas', 'required|max_length[3]|is_natural_no_zero|less_than_equal_to[999]'),
            'cidade_projeto' => array('Cidade do projeto', 'required|max_length[150]'),
            'local_projeto' => array('Local do projeto', 'required|max_length[255]'),
            'data_inicio' => array('Data de início', 'required'),
            'recursos' => array('Recursos', 'required|max_length[100]'),
            'resumo_projeto' => array('Resumo do projeto', 'required|max_length[480]'),
            'descricao_projeto' => array('Descrição do projeto', 'required|max_length[600]'),
            'justificativa' => array('Justificativa', 'required|max_length[150]'),
            'pessoas_alcancadas' => array('Pessoas alcançadas', 'max_length[16000]'),
            'beneficios_alcancados' => array('Benefícios alcançados', 'required|max_length[250]'),
            'objetivos_alcancados' => array('Objetivos alcançados', 'required|max_length[250]')
        );
        $dados = array();
        foreach ($campos as $campo => $regra) {
            $valor = $this->input->post($campo);
            if ($valor !== null && !is_string($valor)) {
                return $this->resposta(422, false, 'Formato inválido nos campos da inscrição.');
            }
            $dados[$campo] = trim((string) $valor);
        }
        $dados['cpf'] = preg_replace('/[.\-\s]/', '', $dados['cpf']);
        $dados['nome'] = $verificado['nome'];
        if ($dados['tipo_solicitante'] === 'empresa') $dados['cidade_farmaceutico'] = $verificado['cidade'];
        $this->form_validation->set_data($dados);
        foreach ($campos as $campo => $regra) {
            $this->form_validation->set_rules($campo, $regra[0], $regra[1]);
        }
        if (!$this->form_validation->run()) {
            return $this->resposta(422, false, implode("\n", $this->form_validation->error_array()));
        }
        $data = DateTime::createFromFormat('!Y-m-d', $dados['data_inicio']);
        $eixos = array('Eixo 1: Envolvimento e desenvolvimento da comunidade', 'Eixo 2: Práticas exitosas de trabalho', 'Eixo 3: Respeito e proteção do Meio Ambiente');
        if (!$data || $data->format('Y-m-d') !== $dados['data_inicio'] || !in_array($dados['eixo_projeto'], $eixos, true)) {
            return $this->resposta(422, false, 'Data de início ou eixo do projeto inválido.');
        }
        $dataMaxima = self::dataInicioMaxima();
        if ($dados['data_inicio'] > $dataMaxima) {
            return $this->resposta(422, false, 'O projeto deve ter iniciado há pelo menos 6 meses. Informe uma data até ' . DateTimeImmutable::createFromFormat('!Y-m-d', $dataMaxima)->format('d/m/Y') . '.');
        }
        $cidadesMineiras = $this->cidadesMineiras();
        if (!in_array($dados['cidade_projeto'], $cidadesMineiras, true)) {
            return $this->resposta(422, false, 'Selecione uma cidade válida na lista de municípios.');
        }
        if ($dados['tipo_solicitante'] === 'farmaceutico' && !in_array($dados['cidade_farmaceutico'], $cidadesMineiras, true)) {
            return $this->resposta(422, false, 'Selecione uma cidade válida para o solicitante.');
        }
        if (!in_array($this->input->post('aceite_termos'), array('on', '1'), true)) {
            return $this->resposta(422, false, 'É necessário aceitar os termos.');
        }
        $arquivos = isset($_FILES['imagens']) ? $_FILES['imagens'] : null;
        if (!$arquivos || !isset($arquivos['name']) || !is_array($arquivos['name']) || count($arquivos['name']) === 0) {
            return $this->resposta(422, false, 'Adicione pelo menos uma imagem do projeto.');
        }
        $principal = filter_var($this->input->post('imagem_principal_idx'), FILTER_VALIDATE_INT);
        if (count($arquivos['name']) > 5) {
            return $this->resposta(422, false, 'É permitido enviar no máximo 5 imagens por projeto.');
        }
        if ($principal === false || $principal === null || $principal < 0 || $principal >= count($arquivos['name'])) {
            return $this->resposta(422, false, 'Selecione uma imagem principal válida.');
        }
        $pasta = FCPATH . 'uploads/atitude-farmaceutica/';
        if (!is_dir($pasta) && !mkdir($pasta, 0755, true) && !is_dir($pasta)) {
            return $this->resposta(500, false, 'Não foi possível preparar a pasta de imagens.');
        }
        $nomes = array();
        $tipos = array('image/jpeg' => 'jpg', 'image/png' => 'png', 'image/webp' => 'webp');
        foreach ($arquivos['name'] as $indice => $nome) {
            foreach (array('name', 'type', 'tmp_name', 'error', 'size') as $chave) {
                if (!isset($arquivos[$chave][$indice]) || is_array($arquivos[$chave][$indice])) {
                    $this->limparImagens($pasta, $nomes);
                    return $this->resposta(422, false, 'Upload de imagem inválido.');
                }
            }
            $temporario = $arquivos['tmp_name'][$indice];
            if ((int) $arquivos['error'][$indice] !== UPLOAD_ERR_OK || !is_uploaded_file($temporario)) {
                $this->limparImagens($pasta, $nomes);
                return $this->resposta(422, false, 'Não foi possível receber a imagem. Envie arquivos de até 5MB cada.');
            }
            if (filesize($temporario) > 5 * 1024 * 1024) {
                $this->limparImagens($pasta, $nomes);
                return $this->resposta(422, false, 'Cada imagem deve ter no máximo 5MB.');
            }
            $info = @getimagesize($temporario);
            if (!$info || !isset($tipos[$info['mime']])) {
                $this->limparImagens($pasta, $nomes);
                return $this->resposta(422, false, 'Envie uma imagem válida nos formatos JPG, PNG ou WEBP.');
            }
            $nomeSalvo = bin2hex(random_bytes(16)) . '.' . $tipos[$info['mime']];
            if (!move_uploaded_file($temporario, $pasta . $nomeSalvo)) {
                $this->limparImagens($pasta, $nomes);
                return $this->resposta(500, false, 'Não foi possível salvar a imagem. Tente novamente.');
            }
            $nomes[] = $nomeSalvo;
        }
        foreach (array('numero_crf', 'email', 'pessoas_alcancadas') as $campo) {
            $dados[$campo] = $dados[$campo] === '' ? null : $dados[$campo];
        }
        $dados['imagens'] = json_encode($nomes);
        $dados['imagem_principal'] = $nomes[$principal];
        $dados['aceite_termos'] = 1;
        $this->load->database();
        $debug = $this->db->db_debug;
        $this->db->db_debug = false;
        $salvou = $this->db->insert('web_site.tbl_atitudefarmaceutica_inscricao', $dados);
        $this->db->db_debug = $debug;
        if (!$salvou) {
            $this->limparImagens($pasta, $nomes);
            log_message('error', 'Falha ao salvar inscrição Atitude Farmacêutica.');
            return $this->resposta(500, false, 'Não foi possível salvar a inscrição. Tente novamente.');
        }
        return $this->resposta(200, true, 'Inscrição enviada com sucesso!');
    }

    private function limparImagens($pasta, $nomes) {
        foreach ($nomes as $nome) {
            if (is_file($pasta . $nome)) {
                unlink($pasta . $nome);
            }
        }
    }

    private function resposta($codigo, $status, $mensagem, $dados = array()) {
        $dados = array_merge($dados, array('status' => $status, 'message' => $mensagem,
            'csrf_name' => $this->security->get_csrf_token_name(), 'csrf_hash' => $this->security->get_csrf_hash()));
        return $this->output->set_status_header($codigo)->set_content_type('application/json', 'utf-8')->set_output(json_encode($dados, JSON_UNESCAPED_UNICODE));
    }
}
