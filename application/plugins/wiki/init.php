<?php
  // add project tab
  define('PROJECT_TAB_WIKI', 'wiki');
  add_action('add_project_tab', 'wiki_add_project_tab');
  function wiki_add_project_tab() {
    add_tabbed_navigation_item(new TabbedNavigationItem(
      PROJECT_TAB_WIKI,
      lang('wiki'),
      get_url('wiki', 'index')
    ));
  }
 
  // overview page
  add_action('project_overview_page_actions','wiki_project_overview_page_actions');
  function wiki_project_overview_page_actions() {
    if (WikiPage::canAdd(logged_user(), active_project())) {
      add_page_action(lang('add wiki page'), get_url('wiki', 'add'));
    } // if
  }

  // my tasks dropdown
  add_action('my_tasks_dropdown','wiki_my_tasks_dropdown');
  function wiki_my_tasks_dropdown() {
    echo '<li class="header"><a href="'.get_url('wiki', 'index').'">'.lang('wiki').'</a></li>';
    if (WikiPage::canAdd(logged_user(), active_project())) {
      echo '<li><a href="'.get_url('wiki', 'add').'">'.lang('add wiki page').'</a></li>';
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
  function wiki_activate() {
    $sql = "
CREATE TABLE IF NOT EXISTS `".TABLE_PREFIX."wiki_pages` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `revision` int(10) unsigned default NULL,
  `project_id` int(10) unsigned default NULL,
  `project_sidebar` tinyint(1) unsigned default '0',
  `project_index` tinyint(1) unsigned default '0',
  `locked` tinyint(1) default '0',
  `locked_by_id` int(10) unsigned default NULL,
  `locked_on` datetime default '0000-00-00 00:00:00',
  PRIMARY KEY  (`id`)
) TYPE=InnoDB  DEFAULT CHARSET=".DB_CHARSET;
    // create table wiki_pages
    DB::execute($sql);
    $sql = "
CREATE TABLE IF NOT EXISTS `".TABLE_PREFIX."wiki_revisions` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `project_id` int(10) unsigned default NULL,
  `page_id` int(10) unsigned default NULL,
  `revision` tinyint(3) unsigned default NULL,
  `name` varchar(50) NOT NULL,
  `content` text NOT NULL,
  `created_on` datetime default NULL,
  `created_by_id` int(10) unsigned default NULL,
  `log_message` varchar(255) default NULL,
  PRIMARY KEY  (`id`)
) TYPE=InnoDB  DEFAULT CHARSET=".DB_CHARSET;
    // create table wiki_revisions
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
  function wiki_deactivate($purge=false) {
    // sample drop table
    if ($purge)
    {
        DB::execute("DROP TABLE IF EXISTS `".TABLE_PREFIX."wiki_revisions`;");
        DB::execute("DROP TABLE IF EXISTS `".TABLE_PREFIX."wiki_pages`;");
        DB::execute("DELETE FROM `".TABLE_PREFIX."application_logs` where rel_object_manager='Wiki';");
    }
  }
  
?>
