CREATE TABLE `tbl_portalfarma_urm_local` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `courseid` VARCHAR(255) NULL,
  `titulo` VARCHAR(180) NOT NULL,
  `cidade` VARCHAR(120) NOT NULL,
  `descricao` TEXT NOT NULL,
  `data` DATE NOT NULL,
  `imagem` VARCHAR(255) NOT NULL,
  `link` VARCHAR(500) NULL,
  `data_cadastro` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_urm_local_courseid` (`courseid`),
  KEY `idx_urm_local_data` (`data`),
  KEY `idx_urm_local_cidade` (`cidade`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
