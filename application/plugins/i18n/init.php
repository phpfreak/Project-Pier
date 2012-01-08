<?php

  /**
  * Internationalization (i18n) plugin
  * Support to manage all internationalization items of project pier
  * All functions are administration level (not project level)
  *
  * Reinier van Loon (phpfreak)
  */
  
  /**
  * All functions here are in the global scope so keep names unique by using
  *   the following pattern:
  *
  *   <name_of_plugin>_<pp_function_name>
  *   i.e. for the hook in 'add_dashboard_tab' use 'i18n_add_dashboard_tab'
  */

  // add administration tab
  add_action('add_administration_tab', 'i18n_add_administration_tab');
  function i18n_add_administration_tab() {
    add_tabbed_navigation_item(
      'i18n',
      'i18n',
      get_url('i18n', 'index')
    );
  }

  // administration dropdown
  add_action('administration_dropdown','i18n_administration_dropdown');
  function i18n_administration_dropdown() {
    echo '<li class="header"><a href="'.get_url('i18n', 'index').'">'.lang('i18n').'</a></li>';
  }
  
  /**
  * If you need an activation routine run from the admin panel
  *   use the following pattern for the function:
  *
  *   <name_of_plugin>_activate
  *
  *  This is good for creation of database tables etc.
  */
  function i18n_activate() {
    $sql = "
      CREATE TABLE IF NOT EXISTS `".TABLE_PREFIX."i18n_locale` (
        `id` int(10) unsigned not null auto_increment,
        `name` varchar(50) not null default '',
        `description` text default '',
        `language_code` varchar(50) not null default '',
        `country_code` varchar(50) not null default '',
        `logo_file` varchar( 50 ) default '',
        `editor_id` int(10) unsigned default NULL,
        `created_on` datetime not null default '0000-00-00 00:00:00',
        `created_by_id` int(10) unsigned default NULL,
        `updated_on` datetime not null default '0000-00-00 00:00:00',
        `updated_by_id` int(10) unsigned default NULL,
        PRIMARY KEY  (`id`),
        UNIQUE KEY  (`language_code`, `country_code`),
        KEY `created_on` (`created_on`)
      );";
    // create table
    DB::execute($sql);
    $sql = "
      CREATE TABLE IF NOT EXISTS `".TABLE_PREFIX."i18n_section` (
        `id` int(10) unsigned not null auto_increment,
        `name` varchar(50) not null default '',
        `description` text default '',
        `created_on` datetime not null default '0000-00-00 00:00:00',
        `created_by_id` int(10) unsigned default NULL,
        `updated_on` datetime not null default '0000-00-00 00:00:00',
        `updated_by_id` int(10) unsigned default NULL,
        PRIMARY KEY  (`id`)
      );";
    // create table
    DB::execute($sql);
    $sql = "
      CREATE TABLE IF NOT EXISTS `".TABLE_PREFIX."i18n_value` (
        `id` int(10) unsigned not null auto_increment,
        `locale_id` int(10) unsigned not null,
        `section_id` int(10) unsigned not null default 0,
        `name` varchar(50) not null default '',
        `value` text default '',
        `created_on` datetime not null default '0000-00-00 00:00:00',
        `created_by_id` int(10) unsigned default NULL,
        `updated_on` datetime not null default '0000-00-00 00:00:00',
        `updated_by_id` int(10) unsigned default NULL,
        PRIMARY KEY (`id`),
        UNIQUE KEY (`locale_id`, `name`)
      );";
    // create table
    DB::execute($sql);
    //add_permission('i18n', PermissionManager::CAN_ACCESS);
    //add_permission('i18n', PermissionManager::CAN_ADD);  // = add/edit
    //add_permission('i18n', PermissionManager::CAN_DELETE);
    //add_permission('i18n', PermissionManager::CAN_VIEW);
  }

  /**
  * If you need an de-activation routine run from the admin panel
  *   use the following pattern for the function:
  *
  *   <name_of_plugin>_deactivate
  *
  *  This is good for deletion of database tables etc.
  */
  function i18n_deactivate($purge=false) {
    // sample drop table
    if ($purge) {
      DB::execute("DROP TABLE IF EXISTS `".TABLE_PREFIX."i18n_value`");
      DB::execute("DROP TABLE IF EXISTS `".TABLE_PREFIX."i18n_section`");
      DB::execute("DROP TABLE IF EXISTS `".TABLE_PREFIX."i18n_locale`");
      // permissions not implemented yet for i18n 
      //remove_permission_source('i18n');
      // TODO: Remove any logo files
    }
  }
?>