<?php
  trace(__FILE__,':begin');
  // add project tab
  define('PROJECT_TAB_FILES', 'files');
  add_action('add_project_tab', 'files_add_project_tab');
  function files_add_project_tab() {
    if (use_permitted(logged_user(), active_project(), 'files')) {
      add_tabbed_navigation_item(
        PROJECT_TAB_FILES,
        'files',
        get_url('files', 'index')
      );
    }
  }
 
  // overview page
  add_action('project_overview_page_actions','files_project_overview_page_actions');
  function files_project_overview_page_actions() {
    if (use_permitted(logged_user(), active_project(), 'files')) {
      if (ProjectFile::canAdd(logged_user(), active_project())) {
        add_page_action(lang('add file'), get_url('files', 'add_file'));
      } // if
      if (ProjectFolder::canAdd(logged_user(), active_project())) {
        add_page_action(lang('add folder'), get_url('files', 'add_folder'));
      } // if
    } // if
  }

  // my tasks dropdown
  add_action('my_tasks_dropdown','files_my_tasks_dropdown');
  function files_my_tasks_dropdown() {
    if (use_permitted(logged_user(), active_project(), 'files')) {
      echo '<li class="header"><a href="'.get_url('files', 'index').'">'.lang('files').'</a></li>';
      if (ProjectFile::canAdd(logged_user(), active_project())) {
        echo '<li><a href="'.get_url('files', 'add_file').'">'.lang('add file').'</a></li>';
      } // if
      if (ProjectFolder::canAdd(logged_user(), active_project())) { 
        echo '<li><a href="'.get_url('files', 'add_folder').'">'.lang('add folder').'</a></li>';
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
  function files_activate() {
    $tp = TABLE_PREFIX;
    $cs = 'character set '.config_option('character_set', 'utf8');
    $co = 'collate '.config_option('collation', 'utf8_unicode_ci');
    $sql = "
CREATE TABLE IF NOT EXISTS `{$tp}project_file_revisions` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `file_id` int(10) unsigned NOT NULL default '0',
  `file_type_id` smallint(5) unsigned NOT NULL default '0',
  `repository_id` varchar(40) $cs $co NOT NULL default '',
  `filename` varchar(100) $cs $co NOT NULL default '',
  `thumb_filename` varchar(44) $cs $co default NULL,
  `revision_number` int(10) unsigned NOT NULL default '0',
  `comment` text $cs $co,
  `type_string` varchar(140) $cs $co NOT NULL default '',
  `filesize` int(10) unsigned NOT NULL default '0',
  `created_on` datetime NOT NULL default '0000-00-00 00:00:00',
  `created_by_id` int(10) unsigned default NULL,
  `updated_on` datetime NOT NULL default '0000-00-00 00:00:00',
  `updated_by_id` int(10) unsigned default NULL,
  PRIMARY KEY  (`id`),
  KEY `file_id` (`file_id`),
  KEY `updated_on` (`updated_on`),
  KEY `revision_number` (`revision_number`)
);
";
    DB::execute($sql);
    $sql = "
CREATE TABLE IF NOT EXISTS `{$tp}project_files` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `project_id` int(10) unsigned NOT NULL default '0',
  `folder_id` smallint(5) unsigned NOT NULL default '0',
  `filename` varchar(100) $cs $co NOT NULL default '',
  `description` text $cs $co,
  `is_private` tinyint(1) unsigned NOT NULL default '0',
  `is_important` tinyint(1) unsigned NOT NULL default '0',
  `is_locked` tinyint(1) unsigned NOT NULL default '0',
  `is_visible` tinyint(1) unsigned NOT NULL default '0',
  `expiration_time` datetime NOT NULL default '0000-00-00 00:00:00',
  `comments_enabled` tinyint(1) unsigned NOT NULL default '0',
  `anonymous_comments_enabled` tinyint(1) unsigned NOT NULL default '0',
  `created_on` datetime NOT NULL default '0000-00-00 00:00:00',
  `created_by_id` int(10) unsigned default '0',
  `updated_on` datetime NOT NULL default '0000-00-00 00:00:00',
  `updated_by_id` int(10) unsigned default '0',
  PRIMARY KEY  (`id`),
  KEY `project_id` (`project_id`)
);
";
    DB::execute($sql);
    $sql = "
CREATE TABLE IF NOT EXISTS `{$tp}project_folders` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `project_id` int(10) unsigned NOT NULL default '0',
  `name` varchar(50) $cs $co NOT NULL default '',
  `parent_id` int(10) unsigned NOT NULL default '0',
  PRIMARY KEY  (`id`),
  UNIQUE KEY `project_id` (`project_id`,`name`)
);
";
    DB::execute($sql);

    $sql = "
INSERT INTO `{$tp}config_options` (`category_name`, `name`, `value`, `config_handler_class`, `is_system`, `option_order`, `dev_comment`) VALUES ('features', 'files_show_icons', '1', 'BoolConfigHandler', 0, 0, 'Show file icons') ON DUPLICATE KEY UPDATE `id` = `id`;
";
    DB::execute($sql);
    $sql = "
INSERT INTO `{$tp}config_options` (`category_name`, `name`, `value`, `config_handler_class`, `is_system`, `option_order`, `dev_comment`) VALUES ('features', 'files_show_thumbnails', '1', 'BoolConfigHandler', 0, 0, 'Show file thumbnails') ON DUPLICATE KEY UPDATE `id` = `id`;
";
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
  function files_deactivate($purge=false) {
    // sample drop table
    if ($purge)
    {
        DB::execute("DROP TABLE IF EXISTS `".TABLE_PREFIX."project_file_revisions`;");
        DB::execute("DROP TABLE IF EXISTS `".TABLE_PREFIX."project_files`;");
        DB::execute("DROP TABLE IF EXISTS `".TABLE_PREFIX."project_folders`;");
        DB::execute("DELETE FROM `".TABLE_PREFIX."application_logs` where rel_object_manager='files';");
        DB::execute("DELETE FROM `".TABLE_PREFIX."config_options` where name='files_show_icons';");
        DB::execute("DELETE FROM `".TABLE_PREFIX."config_options` where name='files_show_thumbnails';");
    }
  }
  trace(__FILE__,':end');
?>