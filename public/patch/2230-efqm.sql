ALTER TABLE `<?php echo $table_prefix ?>project_task_lists` ADD `score` INT( 3 ) NOT NULL DEFAULT '0' AFTER `name`;
ALTER TABLE `<?php echo $table_prefix ?>project_milestones` ADD `goal` INT( 3 ) NOT NULL DEFAULT '0' AFTER `name`;

INSERT INTO `<?php echo $table_prefix ?>permissions` (`id`, `source`, `permission`) VALUES (12, 'tasks', 'edit score');
INSERT INTO `<?php echo $table_prefix ?>permissions` (`id`, `source`, `permission`) VALUES (13, 'milestones', 'edit goal');

INSERT INTO `<?php echo $table_prefix ?>config_options` (`category_name`, `name`, `value`, `config_handler_class`, `is_system`, `option_order`, `dev_comment`) VALUES ('features', 'enable_efqm', '0', 'BoolConfigHandler', 0, 0, 'Enable EFQM options (www.efqm.org)');
INSERT INTO `<?php echo $table_prefix ?>config_categories` (`name`, `is_system`, `category_order`) VALUES ('efqm', 0, 5);
INSERT INTO `<?php echo $table_prefix ?>config_options` (`category_name`, `name`, `value`, `config_handler_class`, `is_system`, `option_order`, `dev_comment`) VALUES ('efqm', 'initial goal', '80', 'IntegerConfigHandler', 0, 0, NULL);
INSERT INTO `<?php echo $table_prefix ?>config_options` (`category_name`, `name`, `value`, `config_handler_class`, `is_system`, `option_order`, `dev_comment`) VALUES ('efqm', 'initial score', '50', 'IntegerConfigHandler', 0, 0, NULL);
INSERT INTO `<?php echo $table_prefix ?>config_options` (`category_name`, `name`, `value`, `config_handler_class`, `is_system`, `option_order`, `dev_comment`) VALUES ('efqm', 'due date offset', '90', 'IntegerConfigHandler', 0, 0, NULL);