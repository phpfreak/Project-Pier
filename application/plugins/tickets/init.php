<?php
  define('DASHBOARD_TAB_MY_TICKETS', 'my_tickets');
  add_action('add_dashboard_tab', 'tickets_add_dashboard_tab');
  function tickets_add_dashboard_tab() {
    trace(__FILE__,'tickets_add_dashboard_tab()');
    if (use_permitted(logged_user(), active_project(), 'tickets')) {
      add_tabbed_navigation_item(
        DASHBOARD_TAB_MY_TICKETS,
        'my tickets',
        get_url('tickets', 'my_tickets')
      );
    } // if
  }

  // add project tab
  define('PROJECT_TAB_TICKETS', 'tickets');
  add_action('add_project_tab', 'tickets_add_project_tab');
  function tickets_add_project_tab() {
    if (use_permitted(logged_user(), active_project(), 'tickets')) {
      add_tabbed_navigation_item(
        PROJECT_TAB_TICKETS, 
        'tickets', 
        get_url('tickets', 'index')
      );
    } // if
  }
 
  // overview page
  add_action('project_overview_page_actions','tickets_project_overview_page_actions');
  function tickets_project_overview_page_actions() {
    if (use_permitted(logged_user(), active_project(), 'tickets')) {
      if (ProjectTicket::canAdd(logged_user(), active_project())) {
        add_page_action(lang('add ticket'), get_url('tickets', 'add_ticket'));
      } // if
    } // if
  }

  // my tasks dropdown
  add_action('my_tasks_dropdown','tickets_my_tasks_dropdown');
  function tickets_my_tasks_dropdown() {
    if (use_permitted(logged_user(), active_project(), 'tickets')) {
      echo '<li class="header"><a href="'.get_url('tickets', 'index').'">'.lang('tickets').'</a></li>';
      if (ProjectTicket::canAdd(logged_user(), active_project())) {
        echo '<li><a href="'.get_url('tickets', 'add_ticket').'">'.lang('add ticket').'</a></li>';
      } // if
    } // if
  }

  // dashboard content (overview)
  add_action('dashboard_content','tickets_dashboard_content');
  function tickets_dashboard_content($context) {
    $tickets = ProjectTickets::getOpenTicketsByUser(logged_user());
    $context->assign('ticketsheader', lang('open tickets'));
    $context->assign('tickets', $tickets);
    $context->includeTemplate(get_template_path('dashboard', 'tickets'));
  }
  
  /**
  * If you need an activation routine run from the admin panel
  *   use the following pattern for the function:
  *
  *   <name_of_plugin>_activate
  *
  *  This is good for creation of database tables etc.
  */
  function tickets_activate() {
    $tp = TABLE_PREFIX;
    $cs = 'character set '.config_option('character_set', 'utf8');
    $co = 'collate '.config_option('collation', 'utf8_unicode_ci');

    $sql = "
CREATE TABLE IF NOT EXISTS `{$tp}project_categories` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `project_id` int(10) unsigned NOT NULL default '0',
  `name` varchar(50) $cs $co NOT NULL default '',
  `description` varchar(255) $cs $co default NULL,
  PRIMARY KEY  (`id`)
);
";
    DB::execute($sql);

    $sql = "
CREATE TABLE IF NOT EXISTS `{$tp}project_tickets` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `project_id` int(10) unsigned NOT NULL default '0',
  `milestone_id` int( 10 ) unsigned NOT NULL DEFAULT 0,
  `category_id` int(10) unsigned default NULL,
  `assigned_to_company_id` int(10) unsigned default NULL,
  `assigned_to_user_id` int(10) unsigned default NULL,
  `summary` varchar(255)  $cs $co NOT NULL default '',
  `type` enum('defect', 'enhancement', 'feature request') $cs $co NOT NULL default 'defect',
  `description` text $cs $co,
  `priority` enum('critical', 'major', 'minor', 'trivial') $cs $co NOT NULL default 'major',
  `state` enum( 'opened', 'confirmed', 'not reproducable', 'test and confirm', 'fixed', 'closed', 'none' ) $cs $co NOT NULL DEFAULT 'opened',
  `is_private` tinyint(1) NOT NULL default '0',
  `due_date` datetime NOT NULL default '0000-00-00 00:00:00',
  `closed_on` datetime NOT NULL default '0000-00-00 00:00:00',
  `closed_by_id` int(10) default NULL,
  `created_on` datetime NOT NULL default '0000-00-00 00:00:00',
  `created_by_id` int(10) unsigned default NULL,
  `updated_on` datetime NOT NULL default '0000-00-00 00:00:00',
  `updated_by_id` int(10) default NULL,
  `updated` enum('settings', 'comment', 'attachment', 'open', 'closed') $cs $co default NULL,
  PRIMARY KEY  (`id`),
  KEY `created_on` (`created_on`),
  KEY `closed_on` (`closed_on`),
  KEY `project_id` (`project_id`)
);
";
    DB::execute($sql);
    $sql = "
CREATE TABLE IF NOT EXISTS `{$tp}project_ticket_changes` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `ticket_id` int(10) unsigned NOT NULL default '0',
  `type` enum('milestone', 'status', 'priority', 'assigned to', 'summary', 'category', 'type', 'private', 'comment', 'attachment', '') $cs $co NOT NULL,
  `from_data` varchar(255) $cs $co NOT NULL default '',
  `to_data` varchar(255) $cs $co NOT NULL default '',
  `created_on` datetime NOT NULL default '0000-00-00 00:00:00',
  `created_by_id` int(10) default NULL,
  PRIMARY KEY  (`id`),
  KEY `created_on` (`created_on`),
  KEY `ticket_id` (`ticket_id`)
);
";
    DB::execute($sql);
    $sql = "
CREATE TABLE IF NOT EXISTS `{$tp}project_ticket_subscriptions` (
  `ticket_id` int(10) unsigned NOT NULL default '0',
  `user_id` int(10) unsigned NOT NULL default '0',
  PRIMARY KEY  (`ticket_id`,`user_id`)
);
";
    // create table
    DB::execute($sql);

    $sql = "INSERT INTO `{$tp}config_categories` (`name`, `is_system`, `category_order`) 
VALUES ('tickets', 0, 4) ON DUPLICATE KEY UPDATE `id` = `id`;";
    DB::execute($sql);

    $sql = "INSERT INTO `{$tp}config_options` 
(`category_name`, `name`, `value`, `config_handler_class`, `is_system`, `option_order`, `dev_comment`) 
VALUES ('tickets', 'tickets_default_categories', 'information request\r\nchange request\r\nincident report\r\ncomplaint\r\ndefect report\r\ngeneral/other', 'TextConfigHandler', 0, 3, NULL) 
ON DUPLICATE KEY UPDATE `id` = `id`";
    DB::execute($sql);

    // TODO add permissions
  }
  

  /**
  * If you need an de-activation routine run from the admin panel
  *   use the following pattern for the function:
  *
  *   <name_of_plugin>_deactivate
  *
  *  This is good for deletion of database tables etc.
  */
  function tickets_deactivate($purge=false) {
    // sample drop table
    if ($purge)
    {
        DB::execute("DROP TABLE IF EXISTS `".TABLE_PREFIX."project_categories`;");
        DB::execute("DROP TABLE IF EXISTS `".TABLE_PREFIX."project_tickets`;");
        DB::execute("DROP TABLE IF EXISTS `".TABLE_PREFIX."project_ticket_changes`;");
        DB::execute("DROP TABLE IF EXISTS `".TABLE_PREFIX."project_ticket_subscriptions`;");
        DB::execute("DELETE FROM `".TABLE_PREFIX."application_logs` where rel_object_manager='ProjectTickets';");
        DB::execute("DELETE FROM `".TABLE_PREFIX."config_categories` WHERE `name` = 'tickets';");
        DB::execute("DELETE FROM `".TABLE_PREFIX."config_options` WHERE `name` = 'tickets_default_categories';");
        // TODO delete permissions
    }
  }
  
?>