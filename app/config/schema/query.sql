SET NAMES 'utf8';

CREATE TABLE `suggestion_type` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(64) NOT NULL,
  `description` VARCHAR(255) NULL,
  PRIMARY KEY (`id`)
)
  ENGINE = InnoDB
  DEFAULT CHARSET = utf8
  COLLATE = utf8_unicode_ci;

CREATE TABLE `suggestion` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `type_id` INT UNSIGNED NOT NULL,
  `priority` ENUM('M', 'S', 'C', 'W') DEFAULT 'C',
  `application` VARCHAR(127),
  `author` VARCHAR(127),
  `content` TEXT,
  `page_url` VARCHAR(255),
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (`type_id`) REFERENCES `suggestion_type`(`id`) ON DELETE CASCADE,
  PRIMARY KEY (`id`)
)
  ENGINE = InnoDB
  DEFAULT CHARSET = utf8
  COLLATE = utf8_unicode_ci;

INSERT INTO `suggestion_type` (`id`, `name`) VALUES
(1, 'error'),
(2, 'feature_request'),
(3, 'change_request'),
(4, 'comment'),
(5, 'other');

SHOW CREATE TABLE `suggestion`\G
SELECT * FROM `suggestion_type`\G

