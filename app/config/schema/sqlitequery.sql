CREATE TABLE suggestion_type (
  id INTEGER PRIMARY KEY AUTOINCREMENT,
  name TEXT NOT NULL,
  description TEXT NULL
);

CREATE TABLE suggestion (
  id INTEGER PRIMARY KEY AUTOINCREMENT,
  type_id INT UNSIGNED NOT NULL,
  priority CHAR(1) DEFAULT 'C',
  application TEXT,
  author TEXT,
  content TEXT,
  page_url TEXT,
  created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);

--   ENGINE = InnoDB
--   DEFAULT CHARSET = utf8
--   COLLATE = utf8_unicode_ci;
--
-- INSERT INTO `suggestion_type` (`id`, `name`) VALUES
-- (1, 'error'),
-- (2, 'feature_request'),
-- (3, 'change_request'),
-- (4, 'comment'),
-- (5, 'other');
--
