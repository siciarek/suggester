CREATE TABLE `suggestion_type` (
  `id` INTEGER UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `name` VARCHAR(64) NOT NULL,
  `description` VARCHAR(255) NULL
) ENGINE = InnoDB DEFAULT CHARSET = utf8 COLLATE = utf8_unicode_ci;

CREATE TABLE `suggestion` (
  `id` INT UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `type_id` INT UNSIGNED NOT NULL,
  `priority` ENUM('M', 'S', 'C', 'W') DEFAULT 'C',
  `application` VARCHAR(127),
  `author` VARCHAR(127),
  `content` TEXT,
  `page_url` VARCHAR(255),
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (`type_id`) REFERENCES `suggestion_type`(`id`) ON DELETE CASCADE
) ENGINE = InnoDB DEFAULT CHARSET = utf8 COLLATE = utf8_unicode_ci;

INSERT INTO `suggestion_type` (`name`) VALUES('error');
INSERT INTO `suggestion_type` (`name`) VALUES('feature_request');
INSERT INTO `suggestion_type` (`name`) VALUES('change_request');
INSERT INTO `suggestion_type` (`name`) VALUES('comment');
INSERT INTO `suggestion_type` (`name`) VALUES('other');
