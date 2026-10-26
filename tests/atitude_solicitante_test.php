<?php
if (PHP_SAPI !== 'cli') { http_response_code(404); exit; }
define('BASEPATH', __DIR__);
class CI_Controller {} class MY_Controller extends CI_Controller {}
require __DIR__ . '/../application/libraries/Atitude_solicitante.php';
require __DIR__ . '/../application/controllers/Capacitacao.php';
require __DIR__ . '/../application/controllers/atitude-farmaceutica/AtitudeFarmaceutica.php';
function conferir_solicitante($ok, $msg) { if (!$ok) throw new RuntimeException($msg); }
$regra = new Atitude_solicitante();
$pf = array('type' => 'success', 'dados' => array(array('Nome' => 'Farmacêutica de teste', 'Cidade' => 'Belo Horizonte')));
$pj = array('type' => 'success', 'RazaoSocial' => 'Empresa de teste', 'Cidade' => 'Contagem');
conferir_solicitante($regra->extrair(array('show_toast'=>true,'type'=>'success','dados'=>array(array('InscricaoPJId'=>36577,'RazaoSocial'=>'Empresa de teste','Cidade'=>'Pouso Alegre'))), 'empresa')['cidade']==='Pouso Alegre', 'ConsultaPJ lê dados aninhados da API');
conferir_solicitante($regra->extrair(array('type'=>'success', 'dados'=>array(array('NomePF'=>'Teste PF'))), 'farmaceutico') === array('tipo'=>'farmaceutico','nome'=>'Teste PF','cidade'=>''), 'ConsultaPF aceita NomePF e permite cidade manual quando ausente');
conferir_solicitante($regra->extrair($pf, 'farmaceutico')['nome'] === 'Farmacêutica de teste', 'PF preenche Nome');
conferir_solicitante($regra->extrair($pj, 'empresa')['nome'] === 'Empresa de teste', 'PJ preenche RazaoSocial');
foreach (array(null, false, array('type' => 'error'), array('type' => array('success')), array('type'=>'success'), array('type'=>'success','Nome'=>'Teste','Cidade'=>'')) as $retorno) conferir_solicitante($regra->extrair($retorno, 'farmaceutico') === null, 'Resposta negativa/incompleta bloqueada');
class EntradaSolicitante {
    public $dados = array('contexto'=>'atitude_farmaceutica','crfmg'=>'123','tipo_solicitante'=>'farmaceutico','numero_crf'=>'123','nome'=>'Nome adulterado','cidade_farmaceutico'=>'Contagem');
    public function post($key) { return $this->dados[$key] ?? null; }
    public function method() { return 'post'; }
}
class SessaoSolicitante {
    public $dados = array();
    public function userdata($key) { return $this->dados[$key] ?? null; }
    public function set_userdata($key, $value) { $this->dados[$key] = $value; }
    public function unset_userdata($key) { unset($this->dados[$key]); }
}
class SaidaSolicitante {
    public $codigo, $dados;
    public function set_status_header($c) { $this->codigo=$c;return $this; }
    public function set_content_type($t,$c) { return $this; }
    public function set_output($json) { $this->dados=json_decode($json,true);return $this; }
}
class ConsultaSolicitanteTeste extends Capacitacao { public $input,$session,$security,$load,$output,$atitude_solicitante; }
function consulta_solicitante($regra) {
    $c=(new ReflectionClass('ConsultaSolicitanteTeste'))->newInstanceWithoutConstructor();
    $c->input=new EntradaSolicitante();$c->session=new SessaoSolicitante();$c->output=new SaidaSolicitante();$c->atitude_solicitante=$regra;
    $c->load=new class{public function library($n){}};
    $c->security=new class{public function get_csrf_token_name(){return 'csrf';}public function get_csrf_hash(){return 'novo';}};
    return $c;
}
$metodo=new ReflectionMethod('Capacitacao','responderConsultaAtitude');$metodo->setAccessible(true);
$c=consulta_solicitante($regra);$metodo->invoke($c,$pf,'farmaceutico');
$verificado=$c->session->userdata('atitude_solicitante_verificado');
conferir_solicitante($c->output->codigo===200 && $regra->confirmado($verificado,'farmaceutico','123'), 'Consulta positiva autoriza identidade');
conferir_solicitante(!$regra->confirmado($verificado,'empresa','123') && !$regra->confirmado($verificado,'farmaceutico','124'), 'Troca de tipo ou registro invalida vínculo');
$metodo->invoke($c,array('type'=>'error'),'farmaceutico');
conferir_solicitante($c->output->codigo===404 && $c->output->dados['message']===Atitude_solicitante::NAO_ENCONTRADO && $c->session->userdata('atitude_solicitante_verificado')===null, 'Resposta negativa remove autorização');
$metodo->invoke($c,$pj,'empresa');
$metodo->invoke($c,array('type'=>'danger','dados'=>array(array('RazaoSocial'=>'Empresa de teste','Cidade'=>'Contagem'))),'empresa');
conferir_solicitante($c->output->codigo===404 && !$c->output->dados['status'] && $c->session->userdata('atitude_solicitante_verificado')===null, 'Danger bloqueia inscrição mesmo quando há dados');
$metodo->invoke($c,null,'farmaceutico');conferir_solicitante($c->output->codigo===503 && !$c->output->dados['status'],'API indisponível não libera inscrição');
$diagnostico = new ReflectionProperty('Capacitacao', 'diagnosticoConsultaRegistro');
$diagnostico->setAccessible(true);
$diagnostico->setValue($c, array('curl_codigo'=>60,'http_status'=>0,'json_erro'=>'Sem resposta da API'));
$metodo->invoke($c,null,'farmaceutico');
conferir_solicitante($c->output->dados['diagnostico']['curl_codigo']===60 && $c->output->codigo===503, 'Falha de transporte retorna diagnóstico em JSON');
$erroConsulta = new ReflectionMethod('Capacitacao', 'erroConsultaRegistro');$erroConsulta->setAccessible(true);
conferir_solicitante($erroConsulta->invoke($c)['type']==='danger', 'Consulta sem contexto também retorna erro estruturado em vez de null');
$c->input->dados['contexto']='outro';conferir_solicitante($metodo->invoke($c,$pf,'farmaceutico')===false,'Outros formulários preservam contrato');
class SalvarSolicitanteTeste extends AtitudeFarmaceutica { public $input,$session,$output,$load,$security,$atitude_evento,$atitude_solicitante,$form_validation; }
function salvar_solicitante($regra,$verificado) {
    $c=new SalvarSolicitanteTeste();$c->input=new EntradaSolicitante();$c->output=new SaidaSolicitante();$c->session=new SessaoSolicitante();
    $c->session->set_userdata('atitude_solicitante_verificado',$verificado);$c->atitude_solicitante=$regra;
    $c->atitude_evento=new class{public function obter_fase(){return 'inscricao';}};
    $c->security=new class{public function get_csrf_token_name(){return 'csrf';}public function get_csrf_hash(){return 'novo';}};
    $c->load=new class{public function library($n){}};
    $c->form_validation=new class{public $dados,$regras=array();public function set_data($d){$this->dados=$d;}public function set_rules($c,$r,$v){$this->regras[$c]=$v;}public function run(){return false;}public function error_array(){return array('Encerrar teste antes de processar arquivos.');}};
    return $c;
}
$c=salvar_solicitante($regra,null);$c->salvar();conferir_solicitante($c->output->codigo===403 && $c->form_validation->dados===null,'POST sem consulta confirmado não chega à gravação');
$c=salvar_solicitante($regra,$verificado);$c->input->dados['tipo_solicitante']='empresa';$c->salvar();conferir_solicitante($c->output->codigo===403,'Não usa PF para inscrição PJ');
$c=salvar_solicitante($regra,$verificado);$c->salvar();
conferir_solicitante($c->output->codigo===422 && $c->form_validation->dados['nome']==='Farmacêutica de teste' && $c->form_validation->dados['cidade_farmaceutico']==='Contagem','Farmacêutico usa nome da consulta e cidade selecionada');
$empresaVerificada = array('tipo'=>'empresa','registro'=>'123','nome'=>'Empresa de teste','cidade'=>'Pouso Alegre');
$c=salvar_solicitante($regra,$empresaVerificada);$c->input->dados['tipo_solicitante']='empresa';$c->salvar();
conferir_solicitante($c->form_validation->dados['cidade_farmaceutico']==='Pouso Alegre', 'Empresa salva a cidade da API mesmo que o POST seja alterado');
conferir_solicitante(strpos($c->form_validation->regras['cpf'],'required')===false,'CPF removido não impede inscrição');
echo "OK: PF/PJ, preenchimento, respostas negativas, vínculo de sessão e bloqueio de inscrição no backend.\n";
