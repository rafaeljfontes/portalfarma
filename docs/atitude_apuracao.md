# Apuração — Atitude Farmacêutica

O botão **Ver resultados** na área restrita usa o endpoint autenticado
`restrito/atitude_farmaceutica/resultados`. Somente projetos aprovados participam.
As consultas agregam as fontes separadamente antes dos JOINs, evitando que a
quantidade de avaliações da comissão multiplique as avaliações populares.

- Comissão: média de `tbl_atitude_comissao_avaliacao.nota_final`, que já contém a
  ponderação interna dos cinco critérios de cada avaliação.
- Popular: média aritmética das cinco notas de cada voto válido em
  `tbl_atitude_votacao`. Como todos os votos têm cinco critérios, equivale à soma
  das notas dividida por cinco vezes o número de avaliações válidas.
- Final: `((comissão × 2) + popular) / 3`.

Avaliações com notas ausentes ou fora de 1 a 5 não compõem as médias.
Os votos antigos sem notas são preservados e identificados no painel.
Sem avaliação popular válida, a nota popular é **0** e a fórmula continua sendo
`((comissão × 2) + 0) / 3`; esses projetos recebem classificação normalmente.
Somente projetos sem avaliação da comissão ficam **Aguardando avaliações**,
com nota final e posição nulas.

No empate exato da nota final, comparar as médias da comissão, em ordem:
**duração → impacto → pessoas → benefícios → relevância**, sempre maior primeiro.
Essa prioridade segue a solicitação, independentemente dos pesos de cálculo.
Sem desempate em nenhum dos cinco critérios, os projetos compartilham a posição
(ex.: 1º, 1º, 2º). ID apenas mantém a apresentação estável, sem definir vencedor.

A biblioteca `Atitude_apuracao` usa somas inteiras e frações reduzidas. O cálculo
da comissão usa centésimos da coluna DECIMAL. As comparações não arredondam as
médias e não fazem multiplicação cruzada de frações. Conversão para número decimal
ocorre somente após a ordenação, para a resposta JSON e exibição com até seis casas.

O modal apresenta pódio, médias, nota final, posição, quantidades de avaliações,
médias individuais de desempate e gráfico da nota final na escala de 0 a 5.
Não há alteração nas notas ou nos votos armazenados para fazer a apuração.

Testes: `php tests/atitude_apuracao_test.php` e
`php tests/atitude_farmaceutica_test.php`.
