-- Executar uma vez em instalações existentes.
USE web_site;
ALTER TABLE bjhp_edicoes ADD COLUMN currentIssueId TINYINT(1) NOT NULL DEFAULT 0 AFTER edicao_atual;
-- Preenchido pela próxima importação OJS: 1 para a edição atual e 0 para as demais.
