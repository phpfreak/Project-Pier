<?php
  
  /**
  * All functions here are in the global scope so keep names unique by using
  *   the following pattern:
  *
  *   <name_of_plugin>_<pp_function_name>
  *   i.e. for the hook in 'add_dashboard_tab' use 'links_add_dashboard_tab'
  */
  
  // add project tab
  define('PROJECT_TAB_LINKS', 'links');
  add_action('add_project_tab', 'links_add_project_tab');
  function links_add_project_tab() {
    add_tabbed_navigation_item(new TabbedNavigationItem(
      PROJECT_TAB_LINKS,
      lang('links'),
      get_url('links', 'index')
    ));
  }
  
  // overview page
  add_action('project_overview_page_actions','links_project_overview_page_actions');
  function links_project_overview_page_actions() {
    if (ProjectLink::canAdd(logged_user(), active_project())) {
      add_page_action(lang('add link'), get_url('links', 'add_link'));
    } // if
  }

  // my tasks dropdown
  add_action('my_tasks_dropdown','links_my_tasks_dropdown');
  function links_my_tasks_dropdown() {
    echo '<li class="header"><a href="'.get_url('links', 'index').'">'.lang('links').'</a></li>';
    if (ProjectLink::canAdd(logged_user(), active_project())) { 
      echo '<li><a href="'.get_url('links', 'add_link').'">'.lang('add link').'</a></li>';
    } // if 
  }
  
  /**
  * If you need an activation routine run from the admin panel
  *   use the following pattern for the function:
  *
  *   <name_of_plugin>_activate
  *
  *  This is good for creation of database tables etc.
  */
  function links_activate() {
    $sql = "CREATE TABLE IF NOT EXISTS `".TABLE_PREFIX."project_links` (
        `id` int(10) unsigned NOT NULL auto_increment,
        `project_id` int(10) unsigned NOT NULL default '0',
        `title` varchar(100) NOT NULL default '',
        `url` text,
        `created_on` datetime NOT NULL default '0000-00-00 00:00:00',
        `created_by_id` int(10) unsigned default NULL,
        PRIMARY KEY  (`id`),
        KEY `created_on` (`created_on`),
        KEY `project_id` (`project_id`)
      ) ENGINE=InnoDB DEFAULT CHARSET=".DB_CHARSET."; ";
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
  function links_deactivate($purge=false) {
    // sample drop table
    if ($purge) {
      DB::execute("DROP TABLE IF EXISTS `".TABLE_PREFIX."project_links`");
    }
  }
