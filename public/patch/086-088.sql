CREATE TABLE `{$tp}contacts` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `company_id` int(10) unsigned NOT NULL DEFAULT '0',
  `user_id` int(10) unsigned NOT NULL DEFAULT '0',
  `email` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `display_name` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `title` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `avatar_file` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `use_gravatar` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `is_favorite` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `timezone` float(4,2) NOT NULL DEFAULT '0.00',
  `office_number` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `fax_number` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `mobile_number` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `home_number` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_on` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `created_by_id` int(10) unsigned DEFAULT NULL,
  `updated_on` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_by_id` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `email` (`email`),
  KEY `company_id` (`company_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE `{$tp}contact_im_values` (
  `contact_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `im_type_id` int(10) unsigned NOT NULL DEFAULT '0',
  `im_value` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `is_default` tinyint(1) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`contact_id`,`im_type_id`),
  KEY `im_value` (`im_value`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE `{$tp}page_attachments` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `rel_object_id` int(10) unsigned DEFAULT NULL,
  `rel_object_manager` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `project_id` int(10) unsigned NOT NULL,
  `page_name` varchar(50) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `text` text COLLATE utf8_unicode_ci NOT NULL,
  `order` tinyint(3) NOT NULL DEFAULT '0',
  `created_on` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `created_by_id` int(10) unsigned DEFAULT NULL,
  `updated_on` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_by_id` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

ALTER TABLE `{$tp}companies` ADD `description` text COLLATE utf8_unicode_ci AFTER `name`;
ALTER TABLE `{$tp}companies` ADD `is_favorite` tinyint(1) unsigned not null default '0' AFTER `timezone`;
ALTER TABLE `{$tp}project_tickets` ADD `due_date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' AFTER `is_private`;
ALTER TABLE `{$tp}project_users` ADD `note` text CHARACTER SET utf8 COLLATE utf8_unicode_ci AFTER `user_id`;
ALTER TABLE `{$tp}wiki_pages` ADD `publish` tinyint(1) unsigned DEFAULT '0';
ALTER TABLE `{$tp}projects` ADD `parent_id` int(10) unsigned not null default '0' AFTER `name`;
ALTER TABLE `{$tp}users` ADD `updated_by_id` int(10) unsigned DEFAULT NULL AFTER `updated_on`;
ALTER TABLE `{$tp}project_tickets` ADD `milestone_id` int(10) unsigned not null default '0' AFTER `project_id`;
ALTER TABLE `{$tp}project_folders` ADD `parent_id` int(10) unsigned not null default '0' AFTER `name`;
ALTER TABLE `{$tp}project_links` ADD `description` text CHARACTER SET utf8 COLLATE utf8_unicode_ci AFTER `url`;
ALTER TABLE `{$tp}project_links` ADD `folder_id` int(10) unsigned not null default '0' AFTER `url`;
ALTER TABLE `{$tp}project_links` ADD `logo_file` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT '' AFTER `description`;
ALTER TABLE `{$tp}project_task_lists` ADD `score` int(3) unsigned not null default '0' AFTER `due_date`;
ALTER TABLE `{$tp}project_task_lists` ADD `start_date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' AFTER `description`;
ALTER TABLE `{$tp}project_tasks` ADD `start_date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' AFTER `text`;
ALTER TABLE `{$tp}project_milestones` ADD `goal` int(3) unsigned not null default '0' AFTER `assigned_to_company_id`;
ALTER TABLE `{$tp}file_repo` ADD `seq` int(10) unsigned not null default '0' AFTER `id`;
ALTER TABLE `{$tp}file_repo` DROP PRIMARY KEY, ADD PRIMARY KEY(`id`,`seq`);

ALTER TABLE `{$tp}administration_tools` CHANGE `id` `id` int(10) unsigned NOT NULL AUTO_INCREMENT;
ALTER TABLE `{$tp}comments` CHANGE `rel_object_manager`  `rel_object_manager` varchar(50);
ALTER TABLE `{$tp}companies` CHANGE `client_of_id` `client_of_id` int(10) unsigned;
ALTER TABLE `{$tp}companies` CHANGE `country`  `country` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL;
ALTER TABLE `{$tp}companies` CHANGE `fax_number`  `fax_number` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL;
ALTER TABLE `{$tp}companies` CHANGE `id` `id` int(10) unsigned NOT NULL AUTO_INCREMENT;
ALTER TABLE `{$tp}companies` CHANGE `logo_file`  `logo_file` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL;
ALTER TABLE `{$tp}companies` CHANGE `phone_number`  `phone_number` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL;
ALTER TABLE `{$tp}companies` CHANGE `fax_number`  `fax_number` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL;
ALTER TABLE `{$tp}companies` CHANGE `timezone`  `timezone` float(4,2) default '0.00';
ALTER TABLE `{$tp}companies` CHANGE `zipcode`  `zipcode` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL;
ALTER TABLE `{$tp}config_categories` CHANGE `id` `id` int(10) unsigned NOT NULL AUTO_INCREMENT;
ALTER TABLE `{$tp}config_options` CHANGE `category_name`  `category_name` varchar(50);
ALTER TABLE `{$tp}config_options` CHANGE `id` `id` int(10) unsigned NOT NULL AUTO_INCREMENT;
ALTER TABLE `{$tp}config_options` CHANGE `option_order` `option_order` tinyint(3) unsigned;
ALTER TABLE `{$tp}file_repo_attributes` CHANGE `id`  `id` varchar(50);
ALTER TABLE `{$tp}file_repo` CHANGE `id`  `id` varchar(50);
ALTER TABLE `{$tp}file_types` CHANGE `icon`  `icon` varchar(50);
ALTER TABLE `{$tp}file_types` CHANGE `id` `id` int(10) unsigned NOT NULL AUTO_INCREMENT;
ALTER TABLE `{$tp}im_types` CHANGE `icon`  `icon` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL;
ALTER TABLE `{$tp}im_types` CHANGE `id` `id` int(10) unsigned NOT NULL AUTO_INCREMENT;
ALTER TABLE `{$tp}im_types` CHANGE `name`  `name` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL;
ALTER TABLE `{$tp}project_categories` CHANGE `description`  `description` varchar(50);
ALTER TABLE `{$tp}project_categories` CHANGE `name`  `name` varchar(50);
ALTER TABLE `{$tp}project_companies` CHANGE `company_id` `company_id` int(10) unsigned;
ALTER TABLE `{$tp}project_folders` CHANGE `id` `id` int(10) unsigned NOT NULL AUTO_INCREMENT;
ALTER TABLE `{$tp}project_forms` CHANGE `id` `id` int(10) unsigned NOT NULL AUTO_INCREMENT;
ALTER TABLE `{$tp}project_forms` CHANGE `order` `order` tinyint(3) unsigned;
ALTER TABLE `{$tp}project_links` CHANGE `title`  `title` varchar(50);
ALTER TABLE `{$tp}project_milestones` CHANGE `assigned_to_company_id` `assigned_to_company_id` int(10);
ALTER TABLE `{$tp}project_tasks` CHANGE `assigned_to_company_id` `assigned_to_company_id` int(10);
ALTER TABLE `{$tp}project_ticket_changes` CHANGE `id` `id` int(10) unsigned NOT NULL AUTO_INCREMENT;
ALTER TABLE `{$tp}project_ticket_changes` CHANGE `ticket_id` `ticket_id` int(10) unsigned;
ALTER TABLE `{$tp}project_ticket_changes` CHANGE `type` `type` enum('milestone','status','priority','assigned to','summary','category','type','private','comment','attachment','');
ALTER TABLE `{$tp}project_tickets` CHANGE `assigned_to_company_id` `assigned_to_company_id` int(10) unsigned;
ALTER TABLE `{$tp}project_tickets` CHANGE `summary`  `summary` varchar(255);
ALTER TABLE `{$tp}project_users` CHANGE `created_by_id` `created_by_id` int(10) unsigned DEFAULT NULL;
ALTER TABLE `{$tp}project_users` CHANGE `created_on` `created_on` datetime NOT NULL DEFAULT '0000-00-00 00:00:00';
ALTER TABLE `{$tp}tags` CHANGE `tag`  `tag` varchar(50);
ALTER TABLE `{$tp}users` CHANGE `salt`  `salt` varchar(50);
ALTER TABLE `{$tp}users` CHANGE `token`  `token` varchar(50);

ALTER TABLE `{$tp}project_file_revisions` CONVERT TO CHARACTER SET utf8 COLLATE utf8_unicode_ci;
ALTER TABLE `{$tp}project_tickets` CONVERT TO CHARACTER SET utf8 COLLATE utf8_unicode_ci;
ALTER TABLE `{$tp}project_times` CONVERT TO CHARACTER SET utf8 COLLATE utf8_unicode_ci;
ALTER TABLE `{$tp}project_files` CONVERT TO CHARACTER SET utf8 COLLATE utf8_unicode_ci;
ALTER TABLE `{$tp}tags` CONVERT TO CHARACTER SET utf8 COLLATE utf8_unicode_ci;
ALTER TABLE `{$tp}wiki_pages` CONVERT TO CHARACTER SET utf8 COLLATE utf8_unicode_ci;
ALTER TABLE `{$tp}wiki_revisions` CONVERT TO CHARACTER SET utf8 COLLATE utf8_unicode_ci;
ALTER TABLE `{$tp}project_categories` CONVERT TO CHARACTER SET utf8 COLLATE utf8_unicode_ci;
ALTER TABLE `{$tp}project_folders` CONVERT TO CHARACTER SET utf8 COLLATE utf8_unicode_ci;
ALTER TABLE `{$tp}project_links` CONVERT TO CHARACTER SET utf8 COLLATE utf8_unicode_ci;
ALTER TABLE `{$tp}project_ticket_changes` CONVERT TO CHARACTER SET utf8 COLLATE utf8_unicode_ci;
ALTER TABLE `{$tp}project_ticket_subscriptions` CONVERT TO CHARACTER SET utf8 COLLATE utf8_unicode_ci;

INSERT INTO `{$tp}contacts`  (
  `id`,
  `company_id`, 
  `user_id`,
  `email`, 
  `display_name`,
  `title`,
  `avatar_file`,
  `use_gravatar`,
  `is_favorite`,
  `timezone`,
  `office_number`,
  `fax_number`,
  `mobile_number`,
  `home_number`,
  `created_on`,
  `created_by_id`,
  `updated_on`,
  `updated_by_id` 
)
SELECT
  `id`,
  `company_id`, 
  `id`,
  `email`, 
  `display_name`,
  `title`,
  `avatar_file`,
  `use_gravatar`,
  0,
  `timezone`,
  `office_number`,
  `fax_number`,
  `mobile_number`,
  `home_number`,
  `created_on`,
  `created_by_id`,
  `updated_on`,
  `created_by_id`
FROM `{$tp}users`;

INSERT INTO `{$tp}contact_im_values`  (
  `contact_id`,
  `im_type_id`,
  `im_value`,
  `is_default`
)
SELECT
  `user_id`,
  `im_type_id`,
  `value`,
  `is_default`
FROM `{$tp}user_im_values` ;

ALTER TABLE `{$tp}users` DROP `company_id`;
ALTER TABLE `{$tp}users` DROP `homepage`;
ALTER TABLE `{$tp}users` DROP `display_name`;
ALTER TABLE `{$tp}users` DROP `title`;
ALTER TABLE `{$tp}users` DROP `avatar_file`;
ALTER TABLE `{$tp}users` DROP `use_gravatar`;
ALTER TABLE `{$tp}users` DROP `office_number`;
ALTER TABLE `{$tp}users` DROP `fax_number`;
ALTER TABLE `{$tp}users` DROP `mobile_number`;
ALTER TABLE `{$tp}users` DROP `home_number`;
ALTER TABLE `{$tp}users` DROP `timezone`;

DROP TABLE `{$tp}user_im_values`;

INSERT INTO `<?php echo $table_prefix ?>permissions` (`id`, `source`, `permission`) VALUES (1, 'files', 'manage') ON DUPLICATE KEY UPDATE `id`=`id`;
INSERT INTO `<?php echo $table_prefix ?>permissions` (`id`, `source`, `permission`) VALUES (2, 'files', 'upload') ON DUPLICATE KEY UPDATE `id`=`id`;
INSERT INTO `<?php echo $table_prefix ?>permissions` (`id`, `source`, `permission`) VALUES (3, 'milestones', 'manage') ON DUPLICATE KEY UPDATE `id`=`id`;
INSERT INTO `<?php echo $table_prefix ?>permissions` (`id`, `source`, `permission`) VALUES (4, 'messages', 'manage') ON DUPLICATE KEY UPDATE `id`=`id`;
INSERT INTO `<?php echo $table_prefix ?>permissions` (`id`, `source`, `permission`) VALUES (5, 'tasks', 'manage') ON DUPLICATE KEY UPDATE `id`=`id`;
INSERT INTO `<?php echo $table_prefix ?>permissions` (`id`, `source`, `permission`) VALUES (6, 'tasks', 'assign to other clients') ON DUPLICATE KEY UPDATE `id`=`id`;
INSERT INTO `<?php echo $table_prefix ?>permissions` (`id`, `source`, `permission`) VALUES (7, 'tasks', 'assign to owner company') ON DUPLICATE KEY UPDATE `id`=`id`;
INSERT INTO `<?php echo $table_prefix ?>permissions` (`id`, `source`, `permission`) VALUES (8, 'tickets', 'manage') ON DUPLICATE KEY UPDATE `id`=`id`;
INSERT INTO `<?php echo $table_prefix ?>permissions` (`id`, `source`, `permission`) VALUES (9, 'projects', 'manage') ON DUPLICATE KEY UPDATE `id`=`id`;
INSERT INTO `<?php echo $table_prefix ?>permissions` (`id`, `source`, `permission`) VALUES (10, 'milestones', 'change status') ON DUPLICATE KEY UPDATE `id`=`id`;
INSERT INTO `<?php echo $table_prefix ?>permissions` (`id`, `source`, `permission`) VALUES (11, 'times', 'manage') ON DUPLICATE KEY UPDATE `id`=`id`;
INSERT INTO `<?php echo $table_prefix ?>permissions` (`id`, `source`, `permission`) VALUES (12, 'tasks', 'edit score') ON DUPLICATE KEY UPDATE `id`=`id`;
INSERT INTO `<?php echo $table_prefix ?>permissions` (`id`, `source`, `permission`) VALUES (13, 'milestones', 'edit goal') ON DUPLICATE KEY UPDATE `id`=`id`;
INSERT INTO `<?php echo $table_prefix ?>permissions` (`id`, `source`, `permission`) VALUES (14, 'messages', 'access') ON DUPLICATE KEY UPDATE `id`=`id`;
INSERT INTO `<?php echo $table_prefix ?>permissions` (`id`, `source`, `permission`) VALUES (15, 'tasks', 'access') ON DUPLICATE KEY UPDATE `id`=`id`;
INSERT INTO `<?php echo $table_prefix ?>permissions` (`id`, `source`, `permission`) VALUES (16, 'files', 'access') ON DUPLICATE KEY UPDATE `id`=`id`;
INSERT INTO `<?php echo $table_prefix ?>permissions` (`id`, `source`, `permission`) VALUES (17, 'forms', 'access') ON DUPLICATE KEY UPDATE `id`=`id`;
INSERT INTO `<?php echo $table_prefix ?>permissions` (`id`, `source`, `permission`) VALUES (18, 'wiki', 'access') ON DUPLICATE KEY UPDATE `id`=`id`;
INSERT INTO `<?php echo $table_prefix ?>permissions` (`id`, `source`, `permission`) VALUES (19, 'wiki', 'manage') ON DUPLICATE KEY UPDATE `id`=`id`;
INSERT INTO `<?php echo $table_prefix ?>permissions` (`id`, `source`, `permission`) VALUES (20, 'projects', 'access') ON DUPLICATE KEY UPDATE `id`=`id`;
INSERT INTO `<?php echo $table_prefix ?>permissions` (`id`, `source`, `permission`) VALUES (21, 'contacts', 'access') ON DUPLICATE KEY UPDATE `id`=`id`;
INSERT INTO `<?php echo $table_prefix ?>permissions` (`id`, `source`, `permission`) VALUES (22, 'contacts', 'manage') ON DUPLICATE KEY UPDATE `id`=`id`;
INSERT INTO `<?php echo $table_prefix ?>permissions` (`id`, `source`, `permission`) VALUES (23, 'search', 'access') ON DUPLICATE KEY UPDATE `id`=`id`;
INSERT INTO `<?php echo $table_prefix ?>permissions` (`id`, `source`, `permission`) VALUES (24, 'tags', 'access') ON DUPLICATE KEY UPDATE `id`=`id`;
INSERT INTO `<?php echo $table_prefix ?>permissions` (`id`, `source`, `permission`) VALUES (25, 'reports', 'access') ON DUPLICATE KEY UPDATE `id`=`id`;

INSERT INTO `<?php echo $table_prefix ?>administration_tools` (`name`, `controller`, `action`, `order`) VALUES ('system_info', 'administration', 'system_info', 3) ON DUPLICATE KEY UPDATE `id`=`id`;
INSERT INTO `<?php echo $table_prefix ?>administration_tools` (`name`, `controller`, `action`, `order`) VALUES ('browse_log', 'administration', 'browse_log', 4) ON DUPLICATE KEY UPDATE `id`=`id`;

INSERT INTO `<?php echo $table_prefix ?>config_options` (`category_name`, `name`, `value`, `config_handler_class`, `is_system`, `option_order`, `dev_comment`) VALUES ('features', 'login_show_options', '1', 'BoolConfigHandler', 0, 0, 'Show options on the login page') ON DUPLICATE KEY UPDATE `id`=`id`;
