-- wbce_search — table structure (MySQL/MariaDB syntax).
-- Executed via Database::importSql(), which rewrites it for SQLite
-- (ENGINE/CHARSET/UNSIGNED stripped, AUTO_INCREMENT → AUTOINCREMENT,
-- inline KEYs dropped). IF NOT EXISTS: install and upgrade both run it.

CREATE TABLE IF NOT EXISTS `{TP_SEARCH}index` (
    `id`          INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `page_id`     INT UNSIGNED NOT NULL DEFAULT 0,
    `section_id`  INT UNSIGNED NOT NULL DEFAULT 0,
    `item_id`     INT UNSIGNED NOT NULL DEFAULT 0,
    `module`      VARCHAR(100) NOT NULL DEFAULT '',
    `title`       TEXT,
    `item_title`  TEXT,
    `description` TEXT,
    `keywords`    TEXT,
    `content`     MEDIUMTEXT,
    `detail_url`  VARCHAR(500) NOT NULL DEFAULT '',
    `thumb_url`   VARCHAR(500) NOT NULL DEFAULT '',
    `visibility`  VARCHAR(50)  NOT NULL DEFAULT 'public',
    `searching`   TINYINT(1)   NOT NULL DEFAULT 1,
    `indexed_at`  INT UNSIGNED NOT NULL DEFAULT 0,
    `tokenized`   TINYINT(1)   NOT NULL DEFAULT 0,
    PRIMARY KEY (`id`),
    KEY `page_id` (`page_id`),
    KEY `section_id` (`section_id`),
    KEY `module` (`module`),
    KEY `tokenized` (`tokenized`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `{TP_SEARCH}stats` (
    `term`        VARCHAR(200) NOT NULL,
    `count`       INT UNSIGNED NOT NULL DEFAULT 1,
    `last_search` INT UNSIGNED NOT NULL DEFAULT 0,
    `misses`      INT UNSIGNED NOT NULL DEFAULT 0,
    PRIMARY KEY (`term`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Word index (WbceSearchWords) — only filled on large sites (setting
-- word_index). utf8mb4_bin: with the _ci default "o" and "ö" would collide
-- in the primary key. The PK's leading `word` column serves exact and prefix
-- lookups; KEY entry_id serves deletes. (SQLite: importSql() drops inline
-- KEYs, lib/setup.php creates the entry_id index there.)
CREATE TABLE IF NOT EXISTS `{TP_SEARCH}words` (
    `word`      VARCHAR(64) COLLATE utf8mb4_bin NOT NULL,
    `entry_id`  INT UNSIGNED NOT NULL,
    `field`     TINYINT UNSIGNED NOT NULL DEFAULT 0,
    `hits`      SMALLINT UNSIGNED NOT NULL DEFAULT 1,
    PRIMARY KEY (`word`, `entry_id`, `field`),
    KEY `entry_id` (`entry_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
