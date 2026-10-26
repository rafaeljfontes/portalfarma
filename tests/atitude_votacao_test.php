<?php
if (PHP_SAPI !== 'cli') { http_response_code(404); exit; }
define('BASEPATH', __DIR__);
class CI_Controller {} class CI_Model {}
require __DIR__ . '/../application/libraries/Atitude_voto_popular.php';
require __DIR__ . '/../application/controllers/atitude-farmaceutica/AtitudeFarmaceutica.php';
require __DIR__ . '/../application/models/Atitude_farmaceutica_model.php';
function verificar($ok, $mensagem) { if (!$ok) throw new RuntimeException($mensagem); }
function log_message($nivel, $mensagem) {}
function html_escape($valor) { return htmlspecialchars((string) $valor, ENT_QUOTES, 'UTF-8'); }
function base_url($path = '') { return 'http://localhost/portalfarma/' . $path; }
function site_url($path) { return base_url($path); }
function notas_teste($ids = array(1, 2, 3)) { $notas = array(); foreach ($ids as $id) $notas[$id] = array_fill_keys(array('relevancia', 'impacto', 'pessoas', 'duracao', 'beneficios'), '4'); return $notas; }
$regra = new Atitude_voto_popular();
verificar($regra->normalizar_ip('2001:0DB8:0000:0000:0000:0000:0000:0001') === '2001:db8::1', 'IPv6 canônico');
verificar($regra->normalizar_ip('::ffff:203.0.113.10') === '203.0.113.10', 'IPv4 mapeado não contorna bloqueio');
foreach (array(null, '', 'invalido', '203.0.113.1, 203.0.113.2', '0.0.0.0', '::') as $ip) verificar($regra->normalizar_ip($ip) === null, 'IP inválido rejeitado');
foreach (array(1, 2, 3, 5) as $limite) verificar(count($regra->preparar(range(1, $limite), notas_teste(range(1, $limite)), $limite)) === $limite, 'Limite dinâmico');
foreach (array(0, 6, '01', '1.0', true, array(2), null) as $nota) { $notas = notas_teste(); $notas[1]['impacto'] = $nota; verificar($regra->preparar(array(1, 2, 3), $notas, 3) === null, 'Nota inválida'); }
verificar($regra->preparar(array(1, 1, 2), notas_teste(), 3) === null, 'Repetidos rejeitados');
verificar($regra->preparar(array(1, 2), notas_teste(), 3) === null, 'Quantidade exata');
verificar($regra->preparar(array(1, 2, '3 OR 1=1'), notas_teste(), 3) === null, 'ID malformado');
$incompletas = notas_teste(); unset($incompletas[2]['impacto']); verificar($regra->preparar(array(1, 2, 3), $incompletas, 3) === null, 'Critério ausente');
$extras = notas_teste(); $extras[1]['peso'] = '5'; verificar($regra->preparar(array(1, 2, 3), $extras, 3) === null, 'Critério extra');
verificar($regra->preparar(array(3, 2, 1), notas_teste(), 3) === $regra->preparar(array(1, 2, 3), notas_teste(), 3), 'Ordenação canônica');
class EntradaVoto {
    public $metodo = 'post', $dados, $ip = '203.0.113.10';
    public function __construct() { $this->dados = array('token' => '', 'email' => ' Pessoa@Example.com ', 'projetos' => array('1','2','3'), 'notas' => notas_teste(), 'codigo' => '123456'); }
    public function method() { return $this->metodo; } public function post($campo) { return $this->dados[$campo] ?? null; }
    public function ip_address() { return $this->ip; }
}
class SaidaVoto {
    public $codigo, $dados;
    public function set_status_header($c) { $this->codigo = $c; return $this; }
    public function set_content_type($t, $c) { return $this; }
    public function set_output($j) { $this->dados = json_decode($j, true); return $this; }
}
class ModeloVotoFake {
    public $erro = null, $votos = array(), $fase = 'votacao', $disponivel = true, $jaVotou = false;
    public function obter_fase() { return $this->fase; }
    public function projeto_disponivel_votacao($id) { return $this->disponivel; }
    public function email_ja_votou($email) { return $this->jaVotou; }
    public function registrar_votos($email, $codigo, $ids, $notas, $ip) { $this->votos = array($email, $codigo, $ids, $notas, $ip); return $this->erro; }
}
class ControllerVotoTeste extends AtitudeFarmaceutica {
    public $input, $output, $session, $security, $load, $atitudes, $email, $atitude_evento, $atitude_voto_popular;
    public function __construct() {
        $this->input = new EntradaVoto(); $this->output = new SaidaVoto(); $this->atitudes = new ModeloVotoFake();
        $this->atitude_evento = new class { public $limite = 3; public function obter_limite_votacao() { return $this->limite; } };
        $this->atitude_voto_popular = new Atitude_voto_popular();
        $this->session = new class {
            public $dados = array('atitude_voto_token' => 'token');
            public function userdata($k) { return $this->dados[$k] ?? null; }
            public function set_userdata($k, $v) { $this->dados[$k] = $v; }
            public function unset_userdata($k) { unset($this->dados[$k]); }
        };
        $this->email = new class {
            public $sucesso = true, $destino, $texto, $enviados = 0, $aviso = false, $html = false;
            public function clear($a) {} public function from($e, $n) {} public function subject($t) {} public function set_mailtype($t) {}
            public function to($e) { $this->destino = $e; } public function message($t) { $this->texto = $t; }
            public function send() { $this->enviados++; if ($this->html) echo '<div>SMTP</div>'; if ($this->aviso) trigger_error('Falha SMTP', E_USER_WARNING); return $this->sucesso; }
        };
        $this->security = new class { public function get_csrf_token_name() { return 'csrf'; } public function get_csrf_hash() { return 'hash'; } };
        $this->load = new class {
            public function database() {} public function model($n, $a) {} public function library($n) {}
            public function view($nome, $dados = array()) { if ($nome !== 'atitude-farmaceutica/projetos_aceitos') return; extract($dados); require __DIR__.'/../application/views/atitude-farmaceutica/projetos_aceitos.php'; }
        };
    }
    public function render_votacao($votacaoAberta, $limiteProjetosVotacao = 3) {
        $tokenVoto=''; $criteriosVotacao=$this->atitude_voto_popular->criterios(); $projetosAceitos=array();
        foreach (array(1,2,3) as $id) {
            $p=(object)array_fill_keys(array('nome_projeto','resumo_projeto','cidade_projeto','local_projeto','pessoas_alcancadas','beneficios_alcancados','objetivos_alcancados'),'<script>alert(1)</script>');
            $p->id=$id; $p->imagem_principal='imagem.png'; $p->imagens='["imagem.png"]'; $p->data_inicio='2026-10-09'; $projetosAceitos[]=$p;
        }
        ob_start(); require __DIR__.'/../application/views/atitude-farmaceutica/votacao.php'; return ob_get_clean();
    }
}
$c=new ControllerVotoTeste(); $c->votar(); verificar($c->output->codigo===200 && $c->output->dados['total']===3,'Salva três projetos');
verificar($c->atitudes->votos[0]==='pessoa@example.com' && $c->atitudes->votos[2]===array(1,2,3) && $c->atitudes->votos[3][2]['impacto']==='4','E-mail, IDs e notas encaminhados');
verificar($c->email->enviados === 0 && $c->atitudes->votos[4] === '203.0.113.10', 'Sem e-mail; IP obtido no servidor');
verificar(preg_match('/\A[A-F0-9]{16}\z/', $c->output->dados['codigo']) === 1, 'Protocolo gerado no servidor');
foreach (array(array(array('token'=>''),403),array(array('email'=>'inválido'),422),array(array('projetos'=>array('1')),422),array(array('projetos'=>array('1','1','2')),422),array(array('projetos'=>array('1','2','3','4')),422),array(array('notas'=>$incompletas),422)) as $caso) {
    $c=new ControllerVotoTeste(); $c->input->dados=array_merge($c->input->dados,$caso[0]); $c->votar(); verificar($c->output->codigo===$caso[1] && !$c->atitudes->votos,'Rejeita entrada inválida');
}
$c=new ControllerVotoTeste();unset($c->input->dados['codigo']);$c->input->dados['ip']='198.51.100.25';$c->votar();verificar($c->output->codigo===200 && $c->atitudes->votos[4]==='203.0.113.10','Voto direto e IP informado pelo usuário ignorado');
$c=new ControllerVotoTeste();$c->input->ip='::ffff:203.0.113.10';$c->votar();verificar($c->output->codigo===200 && $c->atitudes->votos[4]==='203.0.113.10','IP normalizado no controller');
$c=new ControllerVotoTeste();$c->input->ip='0.0.0.0';$c->votar();verificar($c->output->codigo===422 && !$c->atitudes->votos,'IP não identificado impede voto');
$c=new ControllerVotoTeste();$c->atitude_evento->limite=2;$c->votar();verificar($c->output->codigo===422,'Mudança de limite bloqueia envio antigo');
foreach (array('fase'=>409,'projeto'=>422,'duplicado'=>409,'ip_duplicado'=>409,'ip'=>422,'notas'=>422,'banco'=>503) as $erro=>$http) { $c=new ControllerVotoTeste();$c->atitudes->erro=$erro;$c->votar();verificar($c->output->codigo===$http,'Falha do model: '.$erro); }
$c=new ControllerVotoTeste();$c->solicitar_codigo();verificar($c->output->codigo===410 && !$c->email->enviados, 'Rota antiga não envia e-mail');
class BancoVotoFake {
    public $db_debug=true,$fase='votacao',$limite=3,$total=3,$duplicado=false,$ipDuplicado=false,$falha=false,$inseridos=array(),$rollback=false,$commit=false,$liberado=false,$travas=array(),$soltas=array(),$falharSegundaTrava=false;
    public function trans_begin(){return true;}
    public function query($sql,$params=array()){
        if(strpos($sql,'RELEASE_LOCK')!==false){$this->liberado=true;$this->soltas[]=$params[0];return true;}
        if(strpos($sql,'GET_LOCK')!==false){$this->travas[]=$params[0];if($this->falharSegundaTrava && count($this->travas)===2)return false;return new class{public function row(){return (object)array('adquirido'=>1);}};}
        $total=strpos($sql,'WHERE email')!==false?($this->duplicado?1:0):(strpos($sql,'WHERE ip_votante')!==false?($this->ipDuplicado?1:0):$this->total);
        return new class($total){private $total;public function __construct($t){$this->total=$t;}public function num_rows(){return $this->total;}};
    }
    public function insert_batch($t,$linhas){if($this->falha)return false;$this->inseridos=$linhas;return count($linhas);}
    public function error(){return array('code'=>999);}
    public function trans_status(){return true;}
    public function trans_rollback(){$this->rollback=true;}
    public function trans_commit(){$this->commit=true;return true;}
}
class ModeloVotoTeste extends Atitude_farmaceutica_model {
    public $db,$load,$atitude_voto_popular;
    public function __construct(){$this->db=new BancoVotoFake();$this->load=new class{public function library($n){}};$this->atitude_voto_popular=new Atitude_voto_popular();}
    public function obter_fase(){return $this->db->fase;} public function obter_limite_votacao(){return $this->db->limite;}
}
$m=new ModeloVotoTeste();verificar($m->registrar_votos('pessoa@example.com','CODIGO',array(1,2,3),notas_teste(),'203.0.113.10')===null && $m->db->commit && $m->db->liberado,'Transação completa');
verificar($m->db->inseridos[1]['id_proejto']===2 && $m->db->inseridos[1]['impacto']===4 && $m->db->inseridos[1]['ip_votante']==='203.0.113.10' && $m->db->db_debug,'Notas, IP e configuração');
verificar(count($m->db->travas)===2 && count($m->db->soltas)===2,'Travas distintas por e-mail e IP');
$m=new ModeloVotoTeste();$m->db->ipDuplicado=true;
verificar($m->registrar_votos('outro@example.com','CODIGO',array(1,2,3),notas_teste(),'203.0.113.10')==='ip_duplicado','Outro e-mail não contorna bloqueio por IP');
verificar($m->db->rollback && !$m->db->commit && !$m->db->inseridos && count($m->db->soltas)===2,'IP repetido não deixa votos parciais');
$m=new ModeloVotoTeste();$m->db->falharSegundaTrava=true;
verificar($m->registrar_votos('pessoa@example.com','CODIGO',array(1,2,3),notas_teste(),'203.0.113.10')==='banco','Falha de trava impede gravação');
verificar(count($m->db->soltas)===1 && !$m->db->commit && !$m->db->inseridos,'Libera a primeira trava se a segunda falhar');
$m=new ModeloVotoTeste();
verificar($m->registrar_votos('pessoa@example.com','CODIGO',array(1,2,3),notas_teste(),'invalido')==='ip' && !$m->db->travas,'Model também rejeita IP inválido');
$m=new ModeloVotoTeste();
verificar($m->registrar_votos('pessoa@example.com','CODIGO',array(1,2,3),notas_teste(),'::ffff:203.0.113.10')===null && $m->db->inseridos[0]['ip_votante']==='203.0.113.10','Model salva IP canônico');
foreach(array('fase','projeto','duplicado','banco')as $erro){$m=new ModeloVotoTeste();if($erro==='fase')$m->db->fase='inscricao';if($erro==='projeto')$m->db->total=2;if($erro==='duplicado')$m->db->duplicado=true;if($erro==='banco')$m->db->falha=true;verificar($m->registrar_votos('pessoa@example.com','CODIGO',array(1,2,3),notas_teste(),'203.0.113.10')===$erro,'Model: '.$erro);verificar($m->db->rollback && !$m->db->commit && $m->db->liberado,'Rollback e liberação de trava');}
$r=new ControllerVotoTeste();$aberta=$r->render_votacao(true);$fechada=$r->render_votacao(false);$insuficiente=$r->render_votacao(true,4);
verificar(substr_count($aberta,'class="atitude-voto-checkbox"')===3 && strpos($aberta,'name="notas[1][impacto]"')!==false,'Seleção e notas renderizadas');
verificar(strpos($aberta,'<script>alert(1)</script>')===false,'XSS escapado');
verificar(strpos($fechada,'id="atitude-votar-botao"')===false && strpos($insuficiente,'id="atitude-votar-botao"')===false,'Fase fechada e quantidade insuficiente');
echo "OK: limite dinâmico, critérios, e-mail, envio sem código, bloqueio por e-mail/IP, transação e renderização.\n";
