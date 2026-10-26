<?php
defined('BASEPATH') OR exit('No direct script access allowed');

// URL completa até /api/v1. Credenciais apenas no ambiente do servidor.
$config['ojs_url'] = getenv('BJHP_OJS_URL') ?: 'https://bjhp.crfmg.org.br/crfmg/api/v1';
$config['ojs_ca_bundle'] = getenv('BJHP_OJS_CA_BUNDLE') ?: APPPATH . 'certificates/cacert.pem';
$config['ojs_token'] = getenv('BJHP_OJS_TOKEN') ?: 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.IjJkNjI0ZjkwMzk0YjcxY2Q0ZmRhOWYxN2M0ZTcyOWQ2NjI2MjZjZjQi.GDzPpwX4NXlf3zuxM5etWspHWnvRlseqDqvXV-x8uTA';
$config['ojs_locale'] = getenv('BJHP_OJS_LOCALE') ?: 'pt_BR';
// Banco: conexão default de database.php (web_site).
