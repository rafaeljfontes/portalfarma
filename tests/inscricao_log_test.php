<?php
define('BASEPATH', __DIR__);
require __DIR__.'/../application/libraries/Inscricao_log.php';
function checkLog($ok, $message) { if (!$ok) throw new RuntimeException($message); }
$pasta = sys_get_temp_dir().'/portalfarma-log-test-'.bin2hex(random_bytes(6));
$dados = ['nome'=>"Pessoa\nTeste", 'cpf'=>'00000000000', 'email'=>'teste@example.com',
    'course_id'=>119, 'curso_titulo'=>'Curso sintético', 'password'=>'', 'wstoken'=>''];
$sucesso = new Inscricao_log(['pasta'=>$pasta]);
$sucesso->iniciar($dados);
$sucesso->confirmar();
$sucesso->finalizar('Inscrição realizada com sucesso!');
$sucesso->finalizar('Não deve duplicar');
$falha = new Inscricao_log(['pasta'=>$pasta]);
$falha->iniciar($dados);
$falha->erro('core_user_create_users', ['code'=>'curl_error', 'message'=>'Falha na comunicação via cURL.',
    'curl_errno'=>28, 'curl_error'=>'Operation timed out', 'raw'=>'NAO_REGISTRAR']);
$falha->finalizar('Erro ao criar usuário no Moodle.');
$arquivos = glob($pasta.'/*.txt');
checkLog(count($arquivos) === 1, 'Arquivo TXT diário');
$texto = file_get_contents($arquivos[0]);
checkLog(strpos($texto, 'NAO_REGISTRAR') === false, 'Não registrar senhas, tokens ou respostas brutas');
$registros = array_map(function ($linha) { return json_decode($linha, true, 512, JSON_THROW_ON_ERROR); }, file($arquivos[0], FILE_IGNORE_NEW_LINES));
checkLog(count($registros) === 4, 'Uma linha por início e resultado, sem duplicação ou quebra por dados do formulário');
checkLog($registros[1]['resultado'] === 'sucesso' && $registros[1]['inscrito_com_sucesso'] === true, 'Matrícula confirmada gera sucesso');
checkLog($registros[3]['resultado'] === 'erro' && $registros[3]['erros'][0]['curl_errno'] === 28, 'Falha registra etapa e detalhe cURL');
checkLog($registros[1]['dados']['course_id'] === 119 && $registros[1]['dados']['curso_titulo'] === 'Curso sintético', 'Curso identificado no log');
checkLog($registros[0]['tentativa'] === $registros[1]['tentativa'] && $registros[0]['tentativa'] !== $registros[2]['tentativa'], 'Tentativas correlacionadas e distintas');
unlink($arquivos[0]);
rmdir($pasta);
Inscricao_log::$ativo = null;
echo "OK: log TXT diário, dados, curso, sucesso, erro técnico e exclusão de credenciais.\n";
