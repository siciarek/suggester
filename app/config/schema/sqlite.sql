CREATE TABLE suggestion_type (
  `id` INTEGER PRIMARY KEY AUTOINCREMENT,
  `name` TEXT NOT NULL,
  `description` TEXT
);

CREATE TABLE suggestion (
  `id` INTEGER PRIMARY KEY AUTOINCREMENT,
  `type_id` INT UNSIGNED NOT NULL,
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
