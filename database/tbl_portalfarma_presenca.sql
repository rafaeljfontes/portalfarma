CREATE TABLE IF NOT EXISTS `tbl_portalfarma_presenca` (
    `courseid` BIGINT UNSIGNED NOT NULL,
    `id_moodle` BIGINT UNSIGNED NOT NULL,
    PRIMARY KEY (`courseid`, `id_moodle`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
