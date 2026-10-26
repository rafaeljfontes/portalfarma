# Votação popular com avaliação

Página: `/portalfarma/atitude_farmaceutica/votacao`.
Na área restrita de Atitude Farmacêutica, o formulário **Projetos por voto popular**
define a quantidade exata (1 a 100, padrão 3). É persistida no mesmo arquivo local
`application/cache/atitude/evento.json`, chave `limite_projetos_votacao`, sem tabela
de configuração. A fase atual é preservada ao salvar o limite e vice-versa.

O eleitor seleciona exatamente a quantidade configurada e dá notas de 1 a 5 a
relevância, impacto, pessoas alcançadas, duração/continuidade e benefícios. Os
pesos da comissão não são expostos nem aplicados a esses registros populares.
Se existirem menos aprovados que o limite, a página informa indisponibilidade.

Sem cadastro prévio: informar e-mail válido e confirmar o envio na própria tela.
Não é solicitado código por e-mail e o voto não depende do serviço SMTP.
Mudanças no limite são verificadas também no envio; a página deve ser atualizada.
Cada e-mail e cada IP participam uma única vez, inclusive com outros projetos ou
outro e-mail. Travas MySQL por e-mail e por IP, em ordem fixa, impedem duplicidade
concorrente entre sessões distintas. Os três projetos de um envio são um só voto.

Os votos ficam em `web_site.tbl_atitude_votacao`: uma linha por projeto, e-mail e
recibo e IP compartilhados, cinco colunas com as notas. Mantido `id_proejto`, nome da
coluna existente. Todas as linhas são gravadas em uma única transação.
Aplicar `database/atitude_votacao_notas.sql` na estrutura antiga ou usar o CREATE
atualizado em `database/tbl_atitude_votacao.sql`. Notas NULL identificam apenas
votos anteriores à mudança; não atribuir notas artificiais aos registros antigos.
Aplicar também `database/atitude_votacao_ip.sql` para adicionar o campo e índice
`ip_votante`. IPs anteriores são desconhecidos e ficam NULL; o bloqueio por e-mail
continua abrangendo esses registros. A coluna IP não tem chave única, pois um
mesmo envio grava várias linhas.

O IP vem de `CI_Input::ip_address()` e é normalizado para IPv4/IPv6, incluindo
IPv4 mapeado. Não é recebido do formulário. Cabeçalhos de proxy só são usados
conforme `proxy_ips` do CodeIgniter; configure somente proxies efetivamente
confiáveis quando houver proxy reverso em produção. Redes que compartilham um
IP público compartilham também o bloqueio, conforme a regra solicitada.
O endpoint antigo de solicitação de código retorna HTTP 410 sem enviar e-mail.

O cálculo da classificação entre comissão e público utiliza essas notas nos
resultados administrativos, conforme `docs/atitude_apuracao.md`.
