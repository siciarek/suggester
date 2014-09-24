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

INSERT INTO suggestion_type (`name`) VALUES('error');
INSERT INTO suggestion_type (`name`) VALUES('feature_request');
INSERT INTO suggestion_type (`name`) VALUES('change_request');
INSERT INTO suggestion_type (`name`) VALUES('comment');
INSERT INTO suggestion_type (`name`) VALUES('other');

CREATE TABLE `user` (
  `id` INTEGER PRIMARY KEY AUTOINCREMENT,
  `username` TEXT NOT NULL,
  `email` TEXT NOT NULL,
  `password` TEXT NOT NULL,
  `first_name` TEXT NOT NULL,
  `last_name` TEXT NOT NULL,
  `roles` TEXT NOT NULL
);

INSERT INTO user (`username`, `email`, `password`, `first_name`, `last_name`, `roles`) VALUES
('czesolak', 'czesolak@example.com', MD5('password'), 'Czesław', 'Olak', '[ROLE_USER]');
INSERT INTO user (`username`, `email`, `password`, `first_name`, `last_name`, `roles`) VALUES
('mariolak', 'mariolak@example.com', MD5('password'), 'Marianna', 'Olak', '[ROLE_ADMIN]');
