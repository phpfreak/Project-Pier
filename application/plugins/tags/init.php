<?php
  // add project tab
  add_action('add_project_tab', 'tags_add_project_tab');
  function tags_add_project_tab() {
    add_tabbed_navigation_item(
      'tags',
      'tags',
      get_url('project', 'tags')
    );
  }

  // my tasks dropdown
  add_action('my_tasks_dropdown','tags_my_tasks_dropdown');
  function tags_my_tasks_dropdown() {
    echo '<li class="header"><a href="'.get_url('project', 'tags').'">'.lang('tags').'</a></li>';
  }
 
  /**
  * If you need an activation routine run from the admin panel
  *   use the following pattern for the function:
  *
  *   <name_of_plugin>_activate
  *
  *  This is good for creation of database tables etc.
  */
  function tags_activate() {
    $tp = TABLE_PREFIX;
    $cs = 'character set '.config_option('character_set', 'utf8');
    $co = 'collate '.config_option('collation', 'utf8_unicode_ci');
    $sql = "
CREATE TABLE IF NOT EXISTS `{$tp}tags` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `project_id` int(10) unsigned NOT NULL default '0',
  `tag` varchar(50) $cs $co NOT NULL default '',
  `rel_object_id` int(10) unsigned NOT NULL default '0',
  `rel_object_manager` varchar(50) $cs $co NOT NULL default '',
  `created_on` datetime default NULL,
  `created_by_id` int(10) unsigned NOT NULL default '0',
  `is_private` tinyint(1) NOT NULL default '0',
  PRIMARY KEY  (`id`),
  KEY `project_id` (`project_id`),
  KEY `tag` (`tag`),
  KEY `object_id` (`rel_object_id`,`rel_object_manager`)
);
"; 
    // create table 
    DB::execute($sql);
  }
  
  /**
  * If you need an de-activation routine run from the admin panel
  *   use the following pattern for the function:
  *
  *   <name_of_plugin>_deactivate
  *
  *  This is good for deletion of database tables etc.
  */
  function tags_deactivate($purge=false) {
    // sample drop table
    if ($purge)
    {
        $tp = TABLE_PREFIX;
        DB::execute("DROP TABLE IF EXISTS `{$tp}tags`;");
        DB::execute("DELETE FROM `{$tp}application_logs` where rel_object_manager='Tags';");
    }
  }
  
?>