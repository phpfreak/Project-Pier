INSERT INTO `<?php echo $table_prefix ?>administration_tools` (`name`, `controller`, `action`, `order`) VALUES ('test_mail_settings', 'administration', 'tool_test_email', 1);
INSERT INTO `<?php echo $table_prefix ?>administration_tools` (`name`, `controller`, `action`, `order`) VALUES ('mass_mailer', 'administration', 'tool_mass_mailer', 2);

INSERT INTO `<?php echo $table_prefix ?>config_categories` (`name`, `is_system`, `category_order`) VALUES ('system', 1, 0);
INSERT INTO `<?php echo $table_prefix ?>config_categories` (`name`, `is_system`, `category_order`) VALUES ('general', 0, 1);
INSERT INTO `<?php echo $table_prefix ?>config_categories` (`name`, `is_system`, `category_order`) VALUES ('mailing', 0, 2);
INSERT INTO `<?php echo $table_prefix ?>config_categories` (`name`, `is_system`, `category_order`) VALUES ('features', 0, 3);
INSERT INTO `<?php echo $table_prefix ?>config_categories` (`name`, `is_system`, `category_order`) VALUES ('database', 0, 9);
INSERT INTO `<?php echo $table_prefix ?>config_categories` (`name`, `is_system`, `category_order`) VALUES ('tickets', 0, 4);

INSERT INTO `<?php echo $table_prefix ?>config_options` (`category_name`, `name`, `value`, `config_handler_class`, `is_system`, `option_order`, `dev_comment`) VALUES ('system', 'project_logs_per_page', '10', 'IntegerConfigHandler', 1, 0, NULL);
INSERT INTO `<?php echo $table_prefix ?>config_options` (`category_name`, `name`, `value`, `config_handler_class`, `is_system`, `option_order`, `dev_comment`) VALUES ('system', 'messages_per_page', '5', 'IntegerConfigHandler', 1, 0, NULL);
INSERT INTO `<?php echo $table_prefix ?>config_options` (`category_name`, `name`, `value`, `config_handler_class`, `is_system`, `option_order`, `dev_comment`) VALUES ('system', 'max_avatar_width', '50', 'IntegerConfigHandler', 1, 0, NULL);
INSERT INTO `<?php echo $table_prefix ?>config_options` (`category_name`, `name`, `value`, `config_handler_class`, `is_system`, `option_order`, `dev_comment`) VALUES ('system', 'max_avatar_height', '50', 'IntegerConfigHandler', 1, 0, NULL);
INSERT INTO `<?php echo $table_prefix ?>config_options` (`category_name`, `name`, `value`, `config_handler_class`, `is_system`, `option_order`, `dev_comment`) VALUES ('system', 'logs_per_project', '5', 'IntegerConfigHandler', 1, 0, NULL);
INSERT INTO `<?php echo $table_prefix ?>config_options` (`category_name`, `name`, `value`, `config_handler_class`, `is_system`, `option_order`, `dev_comment`) VALUES ('system', 'max_logo_width', '50', 'IntegerConfigHandler', 1, 0, NULL);
INSERT INTO `<?php echo $table_prefix ?>config_options` (`category_name`, `name`, `value`, `config_handler_class`, `is_system`, `option_order`, `dev_comment`) VALUES ('system', 'max_logo_height', '50', 'IntegerConfigHandler', 1, 0, NULL);
INSERT INTO `<?php echo $table_prefix ?>config_options` (`category_name`, `name`, `value`, `config_handler_class`, `is_system`, `option_order`, `dev_comment`) VALUES ('system', 'files_per_page', '10', 'IntegerConfigHandler', 1, 0, NULL);
INSERT INTO `<?php echo $table_prefix ?>config_options` (`category_name`, `name`, `value`, `config_handler_class`, `is_system`, `option_order`, `dev_comment`) VALUES ('general', 'calendar_first_day_of_week', '1', 'DayOfWeekConfigHandler', 0, 0, NULL);
INSERT INTO `<?php echo $table_prefix ?>config_options` (`category_name`, `name`, `value`, `config_handler_class`, `is_system`, `option_order`, `dev_comment`) VALUES ('general', 'site_name', 'ProjectPier', 'StringConfigHandler', 0, 0, NULL);
INSERT INTO `<?php echo $table_prefix ?>config_options` (`category_name`, `name`, `value`, `config_handler_class`, `is_system`, `option_order`, `dev_comment`) VALUES ('general', 'upgrade_last_check_datetime', '2006-09-02 13:46:47', 'DateTimeConfigHandler', 1, 0, 'Date and time of the last upgrade check');
INSERT INTO `<?php echo $table_prefix ?>config_options` (`category_name`, `name`, `value`, `config_handler_class`, `is_system`, `option_order`, `dev_comment`) VALUES ('general', 'upgrade_last_check_new_version', '0', 'BoolConfigHandler', 1, 0, 'True if system checked for the new version and found it. This value is used to highlight upgrade tab in the administration');
INSERT INTO `<?php echo $table_prefix ?>config_options` (`category_name`, `name`, `value`, `config_handler_class`, `is_system`, `option_order`, `dev_comment`) VALUES ('general', 'upgrade_check_enabled', '0', 'BoolConfigHandler', 0, 0, 'Upgrade check enabled / disabled');
INSERT INTO `<?php echo $table_prefix ?>config_options` (`category_name`, `name`, `value`, `config_handler_class`, `is_system`, `option_order`, `dev_comment`) VALUES ('general', 'file_storage_adapter', 'fs', 'FileStorageConfigHandler', 0, 0, 'What storage adapter should be used? fs or mysql');
INSERT INTO `<?php echo $table_prefix ?>config_options` (`category_name`, `name`, `value`, `config_handler_class`, `is_system`, `option_order`, `dev_comment`) VALUES ('general', 'default_project_folders', 'images\r\ndocuments\r\nother\r\n', 'TextConfigHandler', 0, 3, NULL);
INSERT INTO `<?php echo $table_prefix ?>config_options` (`category_name`, `name`, `value`, `config_handler_class`, `is_system`, `option_order`, `dev_comment`) VALUES ('general', 'theme', 'marine', 'ThemeConfigHandler', 0, 0, NULL);
INSERT INTO `<?php echo $table_prefix ?>config_options` (`category_name`, `name`, `value`, `config_handler_class`, `is_system`, `option_order`, `dev_comment`) VALUES ('general', 'logout_redirect_page', 'default', 'StringConfigHandler', '0', '0', 'Logout Redirect mod by Alex: Redirect to a set page upon logout');

INSERT INTO `<?php echo $table_prefix ?>config_options` (`category_name`, `name`, `value`, `config_handler_class`, `is_system`, `option_order`, `dev_comment`) VALUES ('mailing', 'exchange_compatible', '0', 'BoolConfigHandler', 0, 90, NULL);
INSERT INTO `<?php echo $table_prefix ?>config_options` (`category_name`, `name`, `value`, `config_handler_class`, `is_system`, `option_order`, `dev_comment`) VALUES ('mailing', 'mail_transport', 'mail()', 'MailTransportConfigHandler', 0, 10, 'Values: ''mail()'' - try to emulate mail() function, ''smtp'' - use SMTP connection');
INSERT INTO `<?php echo $table_prefix ?>config_options` (`category_name`, `name`, `value`, `config_handler_class`, `is_system`, `option_order`, `dev_comment`) VALUES ('mailing', 'mail_use_reply_to', '0', 'BoolConfigHandler', 0, 11, 'Enable to use Reply-To header in mails');
INSERT INTO `<?php echo $table_prefix ?>config_options` (`category_name`, `name`, `value`, `config_handler_class`, `is_system`, `option_order`, `dev_comment`) VALUES ('mailing', 'mail_from', '', 'StringConfigHandler', 0, 12, 'The From address in every mail sent out');
INSERT INTO `<?php echo $table_prefix ?>config_options` (`category_name`, `name`, `value`, `config_handler_class`, `is_system`, `option_order`, `dev_comment`) VALUES ('mailing', 'smtp_server', '', 'StringConfigHandler', 0, 20, '');
INSERT INTO `<?php echo $table_prefix ?>config_options` (`category_name`, `name`, `value`, `config_handler_class`, `is_system`, `option_order`, `dev_comment`) VALUES ('mailing', 'smtp_port', '25', 'IntegerConfigHandler', 0, 21, NULL);
INSERT INTO `<?php echo $table_prefix ?>config_options` (`category_name`, `name`, `value`, `config_handler_class`, `is_system`, `option_order`, `dev_comment`) VALUES ('mailing', 'smtp_authenticate', '0', 'BoolConfigHandler', 0, 22, 'Use SMTP authentication');
INSERT INTO `<?php echo $table_prefix ?>config_options` (`category_name`, `name`, `value`, `config_handler_class`, `is_system`, `option_order`, `dev_comment`) VALUES ('mailing', 'smtp_username', '', 'StringConfigHandler', 0, 23, NULL);
INSERT INTO `<?php echo $table_prefix ?>config_options` (`category_name`, `name`, `value`, `config_handler_class`, `is_system`, `option_order`, `dev_comment`) VALUES ('mailing', 'smtp_password', '', 'PasswordConfigHandler', 0, 24, NULL);
INSERT INTO `<?php echo $table_prefix ?>config_options` (`category_name`, `name`, `value`, `config_handler_class`, `is_system`, `option_order`, `dev_comment`) VALUES ('mailing', 'smtp_secure_connection', 'no', 'SecureSmtpConnectionConfigHandler', 0, 25, 'Values: no, ssl, tls');

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

INSERT INTO `<?php echo $table_prefix ?>file_types` (`extension`, `icon`, `is_searchable`, `is_image`) VALUES ('zip', 'archive.png', 0, 0);
INSERT INTO `<?php echo $table_prefix ?>file_types` (`extension`, `icon`, `is_searchable`, `is_image`) VALUES ('rar', 'archive.png', 0, 0);
INSERT INTO `<?php echo $table_prefix ?>file_types` (`extension`, `icon`, `is_searchable`, `is_image`) VALUES ('bz', 'archive.png', 0, 0);
INSERT INTO `<?php echo $table_prefix ?>file_types` (`extension`, `icon`, `is_searchable`, `is_image`) VALUES ('bz2', 'archive.png', 0, 0);
INSERT INTO `<?php echo $table_prefix ?>file_types` (`extension`, `icon`, `is_searchable`, `is_image`) VALUES ('gz', 'archive.png', 0, 0);
INSERT INTO `<?php echo $table_prefix ?>file_types` (`extension`, `icon`, `is_searchable`, `is_image`) VALUES ('ace', 'archive.png', 0, 0);
INSERT INTO `<?php echo $table_prefix ?>file_types` (`extension`, `icon`, `is_searchable`, `is_image`) VALUES ('mp3', 'audio.png', 0, 0);
INSERT INTO `<?php echo $table_prefix ?>file_types` (`extension`, `icon`, `is_searchable`, `is_image`) VALUES ('wma', 'audio.png', 0, 0);
INSERT INTO `<?php echo $table_prefix ?>file_types` (`extension`, `icon`, `is_searchable`, `is_image`) VALUES ('ogg', 'audio.png', 0, 0);
INSERT INTO `<?php echo $table_prefix ?>file_types` (`extension`, `icon`, `is_searchable`, `is_image`) VALUES ('doc', 'doc.png', 0, 0);
INSERT INTO `<?php echo $table_prefix ?>file_types` (`extension`, `icon`, `is_searchable`, `is_image`) VALUES ('xsl', 'doc.png', 0, 0);
INSERT INTO `<?php echo $table_prefix ?>file_types` (`extension`, `icon`, `is_searchable`, `is_image`) VALUES ('gif', 'image.png', 0, 1);
INSERT INTO `<?php echo $table_prefix ?>file_types` (`extension`, `icon`, `is_searchable`, `is_image`) VALUES ('jpg', 'image.png', 0, 1);
INSERT INTO `<?php echo $table_prefix ?>file_types` (`extension`, `icon`, `is_searchable`, `is_image`) VALUES ('jpeg', 'image.png', 0, 1);
INSERT INTO `<?php echo $table_prefix ?>file_types` (`extension`, `icon`, `is_searchable`, `is_image`) VALUES ('png', 'image.png', 0, 1);
INSERT INTO `<?php echo $table_prefix ?>file_types` (`extension`, `icon`, `is_searchable`, `is_image`) VALUES ('mov', 'mov.png', 0, 0);
INSERT INTO `<?php echo $table_prefix ?>file_types` (`extension`, `icon`, `is_searchable`, `is_image`) VALUES ('pdf', 'pdf.png', 0, 0);
INSERT INTO `<?php echo $table_prefix ?>file_types` (`extension`, `icon`, `is_searchable`, `is_image`) VALUES ('psd', 'psd.png', 0, 0);
INSERT INTO `<?php echo $table_prefix ?>file_types` (`extension`, `icon`, `is_searchable`, `is_image`) VALUES ('rm', 'rm.png', 0, 0);
INSERT INTO `<?php echo $table_prefix ?>file_types` (`extension`, `icon`, `is_searchable`, `is_image`) VALUES ('svg', 'svg.png', 0, 0);
INSERT INTO `<?php echo $table_prefix ?>file_types` (`extension`, `icon`, `is_searchable`, `is_image`) VALUES ('swf', 'swf.png', 0, 0);
INSERT INTO `<?php echo $table_prefix ?>file_types` (`extension`, `icon`, `is_searchable`, `is_image`) VALUES ('avi', 'video.png', 0, 0);
INSERT INTO `<?php echo $table_prefix ?>file_types` (`extension`, `icon`, `is_searchable`, `is_image`) VALUES ('mpeg', 'video.png', 0, 0);
INSERT INTO `<?php echo $table_prefix ?>file_types` (`extension`, `icon`, `is_searchable`, `is_image`) VALUES ('mpg', 'video.png', 0, 0);
INSERT INTO `<?php echo $table_prefix ?>file_types` (`extension`, `icon`, `is_searchable`, `is_image`) VALUES ('qt', 'mov.png', 0, 0);
INSERT INTO `<?php echo $table_prefix ?>file_types` (`extension`, `icon`, `is_searchable`, `is_image`) VALUES ('vob', 'video.png', 0, 0);
INSERT INTO `<?php echo $table_prefix ?>file_types` (`extension`, `icon`, `is_searchable`, `is_image`) VALUES ('txt', 'doc.png', 1, 0);

INSERT INTO `<?php echo $table_prefix ?>im_types` (`name`, `icon`) VALUES ('ICQ', 'icq.gif');
INSERT INTO `<?php echo $table_prefix ?>im_types` (`name`, `icon`) VALUES ('AIM', 'aim.gif');
INSERT INTO `<?php echo $table_prefix ?>im_types` (`name`, `icon`) VALUES ('MSN', 'msn.gif');
INSERT INTO `<?php echo $table_prefix ?>im_types` (`name`, `icon`) VALUES ('Yahoo!', 'yahoo.gif');
INSERT INTO `<?php echo $table_prefix ?>im_types` (`name`, `icon`) VALUES ('Skype', 'skype.gif');
INSERT INTO `<?php echo $table_prefix ?>im_types` (`name`, `icon`) VALUES ('Jabber', 'jabber.gif');

INSERT INTO `<?php echo $table_prefix ?>projects` (`id`, `name`, `description`, `show_description_in_overview`, `completed_on`, `completed_by_id`, `created_on`, `created_by_id`, `updated_on`, `updated_by_id`) VALUES (1, 'Welcome', 'This is the very first project', 1, '0000-00-00 00:00:00', null, current_timestamp, null, current_timestamp, null);
INSERT INTO `<?php echo $table_prefix ?>project_users` (`project_id` , `user_id` , `role_id` , `created_on` , `created_by_id` ) VALUES ( 1, 1, 0, current_timestamp, 1 );
INSERT INTO `<?php echo $table_prefix ?>project_milestones` (`id`, `project_id`, `name`, `description`, `due_date`, `assigned_to_company_id`, `assigned_to_user_id`, `is_private`, `completed_on`, `completed_by_id`, `created_on`, `created_by_id`, `updated_on`, `updated_by_id`) VALUES
(1, 1, 'Finish Welcome', '', current_timestamp + interval 7 day, 0, 1, 1, '0000-00-00 00:00:00', 0, current_timestamp, 1, current_timestamp, 1);
INSERT INTO `<?php echo $table_prefix ?>project_task_lists` (`id`, `milestone_id`, `project_id`, `name`, `priority`, `description`, `is_private`, `completed_on`, `completed_by_id`, `created_on`, `created_by_id`, `updated_on`, `updated_by_id`, `order`) VALUES 
(1, 1, 1, 'To-Do List', '1', 'Welcome to your new account. You can get started in a minute following these easy steps.', 1, '0000-00-00 00:00:00', 0, current_timestamp, 0, current_timestamp, 0, 0);

INSERT INTO `<?php echo $table_prefix ?>project_tasks` (`id`, `task_list_id`, `text`, `assigned_to_company_id`, `assigned_to_user_id`, `completed_on`, `completed_by_id`, `created_on`, `created_by_id`, `updated_on`, `updated_by_id`, `order`) VALUES (1, 1, 'Step 1: Update your company info\r\nSet your company details such as phone and fax number, address, email, homepage, etc.\r\n', 1, 1, '0000-00-00 00:00:00', 0, current_timestamp, 0, current_timestamp, 0, 1);
INSERT INTO `<?php echo $table_prefix ?>project_tasks` (`id`, `task_list_id`, `text`, `assigned_to_company_id`, `assigned_to_user_id`, `completed_on`, `completed_by_id`, `created_on`, `created_by_id`, `updated_on`, `updated_by_id`, `order`) VALUES (2, 1, 'Step 2: Add team members\r\nYou can create user accounts for all members of your team (an unlimited number). Every member will get a username and password which they can use to access the system\r\n', 1, 1, '0000-00-00 00:00:00', 0, current_timestamp, 0, current_timestamp, 0, 2);
INSERT INTO `<?php echo $table_prefix ?>project_tasks` (`id`, `task_list_id`, `text`, `assigned_to_company_id`, `assigned_to_user_id`, `completed_on`, `completed_by_id`, `created_on`, `created_by_id`, `updated_on`, `updated_by_id`, `order`) VALUES (3, 1, 'Step 3: Add client companies and their members\r\nNow it''s time to define client companies (unlimited). When you''re done you can add their members or leave that for their team leaders. Client members are similar to your company members except that they have limited access to content and functions (you can set what they can do per project and per member)\r\n', 1, 1, '0000-00-00 00:00:00', 0, current_timestamp, 0, current_timestamp, 0, 3);
INSERT INTO `<?php echo $table_prefix ?>project_tasks` (`id`, `task_list_id`, `text`, `assigned_to_company_id`, `assigned_to_user_id`, `completed_on`, `completed_by_id`, `created_on`, `created_by_id`, `updated_on`, `updated_by_id`, `order`) VALUES (4, 1, 'Step 4: Start a project\r\nDefining a new project is really easy: set a name and description (optional) and click submit. After that you can set permissions for your team members and clients.\r\n', 1, 1, '0000-00-00 00:00:00', 0, current_timestamp, 1, current_timestamp, 1, 4);
INSERT INTO `<?php echo $table_prefix ?>project_tasks` (`id`, `task_list_id`, `text`, `assigned_to_company_id`, `assigned_to_user_id`, `completed_on`, `completed_by_id`, `created_on`, `created_by_id`, `updated_on`, `updated_by_id`, `order`) VALUES (5, 1, 'Step 5: Finish the Welcome project\r\n', 1, 1, '0000-00-00 00:00:00', 0, current_timestamp, 0, current_timestamp, 0, 5);

INSERT INTO `<?php echo $table_prefix ?>application_logs` (`id`, `taken_by_id`, `project_id`, `rel_object_id`, `object_name`, `rel_object_manager`, `created_on`, `created_by_id`, `action`, `is_private`, `is_silent`) VALUES
(1, 1, 1, 1, 'Welcome', 'Projects', current_timestamp, 1, 'add', 0, 0),
(2, 1, 1, 1, 'Welcome', 'ProjectMilestones', current_timestamp, 1, 'add', 0, 0),
(3, 1, 1, 1, 'Welcome', 'ProjectTaskLists', current_timestamp, 1, 'add', 0, 0);

INSERT INTO `<?php echo $table_prefix ?>permissions` (`id`, `source`, `permission`) VALUES (1, 'files', 'manage');
INSERT INTO `<?php echo $table_prefix ?>permissions` (`id`, `source`, `permission`) VALUES (2, 'files', 'upload');
INSERT INTO `<?php echo $table_prefix ?>permissions` (`id`, `source`, `permission`) VALUES (3, 'milestones', 'manage');
INSERT INTO `<?php echo $table_prefix ?>permissions` (`id`, `source`, `permission`) VALUES (4, 'messages', 'manage');
INSERT INTO `<?php echo $table_prefix ?>permissions` (`id`, `source`, `permission`) VALUES (5, 'tasks', 'manage');
INSERT INTO `<?php echo $table_prefix ?>permissions` (`id`, `source`, `permission`) VALUES (6, 'tasks', 'assign to other clients');
INSERT INTO `<?php echo $table_prefix ?>permissions` (`id`, `source`, `permission`) VALUES (7, 'tasks', 'assign to owner company');
INSERT INTO `<?php echo $table_prefix ?>permissions` (`id`, `source`, `permission`) VALUES (8, 'tickets', 'manage');
INSERT INTO `<?php echo $table_prefix ?>permissions` (`id`, `source`, `permission`) VALUES (9, 'projects', 'manage');
INSERT INTO `<?php echo $table_prefix ?>permissions` (`id`, `source`, `permission`) VALUES (10, 'milestones', 'change status');
INSERT INTO `<?php echo $table_prefix ?>permissions` (`id`, `source`, `permission`) VALUES (11, 'times', 'manage');

INSERT INTO `<?php echo $table_prefix ?>project_user_permissions` (`user_id`, `project_id`, `permission_id`) VALUES (1, 1, 1);
INSERT INTO `<?php echo $table_prefix ?>project_user_permissions` (`user_id`, `project_id`, `permission_id`) VALUES (1, 1, 2);
INSERT INTO `<?php echo $table_prefix ?>project_user_permissions` (`user_id`, `project_id`, `permission_id`) VALUES (1, 1, 3);
INSERT INTO `<?php echo $table_prefix ?>project_user_permissions` (`user_id`, `project_id`, `permission_id`) VALUES (1, 1, 4);
INSERT INTO `<?php echo $table_prefix ?>project_user_permissions` (`user_id`, `project_id`, `permission_id`) VALUES (1, 1, 5);
INSERT INTO `<?php echo $table_prefix ?>project_user_permissions` (`user_id`, `project_id`, `permission_id`) VALUES (1, 1, 6);
INSERT INTO `<?php echo $table_prefix ?>project_user_permissions` (`user_id`, `project_id`, `permission_id`) VALUES (1, 1, 7);
INSERT INTO `<?php echo $table_prefix ?>project_user_permissions` (`user_id`, `project_id`, `permission_id`) VALUES (1, 1, 8);
INSERT INTO `<?php echo $table_prefix ?>project_user_permissions` (`user_id`, `project_id`, `permission_id`) VALUES (1, 1, 10);

INSERT INTO `<?php echo $table_prefix ?>plugins` (`plugin_id`, `name`, `installed`) VALUES (1, 'files', 0);
INSERT INTO `<?php echo $table_prefix ?>plugins` (`plugin_id`, `name`, `installed`) VALUES (2, 'form', 0);
INSERT INTO `<?php echo $table_prefix ?>plugins` (`plugin_id`, `name`, `installed`) VALUES (3, 'links', 0);
INSERT INTO `<?php echo $table_prefix ?>plugins` (`plugin_id`, `name`, `installed`) VALUES (4, 'tags', 0);
INSERT INTO `<?php echo $table_prefix ?>plugins` (`plugin_id`, `name`, `installed`) VALUES (5, 'tickets', 0);
INSERT INTO `<?php echo $table_prefix ?>plugins` (`plugin_id`, `name`, `installed`) VALUES (6, 'time', 0);
INSERT INTO `<?php echo $table_prefix ?>plugins` (`plugin_id`, `name`, `installed`) VALUES (7, 'wiki', 0);
