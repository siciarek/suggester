SET NAMES 'utf8';

CREATE TABLE `session` (
  `session_id` VARCHAR(35) NOT NULL,
  `data` text NOT NULL,
  `created_at` INTEGER UNSIGNED NOT NULL,
  `modified_at` INTEGER UNSIGNED DEFAULT NULL,
  PRIMARY KEY (`session_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE `suggestion_type` (
  `id` INTEGER NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `name` VARCHAR(64) NOT NULL,
  `description` VARCHAR(255)
) ENGINE = InnoDB DEFAULT CHARSET = utf8 COLLATE = utf8_unicode_ci;

CREATE TABLE `suggestion` (
  `id` INTEGER NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `type_id` INT NOT NULL,
  `priority` ENUM('M', 'S', 'C', 'W') DEFAULT 'C',
  `application` VARCHAR(127),
  `author` VARCHAR(127),
  `content` TEXT,
  `page_url` VARCHAR(255),
  `agent` VARCHAR(255),
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
  `status` ENUM('pending', 'accepted', 'rejected', 'done') DEFAULT 'pending',
  FOREIGN KEY (`type_id`) REFERENCES `suggestion_type`(`id`) ON DELETE CASCADE
) ENGINE = InnoDB DEFAULT CHARSET = utf8 COLLATE = utf8_unicode_ci;

INSERT INTO `suggestion_type` (`name`) VALUES('error');
INSERT INTO `suggestion_type` (`name`) VALUES('feature_request');
INSERT INTO `suggestion_type` (`name`) VALUES('change_request');
INSERT INTO `suggestion_type` (`name`) VALUES('comment');
INSERT INTO `suggestion_type` (`name`) VALUES('other');

CREATE TABLE user (
  `id` INTEGER NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `username` VARCHAR(127)NOT NULL,
  `email` VARCHAR(127) NOT NULL,
  `password` VARCHAR(127) NOT NULL,
  `first_name` VARCHAR(127) NOT NULL,
  `last_name` VARCHAR(127) NOT NULL,
  `roles` VARCHAR(255) NOT NULL DEFAULT '[]'
) ENGINE = InnoDB DEFAULT CHARSET = utf8 COLLATE = utf8_unicode_ci;

INSERT INTO user (`username`, `email`, `password`, `first_name`, `last_name`, `roles`) VALUES
('czesolak', 'czesolak@example.com', MD5('password'), 'Czesław', 'Olak', '[ROLE_USER]');
INSERT INTO user (`username`, `email`, `password`, `first_name`, `last_name`, `roles`) VALUES
('mariolak', 'mariolak@example.com', MD5('password'), 'Marianna', 'Olak', '[ROLE_ADMIN]');
