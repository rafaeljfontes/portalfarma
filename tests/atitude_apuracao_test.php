<?php
if (PHP_SAPI !== 'cli') { http_response_code(404); exit; }
define('BASEPATH', __DIR__);
require __DIR__ . '/../application/libraries/Atitude_apuracao.php';
function conferir_apuracao($ok, $msg) { if (!$ok) throw new RuntimeException($msg); }
function registro_apuracao($id, $criterios = array(3,3,3,3,3), $popular = 15, $c = 1, $p = 1) {
    // Ordem: relevância, impacto, pessoas, duração, benefícios.
    list($r,$i,$a,$d,$b) = $criterios;
    return (object) array('id' => $id, 'nome_projeto' => 'Projeto ' . $id,
        'avaliacoes_comissao' => $c, 'avaliacoes_populares' => $p,
        'soma_comissao_centavos' => ($r*3+$i*2+$a*2+$d+$b*2)*10*$c,
        'soma_popular' => $popular*$p, 'votos' => $p,
        'soma_relevancia' => $r*$c, 'soma_impacto' => $i*$c, 'soma_pessoas' => $a*$c,
        'soma_duracao' => $d*$c, 'soma_beneficios' => $b*$c);
}
$regra = new Atitude_apuracao();
$registro = registro_apuracao(1, array(4,4,4,4,4), 15, 2, 3);
$resultado = $regra->calcular(array($registro)); $projeto = $resultado['projetos'][0];
conferir_apuracao($projeto['nota_comissao'] === 4 && $projeto['nota_popular'] === 3 && abs($projeto['nota_final'] - 11/3) < 1e-12, 'Fórmula 2:1');
conferir_apuracao($resultado['total_avaliacoes_comissao'] === 2 && $resultado['total_avaliacoes_populares'] === 3, 'Quantidades de fontes independentes');
$casos = array(
    'duracao' => array(array(4,1,3,4,3), array(3,3,3,3,3), 15, 15),
    'impacto' => array(array(3,4,2,3,3), array(3,3,3,3,3), 15, 15),
    'pessoas' => array(array(3,3,4,3,2), array(3,3,3,3,3), 15, 15),
    'beneficios' => array(array(2,3,3,3,5), array(4,3,3,3,2), 15, 15),
    'relevancia' => array(array(4,3,3,3,3), array(3,3,3,3,3), 12, 15)
);
foreach ($casos as $criterio => $caso) {
    list($ganha,$perde,$p1,$p2) = $caso;
    $resultado = $regra->calcular(array(registro_apuracao(1,$perde,$p2),registro_apuracao(99,$ganha,$p1)));
    $a = $resultado['projetos'][0]; $b = $resultado['projetos'][1];
    conferir_apuracao($a['nota_final'] === $b['nota_final'], 'Caso de empate exato: ' . $criterio);
    conferir_apuracao($a['id'] === 99 && $a['posicao'] === 1 && $b['posicao'] === 2, 'Desempate por ' . $criterio);
}
$resultado = $regra->calcular(array(registro_apuracao(7, array(3,3,3,3,3),15,1,1),registro_apuracao(2,array(3,3,3,3,3),15,2,2),registro_apuracao(8,array(2,2,2,2,2),10)));
conferir_apuracao(array_column($resultado['projetos'],'id') === array(2,7,8) && array_column($resultado['projetos'],'posicao') === array(1,1,2), 'Empate persistente compartilha posição');
$melhor = registro_apuracao(50,array(3,3,3,3,3),15,1,1000000); $melhor->soma_popular++;
$pior = registro_apuracao(1,array(3,3,3,3,3),15,1,1000000);
$resultado = $regra->calcular(array($pior,$melhor));
conferir_apuracao($resultado['projetos'][0]['id'] === 50 && $resultado['projetos'][1]['posicao'] === 2, 'Não cria empate por arredondamento');
conferir_apuracao(round($resultado['projetos'][0]['nota_final'],4) === round($resultado['projetos'][1]['nota_final'],4), 'Valores visualmente iguais continuam distintos');
$semPublico = registro_apuracao(2,array(5,5,5,5,5),0,1,0); $semPublico->votos = 4;
$semComissao = registro_apuracao(3,array(0,0,0,0,0),25,0,1);
$resultado = $regra->calcular(array($semPublico,$semComissao,registro_apuracao(9)));
conferir_apuracao(array_column($resultado['projetos'], 'id') === array(2,9,3) && $resultado['total_classificados'] === 2, 'Projeto sem voto popular participa da classificação');
conferir_apuracao($resultado['projetos'][0]['nota_popular'] === 0 && abs($resultado['projetos'][0]['nota_final'] - 10/3) < 1e-12, 'Sem notas populares utiliza zero na fórmula');
conferir_apuracao($resultado['projetos'][2]['nota_final'] === null && $resultado['projetos'][2]['posicao'] === null, 'Sem comissão permanece pendente');
$semVotos = $regra->calcular(array(registro_apuracao(5, array(3,3,3,3,3), 0, 1, 0)))['projetos'][0];
conferir_apuracao($semVotos['votos'] === 0 && $semVotos['nota_popular'] === 0 && $semVotos['nota_final'] === 2 && $semVotos['posicao'] === 1, 'Sem nenhum voto popular: (3 x 2 + 0) / 3 = 2');
conferir_apuracao($resultado['votos_sem_notas'] === 4, 'Votos antigos não entram na média');
conferir_apuracao(!isset($resultado['projetos'][0]['_final']), 'Não expõe estruturas internas de comparação');
conferir_apuracao($regra->calcular(array())['total_classificados'] === 0, 'Lista vazia');
echo "OK: fórmula, cinco desempates, empate persistente, frações exatas, pendências e votos sem notas.\n";
