CREATE TABLE `session` (
  `session_id` TEXT NOT NULL PRIMARY KEY,
  `data` text NOT NULL,
  `created_at` INTEGER UNSIGNED NOT NULL,
  `modified_at` INTEGER UNSIGNED DEFAULT NULL
);

CREATE TABLE `suggestion_type` (
  `id` INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT,
  `name` TEXT NOT NULL,
  `description` TEXT
);

CREATE TABLE `suggestion` (
  `id` INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT,
  `type_id` INTEGER NOT NULL,
  `priority` CHAR(1) CHECK(`priority` IN ('M', 'S', 'C', 'W')) NOT NULL DEFAULT 'C',
  `application` TEXT,
  `author` TEXT,
  `content` TEXT,
  `page_url` TEXT,
  `agent` TEXT,
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
  `status` TEXT  CHECK(`status` IN ('pending', 'accepted', 'rejected', 'done')) NOT NULL DEFAULT 'pending',
  FOREIGN KEY (`type_id`) REFERENCES `suggestion_type`(`id`)
);

CREATE TABLE `user` (
  `id` INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT,
  `enabled` BOOLEAN NOT NULL DEFAULT 1,
  `username` TEXT NOT NULL UNIQUE,
  `email` TEXT NOT NULL,
  `password` TEXT NOT NULL,
  `first_name` TEXT,
  `last_name` TEXT,
  `gender` CHECK(`gender` IN ('unknown', 'female', 'male', 'both')) NOT NULL DEFAULT 'unknown',
  `description` TEXT,
  `roles` TEXT NOT NULL DEFAULT '[]',
  `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` DATETIME
);

CREATE TABLE `group` (
  `id` INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT,
  `name` TEXT NOT NULL UNIQUE,
  `description` TEXT,
  `roles` TEXT NOT NULL DEFAULT '[]'
);

CREATE TABLE `user_group` (
  `user_id` INTEGER NOT NULL,
  `group_id` INTEGER NOT NULL,
  FOREIGN KEY (`user_id`) REFERENCES `user`(`id`) ON DELETE CASCADE,
  FOREIGN KEY (`group_id`) REFERENCES `group`(`id`) ON DELETE CASCADE,
  PRIMARY KEY (`user_id`, `group_id`)
);
