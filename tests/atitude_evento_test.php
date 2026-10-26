<?php
if (PHP_SAPI !== 'cli') { http_response_code(404); exit; }
define('BASEPATH', __DIR__);
require __DIR__ . '/../application/libraries/Atitude_evento.php';
function verificar($ok, $mensagem) { if (!$ok) throw new RuntimeException($mensagem); }
$arquivo = tempnam(sys_get_temp_dir(), 'atitude-evento-');
try {
    file_put_contents($arquivo, '{"fase":"inscricao"}');
    $evento = new Atitude_evento(array('arquivo' => $arquivo));
    verificar($evento->obter_fase() === 'inscricao', 'Inscrição inicial');
    verificar($evento->salvar_fase('votacao', 'inscricao'), 'Abre votação e encerra inscrição');
    $outro = new Atitude_evento(array('arquivo' => $arquivo));
    verificar($outro->obter_fase() === 'votacao', 'Estado persistido entre acessos');
    verificar(!$evento->salvar_fase('encerrado', 'inscricao'), 'Não sobrescreve atualização concorrente');
    verificar($evento->salvar_fase('encerrado', 'votacao') && $evento->obter_fase() === 'encerrado', 'Ambas fechadas');
    verificar($evento->salvar_fase('inscricao', 'encerrado'), 'Reabre inscrições');
    verificar(!$evento->salvar_fase('invalida', 'inscricao'), 'Fase inválida rejeitada');
    verificar($evento->obter_limite_votacao() === 3, 'Limite padrão 3');
    verificar($evento->salvar_limite_votacao(2, 3), 'Salva limite pelo painel');
    verificar($outro->obter_limite_votacao() === 2, 'Limite persistido entre acessos');
    verificar(!$evento->salvar_limite_votacao(4, 3), 'Não sobrescreve limite concorrente');
    verificar($evento->obter_fase() === 'inscricao', 'Limite preserva fase');
    verificar($evento->salvar_fase('votacao', 'inscricao') && $evento->obter_limite_votacao() === 2, 'Fase preserva limite');
    verificar(!$evento->salvar_limite_votacao(0, 2) && !$evento->salvar_limite_votacao(101, 2), 'Limites inválidos rejeitados');
    file_put_contents($arquivo, 'inválido');
    verificar($evento->obter_fase() === 'encerrado', 'Configuração inválida mantém evento fechado');
    echo "OK: controle local, persistência, três estados e concorrência, sem banco.\n";
} finally { unlink($arquivo); }
