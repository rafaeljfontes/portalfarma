# Designações de cursos

Instalação no banco configurado pelo PortalFarma:

```powershell
php tools/aplicar_designacoes.php
```

Alternativamente, execute `database/tbl_portalfarma_func_designado.sql` no mesmo banco das tabelas `tbl_portalfarma` e `tbl_portalfarma_user`. Os tipos e a collation das colunas referenciadas são obtidos do schema. As tabelas referenciadas devem utilizar InnoDB e permitir as chaves estrangeiras; em versões que exijam uma chave única para CourseID, confirme a unicidade e o índice dessa coluna antes de instalar. A migração não remove registros existentes.

A listagem `restrito/capacifar/listar` mostra todos os responsáveis e permite substituir a seleção por usuários ativos. A opção “Designados a mim” usa o ID da sessão `usuario_logado.id`, com consulta pelo login da sessão para sessões antigas. O nome exibido é `nome`, quando essa coluna existe; caso contrário, o login `user`.

O ranking do Dashboard usa exclusivamente o vínculo de designação, antes de ordenar e limitar aos dez primeiros. “Ver todos” preserva o escopo. A vinculação anterior de palestrantes com cursos não identifica usuários administrativos: por isso não se associa um palestrante a um usuário por coincidência de ID ou nome.

Sem a tabela instalada, ou sem ID/vínculo do usuário, o ranking não exibe cursos. A listagem geral continua disponível e apresenta um aviso; a atribuição permanece desabilitada até a instalação.
