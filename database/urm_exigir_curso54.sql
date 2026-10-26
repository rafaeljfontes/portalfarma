-- Executar uma vez no banco do Portal Farma antes de usar a nova ação.
ALTER TABLE tbl_portalfarma
    ADD COLUMN exigir_curso54 TINYINT(1) NOT NULL DEFAULT 1;
