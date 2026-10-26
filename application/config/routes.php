<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|   example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|   https://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|   $route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|   $route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|   $route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples: my-controller/index -> my_controller/index
|       my-controller/my-method -> my_controller/my_method
*/
$route['default_controller'] 					= 'inicio';

/* ACESSO RESTRITO */
$route['restrito/bjhp'] = 'restrito/Bjhp/importar';
$route['restrito/bjhp/importar'] = 'restrito/Bjhp/importar';
$route['restrito/bjhp/importar_api'] = 'restrito/Bjhp/importar_api';
$route['restrito/bjhp/editorial'] = 'restrito/Bjhp/editorial';
$route['restrito/bjhp/corpo_editorial'] = 'restrito/Bjhp/corpo_editorial';
$route['restrito/bjhp/salvar_editorial'] = 'restrito/Bjhp/salvar_editorial';
$route['login'] 								= "Login";
$route['entrar'] 								= "Portalfarma/Entrar";
$route['restrito/login/entrar'] 				= "restrito/Login/entrar";
$route['restrito/login/sair'] 					= "restrito/Login/sair";

$route['doc_tecnico']                           = "Doc_tecnico/index";
$route['doc_tecnico/abrir/(:num)']              = "Doc_tecnico/abrir/$1";
$route['restrito/doc_tecnico/listar']            = "restrito/Doc_tecnico/listar";
$route['restrito/doc_tecnico/criar']             = "restrito/Doc_tecnico/criar";
$route['restrito/doc_tecnico/editar/(:num)']     = "restrito/Doc_tecnico/editar/$1";
$route['restrito/doc_tecnico/salvar']            = "restrito/Doc_tecnico/salvar";
$route['restrito/doc_tecnico/excluir/(:num)']    = "restrito/Doc_tecnico/excluir/$1";

$route['restrito/nps/listar'] = "restrito/nps";
$route['nps/listar'] = "NPS/listar";
$route['nps/busca_nps'] = "NPS/busca_nps";
$route['nps/exportar_pdf'] = "NPS/exportar_pdf";

$route['restrito/calendario'] 					= "restrito/calendario";
$route['restrito/calendario/detalhes'] 			= "restrito/calendario/get_detalhes_evento";


$route['restrito/capacifar/listar'] 			= "restrito/capacifar/listar";
$route['restrito/capacifar/listar/(:num)'] 		= "restrito/capacifar/listar/$1";
$route['restrito/capacifar/inscricoescursos'] 	= "restrito/capacifar/inscricoescursos";
$route['restrito/Capacifar/lista_inscritos'] 	= "restrito/capacifar/lista_inscritos";
$route['restrito/Capacifar/lista_portaria/(:num)'] = "restrito/capacifar/lista_portaria/$1";

$route['restrito/universitario'] 				= "restrito/universitario";
$route['restrito/universitario/voltar_acao'] 	= "restrito/universitario/voltar_acao";

$route['restrito/urm/listar'] 					= "restrito/urm/listar";
$route['restrito/urm/listar/(:num)'] 			= "restrito/urm/listar/$1";
$route['restrito/urm/local'] 					= "restrito/urm/local";
$route['restrito/urm/local/cadastrar'] 			= "restrito/urm/local_cadastrar";
$route['restrito/urm/local/editar/(:any)'] 		= "restrito/urm/local_editar/$1";
$route['restrito/urm/local/salvar'] 			= "restrito/urm/local_salvar";
$route['restrito/urm/alterar_liberacao_presenca'] = "restrito/urm/alterar_liberacao_presenca";

$route['restrito/fiscalizacao/listar'] 			= "restrito/fiscalizacao/listar";
$route['restrito/fiscalizacao/listar/(:num)'] 	= "restrito/fiscalizacao/listar/$1";

$route['restrito/seminario/listar'] 			= "restrito/seminario/listar";
$route['restrito/seminario/listar/(:num)'] 		= "restrito/seminario/listar/$1";
$route['restrito/seminario/estatisticas/(:any)'] = 'restrito/seminario/dashboard/$1';
$route['restrito/seminario/alterar_liberacao_presenca'] = 'restrito/seminario/alterar_liberacao_presenca';

$route['restrito/merito/listar'] 					= "restrito/merito/listar";
$route['restrito/merito/listar/(:num)'] 			= "restrito/merito/listar/$1";
$route['restrito/merito/alterar_status'] 			= "restrito/merito/alterar_status";
$route['restrito/merito/voltar_acao'] 				= "restrito/merito/voltar_acao";
$route['restrito/seminario/exportar-excel/(:any)'] 	= 'restrito/seminario/exportar_excel/$1';
$route['restrito/presenca/listar/(:any)'] 			= 'restrito/inscritos/listar_presenca/$1';
$route['restrito/inscritos/atualizar_presenca'] 	= 'restrito/inscritos/atualizar_presenca';

$route['restrito/pesquisa/alterar_status'] 		= "restrito/pesquisa/alterar_status";
$route['restrito/pesquisa/voltar_acao'] 			= "restrito/pesquisa/voltar_acao";

$route['restrito/palestrantes'] 							= "restrito/palestrantes";
$route['restrito/palestrantes/formulario'] 					= "restrito/palestrantes/formulario";
$route['restrito/palestrantes/formulario/(:num)'] 			= "restrito/palestrantes/formulario/$1";
$route['restrito/palestrantes/curso'] 						= "restrito/palestrantes/palestrante_curso";
$route['restrito/palestrantes/vincular'] 					= "restrito/palestrantes/vincular_palestrante_curso";
$route['restrito/palestrantes/excluir_vinculo_palestrante']	= "restrito/palestrantes/excluir_vinculo_palestrante";
$route['restrito/palestrantes/certificado_palestrantes'] 	= "restrito/palestrantes/certificado_palestrantes";
$route['restrito/palestrantes/exportar_excel'] 				= "restrito/palestrantes/exportar_excel";
$route['restrito/palestrantes/exportar_pdf'] 					= "restrito/palestrantes/exportar_pdf";


$route['restrito/cursos/cadastrar'] 				= "restrito/cursos/cadastrar";
$route['restrito/cursos/cadastrar/urm'] = "restrito/cursos/cadastrar/urm";
$route['restrito/cursos/buscar_titulos'] 		= "restrito/cursos/buscar_titulos";
$route['restrito/cursos/proximo_courseid'] 		= "restrito/cursos/proximo_courseid";
$route['restrito/cursos/salvar'] 					= "restrito/cursos/salvar";
$route['restrito/cursos/categorias'] 				= "restrito/cursos/categorias";
$route['restrito/cursos/categorias_curso'] 			= "restrito/cursos/categorias_curso";
$route['restrito/cursos/categorias_vincular'] 		= "restrito/cursos/categorias_vincular";
$route['restrito/cursos/categorias_curso_listar'] 	= "restrito/cursos/categorias_curso_listar";
$route['restrito/cursos/categoria_curso_excluir'] 	= "restrito/cursos/categoria_curso_excluir";
$route['restrito/cursos/categorias_exportar_excel'] 	= "restrito/cursos/categorias_exportar_excel";
$route['restrito/cursos/categorias_exportar_pdf'] 		= "restrito/cursos/categorias_exportar_pdf";
$route['restrito/cursos/para'] 						= "restrito/cursos/para";
$route['restrito/cursos/para_curso'] 					= "restrito/cursos/para_curso";
$route['restrito/cursos/para_vincular'] 				= "restrito/cursos/para_vincular";
$route['restrito/cursos/para_curso_listar'] 			= "restrito/cursos/para_curso_listar";
$route['restrito/cursos/lista_inscritos/(:num)'] 	= "restrito/cursos/lista_inscritos/$1";
$route['restrito/cursos/lista_presenca/(:num)'] 	= "restrito/cursos/lista_inscritos/$1";
$route['restrito/cursos/atualizar_presenca'] 		= "restrito/cursos/atualizar_presenca";



$route['restrito/programacao/cadastrar'] 			= "restrito/programacao/cadastrar";
$route['restrito/programacao/salvar'] 				= "restrito/programacao/salvar";

$route['restrito/plenaria/listar'] 				= "restrito/plenaria/listar";
//$route['restrito/plenaria/formulario'] 			= "restrito/plenaria/formulario";
$route['restrito/plenaria/formulario/(:num)'] 	= "restrito/plenaria/formulario/$1";
$route['restrito/plenaria/salvar'] 				= "restrito/plenaria/salvar";
$route['restrito/plenaria/excluir/(:num)'] 		= "restrito/plenaria/excluir/$1";

$route['restrito/usuarios'] 					= "restrito/gerenciar_usuarios/index";
$route['restrito/logs-inscricoes'] = 'restrito/logs_inscricoes/index';
$route['restrito/usuarios/novo'] 			= "restrito/gerenciar_usuarios/novo";
$route['restrito/usuarios/salvar'] 			= "restrito/gerenciar_usuarios/salvar";
$route['restrito/usuarios/permissoes'] 		= "restrito/gerenciar_usuarios/permissoes";

/* MENU PRINCIPAL */
$route['presencial']						= 'Portalfarma/Presencial';
$route['online']		    				= 'Portalfarma/Online';
$route['curso/listar/(:num)']				= 'Curso/Listar/$1';

$route['recuperar-senha'] 					= 'recuperar';
$route['recuperar_enviar'] 					= 'recuperar/enviar';
$route['resetarSenhaMoodle'] 				= 'recuperar/resetarSenhaMoodle';
$route['trocar_senha'] 						= 'recuperar/trocar_senha';
$route['salvar_nova_senha'] 				= 'recuperar/salvar_nova_senha';
$route['pesquisa/nps/(:any)']				= 'Seminario/nps/$1';

/* INCRIÇÃO DO CURSO CAPACIFAR */
$route['curso/inscricao/(:num)']			= 'Curso/Inscricao/$1';
$route['curso/inscricao_teste/(:num)']		= 'Curso/Inscricao_teste/$1';
$route['curso/inscricao_english/(:num)']	= 'Curso/Inscricao_english/$1';
$route['inscricao/verifica_inscrito']		= 'inscricao/verifica_inscrito';
$route['inscricao/stranger_save']		    = 'inscricao/stranger_save';
$route['inscricao/verifica_inscrito']		= 'inscricao/verifica_inscrito';

/* MERITO ACADEMICO */
$route['merito-academico']						= 'MeritoAcademico';
$route['mertitoacademico/salvar']				= 'MeritoAcademico/salvar';
$route['Capacitacao/InscricaoMeritoAcademico']	= 'Capacitacao/InscricaoMeritoAcademico';

/* PESQUISA CIENTIFICA */
$route['pesquisa-cientifica']				= 'PesquisaCientifica';
$route['pesquisa-cientifica/formulario']	= 'PesquisaCientifica/formulario';
$route['pesquisacientifica/enviar']			= 'PesquisaCientifica/enviar';
$route['universitario']						= 'Universitario';
$route['universitario/salvar']				= 'universitario/salvar';


/* USO RACIONAL DE MEDICAMENTOS */
$route['urm']								= 'URM';
$route['urm/buscarInscricoes']				= 'URM/buscarInscricoes';
$route['urm/setPresenca']					= 'URM/setPresenca';
$route['urm/gerarCertificado/(:any)']		= 'URM/gerarCertificado/$1';
$route['urm/confirmar-presenca']			= 'URM/ConfirmarPresenca';
$route['urm/inscricao/(:any)']				= 'URM/Inscricao/$1';
$route['urm/validar-certificado/(:any)/']	= 'URM/validarCertificado/$1';
$route['urm/processar_inscricao'] 			= 'URM/processar_inscricao';
$route['urm/verificar_cadastro_moodle'] 	= 'URM/verificar_cadastro_moodle';

/* ATITUDE FARMACÊUTICA */
$route['atitude_farmaceutica'] = 'atitude-farmaceutica/AtitudeFarmaceutica/index';
$route['restrito/atitude_farmaceutica'] = 'restrito/AtitudeFarmaceutica/index';
$route['restrito/atitude_farmaceutica/listar'] = 'restrito/AtitudeFarmaceutica/index';
$route['restrito/atitude_farmaceutica/alterar_status'] = 'restrito/AtitudeFarmaceutica/alterar_status';
$route['restrito/atitude_farmaceutica/alterar_fase'] = 'restrito/AtitudeFarmaceutica/alterar_fase';
$route['restrito/atitude_farmaceutica/limite_votacao'] = 'restrito/AtitudeFarmaceutica/salvar_limite_votacao';
$route['restrito/atitude_farmaceutica/resultados'] = 'restrito/AtitudeFarmaceutica/resultados';
$route['atitude_farmaceutica/inscricao'] = 'atitude-farmaceutica/AtitudeFarmaceutica/inscricao';
$route['atitude_farmaceutica/consultar_pf'] = 'Capacitacao/ConsultaPF';
$route['atitude_farmaceutica/consultar_pj'] = 'Capacitacao/ConsultaPJ';
$route['atitude_farmaceutica/votacao'] = 'atitude-farmaceutica/AtitudeFarmaceutica/votacao';
$route['atitude_farmaceutica/votacao_comissao'] = 'atitude-farmaceutica/AtitudeFarmaceutica/votacao_comissao';
$route['atitude_farmaceutica/votacao_comissao/identificar'] = 'atitude-farmaceutica/AtitudeFarmaceutica/identificar_comissao';
$route['restrito/atitude_farmaceutica/comissao'] = 'restrito/AtitudeFarmaceutica/comissao';
$route['restrito/atitude_farmaceutica/comissao/salvar'] = 'restrito/AtitudeFarmaceutica/salvar_membro_comissao';
$route['atitude_farmaceutica/votacao_comissao/salvar'] = 'atitude-farmaceutica/AtitudeFarmaceutica/salvar_comissao';
$route['atitude_farmaceutica/votar'] = 'atitude-farmaceutica/AtitudeFarmaceutica/votar';
$route['atitude_farmaceutica/solicitar_codigo'] = 'atitude-farmaceutica/AtitudeFarmaceutica/solicitar_codigo';

$route['atitude_farmaceutica/consultar_pf'] = 'Capacitacao/ConsultaPF';
$route['atitude_farmaceutica/consultar_pj'] = 'Capacitacao/ConsultaPJ';

/* FISCALIZAÇÃO HUMANIZADA */
$route['fiscalizacao-humanizada']							= 'FiscalizacaoHumanizada';
$route['fiscalizacao-humanizada/buscarInscricoes']			= 'FiscalizacaoHumanizada/buscarInscricoes';
$route['fiscalizacao-humanizada/gerarCertificado/(:any)']	= 'FiscalizacaoHumanizada/gerarCertificado/$1';
$route['fiscalizacao-humanizada/gerar-certificado']			= 'FiscalizacaoHumanizada/gerarCertificado';
$route['fiscalizacao-humanizada/confirmar-presenca']		= 'FiscalizacaoHumanizada/ConfirmarPresenca';
$route['fiscalizacao-humanizada/inscricao']					= 'FiscalizacaoHumanizada/Inscricao';
$route['fiscalizacao-humanizada/inscricao/(:any)'] 			= 'FiscalizacaoHumanizada/Inscricao/$1';
$route['fiscalizacao-humanizada/processar_inscricao'] 		= 'FiscalizacaoHumanizada/processar_inscricao';
$route['fiscalizacao-humanizada/validar-certificado/(:any)/']	= 'FiscalizacaoHumanizada/validarCertificado/$1';

/* SEMINÁRIO */
$route['seminario/inscrever']				= 'Seminario/inscrever';
$route['seminario/processar_inscricao']		= 'Seminario/processar_inscricao';
$route['seminario/buscarInscricoes']		= 'Seminario/buscarInscricoes';
$route['seminario/setPresenca']				= 'Seminario/setPresenca';
$route['seminario/gerarCertificado']		= 'Seminario/gerarCertificado';
$route['seminario/nps/(:any)']				= 'Seminario/nps/$1';
$route['seminario/nps_cadastrar']			= 'Seminario/nps_cadastrar';

/* PLENÁRIA */
$route['plenaria']							= 'Plenaria/index';

/* CERTIFICADOS */
$route['certificados/(:num)'] = 'Certificados/index/$1';
$route['certificados/(:num)/baixar'] = 'Certificados/baixar/$1';
$route['validar-certificado/(:any)'] 				= 'Certificado/validar/$1';
$route['validaCPF'] 								= 'Certificado/validaCPF';
$route['certificado_palestrantes'] 					= 'Certificado/certificado_palestrantes';
$route['certificado/buscar_palestrante_id'] 		= 'Certificado/buscar_palestrante_id';
$route['certificado/gerar_certificado_palestrantes'] = 'Certificado/gerar_certificado_palestrantes';

/* NPS - Pesquisa de Satisfação */
$route['nps/(:any)']						= 'pesquisa/nps/$1';
$route['nps_cadastrar']					= 'pesquisa/nps_cadastrar';
$route['pesquisa/nps/(:any)']					= 'pesquisa/nps/$1';
$route['pesquisa/nps_cadastrar']				= 'pesquisa/nps_cadastrar';


$route['404_override'] = 'error_404';
$route['translate_uri_dashes'] = FALSE;


$route['atitude_farmaceutica/salvar'] = 'atitude-farmaceutica/AtitudeFarmaceutica/salvar';
