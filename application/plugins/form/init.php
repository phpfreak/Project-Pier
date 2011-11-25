<?php
  // add project tab
  define('PROJECT_TAB_FORMS', 'form');
  add_action('add_project_tab', 'form_add_project_tab');
  function form_add_project_tab() {
    if (logged_user()->isAdministrator()) {
      add_tabbed_navigation_item(
        PROJECT_TAB_FORMS,
        'forms',
        get_url('form', 'index')
      );
    } // if
  }
 
  // overview page
  add_action('project_overview_page_actions','form_project_overview_page_actions');
  function form_project_overview_page_actions() {
    if (use_permitted(logged_user(), active_project(), 'forms')) {
      if (ProjectForm::canAdd(logged_user(), active_project())) {
        add_page_action(lang('add form'), get_url('form', 'add'));
      } // if
    } // if
  }

  // my tasks dropdown
  add_action('my_tasks_dropdown','form_my_tasks_dropdown');
  function form_my_tasks_dropdown() {
    if (use_permitted(logged_user(), active_project(), 'forms')) {
      echo '<li class="header"><a href="'.get_url('form', 'index').'">'.lang('forms').'</a></li>';
      if (ProjectForm::canAdd(logged_user(), active_project())) {
        echo '<li><a href="'.get_url('form', 'add').'">'.lang('add form').'</a></li>';
      } // if
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
  function form_activate() {
    $tp = TABLE_PREFIX;
    $cs = 'character set '.config_option('character_set', 'utf8');
    $co = 'collate '.config_option('collation', 'utf8_unicode_ci');
    $sql = "
CREATE TABLE IF NOT EXISTS `{$tp}project_forms` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `project_id` int(10) unsigned NOT NULL default '0',
  `name` varchar(50) NOT NULL default '',
  `description` text $cs $co NOT NULL,
  `success_message` text $cs $co NOT NULL,
  `action` enum('add_comment','add_task') $cs $co NOT NULL default 'add_comment',
  `in_object_id` int(10) unsigned NOT NULL default '0',
  `created_on` datetime default NULL,
  `created_by_id` int(10) unsigned NOT NULL default '0',
  `updated_on` datetime NOT NULL default '0000-00-00 00:00:00',
  `updated_by_id` int(10) unsigned NOT NULL default '0',
  `is_visible` tinyint(1) unsigned NOT NULL default '0',
  `is_enabled` tinyint(1) unsigned NOT NULL default '0',
  `order` tinyint(3) NOT NULL default '0',
  PRIMARY KEY  (`id`)
);";
    // create table wiki_pages
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
  function form_deactivate($purge=false) {
    // sample drop table
    if ($purge)
    {
        DB::execute("DROP TABLE IF EXISTS `".TABLE_PREFIX."project_forms`;");
        DB::execute("DELETE FROM `".TABLE_PREFIX."application_logs` where rel_object_manager='Form';");
    }
  }
  
?>