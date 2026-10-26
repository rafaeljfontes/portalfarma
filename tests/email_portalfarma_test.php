<?php
if (PHP_SAPI !== 'cli') { http_response_code(404); exit; }
define('BASEPATH', __DIR__ . '/../system/');
define('ICONV_ENABLED', extension_loaded('iconv'));
define('MB_ENABLED', extension_loaded('mbstring'));
function verificar_email($ok, $msg) { if (!$ok) throw new RuntimeException($msg); }
function config_item($item) { return $item === 'charset' ? 'UTF-8' : null; }
function is_php($versao) { return version_compare(PHP_VERSION, $versao, '>='); }
function log_message($nivel, $mensagem) {}
function base_url($caminho = '') { return 'https://example.test/portalfarma/' . $caminho; }
$ciEmailTeste = (object) array(
    'config' => new class {
        public $valores;
        public function load($arquivo, $grupo) { $config = array(); require __DIR__ . '/../application/config/email.php'; $this->valores = $config; }
        public function item($nome) { return $this->valores; }
    },
    'lang' => new class { public function load($nome) {} public function line($nome) { return $nome; } },
    'load' => new class { public function library($nome) {} public function view($nome, $dados, $retornar) { extract($dados); ob_start(); require __DIR__ . '/../application/views/' . $nome . '.php'; return ob_get_clean(); } }
);
function &get_instance() { global $ciEmailTeste; return $ciEmailTeste; }
require BASEPATH . 'libraries/Email.php';
require __DIR__ . '/../application/libraries/MY_Email.php';
class EmailPortalTeste extends MY_Email {
    public $capturado, $modo = 'ok';
    protected function enviar_para_fila() { return $this->_spool_email(); }
    protected function _spool_email() {
        $this->capturado = array('headers' => $this->_headers, 'to' => $this->_recipients, 'body' => $this->_body);
        if ($this->modo === 'aviso') trigger_error('Falha de transporte simulada', E_USER_WARNING);
        if ($this->modo === 'html') { echo '<div>Diagnóstico</div>'; return false; }
        return $this->modo === 'ok';
    }
}
$email = new EmailPortalTeste();
$email->from('outro@example.com', 'Outro', 'outro@example.com');
$email->to('destinatario@example.com'); $email->subject('Teste'); $email->message('Mensagem');
$email->set_header('From', 'forjado@example.com');
verificar_email($email->send(), 'Transporte bem sucedido');
verificar_email(strpos($email->capturado['headers']['From'], MY_Email::REMETENTE) !== false && $email->capturado['headers']['Return-Path'] === '<' . MY_Email::REMETENTE . '>', 'Remetente e Return-Path centralizados');
foreach (array('falha', 'aviso', 'html') as $modo) {
    $email = new EmailPortalTeste(); $email->modo = $modo;
    $email->to('destinatario@example.com'); $email->subject('Teste'); $email->message('Mensagem');
    ob_start(); $enviado = $email->send(); $saida = ob_get_clean();
    verificar_email(!$enviado && $saida === '', 'Falha sem HTML na resposta: ' . $modo);
}
$email = new EmailPortalTeste();
verificar_email($email->mySendMail('destinatario@example.com', 'Template', array('body' => 'Teste', 'user' => 'Pessoa')), 'Template compartilhado envia');
verificar_email(strpos($email->capturado['body'], 'Teste') !== false, 'Template gera conteúdo');

// Executa os helpers reais com transporte simulado, sem cadastros ou Moodle.
$arquivos = glob(__DIR__ . '/../application/controllers/*.php'); $total = 0;
foreach ($arquivos as $arquivo) {
    $tokens = token_get_all(file_get_contents($arquivo));
    for ($i = 0; $i < count($tokens); $i++) {
        if (!is_array($tokens[$i]) || $tokens[$i][0] !== T_FUNCTION) continue;
        $j = $i + 1; while (is_array($tokens[$j]) && $tokens[$j][0] === T_WHITESPACE) $j++;
        if (!is_array($tokens[$j]) || !in_array($tokens[$j][1], array('enviar_email', 'enviarEmail', '_enviarEmail'), true)) continue;
        $nome = $tokens[$j][1]; $metodo = ''; $aberto = false; $nivel = 0;
        for ($k = $i; $k < count($tokens); $k++) {
            $token = $tokens[$k]; $metodo .= is_array($token) ? $token[1] : $token;
            if ($token === '{' || (is_array($token) && in_array($token[0], array(T_CURLY_OPEN, T_DOLLAR_OPEN_CURLY_BRACES), true))) { $nivel++; $aberto = true; }
            if ($token === '}') $nivel--;
            if ($aberto && $nivel === 0) break;
        }
        $classe = 'ServicoEmailTeste' . $total;
        eval('class ' . $classe . ' { public $email; public ' . $metodo . ' }');
        $objeto = new $classe(); $objeto->email = new EmailPortalTeste();
        $reflexao = new ReflectionMethod($classe, $nome);
        $args = array(); foreach ($reflexao->getParameters() as $parametro) $args[] = stripos($parametro->getName(), 'email') !== false ? 'destinatario@example.com' : 'Teste';
        verificar_email($reflexao->invokeArgs($objeto, $args) === true, 'Helper retorna sucesso: ' . basename($arquivo));
        verificar_email(strpos($objeto->email->capturado['headers']['From'], MY_Email::REMETENTE) !== false, 'Remetente correto: ' . basename($arquivo));
        $objeto->email->modo = 'falha';
        verificar_email($reflexao->invokeArgs($objeto, $args) === false, 'Helper retorna falha: ' . basename($arquivo));
        echo 'OK: ' . basename($arquivo) . "\n"; $total++;
    }
}
verificar_email($total >= 8, 'Todos os helpers de e-mail encontrados e testados');
echo "OK: remetente, templates, retorno de falha e transporte compartilhado.\n";
$ciEmailTeste->portal_email_fila = new class {
    public $ids = array(101, 102), $falha = null, $dados;
    public function registrar($destinatarios, $assunto, $conteudo) { $this->dados = array($destinatarios, $assunto, $conteudo); return true; }
};
$email = new MY_Email(); $email->transporte = 'fila';
$email->to('principal@example.com'); $email->cc('copia@example.com');
$email->subject('Confirmação — Atitude'); $email->set_mailtype('text'); $email->message("Código: 123456\n<texto>");
verificar_email($email->send() && $email->ids_fila === array(101, 102), 'Adaptador registra e guarda IDs sem declarar entrega');
$dadosFila = $ciEmailTeste->portal_email_fila->dados;
verificar_email($dadosFila[0] === array('principal@example.com', 'copia@example.com'), 'Cópia incluída na fila');
verificar_email($dadosFila[1] === 'Confirmação — Atitude', 'Assunto decodificado para o worker');
verificar_email(strpos($dadosFila[2], '123456') !== false && strpos($dadosFila[2], '&lt;texto&gt;') !== false, 'Texto convertido para HTML com segurança');
echo "OK: adaptador de fila, cópia, assunto UTF-8 e conteúdo do código.\n";
