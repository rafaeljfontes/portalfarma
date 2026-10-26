<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Form_validation extends CI_Form_validation{

        private $ci;
        
        function __construct()
        {
           parent::__construct();
           
           $this->ci=& get_instance();
           
        }

        function my_validar_hora($campo){

                $hora_valida = preg_match('/^(0[0-9]|1[0-9]|2[0-3]):([0-5][0-9])/', $campo) ? true : false;

                if ( ! $hora_valida ){
                        $this->set_message('my_validar_hora', "campo invalido");
                        return false;
                }
                return true;        

        }

        public function my_valid_money($money)
        {
                $money = preg_replace( '/[^0-9]/is', '', $money );
                
                if ( $money <= "0" ){
                        $this->set_message('my_valid_money', "Campo Obrigatório");
                        return false;
                }
                return true;        

        }

        function my_valid_captcha($captcha){
                $captcha = preg_replace( '/[^0-9]/is', '', $captcha );
                if(empty($captcha)){
                        $this->set_message('my_valid_captcha', "Informe o código da imagem");
                        return false;
                }
                
                $this->ci->load->library('session');
                if($captcha != $this->ci->session->captcha_word){
                        $this->set_message('my_valid_captcha', "Código da imagem incorreto");
                        return false;
                }
                return true;
        }

        public function my_valid_cpf($cpf){

                // Extrai somente os números
                $cpf = preg_replace( '/[^0-9]/is', '', $cpf );

                if(empty($cpf)){
                        $this->set_message('my_valid_cpf', "Informe o CPF");
                        return false;
                }
                                
                // Verifica se foi informado todos os digitos corretamente
                if (strlen($cpf) != 11) {
                        $this->set_message('my_valid_cpf', "Digite somente números no CPF");
                        return false;
                }

                // Verifica se foi informada uma sequência de digitos repetidos. Ex: 111.111.111-11
                if (preg_match('/(\d)\1{10}/', $cpf)) {
                        $this->set_message('my_valid_cpf', "CPF inválido. Verifique o CPF informado");
                        return false;
                }

                // Faz o calculo para validar o CPF
                for ($t = 9; $t < 11; $t++) {
                        for ($d = 0, $c = 0; $c < $t; $c++) {
                                @$d += $cpf[$c] * (($t + 1) - $c);
                        }
                        $d = ((10 * $d) % 11) % 10;
                        if ($cpf[$c] != $d) {
                                $this->set_message('my_valid_cpf', "CPF inválido. Verifique o CPF informado");
                                return false;
                        }
                }
                return true;
        }

        public function my_valid_cnpj($cnpj){

                // Extrai somente os números
                $cnpj = preg_replace( '/[^0-9]/is', '', $cnpj );

                if(empty($cnpj)){
                        $this->set_message('my_valid_cnpj', "Informe o CNPJ");
                        return false;
                }
                                
                // Verifica se foi informado todos os digitos corretamente
                if (strlen($cnpj) != 14) {
                        $this->set_message('my_valid_cnpj', "Digite somente números no CNPJ");
                        return false;
                }

                // Verifica se foi informada uma sequência de digitos repetidos. Ex: 11.111.111/1111-11
                if (preg_match('/(\d)\1{10}/', $cnpj)) {
                        $this->set_message('my_valid_cnpj', "CNPJ inválido. Verifique o CNPJ informado");
                        return false;
                }

                $pj = $cnpj;
                if ((strlen($pj) == 14) && ($pj > 0)) {
                        $j = 1;
                        for ($i = 0; $i < 13; $i++) {
                                if ($pj[$i] == $pj[$i + 1]) {
                                $j++;
                                }
                        }
                        if ($j <> 14) {
                                $dv = $pj[12].$pj[13];
                                $r = array(5, 4, 3, 2, 9, 8, 7, 6, 5, 4, 3, 2);
                                $soma1 = $pj[0] * $r[0] + $pj[1] * $r[1] + $pj[2] * $r[2] + $pj[3] * $r[3] + $pj[4] * $r[4] + $pj[5] * $r[5] + $pj[6] * $r[6] + $pj[7] * $r[7] + $pj[8] * $r[8] + $pj[9] * $r[9] + $pj[10] * $r[10] + $pj[11] * $r[11];
                                $resto = $soma1 % 11;
                                $d1 = ($resto < 2) ? 0 : (11 - $resto);
                                $r = array(6, 5, 4, 3, 2, 9, 8, 7, 6, 5, 4, 3, 2);
                                $soma2 = $pj[0] * $r[0] + $pj[1] * $r[1] + $pj[2] * $r[2] + $pj[3] * $r[3] + $pj[4] * $r[4] + $pj[5] * $r[5] + $pj[6] * $r[6] + $pj[7] * $r[7] + $pj[8] * $r[8] + $pj[9] * $r[9] + $pj[10] * $r[10] + $pj[11] * $r[11] + $pj[12] * $r[12];
                                $resto = $soma2 % 11;
                                $d2 = ($resto < 2) ? 0 : (11 - $resto);
                                if ( !(($dv[0] == $d1) && ($dv[1] == $d2)) ) {
                                        $this->set_message('my_valid_cnpj', "CNPJ inválido. Verifique o CNPJ informado");
                                        return false;
                                }
                        }
                }

                return true;
        }


	function my_valid_date($date){

		if(empty($date)){
			$this->form_validation->set_message('my_valid_date', "Informe a data ");
			return false;
		}

		$day 	= substr($date, 0, 2);
		$month 	= substr($date, 3, 2);
		$year 	= substr($date, 6, 4);
		
		if(!(is_numeric($day) &&  is_numeric($month) && is_numeric($year)) ){
			$this->form_validation->set_message('my_valid_date', "Data inválida");
			return false;
		}

		if($day > 31){
			$this->form_validation->set_message('my_valid_date', "Verifique a data informada");
			return false;
		}
		if($month > 12){
			$this->form_validation->set_message('my_valid_date', "Verifique a data informada");
			return false;
		}
		if($year > date('Y') || $year <= 1900){
			$this->form_validation->set_message('my_valid_date', "Verifique a data informada");
			return false;
		}
		if(!checkdate($month, $day, $year)){
			$this->form_validation->set_message('my_valid_date', "Data inválida");
			return false;
		}
	
		return true;
        }
        
	function my_valid_phone($phone){
			
		if(!empty($phone)){
			// Extrai somente os números
			$phone = preg_replace( '/[^0-9]/is', '', $phone );

			if(!( strlen($phone) == 10 || strlen($phone) == 11 )){
				$this->form_validation->set_message('my_valid_phone', "Verifique se o campo está correto");
				return false;
			}

		}
		return true;

	}

        /*
        Validações PF
        */
        public function my_check_cpf_exist_pf($cpf){
                $cpf = preg_replace( '/[^0-9]/is', '', $cpf );
                $user = $this->check_pf_user_exist($cpf);

                if(empty($user)){
                        $this->set_message('my_check_cpf_exist_pf', "Usuário não encontrado. Verifique o CPF informado");
                        return false;        
                }

                return true;
        }

        
        public function my_check_cpf_is_not_exist_pf($cpf){
                $cpf = preg_replace( '/[^0-9]/is', '', $cpf );
                $user = $this->check_pf_user_exist($cpf);
                
                if(!empty($user)){       
                        $this->set_message('my_check_cpf_is_not_exist_pf', "CPF já cadastrado. Use o link para recuperar senha");
                        return false;
                }
                return true;    
        }


        public function my_check_email_is_not_exist_pf($email){
                
                $user = $this->check_pf_user_exist(null, $email);

                if(!empty($user)){
                        $this->set_message('my_check_email_is_not_exist_pf', "e-mail já cadastrado. Use o link para recuperar senha");
                        return false;        
                }

                return true;
        }

        public function my_valid_login_pf($senha, $cpf)
        {
                $cpf = preg_replace( '/[^0-9]/is', '', $cpf );

                if(empty($senha)){
                        $this->set_message('my_valid_login_pf', "Informe a senha");
                        return false;        
                }

                if(empty($cpf)){
                        $this->set_message('my_valid_login_pf', "CPF e/ou senha inválida");
                        return false;        
                }

                // buscar o usuário com esse CPF
                $user = $this->check_pf_user_exist($cpf);

                if(empty($user)){
                        $this->set_message('my_valid_login_pf', "Usuário não encontrado. Verifique o CPF informado");
                        return false;        
                }

                $password_hash = $user->senha;
                if(!password_verify( $senha, $password_hash)){
                        $this->set_message('my_valid_login_pf', "Senha inválida");
                        return false;        
                }

                return true;
        }
        
        public function my_check_inscricao_exist_tbl_pf($inscricao)
        {
                $inscricao = preg_replace( '/[^0-9]/is', '', $inscricao );
                $this->ci->load->database();
		$this->ci->load->model('sqlserver/Tbl_pf_model', 'tbl_pf', TRUE);
		$result = $this->ci->tbl_pf->listWhere(['syscrf.tblPF.InscricaoPFId' => $inscricao]);

		if(empty($result)){
                        $this->set_message('my_check_inscricao_exist_tbl_pf', "Número de inscrição não encontrado.");
                        return false;
                }	

                if ( $result[0]->StatusCadastralId != 2){
                        // $this->set_message('my_check_cpf_exist_tbl_pf', "<span style='color:#069 !important;'>Olá, {$result[0]->NomePF} !<br>Para Reativar sua inscrição <u><a href='#'>clique aqui</a></u>");
                        $this->set_message('my_check_inscricao_exist_tbl_pf', "Não foi possível cadastrar Responsabilidade Técnica para o Profissional: ".$result[0]->NomePF.".<br>Regularize sua inscrição e tente novamente.");
                        return false;	        
                }
		return true;
        }

        public function my_check_cpf_exist_tbl_pf($cpf)
        {
                $cpf = preg_replace( '/[^0-9]/is', '', $cpf );
                $this->ci->load->database();
		$this->ci->load->model('sqlserver/Tbl_pf_model', 'tbl_pf', TRUE);
		$result = $this->ci->tbl_pf->listWhere(['cpf' => $cpf]);

		if(!empty($result)){
			
			if ( $result[0]->StatusCadastralId == 4){
				
				// $this->set_message('my_check_cpf_exist_tbl_pf', "<span style='color:#069 !important;'>Olá, {$result[0]->NomePF} !<br>Para Reativar sua inscrição <u><a href='#'>clique aqui</a></u>");
				$this->set_message('my_check_cpf_exist_tbl_pf', "CPF já cadastrado em nossa base de dados.");
				return false;	
				
			}else{
				$this->set_message('my_check_cpf_exist_tbl_pf', "CPF já cadastrado em nossa base de dados.");
				return false;	
			}
			
			
		}

		return true;
        }

        /*********/
        
        /*
        Validações PJ
        */
        public function my_check_cnpj_exist_pj($cnpj)
        {
                $cnpj = preg_replace( '/[^0-9]/is', '', $cnpj );
                $user = $this->check_pj_user_exist($cnpj);

                if(empty($user)){
                        $this->set_message('my_check_cnpj_exist_pj', "Empresa não encontrada. Verifique o CNPJ informado");
                        return false;        
                }

                return true;
        }

        public function my_check_cpf_exist_pj($cpf)
        {
                $cpf = preg_replace( '/[^0-9]/is', '', $cpf );
                $user = $this->check_pj_user_exist(null, $cpf);

                if(empty($user)){
                        $this->set_message('my_check_cpf_exist_pj', "Representante legal não encontrado. Verifique o CPF informado");
                        return false;        
                }

                return true;
        }

        public function my_check_cpf_is_not_exist_pj($cpf, $cnpj)
        {
                $cpf = preg_replace( '/[^0-9]/is', '', $cpf );
                $cnpj = preg_replace( '/[^0-9]/is', '', $cnpj );

                $user = $this->check_pj_user_exist($cnpj, $cpf);

                if(!empty($user)){
                        $this->set_message('my_check_cpf_is_not_exist_pj', "Já existe um login com esse CPF para esse estabelecimento. Utilize o Link recuperar senha.");
                        return false;        
                }

                return true;
        }
    
        public function my_check_email_is_not_exist_pj($email){
                
                $user = $this->check_pj_user_exist(null, null, $email);

                if(!empty($user)){
                        $this->set_message('my_check_email_is_not_exist_pj', "e-mail já cadastrado. Utilize o link para recuperar senha");
                        return false;        
                }

                return true;
        }

        public function my_valid_login_pj($senha = null, $cnpj_cpf = null)
        {
                $cnpj = preg_replace( '/[^0-9]/is', '', trim(explode(",",$cnpj_cpf)[0]) );
                $cpf = preg_replace( '/[^0-9]/is', '',  trim(explode(",",$cnpj_cpf)[1]) );

                if(empty($senha)){
                        $this->set_message('my_valid_login_pj', "Informe a senha");
                        return false;        
                }

                if(empty($cnpj)){
                        $this->set_message('my_valid_login_pj', "CNPJ não encontrado");
                        return false;        
                }

                if(empty($cpf)){
                        $this->set_message('my_valid_login_pj', "CPF não encontrado");
                        return false;        
                }

                // buscar o usuário com esse CPF
                $user = $this->check_pj_user_exist($cnpj, $cpf);

                if(empty($user)){
                        $this->set_message('my_valid_login_pj', "Usuário não encontrado. Verifique o CPF e/ou CNPJ informado");
                        return false;        
                }

                $password_hash = $user->senha;
                if(!password_verify( $senha, $password_hash)){
                        $this->set_message('my_valid_login_pj', "Senha inválida");
                        return false;        
                }

                return true;
        }
        


        /** validacoes Para modulo PJ */

        public function my_checar_cpf_cadastrado_res_legal($cpf)
        {
                $cpf = preg_replace( '/[^0-9]/is', '', $cpf );
                $res = $this->check_cpf_cadastrado_res_legal($cpf);

                if(!empty($res)){
                        $this->set_message('my_checar_cpf_cadastrado_res_legal', "Representante Legal já cadastrado.");
                        return false;        
                }

                return true;
        }


        /* funções auxiliares - somente para uso interno do arquivo */
        private function check_cpf_cadastrado_res_legal($cpf)
        {  
                $this->ci->load->database();
                $this->ci->load->model('mysql/inscricao_pj_model', 'inscricao_pj', TRUE);
                
                $id_solicitacao = $this->ci->session->userdata['SOLICITACAO'];

                if(isset($cpf)){
                        $resultado = $this->ci->inscricao_pj->query("SELECT count(*) as total FROM inscricao_pj_responsavel_legal WHERE id_solicitacao='".$id_solicitacao."' AND cpf='".$cpf."';");
                }

                if(!empty($resultado[0])){
                        if ( $resultado[0]->total == "0" ){
                                return false;
                        }
                }
                return $resultado[0]->total;
        }

        private function check_pf_user_exist($cpf = null, $email = null)
        {       
                $this->ci->load->database();
                $this->ci->load->model('mysql/acesso_login_model', 'acesso_login', TRUE);
                
                if(isset($cpf)){
                        $user = $this->ci->acesso_login->listUserLogin(['cpf' => $cpf, 'pessoa'=>'PF']);
                }
                if(isset($email)){
                        $user = $this->ci->acesso_login->listUserLogin(['email' => $email, 'pessoa'=>'PF']);
                }
              
                if(!empty($user)){
                        return $user[0];
                }
                /*
                $this->ci->load->database('sqlserver', TRUE);
                $this->ci->load->model('sqlserver/tab_autenticacao_site_model', 'tab_autenticacao_site', TRUE);
                $user = $this->ci->tab_autenticacao_site->listWhere(['cpf' => $cpf]);

                if(!empty($user)){
                        return $user[0];
                }
                */
                return false;
                
        }

        private function check_pj_user_exist($cnpj = null, $cpf = null, $email=null)
        {       
                $this->ci->load->database();
                $this->ci->load->model('mysql/acesso_login_model', 'acesso_login', TRUE);
                
                if(isset($cnpj)){
                        $user = $this->ci->acesso_login->listUserLogin(['cnpj' => $cnpj, 'pessoa'=>'PJ']);
                }
                if(isset($cpf)){
                        $user = $this->ci->acesso_login->listUserLogin(['cpf' => $cpf, 'pessoa'=>'PJ']);
                }
                if(isset($email)){
                        $user = $this->ci->acesso_login->listUserLogin(['email' => $email, 'pessoa'=>'PJ']);
                }
              
                if(!empty($user)){
                        return $user[0];
                }
               
                return false; 
        }







}
