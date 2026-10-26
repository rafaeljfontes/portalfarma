-- Executar somente se a tabela ainda não possuir a coluna courseid.
ALTER TABLE tbl_portalfarma_urm_local
    ADD COLUMN courseid VARCHAR(255) NULL,
    ADD KEY idx_urm_local_courseid (courseid);
