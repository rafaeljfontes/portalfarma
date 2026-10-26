-- Esquema para instalação nova em web_site. Não altera tabelas existentes.
USE web_site;
CREATE TABLE IF NOT EXISTS bjhp_edicoes (
 id BIGINT UNSIGNED NOT NULL PRIMARY KEY,
 ojs_issue_id BIGINT UNSIGNED NOT NULL UNIQUE,
 identificacao VARCHAR(255) NULL,
 titulo VARCHAR(500) NULL,
 data_publicacao DATETIME NULL,
 edicao_atual TINYINT(1) NOT NULL DEFAULT 0,
 currentIssueId TINYINT(1) NOT NULL DEFAULT 0,
 descricao LONGTEXT NULL,
 capa_url TEXT NULL,
 edicao_url TEXT NULL,
 pdf_url TEXT NULL,
 sincronizado_em DATETIME NOT NULL,
 atualizado_em DATETIME NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
CREATE TABLE IF NOT EXISTS bjhp_artigos (
 id BIGINT UNSIGNED NOT NULL PRIMARY KEY,
 edicao_id BIGINT UNSIGNED NOT NULL,
 ojs_article_id BIGINT UNSIGNED NOT NULL UNIQUE,
 titulo TEXT NULL,
 autores TEXT NULL,
 doi VARCHAR(255) NULL,
 paginas VARCHAR(100) NULL,
 artigo_url TEXT NULL,
 pdf_url TEXT NULL,
 sincronizado_em DATETIME NOT NULL,
 atualizado_em DATETIME NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
CREATE TABLE IF NOT EXISTS importacoes (
 id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
 criado_em TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
 usuario_id BIGINT UNSIGNED NOT NULL,
 usuario_nome VARCHAR(255) NOT NULL,
 artigos INT UNSIGNED NOT NULL,
 edicoes INT UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
CREATE TABLE IF NOT EXISTS `bjhp_corpo-editorial` (
  `id` bigint unsigned NOT NULL,
  `categoria` enum('editor_chefe','editor_associado','conselho_consultivo_editorial','tecnologia_da_informacao','design','comunicacao','secretaria_administrativa') DEFAULT NULL,
  `nome` varchar(255) DEFAULT NULL,
  `titulacao` varchar(100) DEFAULT NULL,
  `instituicao` varchar(500) DEFAULT NULL,
  `cidade` varchar(150) DEFAULT NULL,
  `estado` varchar(150) DEFAULT NULL,
  `pais` varchar(100) DEFAULT NULL,
  `orcid` varchar(19) DEFAULT NULL,
  `orcid_url` varchar(255) DEFAULT NULL,
  `foto` varchar(500) DEFAULT NULL,
  `mini_curriculo` text,
  `email` varchar(255) DEFAULT NULL,
  `ordem_exibicao` smallint unsigned NOT NULL,
  `status` enum('ativo','inativo') DEFAULT NULL,
  `criado_em` datetime NOT NULL,
  `atualizado_em` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
