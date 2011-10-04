--
-- Script to upgrade database from 0.8.0.3 to 0.8.6
--

-- create

CREATE TABLE `<?php echo $table_prefix ?>plugins` (
  `plugin_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `installed` tinyint(1) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`plugin_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE `<?php echo $table_prefix ?>permissions` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `source` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `permission` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE `<?php echo $table_prefix ?>project_user_permissions` (
  `user_id` int(10) unsigned NOT NULL,
  `project_id` int(10) unsigned NOT NULL,
  `permission_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`user_id`,`project_id`,`permission_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- alter

ALTER TABLE `<?php echo $table_prefix ?>project_file_revisions` ADD `filename` VARCHAR( 100 ) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL default '' AFTER `repository_id`;
ALTER TABLE `<?php echo $table_prefix ?>project_tasks` ADD `due_date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' AFTER `text`;
ALTER TABLE `<?php echo $table_prefix ?>project_task_lists` ADD `priority` INT( 3 ) NOT NULL DEFAULT '0' AFTER `name`;
ALTER TABLE `<?php echo $table_prefix ?>project_task_lists` ADD `due_date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' AFTER `description`;
ALTER TABLE `<?php echo $table_prefix ?>projects` ADD `priority` INT( 3 ) NOT NULL DEFAULT '0' AFTER `name`;
ALTER TABLE `<?php echo $table_prefix ?>projects` ADD `logo_file` VARCHAR( 44 ) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL AFTER `show_description_in_overview`;
ALTER TABLE `<?php echo $table_prefix ?>project_users` ADD `role_id` INT( 10 ) NOT NULL DEFAULT '0' AFTER `user_id`;
ALTER TABLE `<?php echo $table_prefix ?>users` ADD `homepage` VARCHAR( 100 ) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL default '' AFTER `email`;
ALTER TABLE `<?php echo $table_prefix ?>users` ADD `use_LDAP` TINYINT( 1 ) UNSIGNED NOT NULL DEFAULT '0' AFTER `auto_assign`;
ALTER TABLE `<?php echo $table_prefix ?>users` ADD `use_gravatar` TINYINT( 1 ) UNSIGNED NOT NULL DEFAULT '0' AFTER `avatar_file`;
ALTER TABLE `<?php echo $table_prefix ?>project_file_revisions` CHANGE `type_string` `type_string` VARCHAR( 140 ) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL;
ALTER TABLE `<?php echo $table_prefix ?>users` DROP INDEX `email` , ADD INDEX `email` ( `email` ) 

-- convert

INSERT INTO `<?php echo $table_prefix ?>project_user_permissions` ( user_id, project_id, permission_id )
  (
     SELECT user_id, project_id, ( select id from `<?php echo $table_prefix ?>permissions` where source = 'files' and permission = 'manage' ) 
     from `<?php echo $table_prefix ?>project_users` WHERE can_manage_files = 1
  )
  UNION
  (
     SELECT user_id, project_id, ( select id from `<?php echo $table_prefix ?>permissions` where source = 'files' and permission = 'upload' ) 
     from `<?php echo $table_prefix ?>project_users` WHERE can_upload_files = 1
  )
  UNION
  (
     SELECT user_id, project_id, ( select id from `<?php echo $table_prefix ?>permissions` where source = 'milestones' and permission = 'manage' ) 
     from `<?php echo $table_prefix ?>project_users` WHERE can_manage_milestones = 1
  )  
  UNION
  (
     SELECT user_id, project_id, ( select id from `<?php echo $table_prefix ?>permissions` where source = 'messages' and permission = 'manage' ) 
     from `<?php echo $table_prefix ?>project_users` WHERE can_manage_messages = 1
  )
  UNION
  (
     SELECT user_id, project_id, ( select id from `<?php echo $table_prefix ?>permissions` where source = 'tasks' and permission = 'manage' ) 
     from `<?php echo $table_prefix ?>project_users` WHERE can_manage_tasks = 1
  )
  UNION
  (
     SELECT user_id, project_id, ( select id from `<?php echo $table_prefix ?>permissions` where source = 'tasks' and permission = 'assign to other clients' ) 
     from `<?php echo $table_prefix ?>project_users` WHERE can_assign_to_other = 1
  )
  UNION
  (
     SELECT user_id, project_id, ( select id from `<?php echo $table_prefix ?>permissions` where source = 'tasks' and permission = 'assign to owner company' ) 
     from `<?php echo $table_prefix ?>project_users` WHERE can_assign_to_owners = 1
  )
;

-- drop

ALTER TABLE `<?php echo $table_prefix ?>project_users` 
DROP `can_manage_messages` ,
DROP `can_manage_tasks` ,
DROP `can_manage_milestones` ,
DROP `can_upload_files` ,
DROP `can_manage_files` ,
DROP `can_assign_to_owners` ,
DROP `can_assign_to_other` ;

-- insert

INSERT INTO `<?php echo $table_prefix ?>config_categories` (`name`, `is_system`, `category_order`) VALUES ('features', 0, 3);
INSERT INTO `<?php echo $table_prefix ?>config_categories` (`name`, `is_system`, `category_order`) VALUES ('database', 0, 9);
INSERT INTO `<?php echo $table_prefix ?>config_categories` (`name`, `is_system`, `category_order`) VALUES ('tickets', 0, 4);

INSERT INTO `<?php echo $table_prefix ?>config_options` (`category_name`, `name`, `value`, `config_handler_class`, `is_system`, `option_order`, `dev_comment`) VALUES ('general', 'calendar_first_day_of_week', '1', 'DayOfWeekConfigHandler', 0, 0, NULL);

DELETE FROM `<?php echo $table_prefix ?>config_options`  WHERE `category_name` = 'general' AND `name` = 'theme';
INSERT INTO `<?php echo $table_prefix ?>config_options` (`category_name`, `name`, `value`, `config_handler_class`, `is_system`, `option_order`, `dev_comment`) VALUES ('general', 'theme', 'marine', 'ThemeConfigHandler', 0, 0, NULL);
INSERT INTO `<?php echo $table_prefix ?>config_options` (`category_name`, `name`, `value`, `config_handler_class`, `is_system`, `option_order`, `dev_comment`) VALUES ('general', 'logout_redirect_page', 'default', 'StringConfigHandler', '0', '0', 'Logout Redirect mod by Alex: Redirect to a set page upon logout');

INSERT INTO `<?php echo $table_prefix ?>config_options` (`category_name`, `name`, `value`, `config_handler_class`, `is_system`, `option_order`, `dev_comment`) VALUES ('mailing', 'mail_use_reply_to', '0', 'BoolConfigHandler', 0, 11, 'Enable to use Reply-To header in mails');
INSERT INTO `<?php echo $table_prefix ?>config_options` (`category_name`, `name`, `value`, `config_handler_class`, `is_system`, `option_order`, `dev_comment`) VALUES ('mailing', 'mail_from', '', 'StringConfigHandler', 0, 12, 'The From address in every mail sent out');

INSERT INTO `<?php echo $table_prefix ?>config_options` (`category_name`, `name`, `value`, `config_handler_class`, `is_system`, `option_order`, `dev_comment`) VALUES ('general', 'ldap_host', '', 'StringConfigHandler', 0, 0, NULL);
INSERT INTO `<?php echo $table_prefix ?>config_options` (`category_name`, `name`, `value`, `config_handler_class`, `is_system`, `option_order`, `dev_comment`) VALUES ('general', 'ldap_domain', '', 'StringConfigHandler', 0, 0, NULL);
INSERT INTO `<?php echo $table_prefix ?>config_options` (`category_name`, `name`, `value`, `config_handler_class`, `is_system`, `option_order`, `dev_comment`) VALUES ('general', 'ldap_secure_connection', 'no', 'SecureLDAPConnectionConfigHandler', 0, 0, 'Values: no, tls');

INSERT INTO `<?php echo $table_prefix ?>config_options` (`category_name`, `name`, `value`, `config_handler_class`, `is_system`, `option_order`, `dev_comment`) VALUES ('features', 'per_project_activity_logs', '0', 'BoolConfigHandler', 0, 0, 'Show recent activity logs per project on the owner company dashboard (like BaseCamp) rather than all mashed together');
INSERT INTO `<?php echo $table_prefix ?>config_options` (`category_name`, `name`, `value`, `config_handler_class`, `is_system`, `option_order`, `dev_comment`) VALUES ('features', 'logs_show_icons', '1', 'BoolConfigHandler', 0, 0, 'Show file icons');
INSERT INTO `<?php echo $table_prefix ?>config_options` (`category_name`, `name`, `value`, `config_handler_class`, `is_system`, `option_order`, `dev_comment`) VALUES ('features', 'files_show_icons', '1', 'BoolConfigHandler', 0, 0, 'Show file icons');
INSERT INTO `<?php echo $table_prefix ?>config_options` (`category_name`, `name`, `value`, `config_handler_class`, `is_system`, `option_order`, `dev_comment`) VALUES ('features', 'files_show_thumbnails', '1', 'BoolConfigHandler', 0, 0, 'Show file thumbnails');
INSERT INTO `<?php echo $table_prefix ?>config_options` (`category_name`, `name`, `value`, `config_handler_class`, `is_system`, `option_order`, `dev_comment`) VALUES ('general', 'categories_per_page', '25', 'IntegerConfigHandler', 0, 0, NULL);
INSERT INTO `<?php echo $table_prefix ?>config_options` (`category_name`, `name`, `value`, `config_handler_class`, `is_system`, `option_order`, `dev_comment`) VALUES ('features', 'default_private', '1', 'BoolConfigHandler', 0, 0, 'Default setting for private option');

INSERT INTO `<?php echo $table_prefix ?>config_options` (`category_name`, `name`, `value`, `config_handler_class`, `is_system`, `option_order`, `dev_comment`) VALUES ('general', 'installation_root', '/', 'StringConfigHandler', 0, 0, NULL);
INSERT INTO `<?php echo $table_prefix ?>config_options` (`category_name`, `name`, `value`, `config_handler_class`, `is_system`, `option_order`, `dev_comment`) VALUES ('general', 'check_email_unique', '0', 'BoolConfigHandler', 0, 0, 'True if emails should be unique when adding/editing a user');
INSERT INTO `<?php echo $table_prefix ?>config_options` (`category_name`, `name`, `value`, `config_handler_class`, `is_system`, `option_order`, `dev_comment`) VALUES ('database', 'character_set', 'utf8', 'StringConfigHandler', 0, 0, 'Standard SQL character set (e.g. utf8, latin1)');
INSERT INTO `<?php echo $table_prefix ?>config_options` (`category_name`, `name`, `value`, `config_handler_class`, `is_system`, `option_order`, `dev_comment`) VALUES ('database', 'collation', 'utf8_unicode_ci', 'StringConfigHandler', 0, 0, 'Standard SQL collate value (e.g. latin1_bin, utf8_bin, utf8_unicode_ci)');
INSERT INTO `<?php echo $table_prefix ?>config_options` (`category_name`, `name`, `value`, `config_handler_class`, `is_system`, `option_order`, `dev_comment`) VALUES ('general', 'session_lifetime', '3600', 'IntegerConfigHandler', 0, 24, '');
INSERT INTO `<?php echo $table_prefix ?>config_options` (`category_name`, `name`, `value`, `config_handler_class`, `is_system`, `option_order`, `dev_comment`) VALUES ('general', 'remember_login_lifetime', '1209600', 'IntegerConfigHandler', 0, 24, '');
INSERT INTO `<?php echo $table_prefix ?>config_options` (`category_name`, `name`, `value`, `config_handler_class`, `is_system`, `option_order`, `dev_comment`) VALUES ('general', 'default_controller', 'dashboard', 'StringConfigHandler', 0, 25, '');
INSERT INTO `<?php echo $table_prefix ?>config_options` (`category_name`, `name`, `value`, `config_handler_class`, `is_system`, `option_order`, `dev_comment`) VALUES ('general', 'default_action', 'index', 'StringConfigHandler', 0, 26, '');
INSERT INTO `<?php echo $table_prefix ?>config_options` (`category_name`, `name`, `value`, `config_handler_class`, `is_system`, `option_order`, `dev_comment`) VALUES ('system', 'product_name', 'ProjectPier', 'StringConfigHandler', 1, 0, NULL);
INSERT INTO `<?php echo $table_prefix ?>config_options` (`category_name`, `name`, `value`, `config_handler_class`, `is_system`, `option_order`, `dev_comment`) VALUES ('system', 'product_version', '0.8.6', 'StringConfigHandler', 1, 0, NULL);
INSERT INTO `<?php echo $table_prefix ?>config_options` (`category_name`, `name`, `value`, `config_handler_class`, `is_system`, `option_order`, `dev_comment`) VALUES ('tickets', 'tickets_default_categories', 'information request\r\nchange request\r\nincident report\r\ncomplaint\r\ndefect report\r\ngeneral/other', 'TextConfigHandler', 0, 3, NULL);