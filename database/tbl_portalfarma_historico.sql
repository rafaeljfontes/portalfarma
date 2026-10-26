CREATE TABLE IF NOT EXISTS `tbl_portalfarma_historico` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `id_acao` INT UNSIGNED NOT NULL,
  `id_usuario` INT NOT NULL,
  `id_registro` BIGINT UNSIGNED NOT NULL,
  `data_hora` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_historico_acao` (`id_acao`),
  KEY `idx_historico_usuario` (`id_usuario`),
  KEY `idx_historico_registro` (`id_registro`),
  KEY `idx_historico_data_hora` (`data_hora`),
  CONSTRAINT `fk_historico_acao`
    FOREIGN KEY (`id_acao`) REFERENCES `tbl_portalfarma_auditoria_acoes` (`id`),
  CONSTRAINT `fk_historico_usuario`
    FOREIGN KEY (`id_usuario`) REFERENCES `tbl_portalfarma_user` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT IGNORE INTO `tbl_portalfarma_auditoria_acoes` (`id`, `descricao`)
VALUES
  (18, 'Editar Plenária'),
  (19, 'Ativar curso'),
  (20, 'Desativar curso'),
  (21, 'Aceitar evento universitário'),
  (22, 'Recusar evento universitário'),
  (23, 'Voltar ação do evento universitário');
