-- Aplicar uma vez no banco web_site existente.
ALTER TABLE bjhp_edicoes ADD COLUMN edicao_atual TINYINT(1) NOT NULL DEFAULT 0 AFTER data_publicacao;
