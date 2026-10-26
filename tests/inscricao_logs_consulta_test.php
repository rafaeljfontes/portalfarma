<?php
define('BASEPATH', __DIR__);
class CI_Model {}
require __DIR__.'/../application/models/Inscricao_logs_model.php';
function checkConsulta($ok, $mensagem) { if (!$ok) throw new RuntimeException($mensagem); }
function site_url($path) { return '/'.$path; }
$pasta = sys_get_temp_dir().'/portalfarma-consulta-test-'.bin2hex(random_bytes(6));
mkdir($pasta);
$dados = ['nome'=>'João da Silva', 'cpf'=>'123.456.789-00', 'curso_titulo'=>'Educação em Saúde', 'course_id'=>119];
$inicio = ['tentativa'=>'a', 'data_hora'=>'2026-10-21T23:59:59-03:00', 'dados'=>$dados, 'evento'=>'inicio', 'resultado'=>'em_andamento'];
$fim = array_merge($inicio, ['data_hora'=>'2026-10-22T00:00:01-03:00', 'evento'=>'resultado', 'resultado'=>'sucesso', 'mensagem'=>'Inscrição confirmada']);
$erro = ['tentativa'=>'b', 'data_hora'=>'2026-10-22T01:00:00-03:00', 'dados'=>[
    'nome'=>'<script>alert(1)</script>', 'cpf'=>'00000000000', 'curso_titulo'=>'Outro curso', 'course_id'=>121],
    'evento'=>'resultado', 'resultado'=>'erro', 'mensagem'=>'Falha cURL', 'erros'=>[['curl_errno'=>28, 'curl_error'=>'Timeout']]];
$pendente = array_merge($inicio, ['tentativa'=>'c', 'data_hora'=>'2026-10-22T02:00:00-03:00']);
file_put_contents($pasta.'/inscricoes-2026-10-21.txt', json_encode($inicio)."\n");
file_put_contents($pasta.'/inscricoes-2026-10-22.txt', implode("\n", array_map('json_encode', [$fim, $erro, $pendente]))."\nlinha inválida\n");
$model = new Inscricao_logs_model();
$resultado = $model->consultar('', 1, 50, $pasta);
checkConsulta($resultado['total'] === 3 && $resultado['avisos'] === 1, 'Consolidar tentativas entre dias e ignorar linha inválida');
checkConsulta($resultado['registros'][0]['tentativa'] === 'c' && $resultado['registros'][2]['resultado'] === 'sucesso', 'Mais recentes primeiro e resultado final preservado');
foreach (['JOAO', '12345678900', '123.456', 'educacao em saude'] as $busca) {
    $filtrado = $model->consultar($busca, 1, 50, $pasta);
    checkConsulta($filtrado['total'] === 2, 'Busca por nome, CPF formatado ou sem pontuação e curso: '.$busca);
}
checkConsulta($model->consultar('inexistente', 1, 50, $pasta)['total'] === 0, 'Busca sem resultados');
$pagina = $model->consultar('', 999, 2, $pasta);
checkConsulta($pagina['pagina'] === 2 && count($pagina['registros']) === 1, 'Paginação e limite da página');
checkConsulta($model->consultar('', 1, 50, $pasta.'/ausente')['total'] === 0, 'Diretório ainda não criado');
extract($resultado);
$busca = '<script>busca</script>';
ob_start(); require __DIR__.'/../application/views/restrito/logs_inscricoes.php'; $html = ob_get_clean();
checkConsulta(strpos($html, '<script>alert(1)</script>') === false && strpos($html, '&lt;script&gt;alert(1)&lt;/script&gt;') !== false, 'Escapar conteúdo dos logs no HTML');
checkConsulta(strpos($html, 'Timeout') !== false && strpos($html, 'Sem resultado') !== false, 'Exibir detalhes e tentativas sem finalização');
foreach (glob($pasta.'/*.txt') as $arquivo) unlink($arquivo);
rmdir($pasta);

class CI_Controller {
    public $session; public $load; public $output;
    public static $autenticado = true; public static $permissoes = 'admin';
    public function __construct() {
        $this->session = new class {
            public function userdata($key) { return $key === 'usuario_logado' ? CI_Controller::$autenticado : CI_Controller::$permissoes; }
        };
        $this->load = new class {
            public $modelCarregado = false;
            public $bancoCarregado = false;
            public function database() { $this->bancoCarregado = true; }
            public function model(...$args) { $this->modelCarregado = true; }
            public function view($nome) { throw new RuntimeException($nome); }
        };
        $this->output = new class { public function set_status_header($status) { checkConsulta($status === 403, 'Acesso negado com HTTP 403'); } };
    }
}
function portalfarma_permissoes($valor) { return explode(',', $valor); }
function redirect($url) { throw new RuntimeException('redirect:'.$url); }
require __DIR__.'/../application/controllers/restrito/Logs_inscricoes.php';
CI_Controller::$autenticado = false;
try { new Logs_inscricoes(); throw new RuntimeException('Não deveria permitir acesso'); }
catch (RuntimeException $e) { checkConsulta($e->getMessage() === 'redirect:login', 'Usuário anônimo precisa autenticar'); }
CI_Controller::$autenticado = true; CI_Controller::$permissoes = 'capacifar';
try { new Logs_inscricoes(); throw new RuntimeException('Não deveria permitir acesso'); }
catch (RuntimeException $e) { checkConsulta($e->getMessage() === 'restrito/acesso_negado', 'Somente administrador pode consultar'); }
CI_Controller::$permissoes = 'admin';
$controller = new Logs_inscricoes();
checkConsulta($controller->load->modelCarregado, 'Administrador acessa a consulta');
checkConsulta($controller->load->bancoCarregado, 'Cabeçalho recebe a conexão usada nos contadores do menu');
echo "OK: busca, consolidação, paginação, HTML seguro e acesso exclusivo de administrador.\n";
