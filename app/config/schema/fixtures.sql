INSERT INTO `suggestion_type` (`name`) VALUES('error');
INSERT INTO `suggestion_type` (`name`) VALUES('feature_request');
INSERT INTO `suggestion_type` (`name`) VALUES('change_request');
INSERT INTO `suggestion_type` (`name`) VALUES('comment');
INSERT INTO `suggestion_type` (`name`) VALUES('other');

INSERT INTO user (`username`, `email`, `password`, `first_name`, `last_name`, `gender`) VALUES
('czesolak', 'czesolak@example.com', MD5('password'), 'Czesław', 'Olak', 'male');
INSERT INTO user (`username`, `email`, `password`, `first_name`, `last_name`, `gender`) VALUES
('mariolak', 'mariolak@example.com', MD5('password'), 'Marianna', 'Olak', 'female');
INSERT INTO user (`username`, `email`, `password`, `first_name`, `last_name`, `gender`) VALUES
('hasim', 'hasim@example.com', MD5('password'), 'Hasim', 'Vatabahan', 'female');

INSERT INTO `group` (`name`, `description`, `roles`) VALUES
('Users', 'Basic system users', '[ ROLE_USER ]');
INSERT INTO `group` (`name`, `description`, `roles`) VALUES
('Admins', 'System administrators', '[ ROLE_ADMIN ]');
INSERT INTO `group` (`name`, `description`, `roles`) VALUES
('Superadmins', 'System administrators with extra privileges', '[ ROLE_SUPERADMIN ]');
INSERT INTO `group` (`name`, `description`, `roles`) VALUES
('Basic readers of articles', 'Basic readers of articles', '[ ROLE_BASIC_ARTICLE_READER ]');
INSERT INTO `group` (`name`, `description`, `roles`) VALUES
('Basic editors of articles', 'Basic editors of articles', '[ ROLE_BASIC_ARTICLE_EDITOR ]');
INSERT INTO `group` (`name`, `description`, `roles`) VALUES
('Privileged readers of articles ', 'Privileged readers of articles', '[ ROLE_PRIVILEGED_ARTICLE_READER ]');
INSERT INTO `group` (`name`, `description`, `roles`) VALUES
('Privileged editors of articles', 'Privileged editors of articles', '[ ROLE_PRIVILEGED_ARTICLE_EDITOR ]');

INSERT INTO `user_group` VALUES (1, 1);
INSERT INTO `user_group` VALUES (2, 2);
INSERT INTO `user_group` VALUES (3, 3);


