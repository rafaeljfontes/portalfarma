<?php
if (PHP_SAPI !== 'cli') { http_response_code(404); exit; }
define('BASEPATH', __DIR__);
class CI_Controller {}
class CI_Model {}
require __DIR__ . '/../application/controllers/restrito/AtitudeFarmaceutica.php';
require __DIR__ . '/../application/models/Atitude_farmaceutica_model.php';
require __DIR__ . '/../application/libraries/Atitude_apuracao.php';
function log_message($nivel, $mensagem) {}

function verificar($condicao, $mensagem) {
    if (!$condicao) throw new RuntimeException($mensagem);
}
class EntradaAtitudes {
    public $dados = array();
    public $metodo = 'post';
    public function post($nome) { return $this->dados[$nome] ?? null; }
    public function method() { return $this->metodo; }
}
class SaidaAtitudes {
    public $codigo;
    public $dados;
    public function set_status_header($codigo) { $this->codigo = $codigo; return $this; }
    public function set_content_type($tipo, $charset) { return $this; }
    public function set_output($json) { $this->dados = json_decode($json, true); return $this; }
}
class SessaoAtitudes {
    public function userdata($nome) { return $nome === 'atitudes_token' ? 'token-teste' : null; }
}
class SegurancaAtitudes {
    public function get_csrf_token_name() { return 'csrf'; }
    public function get_csrf_hash() { return 'hash'; }
}
class ModeloAtitudesFake {
    public $resultadosVotos = array('projetos' => array(), 'total_votos' => 0);
    public function resultados_votacao() { return $this->resultadosVotos; }
    public $faseSalva = true;
    public $mudancasFase = array();
    public function salvar_fase($fase, $anterior) { $this->mudancasFase[] = array($fase, $anterior); return $this->faseSalva; }
    public $disponivel = true;
    public $registro;
    public $salva = true;
    public $decisoes = array();
    public function __construct() { $this->registro = (object) array('status' => 0); }
    public function campos_status_disponiveis() { return $this->disponivel; }
    public function campo_motivo_disponivel() { return true; }
    public function buscar($id) { return $this->registro; }
    public function decidir($id, $status, $motivo, $anterior) {
        $this->decisoes[] = array($id, $status, $motivo, $anterior); return $this->salva;
    }
}
class ControllerAtitudesTeste extends AtitudeFarmaceutica {
    public $input, $output, $session, $security, $atitudes;
    public function __construct() {
        $this->input = new EntradaAtitudes(); $this->output = new SaidaAtitudes();
        $this->session = new SessaoAtitudes(); $this->security = new SegurancaAtitudes();
        $this->atitudes = new ModeloAtitudesFake();
        $this->input->dados = array('id' => '12', 'status' => '1', 'status_atual' => '0', 'token' => '');
    }
}
$casos = array(
    'aceitar' => array(array(), 200),
    'recusar com motivo' => array(array('status' => '2', 'motivo' => '  Documentação insuficiente  '), 200),
    'recusar sem motivo' => array(array('status' => '2', 'motivo' => ' '), 422),
    'motivo muito longo' => array(array('status' => '2', 'motivo' => str_repeat('á', 4001)), 422),
    'status inválido' => array(array('status' => '3'), 422),
    'recusar projeto aceito' => array(array('status' => '2', 'status_atual' => '1', 'motivo' => 'Motivo'), 422),
    'alterar projeto recusado' => array(array('status' => '1', 'status_atual' => '2'), 422),
    'ID inválido' => array(array('id' => '12 OR 1=1'), 422),
    'motivo array' => array(array('status' => '2', 'motivo' => array('x')), 422),
    'token inválido' => array(array('token' => ''), 403),
    'status anterior inválido' => array(array('status_atual' => '8'), 422)
);
foreach ($casos as $nome => $caso) {
    $c = new ControllerAtitudesTeste();
    $c->input->dados = array_merge($c->input->dados, $caso[0]);
    $c->alterar_status();
    verificar($c->output->codigo === $caso[1], $nome);
    if ($caso[1] !== 200) verificar(!$c->atitudes->decisoes, 'Não deve atualizar: ' . $nome);
    if ($nome === 'recusar com motivo') verificar($c->output->dados['motivo_recusa'] === 'Documentação insuficiente', 'Motivo preservado');
}
foreach (array('metodo' => 405, 'esquema' => 503, 'ausente' => 404, 'concorrencia' => 409, 'falha' => 409) as $nome => $codigo) {
    $c = new ControllerAtitudesTeste();
    if ($nome === 'metodo') $c->input->metodo = 'get';
    if ($nome === 'esquema') $c->atitudes->disponivel = false;
    if ($nome === 'ausente') $c->atitudes->registro = null;
    if ($nome === 'concorrencia') $c->atitudes->registro->status = 2;
    if ($nome === 'falha') $c->atitudes->salva = false;
    $c->alterar_status(); verificar($c->output->codigo === $codigo, $nome);
}
class BancoAtitudesFake {
    public $db_debug = true, $filtros = array(), $dados, $linhas = 1;
    public $selecao;
    public function select($campos) { $this->selecao = $campos; return $this; }
    public function order_by($campo, $ordem) { return $this; }
    public function get($tabela) { return $this; }
    public function result() { return array(); }
    public function where($campo, $valor) { $this->filtros[$campo] = $valor; return $this; }
    public function update($tabela, $dados) { $this->dados = $dados; return true; }
    public function affected_rows() { return $this->linhas; }
}
class ModeloAtitudesTeste extends Atitude_farmaceutica_model { public $db, $load, $atitude_apuracao; public function campo_motivo_disponivel() { return true; } }
$m = new ModeloAtitudesTeste(); $m->db = new BancoAtitudesFake();
verificar($m->decidir(12, 1, 'motivo anterior', 2), 'Aceite persistido');
verificar($m->db->filtros === array('id' => 12, 'status' => 2), 'Atualização condicionada ao status anterior');
verificar($m->db->dados['motivo_recusa'] === null, 'Aceite limpa recusa anterior');
verificar($m->db->db_debug === true, 'Restaura configuração do banco');
$m->db->linhas = 0;
verificar(!$m->decidir(12, 2, 'Motivo', 0), 'Conflito não é sucesso');
$publico = new ModeloAtitudesTeste(); $publico->db = new BancoAtitudesFake();
$publico->listar_aceitos();
verificar($publico->db->filtros === array('status' => 1), 'Página pública consulta apenas projetos aceitos');
verificar(strpos($publico->db->selecao, 'cpf') === false && strpos($publico->db->selecao, 'email') === false, 'Consulta pública sem dados pessoais');
echo "OK: validações, aceite, recusa, falhas e concorrência.\n";
foreach (array(array('votacao', 'inscricao', 200), array('inscricao', 'votacao', 200), array('encerrado', 'inscricao', 200), array('encerrado', 'votacao', 200), array('inscricao', 'encerrado', 200), array('invalida', 'inscricao', 422), array('inscricao', 'inscricao', 422)) as $caso) {
    $c = new ControllerAtitudesTeste();
    $c->input->dados['fase'] = $caso[0]; $c->input->dados['fase_atual'] = $caso[1];
    $c->alterar_fase();
    verificar($c->output->codigo === $caso[2], 'Alternância de fase validada');
    if ($caso[2] === 200) verificar($c->output->dados['fase'] === $caso[0], 'Fase retornada após salvar');
    else verificar(!$c->atitudes->mudancasFase, 'Fase inválida não salva');
}
$c = new ControllerAtitudesTeste();
$c->input->dados = array('fase' => 'votacao', 'fase_atual' => 'inscricao', 'token' => '');
$c->alterar_fase(); verificar($c->output->codigo === 403 && !$c->atitudes->mudancasFase, 'Token de fase validado');
$c = new ControllerAtitudesTeste();
$c->input->dados = array('fase' => 'votacao', 'fase_atual' => 'inscricao', 'token' => '');
$c->atitudes->faseSalva = false;
$c->alterar_fase(); verificar($c->output->codigo === 409 && !$c->output->dados['success'], 'Falha não retorna fase salva');
echo "OK: alternância inscrição/votação, validação e falha de persistência.\n";
class ControllerLimiteTeste extends ControllerAtitudesTeste {
    public $load, $atitude_evento;
    public function __construct() {
        parent::__construct();
        $this->load = new class { public function library($nome) {} };
        $this->atitude_evento = new class {
            public $salva = true, $chamadas = array();
            public function salvar_limite_votacao($limite, $anterior) { $this->chamadas[] = array($limite, $anterior); return $this->salva; }
        };
        $this->input->dados = array('token' => '', 'limite' => '3', 'limite_atual' => '3');
    }
}
foreach (array('1' => 200, '3' => 200, '100' => 200, '0' => 422, '101' => 422, '1.5' => 422, '01' => 422) as $limite => $http) {
    $c = new ControllerLimiteTeste(); $c->input->dados['limite'] = (string) $limite; $c->salvar_limite_votacao();
    verificar($c->output->codigo === $http, 'Validação do limite administrativo');
    if ($http === 200) verificar($c->output->dados['success'] === true && $c->output->dados['limite'] === (int) $limite, 'Contrato de sucesso do painel');
    else verificar(!$c->atitude_evento->chamadas, 'Limite inválido não persiste');
}
$c = new ControllerLimiteTeste(); $c->input->dados['token'] = ''; $c->salvar_limite_votacao();
verificar($c->output->codigo === 403 && !$c->atitude_evento->chamadas, 'Token protege limite');
$c = new ControllerLimiteTeste(); $c->input->metodo = 'get'; $c->salvar_limite_votacao(); verificar($c->output->codigo === 405, 'Limite exige POST');
$c = new ControllerLimiteTeste(); $c->atitude_evento->salva = false; $c->salvar_limite_votacao(); verificar($c->output->codigo === 409, 'Conflito no limite não é sucesso');
echo "OK: painel de limite, token, validação, contrato JSON e concorrência.\n";
$c = new ControllerAtitudesTeste(); $c->input->metodo = 'get'; $c->resultados();
verificar($c->output->codigo === 200 && $c->output->dados['total_votos'] === 0, 'Consulta de resultados sem votos');
$c->atitudes->resultadosVotos = null; $c->resultados();
verificar($c->output->codigo === 503 && !$c->output->dados['success'], 'Falha de consulta não apresenta resultados inventados');
$c->input->metodo = 'post'; $c->resultados(); verificar($c->output->codigo === 405, 'Método da consulta validado');
class BancoResultadosTeste {
    public $db_debug = true, $falha = false;
    public function query($sql) {
        if ($this->falha) return false;
        verificar(strpos($sql, 'COUNT(*)') !== false && strpos($sql, 'v.id_proejto = p.id') !== false, 'Contagem por projeto');
        return new class {
            public function result() {
                $linhas = array();
                foreach (array(10, 10, 7, 3, 0) as $i => $votos) {
                    $nota = array(4,4,3,2,0)[$i]; $c = $nota ? 1 : 0;
                    $linhas[] = (object) array('id' => $i + 1, 'nome_projeto' => 'Projeto ' . $i, 'votos' => (string) $votos,
                        'avaliacoes_comissao' => $c, 'avaliacoes_populares' => $votos, 'soma_comissao_centavos' => $nota*100,
                        'soma_popular' => $votos*$nota*5, 'soma_duracao' => $nota, 'soma_impacto' => $nota,
                        'soma_pessoas' => $nota, 'soma_beneficios' => $nota, 'soma_relevancia' => $nota);
                }
                return $linhas;
            }
        };
    }
}
$ranking = new ModeloAtitudesTeste(); $ranking->db = new BancoResultadosTeste();
$ranking->load = new class { public function library($nome) {} };
$ranking->atitude_apuracao = new Atitude_apuracao();
$resultado = $ranking->resultados_votacao();
verificar($resultado['total_votos'] === 30, 'Total de votos agregado');
verificar(array_column($resultado['projetos'], 'posicao') === array(1, 1, 2, 3, null), 'Empates compartilham posição; zero votos sem pódio');
$ranking->db->falha = true;
verificar($ranking->resultados_votacao() === null && $ranking->db->db_debug === true, 'Falha controlada e configuração restaurada');
echo "OK: resultados, total de votos, empate e pódio.\n";

function html_escape($valor) { return htmlspecialchars((string) $valor, ENT_QUOTES, 'UTF-8'); }
function base_url($path = '') { return 'http://localhost/portalfarma/' . $path; }
function site_url($path) { return base_url($path); }
class ViewAtitudesTeste {
    public $security;
    public $load;
    public function render_pagina($faseEvento) {
        $this->load = new class { public function view($nome, $dados = array()) {} };
        $projetosAceitos = array();
        ob_start();
        require __DIR__ . '/../application/views/atitude-farmaceutica/atitude_farmacêutica.php';
        return ob_get_clean();
    }
    public function render_publico($projetosAceitos) {
        ob_start();
        require __DIR__ . '/../application/views/atitude-farmaceutica/projetos_aceitos.php';
        return ob_get_clean();
    }
    public function render($projetos, $statusDisponivel = true) {
        $this->security = new SegurancaAtitudes();
        $total = count($projetos); $pagina = $paginas = 1; $token = '';
        $limiteProjetosVotacao = 3;
        ob_start();
        require __DIR__ . '/../application/views/restrito/atitude_farmaceutica_listar.php';
        return ob_get_clean();
    }
}
$projeto = (object) array_fill_keys(array('numero_crf', 'email', 'celular', 'cidade_farmaceutico', 'cpf',
    'eixo_projeto', 'numero_pessoas', 'cidade_projeto', 'local_projeto', 'recursos', 'descricao_projeto',
    'justificativa', 'pessoas_alcancadas', 'beneficios_alcancados', 'objetivos_alcancados'), 'Exemplo');
$projeto->id = 12; $projeto->status = 2; $projeto->nome_projeto = '<script>alert(1)</script>';
$projeto->resumo_projeto = 'Resumo cadastrado <script>alert(2)</script>';
$projeto->criado_em = '2026-10-08 10:00:00'; $projeto->data_inicio = '2026-10-01';
$projeto->motivo_recusa = '<img src=x onerror=alert(1)>';
$projeto->imagens = json_encode(array('imagem.png', '../fora.png', 'arquivo.svg', 'https://externo/imagem.png'));
$projeto->imagem_principal = 'imagem.png';
$renderer = new ViewAtitudesTeste(); $html = $renderer->render(array($projeto));
$paginaInscricao = $renderer->render_pagina('inscricao');
$paginaVotacao = $renderer->render_pagina('votacao');
$paginaEncerrada = $renderer->render_pagina('encerrado');
verificar(strpos($paginaEncerrada, '>Votação</a>') === false && strpos($paginaEncerrada, '>Inscrever minha atitude</a>') === false && strpos($paginaEncerrada, 'Agradecemos a participação') !== false, 'Ambas encerradas exibem agradecimento');
verificar(strpos($paginaInscricao, '>Inscrever minha atitude</a>') !== false && strpos($paginaInscricao, '>Votação</a>') === false, 'Inscrição exibe apenas botão de inscrição');
verificar(strpos($paginaVotacao, '>Votação</a>') !== false && strpos($paginaVotacao, '>Inscrever minha atitude</a>') === false, 'Votação exibe apenas botão de votação');
verificar(strpos($html, '<script>alert(1)</script>') === false, 'Título escapado');
verificar(strpos($html, 'Resumo cadastrado &lt;script&gt;alert(2)&lt;/script&gt;') !== false, 'Resumo exibido e escapado');
verificar(strpos($html, '<img src=x onerror=alert(1)>') === false, 'Motivo escapado');
verificar(strpos($html, 'uploads/atitude-farmaceutica/imagem.png') !== false, 'Imagem local exibida');
verificar(strpos($html, '../fora.png') === false && strpos($html, 'arquivo.svg') === false && strpos($html, 'https://externo') === false, 'Caminhos e tipos inválidos rejeitados');
verificar(strpos($html, 'data-acao="2" disabled') !== false, 'Decisão atual desabilitada');
verificar(strpos($renderer->render(array()), 'Nenhum projeto cadastrado.') !== false, 'Lista vazia');
verificar(strpos($renderer->render(array($projeto), false), 'aplique a migração') === false, 'Alerta de migração removido');
verificar(strpos($html, '<table class="tabela-projetos"') !== false, 'Listagem em tabela');
$htmlPublico = $renderer->render_publico(array($projeto));
$cardPublico = substr($htmlPublico, strpos($htmlPublico, '<article'));
verificar(strpos($cardPublico, 'class="atitude-projeto-imagem"') < strpos($cardPublico, 'class="atitude-projeto-titulo"'), 'Imagem antes do título');
verificar(strpos($htmlPublico, 'Resumo cadastrado &lt;script&gt;alert(2)&lt;/script&gt;') !== false, 'Resumo público escapado');
verificar(strpos($htmlPublico, '<script>alert(1)</script>') === false, 'Título público escapado');
verificar(strpos($htmlPublico, 'datetime="2026-10-01"') !== false, 'Data de início no card');
verificar(strpos($renderer->render_publico(array()), 'Nenhum projeto disponível no momento.') !== false, 'Lista pública vazia');
if (isset($argv[1])) {
    preg_match_all('/<script>(.*?)<\/script>/s', $html, $scripts);
    preg_match_all('/<script>(.*?)<\/script>/s', $htmlPublico, $scriptsPublicos);
    file_put_contents($argv[1], implode("\n", array_merge($scripts[1], $scriptsPublicos[1])));
}
echo "OK: renderização, lista vazia, escape de dados e galeria segura.\n";
echo "OK: filtro público de aceitos, cards e data do projeto.\n";
