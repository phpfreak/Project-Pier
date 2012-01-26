<?php
// Reports Tab Definition

//define('DASHBOARD_TAB_MY_REPORTS', 'my_reports');
//  add_action('add_dashboard_tab', 'reports_add_dashboard_tab');
//  function reports_add_dashboard_tab() {
//    trace(__FILE__,'reports_add_dashboard_tab()');
//    add_tabbed_navigation_item(new TabbedNavigationItem(
//      DASHBOARD_TAB_MY_REPORTS,
//      "My Reports",
//      get_url('reports', 'my_reports')
//    ));
//  }
  
// My Account Reminders and Reports Tab Defintion 
  define('ACCOUNT_TAB_MY_REMINDERS', 'reminders');
  add_action('add_my_account_tab', 'reminders_add_account_tab');
  function reminders_add_account_tab() {
    trace(__FILE__,'reminders_add_account_tab()');
//    add_tabbed_navigation_item(new TabbedNavigationItem(
//      ACCOUNT_TAB_MY_REPORTS,
//      "Reports and Reminders",
//      get_url('reports', 'reports_preferences')
 //   ));
    add_page_action(lang("reminders"), get_url('reminders', 'preferences'));
  }

  add_action('account_overview_page_actions','reports_account_page_actions');
  function reports_account_page_actions() {
    add_page_action(lang('reminders', get_url('reminders', 'preferences')));
  } // if

  $weekArray = array(
    'sunday', 
    'monday',
    'tuesday',
    'wednesday',
    'thursday',
    'friday',
    'saturday',
  );
     
  tpl_assign('weekArray', $weekArray);

  function reminders_activate() {
    $tp = TABLE_PREFIX;
    $cs = 'character set '.config_option('character_set', 'utf8');
    $co = 'collate '.config_option('collation', 'utf8_unicode_ci');
    $sql = "
CREATE TABLE IF NOT EXISTS `{$tp}reminders` (
  `user_id` int(10) unsigned NOT NULL default '0',
  `reminders_enabled` boolean,
  `summarized_by` ENUM('all', 'project', 'milestone', 'task list', 'task') NOT NULL,
  `days_in_future` int unsigned not null default '0',
  `include_everyone` boolean,
  `reminder_days` SET('Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'),
  `reports_enabled` boolean,
  `reports_summarized_by` boolean,
  `reports_include` boolean,
  `reports_activity` boolean,
  `report_day` ENUM('Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'),  
  PRIMARY KEY  (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=".DB_CHARSET;
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
  function reports_deactivate($purge=false) {
    // sample drop table
    if ($purge) {
      DB::execute("DROP TABLE IF EXISTS `".TABLE_PREFIX."reminders`;");
    }
  }

?>
