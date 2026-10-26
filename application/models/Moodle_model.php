<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Moodle_model extends CI_Model
{
    private $url   = 'https://portalfarma.crfmg.org.br/moodle/webservice/rest/server.php';
    private $token = '';
    private $token_User = ''; //Token_update_user
	
	

    protected function request(string $function, array $params = []): array
    {
        $resultado = $this->executar_request($function, $params);
        if (class_exists('Inscricao_log', false) && Inscricao_log::$ativo) {
            if (empty($resultado['ok'])) {
                Inscricao_log::$ativo->erro($function, (array) ($resultado['error'] ?? []));
            } elseif ($function === 'enrol_manual_enrol_users') {
                Inscricao_log::$ativo->confirmar();
            }
        }
        return $resultado;
    }

    private function executar_request(string $function, array $params = []): array
    {
        $payload = array_merge($params, [
            'wstoken'            => trim($function === 'core_user_update_users' ? $this->token_User : $this->token),
            'wsfunction'         => $function,
            'moodlewsrestformat' => 'json',
        ]);

        $ch = curl_init($this->url);

        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST           => true,
            CURLOPT_POSTFIELDS     => http_build_query($payload, '', '&', PHP_QUERY_RFC3986),
            CURLOPT_CONNECTTIMEOUT => 10,
            CURLOPT_TIMEOUT        => 30,
            CURLOPT_SSL_VERIFYPEER => true,
            CURLOPT_SSL_VERIFYHOST => 2,
        ]);

        $raw       = curl_exec($ch);
        $curlError = curl_error($ch);
        $curlErrno = curl_errno($ch);
        $httpCode  = (int) curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($raw === false || $curlError) {
            return [
                'ok'    => false,
                'data'  => null,
                'error' => [
                    'code'       => 'curl_error',
                    'message'    => 'Falha na comunicação via cURL.',
                    'http_code'  => $httpCode ?: null,
                    'curl_error' => $curlError ?: null,
                    'curl_errno' => $curlErrno,
                    'raw'        => $raw,
                ],
            ];
        }

        $json = json_decode($raw, true);

        if (json_last_error() === JSON_ERROR_NONE) {
            if (is_array($json) && isset($json['exception'])) {
                return [
                    'ok'   => false,
                    'data' => null,
                    'error' => [
                        'code'      => $json['errorcode'] ?? 'moodle_exception',
                        'message'   => $json['message'] ?? 'Erro no Moodle WebService.',
                        'debug'     => $json['debuginfo'] ?? null,
                        'http_code' => $httpCode,
                        'raw'       => $raw,
                    ],
                ];
            }

            return [
                'ok'    => true,
                'data'  => $json,
                'error' => null,
            ];
        }

        $xmlErrCode = null;
        $xmlMessage = null;

        if (stripos($raw, '<EXCEPTION') !== false) {
            if (preg_match('/<ERRORCODE>(.*?)<\/ERRORCODE>/si', $raw, $m)) {
                $xmlErrCode = trim($m[1]);
            }
            if (preg_match('/<MESSAGE>(.*?)<\/MESSAGE>/si', $raw, $m)) {
                $xmlMessage = trim($m[1]);
            }
        }

        return [
            'ok'    => false,
            'data'  => null,
            'error' => [
                'code'      => $xmlErrCode ?: 'invalid_response',
                'message'   => $xmlMessage ?: 'Resposta não-JSON do Moodle (verifique token/serviço).',
                'http_code' => $httpCode,
                'raw'       => $raw,
            ],
        ];
    }
	
	public function total_inscritos_curso($courseid)
    {
        $params = [
            'wstoken' => $this->token,
            'wsfunction' => 'core_enrol_get_enrolled_users',
            'courseid' => $courseid,
            'moodlewsrestformat' => 'json'
        ];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($params));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);

        $response = curl_exec($ch);
        curl_close($ch);

        $data = json_decode($response, true);

        // Erro de token ou permissão
        if (isset($data['exception'])) {
            log_message('error', 'Moodle API error: ' . $data['message']);
            return 0;
        }

        return is_array($data) ? count($data) : 0;
    }
	
    public function site_info(): array
    {
        return $this->request('core_webservice_get_site_info');
    }

    public function criar_usuario($username, $senha, $nome, $email, $cidade, $crfmg, $telefone, $pais, $instituicao = ''): array
    {
        $username = strtolower(trim($username));
        $username = preg_replace('/\s+/', '', $username);
		
		// Normaliza espaços, inclusive quebras de linha e espaços Unicode,
		// antes de separar o sobrenome (um espaço final não é um sobrenome).
		$nome = trim(preg_replace('/[\s\p{Z}]+/u', ' ', (string) $nome) ?? '');
		if ($nome === '') {
			return ['ok' => false, 'data' => null, 'error' => [
				'code' => 'invalid_name', 'message' => 'Informe seu nome para realizar a inscrição.'
			]];
		}
		// Procura a posição do último espaço na string
		$ultimo_espaco = mb_strrpos($nome, ' ');

		if ($ultimo_espaco !== false) {
			$firstname = trim(mb_substr($nome, 0, $ultimo_espaco));
			$lastname  = trim(mb_substr($nome, $ultimo_espaco + 1));
		} else {
			// Caso o usuário tenha digitado apenas 1 nome (ex: "Denise")
			$firstname = $nome;
			$lastname  = '.'; // Moodle exige lastname, então usamos um ponto como fallback
		}

        return $this->request('core_user_create_users', [
            'users' => [
                [
                    'username'  => $username,
                    'password'  => (string) $senha,
                    'firstname' => (string) $firstname,
                    'lastname'  => (string) $lastname,
                    'email'     => (string) $email,
                    'city'      => (string) $cidade,
                    'phone1'    => (string) $telefone,
                    'idnumber'  => (string) $crfmg,
                    'country'   => (string) $pais,
                    'institution' => is_string($instituicao) ? trim($instituicao) : '',
                    'preferences' => [
                        [
                            'type'  => 'auth_forcepasswordchange',
                            'value' => 1
                        ]
                    ]
                ]
            ]
        ]);
    }

    public function atualizar_instituicao($userid, $instituicao = ''): array
    {
        return $this->request('core_user_update_users', [
            'users' => [[
                'id' => (int) $userid,
                'institution' => is_string($instituicao) ? trim($instituicao) : '',
            ]],
        ]);
    }

    public function inscrever_curso($userid, $courseid, $roleid = 5): array
    {
        return $this->request('enrol_manual_enrol_users', [
            'enrolments' => [
                [
                    'roleid'   => (int) $roleid,
                    'userid'   => (int) $userid,
                    'courseid' => (int) $courseid
                ]
            ]
        ]);
    }

    public function listar_matriculados(int $courseid): array
    {
        return $this->request('core_enrol_get_enrolled_users', [
            'courseid' => (int) $courseid,
        ]);
    }

    public function esta_matriculado(int $userid, int $courseid): array
    {
        $res = $this->listar_matriculados($courseid);

        if (!$res['ok']) return $res;

        $enrolled = false;
        if (is_array($res['data'])) {
            foreach ($res['data'] as $u) {
                if ((int)($u['id'] ?? 0) === (int)$userid) {
                    $enrolled = true;
                    break;
                }
            }
        }

        if ($enrolled && class_exists('Inscricao_log', false) && Inscricao_log::$ativo) {
            Inscricao_log::$ativo->confirmar();
        }
        return ['ok' => true, 'data' => ['enrolled' => $enrolled], 'error' => null];
    }

    public function buscar_usuario_por_username(string $username): array
    {
        $username = trim(mb_strtolower($username));
        $username = iconv('UTF-8', 'ASCII//TRANSLIT//IGNORE', $username);
        $username = preg_replace('/\s+/', '', $username);
        $username = preg_replace('/[^a-z0-9._-]/', '', $username);

        $res = $this->request('core_user_get_users_by_field', [
            'field'  => 'username',
            'values' => [$username],
        ]);

        // Se ok e retornou lista, devolve o primeiro usuário
        if ($res['ok'] && is_array($res['data']) && count($res['data']) > 0) {
            return [
                'ok'   => true,
                'data' => $res['data'][0], // usuário encontrado
                'error'=> null
            ];
        }

        // Se ok mas vazio -> não existe
        if ($res['ok']) {
            return [
                'ok'   => true,
                'data' => null,
                'error'=> null
            ];
        }

        // Erro do Moodle
        return $res;
    }

    public function buscar_usuario_por_idnumber(string $idnumber): array
    {
        $idnumber = trim((string)$idnumber);

        $res = $this->request('core_user_get_users_by_field', [
            'field'  => 'idnumber',
            'values' => [$idnumber],
        ]);

        if ($res['ok'] && is_array($res['data']) && count($res['data']) > 0) {
            return [
                'ok'   => true,
                'data' => $res['data'][0],
                'error'=> null
            ];
        }

        if ($res['ok']) {
            return [
                'ok'   => true,
                'data' => null,
                'error'=> null
            ];
        }

        return $res;
    }

    public function usuario_existe(string $username): array
    {
        return $this->buscar_usuario_por_username($username);
        // return ($res['ok'] && !empty($res['data']));
    }
	
	public function buscarUsuarioEmail($email)
	{

		$params = [
			'wstoken' => $this->token,
			'wsfunction' => 'core_user_get_users',
			'moodlewsrestformat' => 'json',
			'criteria[0][key]' => 'email',
			'criteria[0][value]' => $email
		];

		$url = $this->url . '?' . http_build_query($params);

		$response = file_get_contents($url);

		return json_decode($response);

	}
	
	public function salvarSenha($userid,$senha)
    {
		
		$params = [
			'wstoken' => $this->token_User,
			'wsfunction' => 'core_user_update_users',
			'moodlewsrestformat' => 'json',
			'users' => [
				[
					'id' => $userid,
					'password' => $senha
				]
			]
		];

		$ch = curl_init();

		curl_setopt_array($ch, [
			CURLOPT_URL => $this->url,
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_POST => true,
			CURLOPT_POSTFIELDS => http_build_query($params)
		]);

		$response = curl_exec($ch);
		curl_close($ch);

		return json_decode($response, true);

    }
	
	// Busca o ID do usuário no Moodle pelo campo de perfil CPF
		public function get_user_by_cpf($cpf) {
			return $this->db->select('u.id')
				->from('mdl_user u')
				->join('mdl_user_info_data d', 'd.userid = u.id')
				->join('mdl_user_info_field f', 'f.id = d.fieldid')
				->where('f.shortname', 'cpf')
				->where('d.data', $cpf)
				->get()
				->row();
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
