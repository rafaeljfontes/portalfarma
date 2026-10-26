-- Para a estrutura antiga com id_eleitor. Executar somente se a consulta abaixo
-- retornar zero. Se houver pendências, vincular o e-mail ao membro correto antes.
-- Este roteiro requer a antiga tabela de eleitor para mapear avaliações existentes.
-- Se ela já foi removida e a tabela de avaliações estiver vazia, basta substituir
-- o vínculo id_eleitor por id_membro e criar a FK e a chave única do novo CREATE.
SELECT COUNT(*) AS avaliacoes_sem_membro
FROM web_site.tbl_atitude_comissao_avaliacao a
LEFT JOIN web_site.tbl_atitude_comissao_eleitor e ON e.id = a.id_eleitor
LEFT JOIN web_site.tbl_atitude_comissao_membro m ON m.email = e.email
WHERE m.id IS NULL;

ALTER TABLE web_site.tbl_atitude_comissao_avaliacao
    ADD COLUMN id_membro BIGINT UNSIGNED NULL AFTER id;

UPDATE web_site.tbl_atitude_comissao_avaliacao a
JOIN web_site.tbl_atitude_comissao_eleitor e ON e.id = a.id_eleitor
JOIN web_site.tbl_atitude_comissao_membro m ON m.email = e.email
SET a.id_membro = m.id;

ALTER TABLE web_site.tbl_atitude_comissao_avaliacao
    MODIFY id_membro BIGINT UNSIGNED NOT NULL,
    ADD UNIQUE KEY comissao_membro_projeto (id_membro, id_projeto),
    ADD CONSTRAINT comissao_membro_fk FOREIGN KEY (id_membro)
        REFERENCES web_site.tbl_atitude_comissao_membro (id);

ALTER TABLE web_site.tbl_atitude_comissao_avaliacao
    DROP FOREIGN KEY comissao_eleitor_fk,
    DROP INDEX comissao_eleitor_projeto,
    DROP COLUMN id_eleitor;

-- A antiga tabela de eleitor deixa de ser utilizada; não é excluída aqui.
