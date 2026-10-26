ALTER TABLE `tbl_portalfarma`
  ADD COLUMN `presenca_liberada` TINYINT(1) NOT NULL DEFAULT 0
  COMMENT 'Libera a confirmação de presença pelo participante na página pública do seminário'
  AFTER `status`;
