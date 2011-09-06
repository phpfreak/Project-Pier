ALTER TABLE `<?php echo $table_prefix ?>project_links` ADD `description` TEXT DEFAULT '' AFTER `url`;
ALTER TABLE `<?php echo $table_prefix ?>project_links` ADD `folder_id` INT( 10 ) NOT NULL DEFAULT 0 AFTER `project_id`;
ALTER TABLE `<?php echo $table_prefix ?>project_links` ADD `logo_file` VARCHAR( 50 ) DEFAULT '' AFTER `description`;