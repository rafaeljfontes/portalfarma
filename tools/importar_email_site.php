<?php
if (PHP_SAPI !== 'cli') { http_response_code(404); exit; }
define('BASEPATH', __DIR__ . '/../system/');
$origem = 'C:/wamp64/www/site-crfmg';
$destino = __DIR__ . '/../application/config/email_fila.php';
try {
    if (in_array('--localizar-portalfarma', $argv, true)) {
        define('APPPATH', __DIR__ . '/../application/');
        define('ENVIRONMENT', 'production');
        require APPPATH . 'config/database.php';
        $atual = $db[$active_group];
        $pdo = new PDO('mysql:host=' . $atual['hostname'] . ';port=' . ($atual['port'] ?? 3306) . ';charset=utf8mb4', $atual['username'], $atual['password'], array(PDO::ATTR_TIMEOUT => 10, PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
        $bases = $pdo->query("SELECT TABLE_SCHEMA FROM information_schema.TABLES WHERE TABLE_NAME = 'tb_disparo_email'")->fetchAll(PDO::FETCH_COLUMN);
        echo json_encode(array('bases_com_fila' => $bases), JSON_UNESCAPED_UNICODE) . "\n";
        exit(0);
    }
    require $origem . '/vendor/codeigniter4/framework/system/Config/DotEnv.php';
    $valores = (new CodeIgniter\Config\DotEnv($origem))->parse();
    $fila = array('dsn' => '', 'dbdriver' => 'mysqli', 'dbprefix' => '', 'pconnect' => false,
        'db_debug' => false, 'cache_on' => false, 'char_set' => 'utf8mb4', 'dbcollat' => 'utf8mb4_general_ci',
        'save_queries' => false, 'encrypt' => false, 'compress' => false, 'stricton' => false,
        'failover' => array());
    foreach (array('hostname', 'username', 'password', 'database', 'port') as $campo) {
        $fila[$campo] = $valores['database.crftech.' . $campo] ?? '';
    }
    $fila['port'] = (int) ($fila['port'] ?: 3306);
    if (!$fila['hostname'] || !$fila['database'] || !$fila['username']) throw new RuntimeException('Configuração crftech incompleta.');
    if (in_array('--inspecionar', $argv, true)) {
        $pdo = new PDO('mysql:host=' . $fila['hostname'] . ';port=' . $fila['port'] . ';charset=utf8mb4', $fila['username'], $fila['password'], array(PDO::ATTR_TIMEOUT => 10, PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
        $descoberta = $pdo->prepare("SELECT TABLE_SCHEMA FROM information_schema.TABLES WHERE TABLE_NAME = 'tb_disparo_email'");
        $descoberta->execute();
        $bases = $descoberta->fetchAll(PDO::FETCH_COLUMN);
        echo json_encode(array('base_configurada' => $fila['database'], 'bases_com_fila' => $bases), JSON_UNESCAPED_UNICODE) . "\n";
        $pdo->exec('USE `' . str_replace('`', '``', $fila['database']) . '`');
        $campos = $pdo->query('SHOW COLUMNS FROM tb_disparo_email')->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode(array_map(function ($campo) { return array('campo' => $campo['Field'], 'tipo' => $campo['Type']); }, $campos), JSON_UNESCAPED_UNICODE) . "\n";
    } else {
        $codigo = "<?php\ndefined('BASEPATH') OR exit('No direct script access allowed');\nreturn " . var_export($fila, true) . ";\n";
        if (file_put_contents($destino, $codigo) === false) throw new RuntimeException('Falha de gravação.');
        echo "Configuração da fila crftech copiada, sem exibir credenciais.\n";
    }
} catch (Throwable $erro) {
    $codigoErro = $erro instanceof PDOException ? ($erro->errorInfo[1] ?? $erro->getCode()) : '';
    fwrite(STDERR, 'Não foi possível importar/consultar a fila (' . get_class($erro) . ', código ' . $codigoErro . ', ' . basename($erro->getFile()) . ':' . $erro->getLine() . ").\n"); exit(1);
}
