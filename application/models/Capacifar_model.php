<?php

/* ------------------- REQUERINDO CONEXÃO COM BANCO AVA/MOODLE -------------------*/
//require_once(dirname(__FILE__).'/../config/mysql_site.class.php');

class Capacifar_model extends CI_Model {

    public function presencas_curso($courseid)
    {
        $consulta = $this->db->query(
            'SELECT id_moodle FROM `tbl_portalfarma_presenca` WHERE courseid = ?', [(int) $courseid]
        );
        if ($consulta === FALSE) throw new RuntimeException('Lista de presença indisponível.');
        return array_map('intval', array_column($consulta->result_array(), 'id_moodle'));
    }

    public function salvar_presencas_curso($courseid, array $alteracoes)
    {
        $debug = $this->db->db_debug;
        $this->db->db_debug = FALSE;
        $this->db->trans_begin();
        try {
            foreach ($alteracoes as $id => $presente) {
                $sql = $presente
                    ? 'INSERT INTO `tbl_portalfarma_presenca` (courseid, id_moodle) VALUES (?, ?) ON DUPLICATE KEY UPDATE id_moodle = VALUES(id_moodle)'
                    : 'DELETE FROM `tbl_portalfarma_presenca` WHERE courseid = ? AND id_moodle = ?';
                if (!$this->db->query($sql, [(int) $courseid, (int) $id])) {
                    throw new RuntimeException('Falha ao salvar presencas.');
                }
            }
            if (!$this->db->trans_status() || !$this->db->trans_commit()) {
                throw new RuntimeException('Falha ao confirmar presencas.');
            }
        } catch (Exception $e) {
            $this->db->trans_rollback();
            throw $e;
        } finally {
            $this->db->db_debug = $debug;
        }
    }

	public function query($query)
    {
        $result = $this->db->query($query);

        return is_bool ( $result ) ? $result : $result->result();
    }

    /*
     * debug last_query
     */
    public function last_query()
    {
        return $this->db->last_query();
    }
	
	public function insert($tabela, $data){
		
        $this->db->insert($tabela, $data);

        if($this->db->affected_rows() > 0){
            return $this->db->insert_id();
        }

        return false;
    }
	
	public function inserir($dados) {

		/* SEPRAR DADOS PARA GERAR LOG */
		$dadosLog = implode(', ', array_map(
				function ($v, $k) { return str_replace("", " ", $k). ' = ' . str_replace(" ", "", $v); },
				$dados,
				array_keys($dados)
		));
		//print_r($dados);//exit;

		if(isset($dados)){

			//if()
			// GRAVAR LOG
			$this->gerarLog( $this->session->userdata('id') , " [INSERIU ATITUDE FARMACEUTICA] => $dadosLog ");

			return $this->db->insert('tbl_atitudefarmaceutica_participantes', $dados);
			//exit;
		}

	}

	public function listarMenu($id = null) {

			$this->db->from('tbl_capacifar_home');
			$this->db->where('status', '1');
			
			$query = $this->db->get();
			
			return $query->result();
	}

	public function listaCursos($id) {

		$this->db->select('*');
		$this->db->from('tbl_capacifar');

		if(!empty($id)){
			$this->db->where('tipo_curso', $id);
		}
		
		$this->db->order_by('status', 'DESC');
		$this->db->order_by('data_cadastro', 'DESC');
		
		if($id == 2){
			$this->db->where('status', '1');			
		}

		$query = $this->db->get();

		return $query->result();

	}

	public function listaCursosPortalFarma($filtro = 'tpf.status = 1', $orderBy = 'tpf.data_cadastro DESC, tpf.data_fim DESC') {

		if (empty($filtro)) {
			$filtro = 'tpf.status = 1';
		}

		if (empty($orderBy)) {
			$orderBy = 'tpf.data_cadastro DESC, tpf.data_fim DESC';
		}

		$sql = "SELECT
					tpf.*,
					GROUP_CONCAT(
						DISTINCT tcp.descricao
						ORDER BY tcp.descricao
						SEPARATOR ', '
					) AS categorias,
					GROUP_CONCAT(
						DISTINCT tcp.icon
						ORDER BY tcp.icon
						SEPARATOR ', '
					) AS icones,
					GROUP_CONCAT(DISTINCT tpp.nome ORDER BY tpp.nome SEPARATOR ', ') AS palestrantes
				FROM web_site.tbl_portalfarma tpf
				LEFT JOIN tbl_tipo_portalfarma ttp
					ON ttp.tipo = tpf.tipo_evento
				LEFT JOIN tbl_categoria_eventos tce
					ON tce.courseid = tpf.courseid
				LEFT JOIN tbl_categorias_portalfarma tcp
					ON tcp.id = tce.id_categoria
				LEFT JOIN tbl_portalfarma_palestrantes_curso tppc
					ON tppc.courseid = tpf.courseid
				LEFT JOIN tbl_portalfarma_palestrantes tpp
					ON tpp.id_palestrante = tppc.id_palestrante
				WHERE " . $filtro . "
				GROUP BY tpf.id
				ORDER BY " . $orderBy;

		return $this->query($sql);
	}

    public function relatorio_inscricoes_cursos($tipoEvento = null, $idUsuario = null)
    {
        $sql = "SELECT tpf.id, tpf.courseid, tpf.tipo_evento, tpf.titulo, tpf.status,
            (SELECT GROUP_CONCAT(DISTINCT p.nome ORDER BY p.nome SEPARATOR ', ')
             FROM tbl_portalfarma_palestrantes_curso pc
             JOIN tbl_portalfarma_palestrantes p ON p.id_palestrante = pc.id_palestrante
             WHERE pc.courseid = tpf.courseid) AS palestrantes,
            CASE tpf.tipo_evento
                WHEN 3 THEN (SELECT COUNT(*) FROM urm_inscricao i WHERE i.urm_evento = tpf.courseid)
                WHEN 4 THEN (SELECT COUNT(*) FROM fiscalizacao_humanizada_inscricao i WHERE i.id_evento = tpf.courseid)
                WHEN 7 THEN (SELECT COUNT(*) FROM tbl_seminario_inscricao i WHERE i.seminario = tpf.courseid)
                ELSE 0
            END AS total_estudantes
            FROM web_site.tbl_portalfarma tpf";
        $parametros = array();
        $condicoes = array();
        if ($tipoEvento !== null) {
            $condicoes[] = 'tpf.tipo_evento = ?';
            $parametros[] = (int) $tipoEvento;
        }
        if ($idUsuario !== null) {
            $this->load->model('Designacoes_model', 'designacoes_model');
            $condicoes[] = $this->designacoes_model->condicao_usuario('tpf', $idUsuario);
        }
        if ($condicoes) $sql .= ' WHERE '.implode(' AND ', $condicoes);
        $sql .= ' ORDER BY tpf.titulo, tpf.id';
        $consulta = $this->db->query($sql, $parametros);
        if ($consulta === false) {
            throw new RuntimeException('Relatório de inscrições indisponível.');
        }
        $cursos = $consulta->result();
        $courseids = array();
        foreach ($cursos as $curso) {
            if (!in_array((int) $curso->tipo_evento, array(3, 4, 7), true)) {
                $courseids[] = (int) $curso->courseid;
            }
        }
        $totaisMoodle = array();
        if ($courseids) {
            $this->load->model('Moodle_api');
            foreach ($this->Moodle_api->totais_inscritos_cursos($courseids) as $total) {
                $totaisMoodle[(int) $total->courseid] = (int) $total->total_estudantes;
            }
        }
        foreach ($cursos as $curso) {
            if (!in_array((int) $curso->tipo_evento, array(3, 4, 7), true)) {
                $curso->total_estudantes = (int) ($totaisMoodle[(int) $curso->courseid] ?? 0);
            } else {
                $curso->total_estudantes = (int) $curso->total_estudantes;
            }
        }
        usort($cursos, function ($a, $b) {
            return ($b->total_estudantes <=> $a->total_estudantes)
                ?: strcmp($a->titulo, $b->titulo);
        });
        return $cursos;
    }

    public function cursosRankingDesignados($idUsuario, $tipoEvento = null)
    {
        $this->load->model('Designacoes_model', 'designacoes_model');
        $condicao = $this->designacoes_model->condicao_usuario('c', $idUsuario);
        if ($tipoEvento !== null) $condicao .= ' AND c.tipo_evento = '.(int) $tipoEvento;
        return $this->query("SELECT c.courseid, c.titulo, c.tipo_evento,
            CASE c.tipo_evento
                WHEN 3 THEN (SELECT COUNT(*) FROM urm_inscricao i WHERE i.urm_evento = c.courseid)
                WHEN 4 THEN (SELECT COUNT(*) FROM fiscalizacao_humanizada_inscricao i WHERE i.id_evento = c.courseid)
                WHEN 7 THEN (SELECT COUNT(*) FROM tbl_seminario_inscricao i WHERE i.seminario = c.courseid)
                ELSE NULL
            END AS total_inscritos_local,
            (SELECT GROUP_CONCAT(DISTINCT p.nome ORDER BY p.nome SEPARATOR ', ')
             FROM tbl_portalfarma_palestrantes_curso pc
             INNER JOIN tbl_portalfarma_palestrantes p ON p.id_palestrante = pc.id_palestrante
             WHERE pc.courseid = c.courseid) AS palestrantes
            FROM tbl_portalfarma c WHERE ".$condicao." ORDER BY c.id DESC");
    }

    public function listaCursosAdministracao($filtro, $designacoes = null)
    {
        // A tabela administrativa não usa categorias/ícones. Evita multiplicar
        // linhas de categorias por palestrantes antes do GROUP_CONCAT.
        $join = $designacoes && $designacoes->disponivel() ? $designacoes->join_listagem() : '';
        $colunas = $join ? 'designados.designados_ids, designados.designados_nomes,' : 'NULL AS designados_ids, NULL AS designados_nomes,';
        return $this->query("SELECT tpf.*, ".$colunas."
            (SELECT GROUP_CONCAT(DISTINCT p.nome ORDER BY p.nome SEPARATOR ', ')
             FROM tbl_portalfarma_palestrantes_curso pc
             JOIN tbl_portalfarma_palestrantes p ON p.id_palestrante = pc.id_palestrante
             WHERE pc.courseid = tpf.courseid) AS palestrantes
            FROM web_site.tbl_portalfarma tpf ".$join."
            WHERE " . $filtro . "
            ORDER BY tpf.data_cadastro DESC, tpf.data_fim DESC");
    }

	public function listaInscritosCurso($courseid) {

		$courseid = (int) $courseid;

		if ($courseid <= 0) {
			return array();
		}

		$moodle = $this->load->database('moodle', TRUE);

		$moodle->select("u.id AS id_moodle, CONCAT(u.firstname, ' ', u.lastname) AS nome_completo, u.username AS cpf, u.email, u.phone1 AS telefone, u.city AS cidade, MIN(ue.timecreated) AS data_inscricao_timestamp, FROM_UNIXTIME(MIN(ue.timecreated), '%d/%m/%Y %H:%i:%s') AS data_inscricao", FALSE);
		$moodle->from('mdl_user u');
		$moodle->join('mdl_user_enrolments ue', 'ue.userid = u.id');
		$moodle->join('mdl_enrol e', 'e.id = ue.enrolid');
		$moodle->where('e.courseid', $courseid);
		$moodle->where('ue.status', 0);
		$moodle->where('u.deleted', 0);
		$moodle->where('u.suspended', 0);
		$moodle->group_by(array('u.id', 'u.firstname', 'u.lastname', 'u.username', 'u.email', 'u.phone1', 'u.city'));
		$moodle->order_by('u.firstname', 'ASC');
		$moodle->order_by('u.lastname', 'ASC');

		return $moodle->get()->result();
	}

	public function listaPesquisas($id = null) {

		$this->db->select('*');
		$this->db->from('tbl_capacifar_trabalhocientifico');

		if(!empty($id)){
			$this->db->where('id', $id);
		}
		//$this->db->order_by('status', 'DESC');
		$this->db->order_by('data_criacao', 'DESC');
		$this->db->where('status', '1');

		$query = $this->db->get();

		return $query->result();

	}

	public function listWhere($id = null) {

		$query = $this->db->get('tbl_capacifar');
		
		if(!empty($id)){
			$this->db->where('id', $id);
		}
		
		
		return $query->result();
	}
	
	public function listaCourseId($id, $dados = null) {

		if(!empty($dados)){
			$this->db->select($dados);
		} else {
			$this->db->select('*');			
		}
		$this->db->from('tbl_capacifar');
			
			$this->db->where('course_id', $id);
			
		$query = $this->db->get();

		return $query->result();
	}

	public function InsertMeritoAcademico($dados){

		$this->db->insert('merito_academico', $dados);
		return $this->db->insert_id();
	}

	public function InsertCasaESua($dados){

		$this->db->insert('tbl_capacifar_sejabemvindo', $dados);
		return $this->db->insert_id();
	}

	public function InsertModelUniversity($dados){

		$this->db->insert('tbl_capacifar_universitario', $dados);
		return $this->db->insert_id();
	}
	
	public function InsertInterativo($dados){

		$this->db->insert('tbl_capacifar_interativo', $dados);
		return $this->db->insert_id();
	}
	
	public function InsertFiscalizacaoHumanizada($dados){

		$this->db->insert('fiscalizacao_humanizada_inscricao', $dados);
		return $this->db->insert_id();
	}
	
	public function PresencaFiscalizacaoHumanizada($dados){

		$data = [
            'presenca' => '1',
        ];
        $this->db->where('cpf', $dados['cpf']);
        $this->db->where('id_evento', $dados['id_evento']);
        $this->db->update('fiscalizacao_humanizada_inscricao', $data);
		//return true;
		return $dados;
		
	}
	
	public function PresencaURM($dados){

		$data = [
            'presenca' => '1',
        ];
        $this->db->where('cpf', $dados['cpf']);
        $this->db->where('urm_evento', $dados['id_evento']);
        $this->db->update('urm_inscricao', $data);
		//return true;
		return $dados;
		
	}
	
	public function InsertURM($dados){

		$this->db->insert('urm_inscricao', $dados);
		return $this->db->insert_id();
	}
	
	public function InsertSaudedaMulher($dados){

		$this->db->insert('saude_da_mulher_inscricao', $dados);
		return $this->db->insert_id();
	}
	
	public function PresencaSaudedaMulher($dados){

		$data = [
            'presenca' => '1',
        ];
        $this->db->where('cpf', $dados['cpf']);
        $this->db->where('id_evento', $dados['id_evento']);
        $this->db->update('saude_da_mulher_inscricao', $data);
		//return true;
		return $dados;
		
	}
	
	public function UpdateMerito($dados){
		
		if($dados['status'] == 1){
			$data = [
				'status' => $dados['status'],
				'representante_crfmg' => $dados['descricao'],
				'observacoes' => $dados['observacoes_acao'] ?? null,
			];
		} else {
			$data = [
				'status' => $dados['status'],
				'observacoes' => $dados['observacoes_acao'] ?? $dados['descricao'],
			];		
		}
		
		
		
        $this->db->where('id', $dados['id']);        
        $this->db->update('merito_academico', $data);
		return true;
		//return $dados;
		
	}
	
	public function UpdatePesquisa($dados){
		
		$data = [
			'status' => $dados['status'],
			'observacoes' => $dados['observacoes_acao'] ?? ($dados['descricao'] ?? null),
		];
		
		
		
        $this->db->where('id_pesquisa', $dados['id']);        
        $this->db->update('tbl_capacifar_trabalhocientifico', $data);
		return true;
		//return $dados;
		
	}

	public function verificaUsuarioAva($enrolid, $dados){

		$username = preg_replace('/[^0-9]/', '', $dados['cpf']);


		$curl = curl_init();
				curl_setopt( $curl, CURLOPT_URL, 'https://ava.crfmg.org.br/capacifar/api_serach_user.php'  );
				curl_setopt( $curl, CURLOPT_POST, true );
				curl_setopt( $curl, CURLOPT_POSTFIELDS, array(
				'username' 	=> $username,
				));
				curl_setopt( $curl, CURLOPT_RETURNTRANSFER, true );
				$response = json_decode( curl_exec( $curl ), true);
				curl_close($curl);
		
		//return $response;exit;
		
		/// Alterando Usuario dentro do ava ///
		/*
		$curl = curl_init();
				curl_setopt( $curl, CURLOPT_URL, 'https://ava.crfmg.org.br/capacifar/api_mdl_update_user.php'  );
				curl_setopt( $curl, CURLOPT_POST, true );
				curl_setopt( $curl, CURLOPT_POSTFIELDS, array(
				'mail' 			=> $dados['email'],
				'crf' 			=> $dados['crfmg'],
				'city' 			=> $dados['cidade'],
				'phone1' 		=> $dados['telefone'],
				'id' 			=> $dados['telefone'],
				));
				curl_setopt( $curl, CURLOPT_RETURNTRANSFER, true );
				$response = json_decode( curl_exec( $curl ), true);
				curl_close($curl);
		*/
		
		//return $response;
		$this->userEnrolments($enrolid, $dados, $response);
	}

	public function InsertUserdb($dados){
		//print_r($dados);
		//ELIMINANDO DADOS DO ARRAY
		unset($dados['nome_curto']);
		unset($dados['menuid']);
		unset($dados['publicoalvo']);
		unset($dados['pf_senha']);
		unset($dados['pf_senha_match']);
		unset($dados['declaro_veracidade']);

		$this->db->insert('tbl_capacifar_inscritos', $dados);
		return $this->db->insert_id();
	}

	public function enrolUser($enrolid, $dados) {

		$senha_pass = preg_replace('/[^0-9]/', '', $dados['pf_senha']);
		$senhaHash 	= password_hash($senha_pass, PASSWORD_DEFAULT);
		$username 	= preg_replace('/[^0-9]/', '', $dados['cpf']);

		$separado = explode(' ',$dados['nome']);

		$nome = array_shift($separado);
		$sobrenome = implode(' ',$separado);


		if($dados['crfmg'] != ''){
			$crfmg = $dados['crfmg'];
		} else {
			$crfmg = '0';
		}

		if(isset($dados['uf'])){
			$uf = $dados['uf'];
		} else {
			$uf = 'BR';
		}
		
		if(isset($dados['faculdade'])){
			$faculdade = $dados['faculdade'];
		} else {
			$faculdade = '';
		}
		
		if(isset($dados['publico_inscrito'])){
			$publico_inscrito = $dados['publico_inscrito'];
		} else {
			$publico_inscrito = '';
		}

		/*Criando Usuario dentro do ava */
		$curl = curl_init();
				curl_setopt( $curl, CURLOPT_URL, 'https://ava.crfmg.org.br/capacifar/api_mdl_user.php'  );
				curl_setopt( $curl, CURLOPT_POST, true );
				curl_setopt( $curl, CURLOPT_POSTFIELDS, array(
				'username' 		=> $username,
				'password' 		=> $senhaHash,
				'fisrtname' 	=> $nome,
				'lastname' 		=> $sobrenome,
				'mail' 			=> $dados['email'],
				'crf' 			=> $crfmg,
				'city' 			=> $dados['cidade'],
				'institution' 	=> $faculdade,
				'country' 		=> $uf,
				'icq' 			=> $publico_inscrito,
				'phone1' 		=> $dados['telefone'],
				));
				curl_setopt( $curl, CURLOPT_RETURNTRANSFER, true );
				$response = json_decode( curl_exec( $curl ), true);
				curl_close($curl);
				//$response = 1701;
			//echo "usuario criado = ".$response."<br>";//*********************************************

		if (!empty($response)) {
			//echo "tem resposta..";
			$this->userEnrolments($enrolid, $dados, $response);
        }else{
            return null;
        }
	}

	public function userEnrolments($enrolid, $dados, $userLastID) {
		$date = new DateTime();
		$timestamp = $date->getTimestamp();

	/*2º Passo - Vincular usuário ao método de inscrição*/
		$curl = curl_init();
				curl_setopt( $curl, CURLOPT_URL, 'https://ava.crfmg.org.br/capacifar/api_search_enrol.php'  );
				curl_setopt( $curl, CURLOPT_POST, true );
				curl_setopt( $curl, CURLOPT_POSTFIELDS, array(
				'courseid' 	=> $enrolid,
				));
				curl_setopt( $curl, CURLOPT_RETURNTRANSFER, true );
				$response = json_decode( curl_exec( $curl ), true);
				curl_close($curl);

			$id_mdl_enrol = $response;

		/*2º Passo - Vincular usuário ao método de inscrição*/
		$curl = curl_init();
				curl_setopt( $curl, CURLOPT_URL, 'https://ava.crfmg.org.br/capacifar/api_mdl_user_enrolments.php'  );
				curl_setopt( $curl, CURLOPT_POST, true );
				curl_setopt( $curl, CURLOPT_POSTFIELDS, array(
				'enrolid' 	=> $id_mdl_enrol,
				'userLastID' 	=> $userLastID,
				'timestamp' => $timestamp,
				));
				curl_setopt( $curl, CURLOPT_RETURNTRANSFER, true );
				$response = json_decode( curl_exec( $curl ), true);
				curl_close($curl);
		$id_user_enrolments = $response;
		//$response = 2087;
		//echo "enrrolamento = ".$response."<br>";//*********************************************

		if (!empty($id_user_enrolments)) {
			$this->roleAssignments($dados, $enrolid, $id_user_enrolments, $userLastID);
		}else{
			return null;
		}
	}

	public function roleAssignments($dados, $enrolid, $id_user_enrolments, $userLastID){

		//$retorno = array();

		$date = new DateTime();
		$timestamp = $date->getTimestamp();

		/* 3º Passo - Recuperar Id do contexto do curso */
		$curl = curl_init();
				curl_setopt( $curl, CURLOPT_URL, 'https://ava.crfmg.org.br/capacifar/api_mdl_context.php'  );
				curl_setopt( $curl, CURLOPT_POST, true );
				curl_setopt( $curl, CURLOPT_POSTFIELDS, array(
				'courseid' => $enrolid,
				));
				curl_setopt( $curl, CURLOPT_RETURNTRANSFER, true );
				$response = json_decode( curl_exec( $curl ), true);
				curl_close($curl);
		//echo "r=".$response;
		$contextid = $response;


		/* 4º Passo - Efetuar inscrito na tabela que gerencia perfil */
		$curl = curl_init();
				curl_setopt( $curl, CURLOPT_URL, 'https://ava.crfmg.org.br/capacifar/api_mdl_role_assignments.php'  );
				curl_setopt( $curl, CURLOPT_POST, true );
				curl_setopt( $curl, CURLOPT_POSTFIELDS, array(
				'contextid' 	=> $contextid,
				'userLastID'=> $userLastID,
				'timestamp' => $timestamp,
				));
				curl_setopt( $curl, CURLOPT_RETURNTRANSFER, true );
				$response = json_decode( curl_exec( $curl ), true);
				curl_close($curl);

		//print_r($response);// = 2109;

		$session['dadosLog'] = $response;
		$this->session->set_flashdata($session);
		//print_r("sessão=" $this->session->set_flashdata($session));


		if (!empty($response)) {
			//echo "retornando(".$response.")";
			return $response;
		}else{
			//echo "FDP";
			return $banco -> pdo -> rollBack();
		}


	}
	
	public function proximoCourseIdUrm()
    {
        // Remove o prefixo URM e os dois dígitos finais do ano antes de
        // comparar os sequenciais, inclusive os cadastrados em anos anteriores.
        $consulta = $this->db->query("SELECT COALESCE(MAX(CAST(SUBSTRING(courseid, 4, CHAR_LENGTH(courseid) - 5) AS UNSIGNED)), 0) AS maior_sequencial
            FROM tbl_portalfarma
            WHERE tipo_evento = ? AND courseid REGEXP '^URM[0-9]+[0-9]{2}$'", array(3));
        return 'URM' . ((int) $consulta->row()->maior_sequencial + 1) . date('y');
    }

	public function inserircurso($dados)
    {
        if (!$this->db->insert('tbl_portalfarma', $dados)) {
            return false;
        }
        return $this->db->insert_id();
    }
	
	public function updatecurso($form_data, $id)
        {
            if(!isset($form_data) || empty($form_data) ){
                return false;
            }

            if(!isset($id) || empty($id)){
                return false;
            }
            
            $this->db->where('id', $id);
            return $this->db->update('tbl_portalfarma', $form_data);
    }
	
	public function updateuni($form_data, $id)
        {
            if(!isset($form_data) || empty($form_data) ){
                return false;
            }

            if(!isset($id) || empty($id)){
                return false;
            }
            
            $this->db->where('id', $id);
            return $this->db->update('tbl_capacifar_universitario', $form_data);
    }
	
	public function UniversitarioRecusar($dados){
		
		$data = [
				'status' => 2,
				'recusa' => $dados['descricao'],
			];
		
        $this->db->where('id', $dados['id']);        
        $this->db->update('tbl_capacifar_universitario', $data);
		return true;
		//return $dados;
		
	}

    public function inserir_programacoes($courseid, $programacoes)
    {
        $dados_insert = [];

        foreach ($programacoes as $prog) {

            $dados_insert[] = [
                'courseid'   => $courseid,
                'data_hora_inicial'=> date('Y-m-d H:i:s', strtotime($prog['inicio'])),
                'hora_final'   => date('Y-m-d H:i:s', strtotime($prog['fim'])),
                'palestra'     => $prog['titulo'],
                'descricao'  => $prog['descricao']
            ];
        }

        $ids = [];
        foreach ($dados_insert as $dados) {
            if (!$this->db->insert('tbl_portalfarma_programacao', $dados)) {
                return false;
            }
            $ids[] = (int) $this->db->insert_id();
        }
        return $ids;
    }
	
	public function updateprogramacao($programacoes)
    {
        $data = [];
		
		$id = $programacoes['id'];
		
		$data = [
				'data_hora_inicial'=> date('Y-m-d H:i:s', strtotime($programacoes['data_hora_inicial'])),
                'hora_final'   => date('Y-m-d H:i:s', strtotime($programacoes['hora_final'])),
                'palestra'     => $programacoes['palestra'],
                'descricao'  => $programacoes['descricao']
			];
		
        $this->db->where('id', $id);        
        $this->db->update('tbl_portalfarma_programacao', $data);
		return true;
    }
	
	public function data_extenso($data){
		$dias_semana = array(
			'Domingo',
			'Segunda-feira',
			'Terça-feira',
			'Quarta-feira',
			'Quinta-feira',
			'Sexta-feira',
			'Sábado'
		);

		$meses_ano = array(
			'',
			'Janeiro',
			'Fevereiro',
			'Março',
			'Abril',
			'Maio',
			'Junho',
			'Julho',
			'Agosto',
			'Setembro',
			'Outubro',
			'Novembro',
			'Dezembro'
		);

		//$data = date('Y-m-d');
		$partes = explode('-', $data);
		$dia = $partes[2];
		$mes = $meses_ano[(int)$partes[1]];
		$ano = $partes[0];
		$dia_semana = $dias_semana[date('w', strtotime($data))];

		$extenso =  $dia . ' de ' . $mes . ' de ' . $ano;
		return $extenso;
	}
	
	public function alterar_status_prog($id, $status) {
		$this->db->where('id', $id);
		return $this->db->update('tbl_portalfarma_programacao', ['status' => $status]);
	}
	
	public function marcar_presenca($id, $courseid, $tabela) {
	
		
		switch ($tabela) {
			case 'tbl_seminario_inscricao':
				$campo = "seminario";				
				break;
			case 'urm_inscricao':
				$campo = "urm_evento";				
				break;
			case 'fiscalizacao_humanizada_inscricao':
				$campo = "id_evento";				
				break;
		}
	
		$this->db->where('id', $id);
		$this->db->where($campo, $courseid);
		return $this->db->update($tabela, ['presenca' => 1]);
	}
	
	public function get_stats_seminario($id_seminario) {
		$curso = $this->db->select('titulo')
                      ->from('tbl_portalfarma')
                      ->where('courseid', $id_seminario) 
                      ->get()
                      ->row();

		$titulo = ($curso) ? $curso->titulo : 'Seminário não encontrado';

		// Sua query de estatísticas atual
		$sql = "SELECT 
					CASE s.ocupacao
						WHEN 2 THEN 'Farmacêutico de outras áreas'
						WHEN 3 THEN 'Fiscal da Vigilância Sanitária Municipal'
						WHEN 4 THEN 'Fiscal da Vigilância Sanitária Estadual'
						WHEN 5 THEN 'Fiscal do CRF/MG'
						WHEN 7 THEN 'Estudante'
						WHEN 8 THEN 'Outros profissionais'
						WHEN 9 THEN 'Fiscal de Conselho Profissional'
						ELSE 'Não informado'
					END AS ocupacao_nome,
					COUNT(CASE WHEN s.tipo_participacao = 'online' THEN 1 END) AS inscritos_online,
					COUNT(CASE WHEN s.tipo_participacao = 'presencial' THEN 1 END) AS inscritos_presencial,
					COUNT(CASE WHEN s.presenca = 1 THEN 1 END) AS presencas_confirmadas
				FROM tbl_seminario_inscricao s 
				WHERE s.seminario = ?
				GROUP BY s.ocupacao";
				
		$resultados = $this->db->query($sql, array($id_seminario))->result();

		// Retorna um array com as duas informações
		return [
			'titulo' => $titulo,
			'lista'  => $resultados
		];
	}
	
}
