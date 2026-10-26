CREATE TABLE IF NOT EXISTS web_site.tbl_atitude_votacao (
    id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(254) NOT NULL,
    ip_votante VARCHAR(45) CHARACTER SET ascii COLLATE ascii_bin NULL,
    codigo CHAR(16) NOT NULL COMMENT 'Código gerado para o envio dos votos',
    id_proejto BIGINT UNSIGNED NOT NULL COMMENT 'ID de tbl_atitudefarmaceutica_inscricao',
    relevancia TINYINT UNSIGNED NULL,
    impacto TINYINT UNSIGNED NULL,
    pessoas TINYINT UNSIGNED NULL,
    duracao TINYINT UNSIGNED NULL,
    beneficios TINYINT UNSIGNED NULL,
    criado_em TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    UNIQUE KEY voto_email_projeto (email, id_proejto),
    KEY voto_projeto (id_proejto),
    KEY voto_codigo (codigo),
    KEY voto_ip (ip_votante),
    CONSTRAINT voto_popular_notas CHECK (
        (relevancia IS NULL AND impacto IS NULL AND pessoas IS NULL AND duracao IS NULL AND beneficios IS NULL)
        OR (relevancia IS NOT NULL AND impacto IS NOT NULL AND pessoas IS NOT NULL AND duracao IS NOT NULL AND beneficios IS NOT NULL
            AND relevancia BETWEEN 1 AND 5 AND impacto BETWEEN 1 AND 5 AND pessoas BETWEEN 1 AND 5 AND duracao BETWEEN 1 AND 5 AND beneficios BETWEEN 1 AND 5)
    )
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
