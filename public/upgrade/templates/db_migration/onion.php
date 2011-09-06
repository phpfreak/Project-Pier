CREATE TABLE `<?php echo $table_prefix ?>attached_files` (
  `rel_object_manager` varchar(50) <?php echo $default_collation ?> NOT NULL default '',
  `rel_object_id` int(10) unsigned NOT NULL default '0',
  `file_id` int(10) unsigned NOT NULL default '0',
  `created_on` datetime NOT NULL default '0000-00-00 00:00:00',
  `created_by_id` int(10) unsigned default NULL,
  PRIMARY KEY  (`rel_object_manager`,`rel_object_id`,`file_id`)
) ENGINE=InnoDB <?php echo $default_charset ?>;

CREATE TABLE `<?php echo $table_prefix ?>comments` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `rel_object_id` int(10) unsigned NOT NULL default '0',
  `rel_object_manager` varchar(30) <?php echo $default_collation ?> NOT NULL default '',
  `text` text <?php echo $default_collation ?>,
  `is_private` tinyint(1) unsigned NOT NULL default '0',
  `is_anonymous` tinyint(1) unsigned NOT NULL default '0',
  `author_name` varchar(50) <?php echo $default_collation ?> default NULL,
  `author_email` varchar(100) <?php echo $default_collation ?> default NULL,
  `author_homepage` varchar(100) <?php echo $default_collation ?> NOT NULL default '',
  `created_on` datetime NOT NULL default '0000-00-00 00:00:00',
  `created_by_id` int(10) unsigned default NULL,
  `updated_on` datetime NOT NULL default '0000-00-00 00:00:00',
  `updated_by_id` int(10) unsigned default NULL,
  PRIMARY KEY  (`id`),
  KEY `object_id` (`rel_object_id`,`rel_object_manager`),
  KEY `created_on` (`created_on`)
) ENGINE=InnoDB <?php echo $default_charset ?>;

CREATE TABLE `<?php echo $table_prefix ?>file_repo` (
  `id` varchar(40) <?php echo $default_collation ?> NOT NULL default '',
  `content` longblob NOT NULL,
  `order` int(10) unsigned NOT NULL default '0',
  PRIMARY KEY  (`id`),
  KEY `order` (`order`)
) ENGINE=InnoDB <?php echo $default_charset ?>;

CREATE TABLE `<?php echo $table_prefix ?>file_repo_attributes` (
  `id` varchar(40) <?php echo $default_collation ?> NOT NULL default '',
  `attribute` varchar(50) <?php echo $default_collation ?> NOT NULL default '',
  `value` text <?php echo $default_collation ?> NOT NULL,
  PRIMARY KEY  (`id`,`attribute`)
) ENGINE=InnoDB <?php echo $default_charset ?>;

CREATE TABLE `<?php echo $table_prefix ?>project_file_revisions` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `file_id` int(10) unsigned NOT NULL default '0',
  `file_type_id` smallint(5) unsigned NOT NULL default '0',
  `repository_id` varchar(40) <?php echo $default_collation ?> NOT NULL default '',
  `thumb_filename` varchar(44) <?php echo $default_collation ?> default NULL,
  `revision_number` int(10) unsigned NOT NULL default '0',
  `comment` text <?php echo $default_collation ?>,
  `type_string` varchar(50) <?php echo $default_collation ?> NOT NULL default '',
  `filesize` int(10) unsigned NOT NULL default '0',
  `created_on` datetime NOT NULL default '0000-00-00 00:00:00',
  `created_by_id` int(10) unsigned default NULL,
  `updated_on` datetime NOT NULL default '0000-00-00 00:00:00',
  `updated_by_id` int(10) unsigned default NULL,
  PRIMARY KEY  (`id`),
  KEY `file_id` (`file_id`),
  KEY `updated_on` (`updated_on`),
  KEY `revision_number` (`revision_number`)
) ENGINE=InnoDB <?php echo $default_charset ?>;

CREATE TABLE `<?php echo $table_prefix ?>project_files` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `project_id` int(10) unsigned NOT NULL default '0',
  `folder_id` smallint(5) unsigned NOT NULL default '0',
  `filename` varchar(100) <?php echo $default_collation ?> NOT NULL default '',
  `description` text <?php echo $default_collation ?>,
  `is_private` tinyint(1) unsigned NOT NULL default '0',
  `is_important` tinyint(1) unsigned NOT NULL default '0',
  `is_locked` tinyint(1) unsigned NOT NULL default '0',
  `is_visible` tinyint(1) unsigned NOT NULL default '0',
  `expiration_time` datetime NOT NULL default '0000-00-00 00:00:00',
  `comments_enabled` tinyint(1) unsigned NOT NULL default '1',
  `anonymous_comments_enabled` tinyint(1) unsigned NOT NULL default '0',
  `created_on` datetime NOT NULL default '0000-00-00 00:00:00',
  `created_by_id` int(10) unsigned default '0',
  `updated_on` datetime NOT NULL default '0000-00-00 00:00:00',
  `updated_by_id` int(10) unsigned default '0',
  PRIMARY KEY  (`id`),
  KEY `project_id` (`project_id`)
) ENGINE=InnoDB <?php echo $default_charset ?>;

CREATE TABLE `<?php echo $table_prefix ?>project_folders` (
  `id` smallint(5) unsigned NOT NULL auto_increment,
  `project_id` int(10) unsigned NOT NULL default '0',
  `name` varchar(50) <?php echo $default_collation ?> NOT NULL default '',
  PRIMARY KEY  (`id`),
  UNIQUE KEY `project_id` (`project_id`,`name`)
) ENGINE=InnoDB <?php echo $default_charset ?>;

ALTER TABLE `<?php echo $table_prefix ?>application_logs` CHANGE `object_id` `rel_object_id` int(10) NOT NULL DEFAULT '0';
ALTER TABLE `<?php echo $table_prefix ?>application_logs` CHANGE `object_manager_class` `rel_object_manager` varchar(50) NOT NULL;
ALTER TABLE `<?php echo $table_prefix ?>application_logs` MODIFY COLUMN `is_private` tinyint(1) unsigned NOT NULL DEFAULT '0';
ALTER TABLE `<?php echo $table_prefix ?>application_logs` ADD COLUMN `is_silent` tinyint(1) unsigned NOT NULL DEFAULT '0';

ALTER TABLE `<?php echo $table_prefix ?>companies` MODIFY COLUMN `client_of_id` smallint(5) unsigned;
ALTER TABLE `<?php echo $table_prefix ?>companies` MODIFY COLUMN `logo_file` varchar(44);
ALTER TABLE `<?php echo $table_prefix ?>companies` ADD COLUMN `timezone` float(3,1) NOT NULL DEFAULT '0.0';

ALTER TABLE `<?php echo $table_prefix ?>project_messages` ADD COLUMN `comments_enabled` tinyint(1) unsigned NOT NULL DEFAULT '1';
ALTER TABLE `<?php echo $table_prefix ?>project_messages` ADD COLUMN `anonymous_comments_enabled` tinyint(1) unsigned NOT NULL DEFAULT '0';
ALTER TABLE `<?php echo $table_prefix ?>project_messages` DROP COLUMN `is_locked`;

ALTER TABLE `<?php echo $table_prefix ?>project_milestones` MODIFY COLUMN `description` text;

ALTER TABLE `<?php echo $table_prefix ?>project_tasks` MODIFY COLUMN `text` text;

ALTER TABLE `<?php echo $table_prefix ?>project_users` CHANGE `can_upload_documents` `can_upload_files` tinyint(1) unsigned DEFAULT '0';
ALTER TABLE `<?php echo $table_prefix ?>project_users` CHANGE `can_manage_documents` `can_manage_files` tinyint(1) unsigned DEFAULT '0';
ALTER TABLE `<?php echo $table_prefix ?>project_users` ADD COLUMN `can_assign_to_owners` tinyint(1) unsigned NOT NULL DEFAULT '0';
ALTER TABLE `<?php echo $table_prefix ?>project_users` ADD COLUMN `can_assign_to_other` tinyint(1) unsigned NOT NULL DEFAULT '0';

ALTER TABLE `<?php echo $table_prefix ?>searchable_objects` CHANGE `object_manager_class` `rel_object_manager` varchar(50) NOT NULL;
ALTER TABLE `<?php echo $table_prefix ?>searchable_objects` CHANGE `object_id` `rel_object_id` int(10) NOT NULL DEFAULT '0';
ALTER TABLE `<?php echo $table_prefix ?>searchable_objects` DROP KEY `PRIMARY`, ADD PRIMARY KEY (`rel_object_manager`,`rel_object_id`,`column_name`);

ALTER TABLE `<?php echo $table_prefix ?>tags` CHANGE `object_id` `rel_object_id` int(10) NOT NULL DEFAULT '0';
ALTER TABLE `<?php echo $table_prefix ?>tags` CHANGE `object_manager_class` `rel_object_manager` varchar(50) NOT NULL;
ALTER TABLE `<?php echo $table_prefix ?>tags` DROP KEY `object_id`, ADD INDEX `object_id` (`rel_object_id`,`rel_object_manager`);

ALTER TABLE `<?php echo $table_prefix ?>users` MODIFY COLUMN `company_id` smallint(5) unsigned NOT NULL DEFAULT '0';
ALTER TABLE `<?php echo $table_prefix ?>users` MODIFY COLUMN `username` varchar(50) NOT NULL;
ALTER TABLE `<?php echo $table_prefix ?>users` ADD COLUMN `token` varchar(40) NOT NULL;
ALTER TABLE `<?php echo $table_prefix ?>users` ADD COLUMN `salt` varchar(13) NOT NULL;
ALTER TABLE `<?php echo $table_prefix ?>users` ADD COLUMN `twister` varchar(10) NOT NULL;
ALTER TABLE `<?php echo $table_prefix ?>users` MODIFY COLUMN `avatar_file` varchar(44);
ALTER TABLE `<?php echo $table_prefix ?>users` ADD COLUMN `timezone` float(3,1) NOT NULL DEFAULT '0.0';
ALTER TABLE `<?php echo $table_prefix ?>users` DROP COLUMN `password`;
ALTER TABLE `<?php echo $table_prefix ?>users` DROP KEY `session_id`;
ALTER TABLE `<?php echo $table_prefix ?>users` DROP COLUMN `session_id`;

DROP TABLE IF EXISTS `<?php echo $table_prefix ?>document_downloads`;

-- Modify existing tables or add tables with initial data;

DROP TABLE IF EXISTS `<?php echo $table_prefix ?>administration_tools`;

CREATE TABLE `<?php echo $table_prefix ?>administration_tools` (
  `id` tinyint(3) unsigned NOT NULL auto_increment,
  `name` varchar(50) <?php echo $default_collation ?> NOT NULL default '',
  `controller` varchar(50) <?php echo $default_collation ?> NOT NULL default '',
  `action` varchar(50) <?php echo $default_collation ?> NOT NULL default '',
  `order` tinyint(3) unsigned NOT NULL default '0',
  PRIMARY KEY  (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB <?php echo $default_charset ?>;

INSERT INTO `<?php echo $table_prefix ?>administration_tools` (`id`, `name`, `controller`, `action`, `order`) VALUES (1, 'test_mail_settings', 'administration', 'tool_test_email', 1);
INSERT INTO `<?php echo $table_prefix ?>administration_tools` (`id`, `name`, `controller`, `action`, `order`) VALUES (2, 'mass_mailer', 'administration', 'tool_mass_mailer', 2);

DROP TABLE IF EXISTS `<?php echo $table_prefix ?>config_categories`;

CREATE TABLE `<?php echo $table_prefix ?>config_categories` (
  `id` tinyint(3) unsigned NOT NULL auto_increment,
  `name` varchar(50) <?php echo $default_collation ?> NOT NULL default '',
  `is_system` tinyint(1) unsigned NOT NULL default '0',
  `category_order` tinyint(3) unsigned NOT NULL default '0',
  PRIMARY KEY  (`id`),
  UNIQUE KEY `name` (`name`),
  KEY `order` (`category_order`)
) ENGINE=InnoDB <?php echo $default_charset ?> COLLATE=utf8_unicode_ci;

INSERT INTO `<?php echo $table_prefix ?>config_categories` (`id`, `name`, `is_system`, `category_order`) VALUES (1, 'system', 1, 0);
INSERT INTO `<?php echo $table_prefix ?>config_categories` (`id`, `name`, `is_system`, `category_order`) VALUES (2, 'general', 0, 1);
INSERT INTO `<?php echo $table_prefix ?>config_categories` (`id`, `name`, `is_system`, `category_order`) VALUES (3, 'mailing', 0, 2);

DROP TABLE IF EXISTS `<?php echo $table_prefix ?>config_options`;

CREATE TABLE `<?php echo $table_prefix ?>config_options` (
  `id` smallint(5) unsigned NOT NULL auto_increment,
  `category_name` varchar(30) <?php echo $default_collation ?> NOT NULL default '',
  `name` varchar(50) <?php echo $default_collation ?> NOT NULL default '',
  `value` text <?php echo $default_collation ?>,
  `config_handler_class` varchar(50) <?php echo $default_collation ?> NOT NULL default '',
  `is_system` tinyint(1) unsigned NOT NULL default '0',
  `option_order` smallint(5) unsigned NOT NULL default '0',
  `dev_comment` varchar(255) <?php echo $default_collation ?> default NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `name` (`name`),
  KEY `order` (`option_order`),
  KEY `category_id` (`category_name`)
) ENGINE=InnoDB <?php echo $default_charset ?>;

INSERT INTO `<?php echo $table_prefix ?>config_options` (`id`, `category_name`, `name`, `value`, `config_handler_class`, `is_system`, `option_order`, `dev_comment`) VALUES (1, 'system', 'project_logs_per_page', '15', 'IntegerConfigHandler', 1, 0, NULL);
INSERT INTO `<?php echo $table_prefix ?>config_options` (`id`, `category_name`, `name`, `value`, `config_handler_class`, `is_system`, `option_order`, `dev_comment`) VALUES (2, 'system', 'messages_per_page', '5', 'IntegerConfigHandler', 1, 0, NULL);
INSERT INTO `<?php echo $table_prefix ?>config_options` (`id`, `category_name`, `name`, `value`, `config_handler_class`, `is_system`, `option_order`, `dev_comment`) VALUES (3, 'system', 'max_avatar_width', '50', 'IntegerConfigHandler', 1, 0, NULL);
INSERT INTO `<?php echo $table_prefix ?>config_options` (`id`, `category_name`, `name`, `value`, `config_handler_class`, `is_system`, `option_order`, `dev_comment`) VALUES (4, 'system', 'max_avatar_height', '50', 'IntegerConfigHandler', 1, 0, NULL);
INSERT INTO `<?php echo $table_prefix ?>config_options` (`id`, `category_name`, `name`, `value`, `config_handler_class`, `is_system`, `option_order`, `dev_comment`) VALUES (5, 'system', 'dashboard_logs_count', '15', 'IntegerConfigHandler', 1, 0, NULL);
INSERT INTO `<?php echo $table_prefix ?>config_options` (`id`, `category_name`, `name`, `value`, `config_handler_class`, `is_system`, `option_order`, `dev_comment`) VALUES (6, 'system', 'max_logo_width', '50', 'IntegerConfigHandler', 1, 0, NULL);
INSERT INTO `<?php echo $table_prefix ?>config_options` (`id`, `category_name`, `name`, `value`, `config_handler_class`, `is_system`, `option_order`, `dev_comment`) VALUES (7, 'system', 'max_logo_height', '50', 'IntegerConfigHandler', 1, 0, NULL);
INSERT INTO `<?php echo $table_prefix ?>config_options` (`id`, `category_name`, `name`, `value`, `config_handler_class`, `is_system`, `option_order`, `dev_comment`) VALUES (8, 'system', 'files_per_page', '10', 'IntegerConfigHandler', 1, 0, NULL);
INSERT INTO `<?php echo $table_prefix ?>config_options` (`id`, `category_name`, `name`, `value`, `config_handler_class`, `is_system`, `option_order`, `dev_comment`) VALUES (9, 'general', 'site_name', 'ProjectPier', 'StringConfigHandler', 0, 0, NULL);
INSERT INTO `<?php echo $table_prefix ?>config_options` (`id`, `category_name`, `name`, `value`, `config_handler_class`, `is_system`, `option_order`, `dev_comment`) VALUES (10, 'general', 'upgrade_last_check_datetime', '', 'DateTimeConfigHandler', 1, 0, 'Date and time of the last upgrade check');
INSERT INTO `<?php echo $table_prefix ?>config_options` (`id`, `category_name`, `name`, `value`, `config_handler_class`, `is_system`, `option_order`, `dev_comment`) VALUES (11, 'general', 'upgrade_last_check_new_version', '0', 'BoolConfigHandler', 1, 0, 'True if system checked for the new version and found it. This value is used to highlight upgrade tab in the administration');
INSERT INTO `<?php echo $table_prefix ?>config_options` (`id`, `category_name`, `name`, `value`, `config_handler_class`, `is_system`, `option_order`, `dev_comment`) VALUES (12, 'general', 'upgrade_check_enabled', '1', 'BoolConfigHandler', 0, 0, 'Upgrade check enabled / dissabled');
INSERT INTO `<?php echo $table_prefix ?>config_options` (`id`, `category_name`, `name`, `value`, `config_handler_class`, `is_system`, `option_order`, `dev_comment`) VALUES (13, 'general', 'file_storage_adapter', 'mysql', 'FileStorageConfigHandler', 0, 0, 'What storage adapter should be used? fs or mysql');
INSERT INTO `<?php echo $table_prefix ?>config_options` (`id`, `category_name`, `name`, `value`, `config_handler_class`, `is_system`, `option_order`, `dev_comment`) VALUES (14, 'general', 'default_project_folders', 'images\r\ndocuments\r\n\r\nother', 'TextConfigHandler', 0, 3, NULL);
INSERT INTO `<?php echo $table_prefix ?>config_options` (`id`, `category_name`, `name`, `value`, `config_handler_class`, `is_system`, `option_order`, `dev_comment`) VALUES (15, 'general', 'theme', 'default', 'ThemeConfigHandler', 0, 0, NULL);
INSERT INTO `<?php echo $table_prefix ?>config_options` (`id`, `category_name`, `name`, `value`, `config_handler_class`, `is_system`, `option_order`, `dev_comment`) VALUES (16, 'mailing', 'exchange_compatible', '0', 'BoolConfigHandler', 0, 0, NULL);
INSERT INTO `<?php echo $table_prefix ?>config_options` (`id`, `category_name`, `name`, `value`, `config_handler_class`, `is_system`, `option_order`, `dev_comment`) VALUES (17, 'mailing', 'mail_transport', 'mail()', 'MailTransportConfigHandler', 0, 0, 'Values: ''mail()'' - try to emulate mail() function, ''smtp'' - use SMTP connection');
INSERT INTO `<?php echo $table_prefix ?>config_options` (`id`, `category_name`, `name`, `value`, `config_handler_class`, `is_system`, `option_order`, `dev_comment`) VALUES (18, 'mailing', 'smtp_server', '', 'StringConfigHandler', 0, 0, '');
INSERT INTO `<?php echo $table_prefix ?>config_options` (`id`, `category_name`, `name`, `value`, `config_handler_class`, `is_system`, `option_order`, `dev_comment`) VALUES (19, 'mailing', 'smtp_port', '25', 'IntegerConfigHandler', 0, 0, NULL);
INSERT INTO `<?php echo $table_prefix ?>config_options` (`id`, `category_name`, `name`, `value`, `config_handler_class`, `is_system`, `option_order`, `dev_comment`) VALUES (20, 'mailing', 'smtp_authenticate', '0', 'BoolConfigHandler', 0, 0, 'Use SMTP authentication');
INSERT INTO `<?php echo $table_prefix ?>config_options` (`id`, `category_name`, `name`, `value`, `config_handler_class`, `is_system`, `option_order`, `dev_comment`) VALUES (21, 'mailing', 'smtp_username', '', 'StringConfigHandler', 0, 0, NULL);
INSERT INTO `<?php echo $table_prefix ?>config_options` (`id`, `category_name`, `name`, `value`, `config_handler_class`, `is_system`, `option_order`, `dev_comment`) VALUES (22, 'mailing', 'smtp_password', '', 'PasswordConfigHandler', 0, 0, NULL);
INSERT INTO `<?php echo $table_prefix ?>config_options` (`id`, `category_name`, `name`, `value`, `config_handler_class`, `is_system`, `option_order`, `dev_comment`) VALUES (23, 'mailing', 'smtp_secure_connection', 'no', 'SecureSmtpConnectionConfigHandler', 0, 0, 'Values: no, ssl, tls');
INSERT INTO `<?php echo $table_prefix ?>config_options` (`id`, `category_name`, `name`, `value`, `config_handler_class`, `is_system`, `option_order`, `dev_comment`) VALUES (24, 'system', 'feed_logs_count', '50', 'IntegerConfigHandler', 1, 0, 'Number of items in feeds');

DROP TABLE IF EXISTS `<?php echo $table_prefix ?>file_types`;

CREATE TABLE `<?php echo $table_prefix ?>file_types` (
  `id` smallint(5) unsigned NOT NULL auto_increment,
  `extension` varchar(10) <?php echo $default_collation ?> NOT NULL default '',
  `icon` varchar(30) <?php echo $default_collation ?> NOT NULL default '',
  `is_searchable` tinyint(1) unsigned NOT NULL default '0',
  `is_image` tinyint(1) unsigned NOT NULL default '0',
  PRIMARY KEY  (`id`),
  UNIQUE KEY `extension` (`extension`)
) ENGINE=InnoDB <?php echo $default_charset ?>;

INSERT INTO `<?php echo $table_prefix ?>file_types` (`id`, `extension`, `icon`, `is_searchable`, `is_image`) VALUES (1, 'zip', 'archive.png', 0, 0);
INSERT INTO `<?php echo $table_prefix ?>file_types` (`id`, `extension`, `icon`, `is_searchable`, `is_image`) VALUES (2, 'rar', 'archive.png', 0, 0);
INSERT INTO `<?php echo $table_prefix ?>file_types` (`id`, `extension`, `icon`, `is_searchable`, `is_image`) VALUES (3, 'bz', 'archive.png', 0, 0);
INSERT INTO `<?php echo $table_prefix ?>file_types` (`id`, `extension`, `icon`, `is_searchable`, `is_image`) VALUES (4, 'bz2', 'archive.png', 0, 0);
INSERT INTO `<?php echo $table_prefix ?>file_types` (`id`, `extension`, `icon`, `is_searchable`, `is_image`) VALUES (5, 'gz', 'archive.png', 0, 0);
INSERT INTO `<?php echo $table_prefix ?>file_types` (`id`, `extension`, `icon`, `is_searchable`, `is_image`) VALUES (6, 'ace', 'archive.png', 0, 0);
INSERT INTO `<?php echo $table_prefix ?>file_types` (`id`, `extension`, `icon`, `is_searchable`, `is_image`) VALUES (7, 'mp3', 'audio.png', 0, 0);
INSERT INTO `<?php echo $table_prefix ?>file_types` (`id`, `extension`, `icon`, `is_searchable`, `is_image`) VALUES (8, 'wma', 'audio.png', 0, 0);
INSERT INTO `<?php echo $table_prefix ?>file_types` (`id`, `extension`, `icon`, `is_searchable`, `is_image`) VALUES (9, 'ogg', 'audio.png', 0, 0);
INSERT INTO `<?php echo $table_prefix ?>file_types` (`id`, `extension`, `icon`, `is_searchable`, `is_image`) VALUES (10, 'doc', 'doc.png', 0, 0);
INSERT INTO `<?php echo $table_prefix ?>file_types` (`id`, `extension`, `icon`, `is_searchable`, `is_image`) VALUES (11, 'xsl', 'doc.png', 0, 0);
INSERT INTO `<?php echo $table_prefix ?>file_types` (`id`, `extension`, `icon`, `is_searchable`, `is_image`) VALUES (12, 'gif', 'image.png', 0, 1);
INSERT INTO `<?php echo $table_prefix ?>file_types` (`id`, `extension`, `icon`, `is_searchable`, `is_image`) VALUES (13, 'jpg', 'image.png', 0, 1);
INSERT INTO `<?php echo $table_prefix ?>file_types` (`id`, `extension`, `icon`, `is_searchable`, `is_image`) VALUES (14, 'jpeg', 'image.png', 0, 1);
INSERT INTO `<?php echo $table_prefix ?>file_types` (`id`, `extension`, `icon`, `is_searchable`, `is_image`) VALUES (15, 'png', 'image.png', 0, 1);
INSERT INTO `<?php echo $table_prefix ?>file_types` (`id`, `extension`, `icon`, `is_searchable`, `is_image`) VALUES (16, 'mov', 'mov.png', 0, 0);
INSERT INTO `<?php echo $table_prefix ?>file_types` (`id`, `extension`, `icon`, `is_searchable`, `is_image`) VALUES (17, 'pdf', 'pdf.png', 0, 0);
INSERT INTO `<?php echo $table_prefix ?>file_types` (`id`, `extension`, `icon`, `is_searchable`, `is_image`) VALUES (18, 'psd', 'psd.png', 0, 0);
INSERT INTO `<?php echo $table_prefix ?>file_types` (`id`, `extension`, `icon`, `is_searchable`, `is_image`) VALUES (19, 'rm', 'rm.png', 0, 0);
INSERT INTO `<?php echo $table_prefix ?>file_types` (`id`, `extension`, `icon`, `is_searchable`, `is_image`) VALUES (20, 'svg', 'svg.png', 0, 0);
INSERT INTO `<?php echo $table_prefix ?>file_types` (`id`, `extension`, `icon`, `is_searchable`, `is_image`) VALUES (21, 'swf', 'swf.png', 0, 0);
INSERT INTO `<?php echo $table_prefix ?>file_types` (`id`, `extension`, `icon`, `is_searchable`, `is_image`) VALUES (22, 'avi', 'video.png', 0, 0);
INSERT INTO `<?php echo $table_prefix ?>file_types` (`id`, `extension`, `icon`, `is_searchable`, `is_image`) VALUES (23, 'mpeg', 'video.png', 0, 0);
INSERT INTO `<?php echo $table_prefix ?>file_types` (`id`, `extension`, `icon`, `is_searchable`, `is_image`) VALUES (24, 'mpg', 'video.png', 0, 0);
INSERT INTO `<?php echo $table_prefix ?>file_types` (`id`, `extension`, `icon`, `is_searchable`, `is_image`) VALUES (25, 'qt', 'mov.png', 0, 0);
INSERT INTO `<?php echo $table_prefix ?>file_types` (`id`, `extension`, `icon`, `is_searchable`, `is_image`) VALUES (26, 'vob', 'video.png', 0, 0);
INSERT INTO `<?php echo $table_prefix ?>file_types` (`id`, `extension`, `icon`, `is_searchable`, `is_image`) VALUES (27, 'txt', 'doc.png', 1, 0);

DROP TABLE IF EXISTS `<?php echo $table_prefix ?>im_types`;

CREATE TABLE `<?php echo $table_prefix ?>im_types` (
  `id` tinyint(3) unsigned NOT NULL auto_increment,
  `name` varchar(30) <?php echo $default_collation ?> NOT NULL default '',
  `icon` varchar(30) <?php echo $default_collation ?> NOT NULL default '',
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB <?php echo $default_charset ?>;

INSERT INTO `<?php echo $table_prefix ?>im_types` (`id`, `name`, `icon`) VALUES (1, 'ICQ', 'icq.gif');
INSERT INTO `<?php echo $table_prefix ?>im_types` (`id`, `name`, `icon`) VALUES (2, 'AIM', 'aim.gif');
INSERT INTO `<?php echo $table_prefix ?>im_types` (`id`, `name`, `icon`) VALUES (3, 'MSN', 'msn.gif');
INSERT INTO `<?php echo $table_prefix ?>im_types` (`id`, `name`, `icon`) VALUES (4, 'Yahoo!', 'yahoo.gif');
INSERT INTO `<?php echo $table_prefix ?>im_types` (`id`, `name`, `icon`) VALUES (5, 'Skype', 'skype.gif');
INSERT INTO `<?php echo $table_prefix ?>im_types` (`id`, `name`, `icon`) VALUES (6, 'Jabber', 'jabber.gif');