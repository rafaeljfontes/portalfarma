# E-mail do Portal Farma

Todos os serviços usam `application/libraries/MY_Email.php`. O padrão agora é a fila `tb_disparo_email` do banco `crftech`, com o mesmo contrato dos controllers do projeto `site-crfmg`. A configuração fica em `application/config/email.php`.

A conexão privada foi copiada do `.env` local do site para `application/config/email_fila.php`, que está ignorado pelo Git. Esse arquivo precisa existir também no servidor de produção. A cópia local aponta para `web_crftech`, banco ausente no servidor configurado; atualize a conexão com os valores de produção antes do teste real.

Para refazer a importação da conexão local do site, use `php tools/importar_email_site.php`. Para conferir a estrutura da fila sem exibir credenciais, use `php tools/importar_email_site.php --inspecionar`.

Na fila, sucesso significa registro pendente, não confirmação de entrega. `send()` retorna `false` se o registro falhar. Destinatários e cópias são deduplicados e registrados em uma transação, com uma mensagem por endereço; não há cabeçalho CC no contrato do site. Anexos não são enviados silenciosamente: esse modo retorna falha quando houver anexos.

O remetente final do modo fila é definido pelo serviço de produção que processa `tb_disparo_email`, que precisa estar configurado para `noreply@crfmg.org.br`. O contrato usado pelo site não inclui um campo de remetente. No modo direto, From e Return-Path são forçados para esse endereço.

Para usar SMTP direto, configure `PORTALFARMA_EMAIL_TRANSPORT=direto` e as variáveis abaixo.

Para SMTP, configure no ambiente do Apache/PHP:

- `PORTALFARMA_SMTP_HOST`: servidor autorizado a enviar pela conta (padrão: `smtp.gmail.com`).
- `PORTALFARMA_SMTP_PORT`: porta (padrão: 587).
- `PORTALFARMA_SMTP_CRYPTO`: `tls` ou `ssl` (padrão: `tls`).
- `PORTALFARMA_SMTP_USER`: usuário (padrão: `noreply@crfmg.org.br`).
- `PORTALFARMA_SMTP_PASS`: senha ou senha de aplicativo da conta.

No modo direto, o padrão é SMTP do Gmail na porta 587 com TLS/STARTTLS. Para usar 465 com SSL, configure a porta como `465` e a segurança como `ssl`. `PORTALFARMA_EMAIL_PROTOCOL` permite escolher explicitamente `smtp`, `mail` ou `sendmail`. Não há credenciais de exemplo nem Mailtrap no transporte compartilhado.

As variáveis precisam estar disponíveis ao PHP usado pelo Apache e ao PHP do terminal para o teste CLI. Reinicie o serviço após alterar o ambiente.

Testes sem envio real, incluindo templates e retorno de falhas:

```powershell
C:/wamp64/bin/php/php8.2.29/php.exe tests/email_portalfarma_test.php
C:/wamp64/bin/php/php8.2.29/php.exe tests/email_fila_test.php
```

Teste real, exclusivo pelo terminal, sem registrar inscrições, votos ou alterar contas:

```powershell
$env:PORTALFARMA_EMAIL_TEST_TO = 'rafaeljfontes@yahoo.com.br'
$env:PORTALFARMA_EMAIL_TEST_CC = 'rafael.fontes@crfmg.org.br'
C:/wamp64/bin/php/php8.2.29/php.exe index.php cli/ValidarEmail
```

No modo fila, `registrado_na_fila: true` retorna os IDs dos registros e `enviado: null`. Para consultar o andamento somente desses IDs:

```powershell
$env:PORTALFARMA_EMAIL_TEST_IDS = 'ID1,ID2'
C:/wamp64/bin/php/php8.2.29/php.exe index.php cli/ValidarEmail estado
```

Substitua os IDs pelos números retornados no teste. No modo direto, `enviado: true` significa que o transporte aceitou a mensagem; confirme o recebimento na caixa de entrada ou spam. As falhas são registradas sem expor corpo, código ou credenciais no navegador.

Os helpers de Mérito Acadêmico e Pesquisa Científica existem, mas seus disparos estão comentados no fluxo atual; os testes validam os helpers sem ativar novos disparos.
