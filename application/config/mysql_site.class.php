<?php
class mysql_site {
    public $pdo = null;
    private $host = null;
    private $data = null;
    private $user = null;
    private $pass = null;
    private $cone = null;
    public function __construct() {
        try {
            $this -> cone = parse_ini_file('mysql_site.ini');
            $this -> host = $this -> cone['host'];
            $this -> data = $this -> cone['data'];
            $this -> user = $this -> cone['user'];
            $this -> pass = $this -> cone['pass'];
            $this -> pdo = new \PDO('mysql:host='.$this -> host.';dbname='.$this -> data, $this -> user, $this -> pass);
        }catch (Exception $e) {
            echo "Erro de Conexão com a Base de Dados: ".$e -> getMessage();
            exit;
        }
    }
    public function __destruct() {
        $this -> pdo = null;
        $this -> host = null;
        $this -> data = null;
        $this -> user = null;
        $this -> pass = null;
        $this -> cone = null;
    }
}
?>