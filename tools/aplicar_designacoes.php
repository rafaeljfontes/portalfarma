<?php
// Uso: php tools/aplicar_designacoes.php
if (PHP_SAPI !== 'cli') { http_response_code(404); exit; }
define('BASEPATH', __DIR__);
define('ENVIRONMENT', 'production');
require __DIR__.'/../application/config/database.php';
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
try {
    $config = $db[$active_group];
    $con = mysqli_init();
    $con->options(MYSQLI_OPT_CONNECT_TIMEOUT, 3);
    $con->real_connect($config['hostname'], $config['username'], $config['password'], $config['database'], $config['port'] ?? 3306);
    $con->multi_query(file_get_contents(__DIR__.'/../database/tbl_portalfarma_func_designado.sql'));
    do { if ($result = $con->store_result()) $result->free(); } while ($con->more_results() && $con->next_result());
    echo "Tabela de designações instalada.\n";
} catch (Throwable $e) {
    fwrite(STDERR, 'Não foi possível instalar a tabela de designações (código '.(int) $e->getCode()."). Verifique a conexão e execute o SQL no banco.\n");
    exit(1);
}
