<?php
define('BASEPATH', __DIR__);
class CI_Controller { public $input; public $load; public $db; public $capacifar_model; }
function log_message($level, $message) {}
function registrar_historico($acao, $id, &$erro = null) {
    if ($GLOBALS['auditoria'] === 'exception') throw new RuntimeException('Falha simulada');
    if ($GLOBALS['auditoria'] === 'failure') {
        $erro = 'O usuário da sessão não foi localizado para registrar o histórico.';
        return false;
    }
    return true;
}
require __DIR__.'/../application/controllers/restrito/Cursos.php';
class CadastroInput {
    public function post() {
        return ['tipo_evento'=>1, 'courseid'=>101, 'titulo'=>'Curso teste',
            'nome_curto'=>'teste', 'data_inicio'=>'2026-10-20', 'publico_alvo'=>'1', 'topicos'=>'Teste'];
    }
}
class CadastroLoader { public function helper($name) {} }
class CadastroDb { public $db_debug = true; public function error() { return ['message'=>'']; } }
class CadastroModel { public function inserircurso($dados) { return 42; } }
foreach (['success', 'failure', 'exception'] as $cenario) {
    $GLOBALS['auditoria'] = $cenario;
    $controller = (new ReflectionClass('Cursos'))->newInstanceWithoutConstructor();
    $controller->input = new CadastroInput();
    $controller->load = new CadastroLoader();
    $controller->db = new CadastroDb();
    $controller->capacifar_model = new CadastroModel();
    ob_start();
    $controller->salvar();
    $resultado = json_decode(ob_get_clean(), true, 512, JSON_THROW_ON_ERROR);
    if ($resultado['status'] !== 'success' || $resultado['id'] !== 42
        || $resultado['message'] !== 'Curso salvo com sucesso!'
        || ($cenario === 'success' ? $resultado['warning'] !== null : empty($resultado['warning']))) {
        throw new RuntimeException('Retorno incorreto no cenário: '.$cenario);
    }
    if (!$controller->db->db_debug) throw new RuntimeException('Configuração do banco não restaurada.');
}
echo "OK: cadastro confirmado com auditoria bem-sucedida, recusada ou com exceção.\n";
