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

CREATE TABLE `user` (
  `id` INTEGER NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `enabled` BOOLEAN NOT NULL DEFAULT true,
  `username` VARCHAR(127)NOT NULL UNIQUE,
  `email` VARCHAR(127) NOT NULL,
  `password` VARCHAR(127) NOT NULL,
  `first_name` VARCHAR(127),
  `last_name` VARCHAR(127),
  `gender` ENUM('unknown', 'female', 'male', 'both') DEFAULT 'unknown',
  `description` VARCHAR(255),
  `roles` VARCHAR(255) NOT NULL DEFAULT '[]',
  `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` DATETIME
) ENGINE = InnoDB DEFAULT CHARSET = utf8 COLLATE = utf8_unicode_ci;

CREATE TABLE `group` (
  `id` INTEGER NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `name` VARCHAR(64) NOT NULL UNIQUE,
  `description` VARCHAR(255),
  `roles` VARCHAR(255) NOT NULL DEFAULT '[]'
) ENGINE = InnoDB DEFAULT CHARSET = utf8 COLLATE = utf8_unicode_ci;

CREATE TABLE `user_group` (
  `user_id` INTEGER NOT NULL,
  `group_id` INTEGER NOT NULL,
  FOREIGN KEY (`user_id`) REFERENCES `user`(`id`) ON DELETE CASCADE,
  FOREIGN KEY (`group_id`) REFERENCES `group`(`id`) ON DELETE CASCADE,
  PRIMARY KEY (`user_id`, `group_id`)
) ENGINE = InnoDB;
