ALTER TABLE `<?php echo $table_prefix ?>project_task_lists` ADD `start_date` datetime NOT NULL default '0000-00-00 00:00:00' after `priority`;
ALTER TABLE `<?php echo $table_prefix ?>project_tasks` ADD `start_date` datetime NOT NULL default '0000-00-00 00:00:00' after `text`;
