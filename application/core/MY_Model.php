<?php

class MY_Model extends CI_Model
{
    protected $active_group;
    protected $db_sql;

    public function __construct() {
        parent::__construct();
        $this->connect();
    }

    public function __destruct() {
        $this->db->close();
    }

    public function connect($active_group = 'sqlserver'){
        $this->active_group = $active_group;
        $db = $this->load->database($active_group, TRUE);
        $this->db = $db;

        $db_sql = $this->load->database('sqlserver', TRUE);
        $this->db_sql = $db_sql;
    }

}