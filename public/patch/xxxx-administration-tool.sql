INSERT INTO `<?php echo $table_prefix ?>administration_tools` (`name`, `controller`, `action`, `order`) VALUES ('browse_log', 'administration', 'browse_log', 4);
INSERT INTO `<?php echo $table_prefix ?>config_options` (`category_name`, `name`, `value`, `config_handler_class`, `is_system`, `option_order`, `dev_comment`) VALUES ('features', 'enable_efqm', '0', 'BoolConfigHandler', 0, 0, 'Enable EFQM options (www.efqm.org)');
INSERT INTO `<?php echo $table_prefix ?>administration_tools` (`name`, `controller`, `action`, `order`) VALUES ('system_info', 'administration', 'system_info', 3);

