CREATE TABLE `<?php echo $table_prefix ?>page_attachments` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `rel_object_id` int(10) unsigned NULL,
  `rel_object_manager` varchar(50) <?php echo $default_collation ?> NULL,
  `project_id` int(10) unsigned NOT NULL ,
  `page_name` varchar(50) <?php echo $default_collation ?> NOT NULL default '',
  `text` text <?php echo $default_collation ?> NOT NULL,
  `order` tinyint(3) NOT NULL default '0',
  `created_on` datetime NOT NULL default '0000-00-00 00:00:00',
  `created_by_id` int(10) unsigned default NULL,
  `updated_on` datetime NOT NULL default '0000-00-00 00:00:00',
  `updated_by_id` int(10) unsigned default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB <?php echo $default_charset ?>;