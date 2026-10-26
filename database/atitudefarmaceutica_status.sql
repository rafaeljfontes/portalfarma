-- Aplicar antes de gerenciar as decisões. Campos existentes são preservados.
SET @atitude_status_sql = IF(
    EXISTS(SELECT 1 FROM information_schema.COLUMNS WHERE TABLE_SCHEMA = 'web_site'
        AND TABLE_NAME = 'tbl_atitudefarmaceutica_inscricao' AND COLUMN_NAME = 'status'),
    'SELECT 1',
    'ALTER TABLE web_site.tbl_atitudefarmaceutica_inscricao ADD COLUMN status TINYINT UNSIGNED NOT NULL DEFAULT 0 COMMENT ''0: Pendente, 1: Aceito, 2: Recusado'''
);
PREPARE atitude_status_stmt FROM @atitude_status_sql;
EXECUTE atitude_status_stmt;
DEALLOCATE PREPARE atitude_status_stmt;

SET @atitude_motivo_sql = IF(
    EXISTS(SELECT 1 FROM information_schema.COLUMNS WHERE TABLE_SCHEMA = 'web_site'
        AND TABLE_NAME = 'tbl_atitudefarmaceutica_inscricao' AND COLUMN_NAME = 'motivo_recusa'),
    'SELECT 1',
    'ALTER TABLE web_site.tbl_atitudefarmaceutica_inscricao ADD COLUMN motivo_recusa TEXT DEFAULT NULL'
);
PREPARE atitude_motivo_stmt FROM @atitude_motivo_sql;
EXECUTE atitude_motivo_stmt;
DEALLOCATE PREPARE atitude_motivo_stmt;
