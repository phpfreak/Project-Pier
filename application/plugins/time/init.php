<?php
  // add project tab
  add_action('add_project_tab', 'times_add_project_tab');
  function times_add_project_tab() {
    add_tabbed_navigation_item(
      'time',
      'time',
      get_url('time', 'index')
    );
  }

  // add administration tab
  add_action('add_administration_tab', 'times_add_administration_tab');
  function times_add_administration_tab() {
    add_tabbed_navigation_item(
      'time',
      'time',
      get_url('administration', 'time')
    );
  }
 
  // overview page
  add_action('project_overview_page_actions','times_project_overview_page_actions');
  function times_project_overview_page_actions() {
    //not_existing_function();
    if (ProjectTime::canAdd(logged_user(), active_project())) {
      add_page_action(lang('add time'), get_url('time', 'add'));
    } // if
  }

  // my tasks dropdown
  add_action('my_tasks_dropdown','times_my_tasks_dropdown');
  function times_my_tasks_dropdown() {
    echo '<li class="header"><a href="'.get_url('time', 'index').'">'.lang('time').'</a></li>';
    if (ProjectTime::canAdd(logged_user(), active_project())) {
      echo '<li><a href="'.get_url('time', 'add').'">'.lang('add time').'</a></li>';
    } // if
  }

  // administration dropdown
  add_action('administration_dropdown','times_administration_dropdown');
  function times_administration_dropdown() {
    echo '<li class="header"><a href="'.get_url('administration', 'time').'">'.lang('time').'</a></li>';
  }

  
  /**
  * If you need an activation routine run from the admin panel
  *   use the following pattern for the function:
  *
  *   <name_of_plugin>_activate
  *
  *  This is good for creation of database tables etc.
  */
  function time_activate() {
    $tp = TABLE_PREFIX;
    $cs = 'character set '.config_option('character_set', 'utf8');
    $co = 'collate '.config_option('collate', 'utf8_unicode_ci');
    $sql = "
CREATE TABLE IF NOT EXISTS `{$tp}project_times` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `project_id` int(10) unsigned default NULL,
  `task_list_id` int(11) default NULL,
  `task_id` int(11) default NULL,
  `name` varchar(100) $cs $co default NULL,
  `description` text $cs $co default NULL,
  `done_date` datetime NOT NULL default '0000-00-00 00:00:00',
  `hours` float(4,2) NOT NULL default '0.00',
  `is_billable` tinyint(1) unsigned NOT NULL default '1',
  `assigned_to_company_id` smallint(10) NOT NULL default '0',
  `assigned_to_user_id` int(10) unsigned NOT NULL default '0',
  `is_private` tinyint(1) unsigned NOT NULL default '0',
  `is_closed` tinyint(1) unsigned NOT NULL default '0',
  `created_on` datetime NOT NULL default '0000-00-00 00:00:00',
  `created_by_id` int(10) unsigned default NULL,
  `updated_on` datetime NOT NULL default '0000-00-00 00:00:00',
  `updated_by_id` int(10) unsigned default NULL,
  PRIMARY KEY  (`id`),
  KEY `project_id` (`project_id`),
  KEY `done_date` (`done_date`),
  KEY `created_on` (`created_on`)
);
";
    // create table
    DB::execute($sql);
    // TODO insert config options
    // TODO insert permission options
  }
  
  /**
  * If you need an de-activation routine run from the admin panel
  *   use the following pattern for the function:
  *
  *   <name_of_plugin>_deactivate
  *
  *  This is good for deletion of database tables etc.
  */
  function time_deactivate($purge=false) {
    if ($purge) {
      $tp = TABLE_PREFIX;
      // TODO rename table to xxx_del
      // maybe just rename table to xxx_del
      // DB::execute("RENAME TABLE `{$pf}project_times` TO `{$pf}project_times_del` ;
      DB::execute("DROP TABLE IF EXISTS `{$tp}project_times`;");
      // TODO delete config options
      // TODO delete permission options
    }
  }
  
?>