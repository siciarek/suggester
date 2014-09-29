CREATE TABLE `contact_list` (
    `id` INTEGER NOT NULL PRIMARY KEY AUTO_INCREMENT
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE `address_list` (
    `id` INTEGER NOT NULL PRIMARY KEY AUTO_INCREMENT
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE `document_list` (
    `id` INTEGER NOT NULL PRIMARY KEY AUTO_INCREMENT
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- -------------------------------------------------------------------------------------------

CREATE TABLE `contact_list_entry` (
    `id` INTEGER NOT NULL PRIMARY KEY AUTO_INCREMENT,
    `enabled` BOOLEAN DEFAULT 1,
    `main` BOOLEAN DEFAULT 0,
    `type` ENUM('phone', 'email', 'fax', 'facebook', 'gg', 'other') NOT NULL,
    `value` VARCHAR(255) NOT NULL,
    `contact_list_id` INTEGER NOT NULL,
    FOREIGN KEY (`contact_list_id`) REFERENCES `contact_list`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE `document` (
  `id` INTEGER NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `mime_type` VARCHAR(64) NOT NULL,
  `title` VARCHAR(127) NOT NULL,
  `path` VARCHAR(255) NOT NULL,
  `size` INTEGER UNSIGNED DEFAULT 0,
  `document_list_id` INTEGER NOT NULL,
  FOREIGN KEY (`document_list_id`) REFERENCES `document_list`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE `address` (
    `id` INTEGER NOT NULL PRIMARY KEY AUTO_INCREMENT,
    `enabled` BOOLEAN DEFAULT 1,
    `main` BOOLEAN DEFAULT 0,
    `type` ENUM('location', 'correspondence', 'invoice', 'other') NOT NULL,
    `postal_code` VARCHAR(64),
    `address` VARCHAR(127),
    `address_list_id` INTEGER NOT NULL,
    FOREIGN KEY (`address_list_id`) REFERENCES `address_list`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- -------------------------------------------------------------------------------------------

CREATE TABLE `provider` (
  `id` INTEGER NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `branch` VARCHAR(127) NOT NULL,
  `name` VARCHAR(127) NOT NULL,
  `contact_list_id` INTEGER NOT NULL,
  `address_list_id` INTEGER NOT NULL,
  `document_list_id` INTEGER NOT NULL,
  FOREIGN KEY (`contact_list_id`) REFERENCES `contact_list`(`id`) ON DELETE CASCADE,
  FOREIGN KEY (`address_list_id`) REFERENCES `address_list`(`id`) ON DELETE CASCADE,
  FOREIGN KEY (`document_list_id`) REFERENCES `document_list`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE `product` (
  `id` INTEGER NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `type` VARCHAR(64),
  `name` VARCHAR(127) NOT NULL,
  `price_currency` CHAR(3),
  `price_value` DECIMAL(10, 7),
  `provider_id` INTEGER NOT NULL,
  FOREIGN KEY (`provider_id`) REFERENCES `provider`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE `product_parameter` (
  `id` INTEGER NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `type` VARCHAR(64) NOT NULL,
  `name` VARCHAR(127) NOT NULL,
  `value` VARCHAR(255) NOT NULL,
  `product_id` INTEGER NOT NULL,
  FOREIGN KEY (`product_id`) REFERENCES `product`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- to tylko aby wygenerować model:

CREATE TABLE `price` (
  `id` INTEGER NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `currency` CHAR(3) NOT NULL,
  `value` DECIMAL(10, 2)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- -------------------------------------------------------------------------------------------

CREATE TABLE `client` (
    `id` INTEGER NOT NULL PRIMARY KEY AUTO_INCREMENT,
    `contact_list_id` INTEGER NOT NULL,
    `address_list_id` INTEGER NOT NULL,
    `document_list_id` INTEGER NOT NULL,
    `type` ENUM('person', 'organisation'),
    `name` VARCHAR(127) NOT NULL,
    `last_name` VARCHAR(127),
    `date_of_birth` DATE,
    `tax_number` VARCHAR(64),
# Timestampable
    `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at` DATETIME,
# SoftDeletable
    `deleted_at` DATETIME,
# Sluggable
    `slug` VARCHAR(127),
    FOREIGN KEY (`contact_list_id`) REFERENCES `contact_list`(`id`) ON DELETE CASCADE,
    FOREIGN KEY (`address_list_id`) REFERENCES `address_list`(`id`) ON DELETE CASCADE,
    FOREIGN KEY (`document_list_id`) REFERENCES `document_list`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE `client_relation` (
  `owning_id` INTEGER NOT NULL,
  `type` ENUM('spouse', 'partner', 'worker', 'child', 'grandchild', 'parent', 'grandparent'),
  `inversed_id` INTEGER NOT NULL,
  FOREIGN KEY (`owning_id`) REFERENCES `client`(`id`) ON DELETE CASCADE,
  FOREIGN KEY (`inversed_id`) REFERENCES `client`(`id`) ON DELETE CASCADE,
  PRIMARY KEY (`owning_id`, `inversed_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE `client_event` (
  `id` INTEGER NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `parent_id` INTEGER,
  `client_id` INTEGER,
  `product_id` INTEGER,
  `event` VARCHAR(127), -- info, order, payment
  `channel` VARCHAR(64),
  `info` VARCHAR(255),
  `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (`parent_id`) REFERENCES `client_event`(`id`) ON DELETE CASCADE,
  FOREIGN KEY (`client_id`) REFERENCES `client`(`id`) ON DELETE CASCADE,
  FOREIGN KEY (`product_id`) REFERENCES `product`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- -------------------------------------------------------------------------------------------

CREATE TABLE `order` (
    `id` INTEGER NOT NULL PRIMARY KEY AUTO_INCREMENT,
    `paid` BOOLEAN DEFAULT 0,
    `parent_id` INTEGER NOT NULL,
    `product_id` INTEGER NOT NULL,
    `client_id` INTEGER NOT NULL,
    `document_list_id` INTEGER NOT NULL,
    `status` ENUM('pending', 'inprogress', 'complete', 'rejected') DEFAULT 'pending',
# Timestampable
    `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at` DATETIME,
# SoftDeletable
    `deleted_at` DATETIME,
    FOREIGN KEY (`document_list_id`) REFERENCES `document_list`(`id`) ON DELETE CASCADE,
    FOREIGN KEY (`parent_id`) REFERENCES `order`(`id`) ON DELETE CASCADE,
    FOREIGN KEY (`product_id`) REFERENCES `product`(`id`) ON DELETE CASCADE,
    FOREIGN KEY (`client_id`) REFERENCES `client`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- -------------------------------------------------------------------------------------------

CREATE TABLE `user` (
    `id` INTEGER NOT NULL PRIMARY KEY AUTO_INCREMENT,
    `enabled` BOOLEAN NOT NULL DEFAULT true,
    `username` VARCHAR(127)NOT NULL UNIQUE,
    `email` VARCHAR(127) NOT NULL,
    `password` VARCHAR(127) NULL,
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

-- -------------------------------------------------------------------------------------------

CREATE TABLE `session` (
  `session_id` VARCHAR(35) NOT NULL,
  `data` text NOT NULL,
  `created_at` INTEGER UNSIGNED NOT NULL,
  `modified_at` INTEGER UNSIGNED DEFAULT NULL,
  PRIMARY KEY (`session_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- -------------------------------------------------------------------------------------------
-- -------------------------------------------------------------------------------------------

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
