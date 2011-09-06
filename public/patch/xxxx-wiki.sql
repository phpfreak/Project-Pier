ALTER TABLE `<?php echo $table_prefix ?>wiki_pages` ADD `publish` tinyint(1) unsigned default 0;
ALTER TABLE `<?php echo $table_prefix ?>wiki_pages` ADD `locked` tinyint(1) unsigned default 0;
ALTER TABLE `<?php echo $table_prefix ?>wiki_pages` ADD `locked_by_id` int(10) unsigned default null;
ALTER TABLE `<?php echo $table_prefix ?>wiki_pages` ADD `locked_on` datetime default '0000-00-00 00:00:00';