-- Executar uma vez na tabela existente. NULL preserva os votos anteriores,
-- que não tinham avaliação por critério. Novos envios exigem todas as notas.
ALTER TABLE web_site.tbl_atitude_votacao
    ADD COLUMN relevancia TINYINT UNSIGNED NULL,
    ADD COLUMN impacto TINYINT UNSIGNED NULL,
    ADD COLUMN pessoas TINYINT UNSIGNED NULL,
    ADD COLUMN duracao TINYINT UNSIGNED NULL,
    ADD COLUMN beneficios TINYINT UNSIGNED NULL,
    ADD CONSTRAINT voto_popular_notas CHECK (
        (relevancia IS NULL AND impacto IS NULL AND pessoas IS NULL AND duracao IS NULL AND beneficios IS NULL)
        OR (relevancia IS NOT NULL AND impacto IS NOT NULL AND pessoas IS NOT NULL AND duracao IS NOT NULL AND beneficios IS NOT NULL
            AND relevancia BETWEEN 1 AND 5 AND impacto BETWEEN 1 AND 5 AND pessoas BETWEEN 1 AND 5 AND duracao BETWEEN 1 AND 5 AND beneficios BETWEEN 1 AND 5)
    );
