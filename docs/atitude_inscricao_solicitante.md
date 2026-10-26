# Inscrição por solicitante

O passo 1 permite Farmacêutico ou Empresa. A consulta é obrigatória pelo registro
no CRF/MG. As rotas `atitude_farmaceutica/consultar_pf` e `consultar_pj` chamam
`Capacitacao::ConsultaPF()` e `ConsultaPJ()`, enviando `crfmg` e o contexto
`atitude_farmaceutica`. As chamadas antigas sem contexto mantêm sua resposta.

Somente `type: success` com Nome/NomePF/RazaoSocial permite continuar. O nome
é preenchido pela API e fica somente para leitura. A cidade usa o select de
`estados_cidades.php`: para Farmacêutico fica habilitado para escolha obrigatória;
para Empresa é preenchido pela API e desabilitado, com campo oculto para envio e revisão. Os demais dados
permanecem manuais. Respostas negativas exibem o aviso de cadastro não encontrado
e bloqueiam o avanço. Indisponibilidade da API também bloqueia a inscrição.

O resultado positivo fica na sessão, vinculado ao tipo e ao registro. Uma consulta
negativa apaga a confirmação anterior. O backend de gravação exige a confirmação
correspondente e salva nome obtido na consulta. A cidade da empresa também vem da
consulta; a cidade selecionada pelo farmacêutico é validada na lista no backend.
O CPF removido da tela não é mais obrigatório;
em bases antigas o campo é mantido com string vazia para compatibilidade.

O passo 3 mantém até cinco imagens, ajustes e a confirmação dos recortes. A imagem
principal é escolhida nessa etapa, com miniaturas que acompanham os ajustes.
Ao remover uma imagem, o índice da principal é corrigido. O passo 4 tem Preview
do card com a principal recortada, título, resumo e data. Conteúdo é inserido por
textContent e a URL temporária da imagem é liberada após fechar o modal.

## Atualização de produção

Aplicar `database/atitude_solicitante.sql` apenas se as colunas `nome` e
`tipo_solicitante` ainda não existirem (se uma já existir, adicionar só a ausente).
Publicar em conjunto:

- `application/controllers/Capacitacao.php`
- `application/controllers/atitude-farmaceutica/AtitudeFarmaceutica.php`
- `application/libraries/Atitude_solicitante.php`
- `application/config/routes.php`
- `application/views/atitude-farmaceutica/inscricao_view.php`
- `assets/js/atitude-solicitante.js`
- `application/certificates/cacert.pem`

As consultas usam GET na API `v2api.crfmg.org.br`. Falhas de transporte, HTTP ou
JSON são registradas no log do CodeIgniter e devolvidas em `diagnostico` ao console,
sem dados pessoais da resposta bruta. O erro SSL 60 usa o pacote CA como alternativa
quando não há `curl.cainfo` configurado, mantendo a verificação de certificado e host.

Não substituir configurações de URL, sessão ou banco de produção pelas locais.
