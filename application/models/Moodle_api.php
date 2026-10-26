<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Moodle_api extends CI_Model {

    private $moodle;

    public function relatorio_curso($courseid)
    {
        if (!ctype_digit((string) $courseid) || (int) $courseid <= 0) {
            throw new InvalidArgumentException('Curso inválido.');
        }
        $id = (int) $courseid;
        $dados = ['inscritos' => NULL, 'ativos' => NULL, 'acessos' => NULL,
            'atividades' => NULL, 'certificados' => NULL];
        $debug = $this->moodle->db_debug;
        $this->moodle->db_debug = FALSE;
        try {
            $alunos = "SELECT DISTINCT ue.userid FROM mdl_enrol e
                JOIN mdl_user_enrolments ue ON ue.enrolid = e.id AND ue.status = 0
                JOIN mdl_user u ON u.id = ue.userid AND u.deleted = 0
                JOIN mdl_context ctx ON ctx.instanceid = e.courseid AND ctx.contextlevel = 50
                JOIN mdl_role_assignments ra ON ra.contextid = ctx.id AND ra.userid = ue.userid AND ra.roleid = 5
                WHERE e.courseid = ?";
            $consultas = [
                'inscritos' => ["SELECT COUNT(*) AS total FROM ($alunos) alunos", [$id]],
                'logs' => ["SELECT COUNT(DISTINCT CASE WHEN l.edulevel = 2 THEN l.userid END) AS ativos,
                    COALESCE(SUM(l.action = 'viewed' AND l.target = 'course'), 0) AS acessos,
                    COALESCE(SUM(l.action = 'viewed' AND l.target = 'course_module' AND l.contextlevel = 70), 0) AS atividades
                    FROM mdl_logstore_standard_log l JOIN ($alunos) alunos ON alunos.userid = l.userid
                    WHERE l.courseid = ? AND l.anonymous = 0", [$id, $id]],
            ];
            foreach ($consultas as $chave => $consulta) {
                try {
                    $query = $this->moodle->query($consulta[0], $consulta[1]);
                    if ($query === FALSE) continue;
                    $linha = $query->row();
                    if ($chave === 'inscritos') $dados['inscritos'] = (int) $linha->total;
                    else foreach (['ativos', 'acessos', 'atividades'] as $campo) $dados[$campo] = (int) $linha->$campo;
                } catch (Exception $e) {
                    log_message('error', 'Relatório Moodle: indicador indisponível para curso '.$id.'.');
                }
            }
            // Emissões de todos os usuários, inclusive quem não está mais matriculado.
            $total = 0;
            $encontrado = FALSE;
            try {
                foreach (['customcert' => 'customcertid', 'certificate' => 'certificateid'] as $modulo => $campo) {
                    if (!$this->moodle->table_exists('mdl_'.$modulo.'_issues')) continue;
                    $encontrado = TRUE;
                    $query = $this->moodle->query("SELECT COUNT(*) AS total FROM mdl_{$modulo}_issues i
                        JOIN mdl_{$modulo} c ON c.id = i.$campo WHERE c.course = ?", [$id]);
                    if ($query === FALSE) throw new RuntimeException('Certificados indisponíveis.');
                    $total += (int) $query->row()->total;
                }
                // Course certificate usa a ferramenta tool_certificate para suas emissões.
                // O courseid pertence ao curso; o id da URL view.php é da atividade.
                if ($this->moodle->table_exists('mdl_tool_certificate_issues')) {
                    $encontrado = TRUE;
                    $query = $this->moodle->query("SELECT COUNT(*) AS total
                        FROM mdl_tool_certificate_issues
                        WHERE courseid = ? AND component = ?", [$id, 'mod_coursecertificate']);
                    if ($query === FALSE) throw new RuntimeException('Certificados do curso indisponíveis.');
                    $total += (int) $query->row()->total;
                }
                if ($encontrado) $dados['certificados'] = $total;
            } catch (Exception $e) {
                log_message('error', 'Relatório Moodle: certificados indisponíveis para curso '.$id.'.');
            }
            return $dados;
        } finally {
            $this->moodle->db_debug = $debug;
        }
    }

    public function __construct()
    {
        parent::__construct();
        $this->moodle = $this->load->database('moodle', TRUE);
    }

    public function grupos_do_curso($courseid)
    {
        if (!ctype_digit((string) $courseid) || (int) $courseid <= 0) {
            throw new InvalidArgumentException('Curso invalido.');
        }
        $debug = $this->moodle->db_debug;
        $this->moodle->db_debug = FALSE;
        try {
            $query = $this->moodle->query("SELECT g.id AS grupo_id, g.name AS grupo_nome,
                    u.id AS usuario_id, CONCAT(u.firstname, ' ', u.lastname) AS usuario_nome
                FROM mdl_groups g
                LEFT JOIN mdl_groups_members gm ON gm.groupid = g.id
                LEFT JOIN mdl_user u ON u.id = gm.userid AND u.deleted = 0
                WHERE g.courseid = ?
                ORDER BY g.name, g.id, u.firstname, u.lastname, u.id", [(int) $courseid]);
            if ($query === FALSE) {
                throw new RuntimeException('Consulta de grupos indisponivel.');
            }
            $grupos = [];
            foreach ($query->result() as $linha) {
                $id = (int) $linha->grupo_id;
                if (!isset($grupos[$id])) {
                    $grupos[$id] = ['id' => $id, 'nome' => $linha->grupo_nome, 'membros' => []];
                }
                if ($linha->usuario_id !== NULL) {
                    $grupos[$id]['membros'][] = ['id' => (int) $linha->usuario_id, 'nome' => $linha->usuario_nome];
                }
            }
            return array_values($grupos);
        } finally {
            $this->moodle->db_debug = $debug;
        }
    }

    public function totais_inscritos_cursos(array $courseids)
    {
        $ids = array_values(array_unique(array_filter(array_map('intval', $courseids), function ($id) { return $id > 0; })));
        if (!$ids) return [];
        $placeholders = implode(',', array_fill(0, count($ids), '?'));
        $debug = $this->moodle->db_debug;
        $this->moodle->db_debug = FALSE;
        try {
            // Preserva o critério da contagem anterior: matrícula ativa e papel
            // de estudante no contexto do curso, contando cada pessoa uma vez.
            $query = $this->moodle->query("SELECT c.id AS courseid, COUNT(DISTINCT ue.userid) AS total_estudantes
                FROM mdl_course c
                JOIN mdl_course_categories cc ON cc.id = c.category
                JOIN mdl_enrol e ON e.courseid = c.id
                JOIN mdl_user_enrolments ue ON ue.enrolid = e.id AND ue.status = 0
                JOIN mdl_context ctx ON ctx.instanceid = c.id AND ctx.contextlevel = 50
                WHERE c.id IN ($placeholders)
                AND EXISTS (SELECT 1 FROM mdl_role_assignments ra
                    WHERE ra.contextid = ctx.id AND ra.userid = ue.userid AND ra.roleid = 5)
                GROUP BY c.id", $ids);
            if ($query === FALSE) throw new RuntimeException('Contagem de inscritos indisponível.');
            return $query->result();
        } finally {
            $this->moodle->db_debug = $debug;
        }
    }

    public function total_alunos()
    {
        $sql = "
            SELECT 
				c.id AS courseid,
				c.fullname,
				cc.id AS categoryid,
				cc.name AS category_name,

				-- Professor (pode trazer mais de um, separados por vírgula)
				GROUP_CONCAT(DISTINCT CONCAT(p.firstname, ' ', p.lastname) SEPARATOR ', ') AS professor,

				-- Total de estudantes
				COUNT(DISTINCT ue.userid) AS total_estudantes

			FROM mdl_course c

			JOIN mdl_course_categories cc 
				ON cc.id = c.category

			-- Matrículas
			JOIN mdl_enrol e 
				ON e.courseid = c.id

			JOIN mdl_user_enrolments ue 
				ON ue.enrolid = e.id AND ue.status = 0

			-- Contexto do curso
			JOIN mdl_context ctx 
				ON ctx.instanceid = c.id 
				AND ctx.contextlevel = 50

			-- Role estudantes
			JOIN mdl_role_assignments ra_student 
				ON ra_student.contextid = ctx.id 
				AND ra_student.userid = ue.userid
				AND ra_student.roleid = 5

			-- Role professor
			LEFT JOIN mdl_role_assignments ra_prof 
				ON ra_prof.contextid = ctx.id 
				AND ra_prof.roleid in (3,4)

			LEFT JOIN mdl_user p 
				ON p.id = ra_prof.userid

			GROUP BY c.id, cc.id, cc.name

			ORDER BY cc.name, c.fullname;
					";

		return $this->moodle->query($sql)->result();

    }
	
	public function total_alunos_curso($courseid)
    {
        $sql = "
            SELECT 
			c.id AS courseid,
			c.fullname,
			COUNT(DISTINCT ue.userid) AS total_estudantes
		FROM mdl_course c
		JOIN mdl_enrol e ON e.courseid = c.id
		JOIN mdl_user_enrolments ue ON ue.enrolid = e.id
		JOIN mdl_context ctx ON ctx.instanceid = c.id AND ctx.contextlevel = 50
		JOIN mdl_role_assignments ra ON ra.contextid = ctx.id
		WHERE ra.roleid = 5 AND c.id = ".$courseid."
		AND ue.status = 0
		GROUP BY c.id
        ";

		return $this->moodle->query($sql)->result();

    }
	
	public function total_inscritos_moodle()
    {
        $sql = "
            SELECT r.shortname, COUNT(DISTINCT u.id) AS total
			FROM mdl_user u
			JOIN mdl_role_assignments ra ON ra.userid = u.id
			JOIN mdl_role r ON r.id = ra.roleid
			WHERE u.deleted = 0
			GROUP BY r.shortname;
        ";

        return $this->moodle->query($sql)->result();

    }
	
	public function total_inscritos_cursos($courseid)
    {
        $sql = "
            SELECT COUNT(ue.id) AS total 
			FROM mdl_user_enrolments ue 
			JOIN mdl_enrol e ON e.id = ue.enrolid 
			JOIN mdl_user u ON u.id = ue.userid 
			WHERE e.courseid = ".$courseid."
			  AND u.deleted = 0 
			  AND e.status = 0 
			  AND (ue.timeend = 0 OR ue.timeend > UNIX_TIMESTAMP());
        ";

        return $this->moodle->query($sql)->result();

    }
	
	public function contador_inscritos()
    {
        $sql = "
            SELECT COUNT(*) AS total_usuarios_ativos
				FROM mdl_user
				WHERE deleted = 0
				AND suspended = 0
				AND id > 2;
        ";

        return $this->moodle->query($sql)->result();

    }
	
	
	public function get_estudantes_curso($courseid) {
		
		$sql = "
            SELECT 
				u.id as id_moodle, CONCAT(u.firstname, ' ', u.lastname) AS nome_completo, u.username as cpf, u.email AS email, u.phone1 AS telefone
			FROM mdl_user u
			JOIN mdl_user_enrolments ue ON ue.userid = u.id
			JOIN mdl_enrol e ON e.id = ue.enrolid
			JOIN mdl_course c ON c.id = e.courseid
			WHERE c.id = ".$courseid."
			  AND u.deleted = 0
			  AND u.suspended = 0
			ORDER BY u.firstname
        ";

        return $this->moodle->query($sql)->result();

		
		/*u.id')
			->join('mdl_context ct', 'ct.id = ra.contextid')
			->join('mdl_course c', 'c.id = ct.instanceid')
			// Buscando campo personalizado de CPF (ajuste o nome 'cpf' se for diferente no seu Moodle)
			->join('mdl_user_info_data info', 'info.userid = u.id', 'left')
			->join('mdl_user_info_field field', 'field.id = info.fieldid AND field.shortname = "cpf"', 'left')
			->where('c.id', $courseid)
			->where('ra.roleid', 5) // 5 costuma ser o ID padrão de estudante
			->where('ct.contextlevel', 50) // Nível de contexto de curso
			->get()
			->result();*/
	}
	
	public function categoria_inscritos()
    {
		
		$sql = "SELECT
				COALESCE(NULLIF(TRIM(d.data), ''), 'Sem categoria') AS categoria,
				COUNT(DISTINCT u.id) AS total_usuarios
			FROM mdl_user u
			LEFT JOIN mdl_user_info_field f
				ON f.shortname = 'categoria'
			LEFT JOIN mdl_user_info_data d
				ON d.userid = u.id
				AND d.fieldid = f.id
			WHERE u.deleted = 0
				AND u.suspended = 0
				AND u.id > 2
			GROUP BY COALESCE(NULLIF(TRIM(d.data), ''), 'Sem categoria')
			ORDER BY total_usuarios DESC;";
			
			return $this->moodle->query($sql)->result();
	
	}
	
	public function total_students_mes()
    {
        $sql = "
            SELECT 
				FROM_UNIXTIME(ue.timecreated, '%Y-%m') AS mes,
				COUNT(*) AS total
			FROM mdl_user_enrolments ue
			WHERE YEAR(FROM_UNIXTIME(ue.timecreated)) = YEAR(CURDATE())
			GROUP BY mes
			ORDER BY mes ASC;
        ";

        return $this->moodle->query($sql)->result();

    }

	public function media_inscricoes_mensal_por_cursos($courseids, $ano = 2026)
	{
		$idsValidos = array_values(array_unique(array_filter(array_map('intval', (array) $courseids), function ($id) {
			return $id > 0;
		})));

		if (empty($idsValidos)) {
			return 0;
		}

		$ano = (int) $ano;
		$listaIds = implode(',', $idsValidos);
		$sql = "SELECT ROUND(
				COUNT(DISTINCT CASE
					WHEN ue.status = 0
						AND ra.id IS NOT NULL
						AND YEAR(FROM_UNIXTIME(ue.timecreated)) = {$ano}
					THEN ue.id
				END) /
				CASE
					WHEN YEAR(CURDATE()) = {$ano} THEN GREATEST(MONTH(CURDATE()), 1)
					WHEN YEAR(CURDATE()) > {$ano} THEN 12
					ELSE 1
				END,
				1
			) AS media_inscricoes_mes
			FROM mdl_enrol e
			LEFT JOIN mdl_user_enrolments ue ON ue.enrolid = e.id
			LEFT JOIN mdl_context ctx
				ON ctx.instanceid = e.courseid
				AND ctx.contextlevel = 50
			LEFT JOIN mdl_role_assignments ra
				ON ra.contextid = ctx.id
				AND ra.userid = ue.userid
				AND ra.roleid = 5
			WHERE e.status = 0
				AND e.courseid IN ({$listaIds})";

		$resultado = $this->moodle->query($sql)->row();
		return $resultado ? (float) $resultado->media_inscricoes_mes : 0;
	}
	
	public function atualizarSenhaMoodle($userid, $senha)
	{
		// 1. Define os dados para atualização
		$data = array(
			'password' => $senha
		);

		// 2. Define o filtro (WHERE)
		$this->moodle->where('id', $userid);

		// 3. Executa o update informando a tabela e os dados
		return $this->moodle->update('mdl_user', $data);
	}
	
	public function verificaCpf($cpf)
    {

        $sql = "
            SELECT 
				u.id,
				u.username,
				u.firstname,
				u.lastname,
				u.email,
				u.phone1,
				u.idnumber,
				u.institution,
				u.city,
				f.name AS nome_campo,
				f.shortname AS nome_curto_campo,
				d.data AS valor_categoria
			FROM mdl_user u
			LEFT JOIN mdl_user_info_data d ON d.userid = u.id
			LEFT JOIN mdl_user_info_field f ON f.id = d.fieldid
			WHERE u.username = ?;
        ";

        return $this->moodle->query($sql, [$cpf])->result();
    }
	
	public function lista_cursos()
    {

        $sql = "
            SELECT 
				id AS courseid, 
				fullname AS nome_do_curso, 
				shortname AS nome_curto
			FROM 
				mdl_course;
        ";

        return $this->moodle->query($sql)->result();
    }
	
	public function lista_inscritos_cursos($courseid)
    {

        $sql = "
            SELECT 
				CONCAT(u.firstname, ' ', REPLACE(u.lastname, '-', '')) AS nome,
				u.username AS cpf,
				COALESCE(uid.data, 'Sem categoria') AS ocupacao
			FROM mdl_user u
			JOIN mdl_user_enrolments ue ON ue.userid = u.id
			JOIN mdl_enrol e ON e.id = ue.enrolid
			LEFT JOIN mdl_user_info_field uif ON uif.shortname = 'categoria'
			LEFT JOIN mdl_user_info_data uid ON uid.fieldid = uif.id AND uid.userid = u.id
			WHERE e.courseid = '".$courseid."'
			  AND u.deleted = 0
			  AND u.confirmed = 1
			ORDER BY nome ASC;
        ";

        return $this->moodle->query($sql)->result();
    }
	
	public function verifica_farma_sys($cpf)
	{
		
		///API Lucas *** VERIFICA SE É FARMACÊUTICO
		
			$curl = curl_init();
				curl_setopt( $curl, CURLOPT_URL, 'http://api.crfmg.org.br/api/check/pf-existe' );
				curl_setopt( $curl, CURLOPT_POST, true );
				curl_setopt( $curl, CURLOPT_POSTFIELDS, array(
				'cpf' => $cpf,
				));
				curl_setopt( $curl, CURLOPT_RETURNTRANSFER, true );
			$response = json_decode( curl_exec( $curl ), true);
				curl_close($curl);
				
			return json_encode($response);
	}
	
	// Busca o ID do usuário no Moodle pelo campo de perfil CPF
		public function get_user_by_cpf($cpf) {
			
			$sql = "
            SELECT u.id
				FROM mdl_user u
				JOIN mdl_user_enrolments ue ON ue.userid = u.id
				JOIN mdl_enrol e ON e.id = ue.enrolid
				WHERE u.username = '".$cpf."' 
				  AND e.courseid = 54
				  AND ue.status = 0;
			";

			return $this->moodle->query($sql)->result();
		
		}
		
		public function get_user_enrol($cpf) {
			
			$sql = "
            SELECT u.id, Concat(u.firstname,' ',u.lastname) as Nome_Completo,
				u.idnumber as crfmg, u.email, u.phone1, u.city, u.country, d.data AS categoria
				FROM mdl_user u
				LEFT JOIN mdl_user_info_data d ON d.userid = u.id
				WHERE u.username = '".$cpf."';
			";

			return $this->moodle->query($sql)->result();
		
		}
		// Verifica se o ID do usuário já tem matrícula no curso
		public function is_enrolled($userid, $courseid) {
			$this->db->from('mdl_user_enrolments ue');
			$this->db->join('mdl_enrol e', 'e.id = ue.enrolid');
			$this->db->where('e.courseid', $courseid);
			$this->db->where('ue.userid', $userid);
			return $this->db->count_all_results() > 0;
		}
}
