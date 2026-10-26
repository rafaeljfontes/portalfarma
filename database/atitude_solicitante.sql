-- Executar uma vez em tabelas que ainda não possuem estas colunas.
ALTER TABLE web_site.tbl_atitudefarmaceutica_inscricao
    ADD COLUMN tipo_solicitante VARCHAR(20) NOT NULL DEFAULT 'farmaceutico',
    ADD COLUMN nome VARCHAR(255) NULL;
