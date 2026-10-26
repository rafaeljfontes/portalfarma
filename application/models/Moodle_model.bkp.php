<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Moodle_model extends CI_Model {

    private $url   = 'https://portalfarma.crfmg.org.br/moodle/webservice/rest/server.php';
    private $token = '';

    private function request($function, $params) {

        $params['wstoken']            = $this->token;
        $params['wsfunction']         = $function;
        $params['moodlewsrestformat'] = 'json';

        $ch = curl_init($this->url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($params));

        $response = curl_exec($ch);
        curl_close($ch);

        return json_decode($response, true);
    }

    public function criar_usuario($username, $senha, $nome, $email, $cidade, $crfmg, $telefone) {

        return $this->request('core_user_create_users', [
            'users' => [[
                'username'  	=> $username,
                'password'  	=> $senha,
                'firstname' 	=> $nome,
                'lastname'  	=> '',
                'email'     	=> $email,
                'city'      	=> $cidade,
                'phone1'      	=> $telefone,
                'idnumber'      => $crfmg,
                'country'   	=> 'BR',
                'preferences' => [[
                    'type' => 'auth_forcepasswordchange',
                    'value' => 1
                ]]
            ]]
        ]);
    }

    public function inscrever_curso($userid, $courseid) {

        return $this->request('enrol_manual_enrol_users', [
            'enrolments' => [[
                'roleid'   => 5,
                'userid'   => $userid,
                'courseid' => $courseid
            ]]
        ]);
    }
}
