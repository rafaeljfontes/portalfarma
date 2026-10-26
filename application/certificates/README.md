# Certificados HTTPS das integrações

`cacert.pem` é o pacote público de autoridades certificadoras Mozilla, baixado de
`https://curl.se/ca/cacert.pem` em 19/10/2026. O SHA-256 foi conferido com o
arquivo `https://curl.se/ca/cacert.pem.sha256` publicado pelo curl:
`a41b5d356aea97a529fe27e0f7316d2f9d946d75927476cf9cf1b90637d00505`.

O cliente OJS usa este arquivo com `CURLOPT_CAINFO`, mantendo a verificação do
certificado e do nome do servidor habilitadas. Não contém credenciais.
Para substituir o arquivo, configure `BJHP_OJS_CA_BUNDLE` com um caminho absoluto.

As consultas `Capacitacao::ConsultaPF()` e `ConsultaPJ()` também usam este pacote
como alternativa quando o cURL retorna erro 60 e `curl.cainfo` não está configurado.
A validação SSL permanece ativa. Publicar `Capacitacao.php` junto com o pacote CA.

Atualizações oficiais: https://curl.se/docs/caextract.html
Orientações: https://curl.se/docs/sslcerts.html
