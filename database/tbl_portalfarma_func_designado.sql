-- Executar no mesmo banco de tbl_portalfarma e tbl_portalfarma_user.
-- Mantém os tipos e a collation das chaves existentes, inclusive CourseIDs URM.
SET @schema_designacoes = DATABASE();
SELECT CONCAT(COLUMN_TYPE, IF(CHARACTER_SET_NAME IS NULL, '', CONCAT(' CHARACTER SET ', CHARACTER_SET_NAME, ' COLLATE ', COLLATION_NAME)))
INTO @tipo_courseid_designacoes FROM information_schema.COLUMNS
WHERE TABLE_SCHEMA = @schema_designacoes AND TABLE_NAME = 'tbl_portalfarma' AND COLUMN_NAME = 'courseid';
SELECT COLUMN_TYPE INTO @tipo_usuario_designacoes FROM information_schema.COLUMNS
WHERE TABLE_SCHEMA = @schema_designacoes AND TABLE_NAME = 'tbl_portalfarma_user' AND COLUMN_NAME = 'id';

-- A chave referenciada precisa de índice; não altera nem remove os dados existentes.
SET @indice_designacoes = IF(EXISTS(SELECT 1 FROM information_schema.STATISTICS WHERE TABLE_SCHEMA = @schema_designacoes
    AND TABLE_NAME = 'tbl_portalfarma' AND COLUMN_NAME = 'courseid' AND SEQ_IN_INDEX = 1),
    'SELECT 1', 'ALTER TABLE tbl_portalfarma ADD INDEX idx_portalfarma_courseid_designacoes (courseid)');
PREPARE stmt_designacoes FROM @indice_designacoes;
EXECUTE stmt_designacoes;
DEALLOCATE PREPARE stmt_designacoes;

SET @ddl_designacoes = CONCAT('CREATE TABLE IF NOT EXISTS tbl_portalfarma_func_designado (
    id INT NOT NULL AUTO_INCREMENT,
    courseid ', @tipo_courseid_designacoes, ' NOT NULL,
    id_usuario ', @tipo_usuario_designacoes, ' NOT NULL,
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (id),
    UNIQUE KEY uq_designado_curso_usuario (courseid, id_usuario),
    KEY idx_designado_usuario_curso (id_usuario, courseid),
    CONSTRAINT fk_designado_curso FOREIGN KEY (courseid) REFERENCES tbl_portalfarma (courseid) ON DELETE CASCADE,
    CONSTRAINT fk_designado_usuario FOREIGN KEY (id_usuario) REFERENCES tbl_portalfarma_user (id) ON DELETE CASCADE
) ENGINE=InnoDB');
PREPARE stmt_designacoes FROM @ddl_designacoes;
EXECUTE stmt_designacoes;
DEALLOCATE PREPARE stmt_designacoes;
