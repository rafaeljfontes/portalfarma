# Votação da comissão — Atitude Farmacêutica

Página: `/portalfarma/atitude_farmaceutica/votacao_comissao`.
Envio POST: `/portalfarma/atitude_farmaceutica/votacao_comissao/salvar`.

Antes de liberar, executar `database/tbl_atitude_comissao_membro.sql` e depois
`database/tbl_atitude_comissao.sql` no banco da aplicação. Para a estrutura antiga,
usar `database/atitude_comissao_migrar_membro.sql`, verificando vínculos pendentes.
As avaliações são independentes dos votos populares. Cada avaliação tem o
`id_membro` do cadastro autorizado, o `id_projeto`, cinco notas e a nota final
calculada no servidor. A tabela `tbl_atitude_comissao_eleitor` não é utilizada.
O envio completo é gravado em transação: falhas não deixam avaliações parciais.

A página lista status 1 e exige cinco notas inteiras de 1 a 5 por projeto.
O servidor consulta novamente todos os aprovados ao salvar e rejeita projetos
extras/ausentes. Se a lista tiver mudado, o eleitor deve atualizar a página.
E-mails são normalizados com trim e minúsculas antes da gravação.
Os pesos ficam somente na biblioteca `Atitude_avaliacao`, sem exposição na view
ou na resposta do endpoint.

Cadastro prévio: `/portalfarma/restrito/atitude_farmaceutica/comissao`, com a
mesma permissão administrativa `atitudes`. Aplicar também
`database/tbl_atitude_comissao_membro.sql`. Cadastre nome, e-mail e situação ativa.
A página pública só carrega os projetos depois que um e-mail ativo é identificado.
O envio valida a sessão identificada e consulta novamente o cadastro ativo dentro
da transação. Desativar um membro bloqueia novos envios, preservando votos antigos.
Essa página é independente da fase da votação popular. A identificação consulta
o cadastro pelo e-mail informado; não envia código de verificação de posse.

Validação: `php tests/atitude_comissao_test.php`.
