-- Requer tbl_atitude_comissao_membro criada previamente.
CREATE TABLE IF NOT EXISTS web_site.tbl_atitude_comissao_avaliacao (
    id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    id_membro BIGINT UNSIGNED NOT NULL,
    id_projeto BIGINT UNSIGNED NOT NULL,
    relevancia TINYINT UNSIGNED NOT NULL,
    impacto TINYINT UNSIGNED NOT NULL,
    pessoas TINYINT UNSIGNED NOT NULL,
    duracao TINYINT UNSIGNED NOT NULL,
    beneficios TINYINT UNSIGNED NOT NULL,
    nota_final DECIMAL(3,2) NOT NULL,
    criado_em TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    UNIQUE KEY comissao_membro_projeto (id_membro, id_projeto),
    KEY comissao_projeto (id_projeto),
    CONSTRAINT comissao_membro_fk FOREIGN KEY (id_membro)
        REFERENCES web_site.tbl_atitude_comissao_membro (id),
    CONSTRAINT comissao_notas_validas CHECK (
        relevancia BETWEEN 1 AND 5 AND impacto BETWEEN 1 AND 5
        AND pessoas BETWEEN 1 AND 5 AND duracao BETWEEN 1 AND 5
        AND beneficios BETWEEN 1 AND 5 AND nota_final BETWEEN 1 AND 5
    )
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
