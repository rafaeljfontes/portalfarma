<?php
if (PHP_SAPI !== 'cli') { http_response_code(404); exit; }
define('APPPATH', __DIR__ . '/../application/');
require __DIR__ . '/atitude_solicitante_test.php';

foreach (array('nome_projeto'=>150,'justificativa'=>150,'recursos'=>100,'beneficios_alcancados'=>250,'objetivos_alcancados'=>250,'numero_pessoas'=>3) as $campo=>$maximo) {
    conferir_solicitante(strpos($c->form_validation->regras[$campo], 'max_length['.$maximo.']') !== false, 'Limite do backend: '.$campo);
}
conferir_solicitante(strpos($c->form_validation->regras['numero_pessoas'], 'less_than_equal_to[999]') !== false, 'Pessoas limitado a 999');
$limite = new ReflectionMethod('AtitudeFarmaceutica', 'dataInicioMaxima');
$limite->setAccessible(true);
foreach (array('2026-10-19'=>'2026-04-19', '2026-08-31'=>'2026-02-28', '2024-08-31'=>'2024-02-29', '2026-01-19'=>'2025-07-19') as $hoje=>$esperado) {
    conferir_solicitante($limite->invoke(null, new DateTimeImmutable($hoje, new DateTimeZone('America/Sao_Paulo'))) === $esperado, 'Seis meses de calendário: ' . $hoje);
}
$maxima = $limite->invoke(null);
$consultaCidades = new ReflectionMethod('AtitudeFarmaceutica', 'cidadesMineiras');
$consultaCidades->setAccessible(true);
conferir_solicitante(in_array('Pouso Alegre', $consultaCidades->invoke($c), true), 'Cidades vêm da lista existente');

function salvar_campos($regra, $verificado, $data, $cidade) {
    $c = salvar_solicitante($regra, $verificado);
    $c->input->dados['data_inicio'] = $data;
    $c->input->dados['cidade_projeto'] = $cidade;
    $c->input->dados['eixo_projeto'] = 'Eixo 1: Envolvimento e desenvolvimento da comunidade';
    // Isola as validações de data/cidade que ocorrem após o form_validation do CI.
    $c->form_validation = new class {
        public function set_data($dados) {}
        public function set_rules($campo, $nome, $regras) {}
        public function run() { return true; }
    };
    $c->salvar();
    return $c;
}
$recente = (new DateTimeImmutable($maxima))->modify('+1 day')->format('Y-m-d');
$resultado = salvar_campos($regra, $verificado, $recente, 'Pouso Alegre');
conferir_solicitante($resultado->output->codigo === 422 && strpos($resultado->output->dados['message'], 'pelo menos 6 meses') !== false, 'Backend rejeita data um dia após o limite');
foreach (array($maxima, '2000-01-01') as $dataAceita) {
    $resultado = salvar_campos($regra, $verificado, $dataAceita, 'Pouso Alegre');
    conferir_solicitante($resultado->output->dados['message'] === 'É necessário aceitar os termos.', 'Data no limite ou anterior passa pela validação');
}
$resultado = salvar_campos($regra, $verificado, '2026-02-30', 'Pouso Alegre');
conferir_solicitante(strpos($resultado->output->dados['message'], 'inválido') !== false, 'Data inexistente rejeitada');
$resultado = salvar_campos($regra, $verificado, $maxima, 'Cidade inexistente de teste');
conferir_solicitante(strpos($resultado->output->dados['message'], 'Selecione uma cidade válida') !== false, 'Backend rejeita cidade fora da lista');
echo "OK: limites de tamanho, pessoas até 999, seis meses de calendário, datas e cidades no backend.\n";
