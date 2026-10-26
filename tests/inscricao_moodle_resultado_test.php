<?php
// Testes com dados sintéticos, sem conexão com o Moodle ou envio de e-mail.
define('BASEPATH', __DIR__);
class CI_Model {}
class CI_Controller { public $input; public $session; public $Moodle_model; }
require __DIR__.'/../application/models/Moodle_model.php';
require __DIR__.'/../application/controllers/Inscricao.php';
function checkInscricao($ok, $message) { if (!$ok) throw new RuntimeException($message); }
class MoodleNomeTeste extends Moodle_model {
    public $params; public $requests = 0;
    protected function request(string $function, array $params = []): array {
        $this->params = $params; $this->requests++;
        return ['ok'=>true, 'data'=>[['id'=>42]], 'error'=>null];
    }
}
$model = new MoodleNomeTeste();
foreach ([['  Universidade Exemplo  ', 'Universidade Exemplo'], ['', ''], [null, '']] as [$entrada, $esperado]) {
    $model->criar_usuario('teste', 'senha', 'Ana Silva', 'teste@example.com', 'Cidade', '', '', 'BR', $entrada);
    checkInscricao($model->params['users'][0]['institution'] === $esperado, 'Instituição na criação');
    $model->atualizar_instituicao(42, $entrada);
    checkInscricao($model->params['users'][0] === ['id' => 42, 'institution' => $esperado], 'Instituição na atualização');
}
foreach ([
    ['Ana Silva   ', 'Ana', 'Silva'],
    ["  Ana\tMaria\nSilva \r\n", 'Ana Maria', 'Silva'],
    ["Ana\u{00A0}Silva\u{00A0}", 'Ana', 'Silva'],
    ["João\u{2003}José da Conceição\u{2003}", 'João José da', 'Conceição'],
    ['Denise  ', 'Denise', '.'],
] as [$nome, $primeiro, $ultimo]) {
    $resultado = $model->criar_usuario('teste', 'senha', $nome, 'teste@example.com', 'Cidade', '', '', 'BR');
    $user = $model->params['users'][0];
    checkInscricao($resultado['ok'] && $user['firstname'] === $primeiro && $user['lastname'] === $ultimo,
        'Nome e sobrenome normalizados: '.json_encode($nome));
}
$requests = $model->requests;
$resultado = $model->criar_usuario('teste', 'senha', " \t\u{00A0}", '', '', '', '', 'BR');
checkInscricao(!$resultado['ok'] && $model->requests === $requests, 'Nome vazio não deve chamar o Moodle');
class RedirectInscricaoTeste extends RuntimeException {}
function redirect($url) { throw new RedirectInscricaoTeste($url); }
class InscricaoInputTeste {
    public function post($key) {
        return ['nome'=>'Ana Silva', 'cpf'=>'00000000000', 'cidade'=>'Cidade', 'email'=>'teste@example.com',
            'crfmg'=>'', 'telefone'=>'', 'course_id'=>119, 'curso_titulo'=>'Curso teste', 'campo_evento'=>'Online'][$key] ?? null;
    }
}
class InscricaoSessionTeste {
    public $flash = [];
    public function set_flashdata($key, $value) { $this->flash[$key] = $value; }
}
class InscricaoMoodleTeste {
    public $cenario; public $matriculas = 0;
    public function atualizar_instituicao($userid, $instituicao = '') {
        checkInscricao($instituicao === '', 'Instituição ausente deve ser enviada vazia');
        return ['ok' => $this->cenario !== 'institution'];
    }
    public function usuario_existe($username) {
        return ['ok'=>true, 'data'=>['id'=>in_array($this->cenario, ['create', 'name']) ? null : 42]];
    }
    public function criar_usuario(...$args) {
        return ['ok'=>false, 'error'=>$this->cenario === 'name'
            ? ['message'=>'Informe seu nome para realizar a inscrição.']
            : ['raw'=>json_encode(['debuginfo'=>'The field lastname cannot be blank'])]];
    }
    public function esta_matriculado($user, $course) {
        return ['ok'=>$this->cenario !== 'lookup', 'data'=>['enrolled'=>false]];
    }
    public function inscrever_curso($user, $course) { $this->matriculas++; return ['ok'=>false]; }
}
foreach (['create', 'name', 'institution', 'lookup', 'enrol'] as $cenario) {
    $controller = (new ReflectionClass('Inscricao'))->newInstanceWithoutConstructor();
    $controller->input = new InscricaoInputTeste();
    $controller->session = new InscricaoSessionTeste();
    $controller->Moodle_model = new InscricaoMoodleTeste();
    $controller->Moodle_model->cenario = $cenario;
    try { $controller->salvar(); throw new RuntimeException('Deveria interromper a inscrição.'); }
    catch (RedirectInscricaoTeste $e) { checkInscricao($e->getMessage() === 'curso/inscricao/119', 'Retornar ao formulário'); }
    checkInscricao($controller->session->flash['type'] === 'danger', 'Falha não pode gerar confirmação de sucesso: '.$cenario);
    checkInscricao($controller->Moodle_model->matriculas === ($cenario === 'enrol' ? 1 : 0), 'Não matricular após falha anterior');
}
echo "OK: normalização de nomes, sobrenome obrigatório e interrupção das falhas de criação e matrícula.\n";
