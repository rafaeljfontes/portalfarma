<?php
	/*
		funções auxiliares helpers
	*/
	function portalfarma_permissoes($valor)
	{
		$permitidas = array('admin', 'dashboard', 'capacifar', 'atitudes', 'tragadevolta', 'receitas', 'cientificos', 'BJHP');
		$valor = trim((string) $valor);
		$permissoes = array();

		if ($valor !== '') {
			$json = json_decode($valor, true);
			if (json_last_error() === JSON_ERROR_NONE && is_array($json)) {
				foreach ($json as $chave => $item) {
					if (is_string($chave) && !is_int($chave) && $item) {
						$permissoes[] = $chave;
					} elseif (is_string($item)) {
						$permissoes[] = $item;
					}
				}
			} else {
				$valor = str_ireplace(array('permissão:', 'permissao:'), '', $valor);
				$permissoes = array_map('trim', explode(',', $valor));
			}
		}

		return array_values(array_intersect($permitidas, array_unique($permissoes)));
	}

	function document_root()
	{	
		return $_SERVER['DOCUMENT_ROOT']."/";
	}

	function base_system()
	{	
		//$base_system = 'http://localhost/';
		$base_system = 'https://crfmg.org.br/';
		return $base_system;
	}

	function getEstados(){
		$estados = array();

		$estados['AC'] = "Acre";
		$estados['AL'] = "Alagoas";
		$estados['AP'] = "Amapá";
		$estados['AM'] = "Amazonas";
		$estados['BA'] = "Bahia";
		$estados['CE'] = "Ceará";
		$estados['DF'] = "Distrito Federal";
		$estados['ES'] = "Espírito Santo";
		$estados['GO'] = "Goiás";
		$estados['MA'] = "Maranhão";
		$estados['MT'] = "Mato Grosso";
		$estados['MS'] = "Mato Grosso do Sul";
		$estados['MG'] = "Minas Gerais";
		$estados['PA'] = "Pará";
		$estados['PB'] = "Paraíba ";
		$estados['PR'] = "Paraná";
		$estados['PE'] = "Pernambuco";
		$estados['PI'] = "Piauí";
		$estados['RJ'] = "Rio de Janeiro";
		$estados['RN'] = "Rio Grande do Norte";
		$estados['RS'] = "Rio Grande do Sul ";
		$estados['RO'] = "Rondônia";
		$estados['RR'] = "Roraima";
		$estados['SC'] = "Santa Catarina ";
		$estados['SP'] = "São Paulo ";
		$estados['SE'] = "Sergipe";
		$estados['TO'] = "Tocantins";

		return $estados;
	}


	function createCaptcha(){
		$rules_captcha = array(
			'word'          => mt_rand(100000,999999),
			'img_path'      => './cache/captcha/',
			'img_url'       => base_url().'cache/captcha/',
			'font_path'     => './assets/fonts/Roboto-Bold.ttf',
			'img_width'     => '110',
			'img_height'    => 50,
			'expiration'    => 7200,
			'word_length'   => 12,
			'font_size'     => 12,
			'img_id'        => 'captcha',
	
			// White background and border, black text and red grid
			'colors'        => array(
					'background' => array(mt_rand(200,255), 255, 255),
					'border' => array(255, 255, 255),
					'text' => array(0, 0, 0),
					'grid' => array(mt_rand(200,255), 40, 40)
			)
		);

		return create_captcha($rules_captcha);
	}

	function cpfMask($cpf){
		$cpf = preg_replace( '/[^0-9]/is', '', $cpf );
		
		if(empty($cpf) || strlen($cpf) != 11){
			return false;
		}
		
		return substr($cpf,0,3).".".substr($cpf,3,3).".".substr($cpf,6,3)."-".substr($cpf,9,2);
	}

	function cnpjMask($cnpj){
		$cnpj = preg_replace( '/[^0-9]/is', '', $cnpj );
		
		if(empty($cnpj) || strlen($cnpj) != 14){
			return false;
		}
		return substr($cnpj,0,2).".".substr($cnpj,2,3).".".substr($cnpj,5,3)."/".substr($cnpj,8,4)."-".substr($cnpj,12,2);
	}

	function getIpUser()
	{
		if (isset($_SERVER['HTTP_CLIENT_IP'])) {
			$ip = $_SERVER['HTTP_CLIENT_IP'];
		}elseif (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
			$ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
		}elseif (isset($_SERVER['HTTP_X_FORWARDED'])) {
			$ip = $_SERVER['HTTP_X_FORWARDED'];
		}elseif (isset($_SERVER['HTTP_FORWARDED_FOR'])) {
			$ip = $_SERVER['HTTP_FORWARDED_FOR'];
		}elseif (isset($_SERVER['HTTP_FORWARDED'])) {
			$ip = $_SERVER['HTTP_FORWARDED'];
		}elseif (isset($_SERVER['REMOTE_ADDR'])) {
			$ip = $_SERVER['REMOTE_ADDR'];
		}else{
			$ip = 'desconhecido';
		}
		return $ip;
	}


	function getEmailExibicao($email)
	{
		$user = strstr($email, '@', true);
		$domain = strstr($email, '@', false);
		$user_encpty = str_replace( substr($user, 3, strlen($user)), str_repeat("*", strlen(substr($user, 3, strlen($user))) ), $user);

		$email = $user_encpty.$domain;

		return $email;
	}

	function properCase($string = null)
	{
		$ignore  = array ("do", "dos", "da", "das", "de");
		$explode = explode(" ", mb_strtolower( $string ) );
		$output  = "";
		foreach ($explode as $word) {
			$output .= ( in_array($word, $ignore) ? $word : ucfirst($word) )." ";
		}
		return trim($output);
	}
