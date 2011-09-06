CREATE TABLE `<?php echo $table_prefix ?>administration_tools` (
  `id` tinyint(3) unsigned NOT NULL auto_increment,
  `name` varchar(50) <?php echo $default_collation ?> NOT NULL default '',
  `controller` varchar(50) <?php echo $default_collation ?> NOT NULL default '',
  `action` varchar(50) <?php echo $default_collation ?> NOT NULL default '',
  `order` tinyint(3) unsigned NOT NULL default '0',
  PRIMARY KEY  (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB <?php echo $default_charset ?>;

CREATE TABLE `<?php echo $table_prefix ?>application_logs` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `taken_by_id` int(10) unsigned default NULL,
  `project_id` int(10) unsigned NOT NULL default '0',
  `rel_object_id` int(10) NOT NULL default '0',
  `object_name` text <?php echo $default_collation ?>,
  `rel_object_manager` varchar(50) <?php echo $default_collation ?> NOT NULL default '',
  `created_on` datetime NOT NULL default '0000-00-00 00:00:00',
  `created_by_id` int(10) unsigned default NULL,
  `action` enum('upload','open','close','delete','edit','add') <?php echo $default_collation ?> default NULL,
  `is_private` tinyint(1) unsigned NOT NULL default '0',
  `is_silent` tinyint(1) unsigned NOT NULL default '0',
  PRIMARY KEY  (`id`),
  KEY `created_on` (`created_on`),
  KEY `project_id` (`project_id`)
) ENGINE=InnoDB <?php echo $default_charset ?>;

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

CREATE TABLE `<?php echo $table_prefix ?>companies` (
  `id` smallint(5) unsigned NOT NULL auto_increment,
  `client_of_id` smallint(5) unsigned default NULL,
  `name` varchar(50) <?php echo $default_collation ?> default NULL,
  `email` varchar(100) <?php echo $default_collation ?> default NULL,
  `homepage` varchar(100) <?php echo $default_collation ?> default NULL,
  `address` varchar(100) <?php echo $default_collation ?> default NULL,
  `address2` varchar(100) <?php echo $default_collation ?> default NULL,
  `city` varchar(50) <?php echo $default_collation ?> default NULL,
  `state` varchar(50) <?php echo $default_collation ?> default NULL,
  `zipcode` varchar(30) <?php echo $default_collation ?> default NULL,
  `country` varchar(10) <?php echo $default_collation ?> default NULL,
  `phone_number` varchar(30) <?php echo $default_collation ?> default NULL,
  `fax_number` varchar(30) <?php echo $default_collation ?> default NULL,
  `logo_file` varchar(44) <?php echo $default_collation ?> default NULL,
  `timezone` float(3,1) NOT NULL default '0.0',
  `hide_welcome_info` tinyint(1) unsigned NOT NULL default '0',
  `created_on` datetime NOT NULL default '0000-00-00 00:00:00',
  `created_by_id` int(10) unsigned default NULL,
  `updated_on` datetime NOT NULL default '0000-00-00 00:00:00',
  `updated_by_id` int(10) unsigned default NULL,
  PRIMARY KEY  (`id`),
  KEY `created_on` (`created_on`),
  KEY `client_of_id` (`client_of_id`)
) ENGINE=InnoDB <?php echo $default_charset ?>;

CREATE TABLE `<?php echo $table_prefix ?>config_categories` (
  `id` tinyint(3) unsigned NOT NULL auto_increment,
  `name` varchar(50) <?php echo $default_collation ?> NOT NULL default '',
  `is_system` tinyint(1) unsigned NOT NULL default '0',
  `category_order` tinyint(3) unsigned NOT NULL default '0',
  PRIMARY KEY  (`id`),
  UNIQUE KEY `name` (`name`),
  KEY `order` (`category_order`)
) ENGINE=InnoDB <?php echo $default_charset ?>;

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

CREATE TABLE `<?php echo $table_prefix ?>file_types` (
  `id` smallint(5) unsigned NOT NULL auto_increment,
  `extension` varchar(10) <?php echo $default_collation ?> NOT NULL default '',
  `icon` varchar(30) <?php echo $default_collation ?> NOT NULL default '',
  `is_searchable` tinyint(1) unsigned NOT NULL default '0',
  `is_image` tinyint(1) unsigned NOT NULL default '0',
  PRIMARY KEY  (`id`),
  UNIQUE KEY `extension` (`extension`)
) ENGINE=InnoDB <?php echo $default_charset ?>;

CREATE TABLE `<?php echo $table_prefix ?>im_types` (
  `id` tinyint(3) unsigned NOT NULL auto_increment,
  `name` varchar(30) <?php echo $default_collation ?> NOT NULL default '',
  `icon` varchar(30) <?php echo $default_collation ?> NOT NULL default '',
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB <?php echo $default_charset ?>;

CREATE TABLE `<?php echo $table_prefix ?>message_subscriptions` (
  `message_id` int(10) unsigned NOT NULL default '0',
  `user_id` int(10) unsigned NOT NULL default '0',
  PRIMARY KEY  (`message_id`,`user_id`)
) ENGINE=InnoDB <?php echo $default_charset ?>;

CREATE TABLE `<?php echo $table_prefix ?>project_companies` (
  `project_id` int(10) unsigned NOT NULL default '0',
  `company_id` smallint(5) unsigned NOT NULL default '0',
  PRIMARY KEY  (`project_id`,`company_id`)
) ENGINE=InnoDB <?php echo $default_charset ?>;

CREATE TABLE `<?php echo $table_prefix ?>project_messages` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `milestone_id` int(10) unsigned NOT NULL default '0',
  `project_id` int(10) unsigned default NULL,
  `title` varchar(100) <?php echo $default_collation ?> default NULL,
  `text` text <?php echo $default_collation ?>,
  `additional_text` text <?php echo $default_collation ?>,
  `is_important` tinyint(1) unsigned NOT NULL default '0',
  `is_private` tinyint(1) unsigned NOT NULL default '0',
  `comments_enabled` tinyint(1) unsigned NOT NULL default '0',
  `anonymous_comments_enabled` tinyint(1) unsigned NOT NULL default '0',
  `created_on` datetime NOT NULL default '0000-00-00 00:00:00',
  `created_by_id` int(10) unsigned default NULL,
  `updated_on` datetime NOT NULL default '0000-00-00 00:00:00',
  `updated_by_id` int(10) unsigned default NULL,
  PRIMARY KEY  (`id`),
  KEY `milestone_id` (`milestone_id`),
  KEY `project_id` (`project_id`),
  KEY `created_on` (`created_on`)
) ENGINE=InnoDB <?php echo $default_charset ?>;

CREATE TABLE `<?php echo $table_prefix ?>project_milestones` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `project_id` int(10) unsigned default NULL,
  `name` varchar(100) <?php echo $default_collation ?> default NULL,
  `description` text <?php echo $default_collation ?>,
  `due_date` datetime NOT NULL default '0000-00-00 00:00:00',
  `assigned_to_company_id` smallint(10) NOT NULL default '0',
  `assigned_to_user_id` int(10) unsigned NOT NULL default '0',
  `is_private` tinyint(1) unsigned NOT NULL default '0',
  `completed_on` datetime NOT NULL default '0000-00-00 00:00:00',
  `completed_by_id` int(10) unsigned default NULL,
  `created_on` datetime NOT NULL default '0000-00-00 00:00:00',
  `created_by_id` int(10) unsigned default NULL,
  `updated_on` datetime NOT NULL default '0000-00-00 00:00:00',
  `updated_by_id` int(10) unsigned default NULL,
  PRIMARY KEY  (`id`),
  KEY `project_id` (`project_id`),
  KEY `due_date` (`due_date`),
  KEY `completed_on` (`completed_on`),
  KEY `created_on` (`created_on`)
) ENGINE=InnoDB <?php echo $default_charset ?>;

CREATE TABLE `<?php echo $table_prefix ?>project_task_lists` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `milestone_id` int(10) unsigned NOT NULL default '0',
  `project_id` int(10) unsigned default NULL,
  `name` varchar(100) <?php echo $default_collation ?> default NULL,
  `priority` INT( 3 ) UNSIGNED NOT NULL DEFAULT '0',
  `description` text <?php echo $default_collation ?>,
  `due_date` datetime NOT NULL default '0000-00-00 00:00:00',
  `is_private` tinyint(1) unsigned NOT NULL default '0',
  `completed_on` datetime NOT NULL default '0000-00-00 00:00:00',
  `completed_by_id` int(10) unsigned default NULL,
  `created_on` datetime default NULL,
  `created_by_id` int(10) unsigned NOT NULL default '0',
  `updated_on` datetime default NULL,
  `updated_by_id` int(10) unsigned NOT NULL default '0',
  `order` tinyint(3) unsigned NOT NULL default '0',
  PRIMARY KEY  (`id`),
  KEY `milestone_id` (`milestone_id`),
  KEY `project_id` (`project_id`),
  KEY `completed_on` (`completed_on`),
  KEY `created_on` (`created_on`)
) ENGINE=InnoDB <?php echo $default_charset ?>;

CREATE TABLE `<?php echo $table_prefix ?>project_tasks` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `task_list_id` int(10) unsigned default NULL,
  `text` text <?php echo $default_collation ?>,
  `due_date` datetime NOT NULL default '0000-00-00 00:00:00',
  `assigned_to_company_id` smallint(5) unsigned default NULL,
  `assigned_to_user_id` int(10) unsigned default NULL,
  `completed_on` datetime NOT NULL default '0000-00-00 00:00:00',
  `completed_by_id` int(10) unsigned default NULL,
  `created_on` datetime NOT NULL default '0000-00-00 00:00:00',
  `created_by_id` int(10) unsigned default NULL,
  `updated_on` datetime NOT NULL default '0000-00-00 00:00:00',
  `updated_by_id` int(10) unsigned default NULL,
  `order` int(10) unsigned NOT NULL default '0',
  PRIMARY KEY  (`id`),
  KEY `task_list_id` (`task_list_id`),
  KEY `completed_on` (`completed_on`),
  KEY `created_on` (`created_on`),
  KEY `order` (`order`)
) ENGINE=InnoDB <?php echo $default_charset ?>;

CREATE TABLE `<?php echo $table_prefix ?>project_users` (
  `project_id` int(10) unsigned NOT NULL default '0',
  `user_id` int(10) unsigned NOT NULL default '0',
  `role_id` int(10) unsigned NOT NULL default '0',
  `created_on` datetime default NULL,
  `created_by_id` int(10) unsigned NOT NULL default '0',
  PRIMARY KEY  (`project_id`,`user_id`)
) ENGINE=InnoDB <?php echo $default_charset ?>;

CREATE TABLE `<?php echo $table_prefix ?>projects` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `name` varchar(50) <?php echo $default_collation ?> default NULL,
  `priority` int(3) UNSIGNED NOT NULL DEFAULT '0',
  `description` text <?php echo $default_collation ?>,
  `show_description_in_overview` tinyint(1) unsigned NOT NULL default '0',
  `logo_file` varchar(44) <?php echo $default_collation ?> default NULL,
  `completed_on` datetime NOT NULL default '0000-00-00 00:00:00',
  `completed_by_id` int(11) default NULL,
  `created_on` datetime NOT NULL default '0000-00-00 00:00:00',
  `created_by_id` int(10) unsigned default NULL,
  `updated_on` datetime NOT NULL default '0000-00-00 00:00:00',
  `updated_by_id` int(10) unsigned default NULL,
  PRIMARY KEY  (`id`),
  KEY `completed_on` (`completed_on`)
) ENGINE=InnoDB <?php echo $default_charset ?>;

CREATE TABLE `<?php echo $table_prefix ?>searchable_objects` (
  `rel_object_manager` varchar(50) <?php echo $default_collation ?> NOT NULL default '',
  `rel_object_id` int(10) unsigned NOT NULL default '0',
  `column_name` varchar(50) <?php echo $default_collation ?> NOT NULL default '',
  `content` text <?php echo $default_collation ?> NOT NULL,
  `project_id` int(10) unsigned NOT NULL default '0',
  `is_private` tinyint(1) unsigned NOT NULL default '0',
  PRIMARY KEY  (`rel_object_manager`,`rel_object_id`,`column_name`),
  KEY `project_id` (`project_id`),
  FULLTEXT KEY `content` (`content`)
) ENGINE=MyISAM <?php echo $default_charset ?>;

CREATE TABLE `<?php echo $table_prefix ?>user_im_values` (
  `user_id` int(10) unsigned NOT NULL default '0',
  `im_type_id` tinyint(3) unsigned NOT NULL default '0',
  `value` varchar(50) <?php echo $default_collation ?> NOT NULL default '',
  `is_default` tinyint(1) unsigned NOT NULL default '0',
  PRIMARY KEY  (`user_id`,`im_type_id`),
  KEY `is_default` (`is_default`)
) ENGINE=InnoDB <?php echo $default_charset ?>;

CREATE TABLE `<?php echo $table_prefix ?>users` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `company_id` smallint(5) unsigned NOT NULL default '0',
  `username` varchar(50) <?php echo $default_collation ?> NOT NULL default '',
  `email` varchar(100) <?php echo $default_collation ?> default NULL,
  `homepage` varchar(100) <?php echo $default_collation ?> default NULL,
  `token` varchar(40) <?php echo $default_collation ?> NOT NULL default '',
  `salt` varchar(13) <?php echo $default_collation ?> NOT NULL default '',
  `twister` varchar(10) <?php echo $default_collation ?> NOT NULL default '',
  `display_name` varchar(50) <?php echo $default_collation ?> default NULL,
  `title` varchar(30) <?php echo $default_collation ?> default NULL,
  `avatar_file` varchar(44) <?php echo $default_collation ?> default NULL,
  `use_gravatar` tinyint(1) unsigned NOT NULL default '0',
  `office_number` varchar(20) <?php echo $default_collation ?> default NULL,
  `fax_number` varchar(20) <?php echo $default_collation ?> default NULL,
  `mobile_number` varchar(20) <?php echo $default_collation ?> default NULL,
  `home_number` varchar(20) <?php echo $default_collation ?> default NULL,
  `timezone` float(3,1) NOT NULL default '0.0',
  `created_on` datetime NOT NULL default '0000-00-00 00:00:00',
  `created_by_id` int(10) unsigned default NULL,
  `updated_on` datetime NOT NULL default '0000-00-00 00:00:00',
  `last_login` datetime NOT NULL default '0000-00-00 00:00:00',
  `last_visit` datetime NOT NULL default '0000-00-00 00:00:00',
  `last_activity` datetime NOT NULL default '0000-00-00 00:00:00',
  `is_admin` tinyint(1) unsigned default NULL,
  `auto_assign` tinyint(1) unsigned NOT NULL default '0',
  `use_LDAP` tinyint(1) unsigned NOT NULL default '0',
  PRIMARY KEY  (`id`),
  UNIQUE KEY `username` (`username`),
  KEY `email` (`email`),
  KEY `last_visit` (`last_visit`),
  KEY `company_id` (`company_id`),
  KEY `last_login` (`last_login`)
) ENGINE=InnoDB <?php echo $default_charset ?>;

CREATE TABLE `<?php echo $table_prefix ?>plugins` (
  `plugin_id` int(10) unsigned NOT NULL auto_increment,
  `name` varchar(100) <?php echo $default_collation ?> NOT NULL,
  `installed` tinyint(1) unsigned NOT NULL default '0',
  PRIMARY KEY  (`plugin_id`)
) ENGINE=InnoDB <?php echo $default_charset ?>;

CREATE TABLE `<?php echo $table_prefix ?>permissions` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `source` varchar(50) <?php echo $default_collation ?> NOT NULL,
  `permission` varchar(100) <?php echo $default_collation ?> NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB <?php echo $default_charset ?>;

CREATE TABLE `<?php echo $table_prefix ?>project_user_permissions` (
  `user_id` int(10) unsigned NOT NULL,
  `project_id` int(10) unsigned NOT NULL,
  `permission_id` int(10) unsigned NOT NULL,
  PRIMARY KEY  (`user_id`,`project_id`,`permission_id`)
) ENGINE=InnoDB <?php echo $default_charset ?>;