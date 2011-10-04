<?php

  /**
  * Upgrade from 0.8.0.3 to 0.8.6
  *
  * @package ScriptUpgrader.scripts
  * @http://www.projectpier.org/
  */
  class PearUpgradeScript extends ScriptUpgraderScript {
  
    /**
    * Database connection link
    *
    * @var resource
    */
    private $database_connection = null;
    private $default_collation = '';
    private $default_charset = '';
  
    /**
    * Construct the PearUpgradeScript
    *
    * @param Output $output
    * @return QuinceUpgradeScript
    */
    function __construct(Output $output) {
      parent::__construct($output);
      $this->setVersionFrom('0.8.0.3');
      $this->setVersionTo('0.8.6');
    } // __construct
    
    /**
    * Execute the script
    *
    * @param void
    * @return boolean
    */
    function execute() {
      define('ROOT', realpath(dirname(__FILE__) . '/../../../'));
      
      // ---------------------------------------------------
      //  Load config
      // ---------------------------------------------------
      
      $config_is_set = require_once INSTALLATION_PATH . '/config/config.php';
      if (!$config_is_set) {
        $this->printMessage('Valid config files was not found!', true);
        return false;
      } else {
        $this->printMessage('Config file found and loaded.');
      } // if
      
      if (PRODUCT_VERSION == '0.8.6') {
        $this->printMessage('You are already running ProjectPier 0.8.6');
        return true;
      } // if
      
      if (PRODUCT_VERSION !== '0.8.0.3') {
        $this->printMessage('This upgrade script can be used only to upgrade 0.8.0.3 to 0.8.6', true);
        return false;
      } // if
      
      // ---------------------------------------------------
      //  Connect to database
      // ---------------------------------------------------
      
      if ($this->database_connection = mysql_connect(DB_HOST, DB_USER, DB_PASS)) {
        $this->printMessage('Upgrade script has connected to database ' . DB_NAME);
        if (mysql_select_db(DB_NAME, $this->database_connection)) {
          $this->printMessage('Upgrade selected database ' . DB_NAME);
        } else {
          $this->printMessage('Failed to select database ' . DB_NAME);
          return false;
        } // if
      } else {
        $this->printMessage('Failed to connect to database ' . DB_HOST);
        return false;
      } // if
      
      // ---------------------------------------------------
      //  Check MySQL version
      // ---------------------------------------------------
      
      $mysql_version = mysql_get_server_info($this->database_connection);
      if ($mysql_version && version_compare($mysql_version, '4.1', '>=')) {
        $constants['DB_CHARSET'] = 'utf8';
        mysql_query("SET NAMES 'utf8'", $this->database_connection);
        tpl_assign('default_collation', $this->default_collation = 'collate utf8_unicode_ci');
        tpl_assign('default_charset', $this->default_charset = 'DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci');
      } else {
        tpl_assign('default_collation', $this->default_collation = '');
        tpl_assign('default_charset', $this->default_charset = '');
      } // if
      
      tpl_assign('table_prefix', TABLE_PREFIX);
      
      // ---------------------------------------------------
      //  Check test query
      // ---------------------------------------------------
      
      $test_table_name = TABLE_PREFIX . 'test_table';
      $test_table_sql = "CREATE TABLE `$test_table_name` (
        `id` int(10) unsigned NOT NULL auto_increment,
        `name` varchar(50) $this->default_collation NOT NULL default '',
        PRIMARY KEY  (`id`)
      ) ENGINE=InnoDB $this->default_charset;";
      
      if (mysql_query($test_table_sql, $this->database_connection)) {
        $this->printMessage('Test query has been executed. It is safe to proceed with database migration.');
        mysql_query("DROP TABLE `$test_table_name`", $this->database_connection);
      } else {
        $this->printMessage('Failed to executed test query. MySQL said: ' . mysql_error($this->database_connection), true);
        return false;
      } // if

      if (!file_is_writable(INSTALLATION_PATH . '/config/config.php')) {
        $this->printMessage('Configuration file is not writable.',true);
        return false;
      } // if
      $this->printMessage('Configuration file is writable.');

      // ---------------------------------------------------
      //  Execute migration
      // ---------------------------------------------------
      
      mysql_query('BEGIN WORK');
      
      if ($this->upgradePermissions() === false) {
        mysql_query('ROLLBACK');
        $this->printMessage('Upgrade process failed!', true);
        return false;
      } // if
      if ($this->addPluginsTable() === false) {
        mysql_query('ROLLBACK');
        $this->printMessage('Upgrade process failed!', true);
        return false;
      } // if
       if ($this->fixConfigFile() === false) {
         mysql_query('ROLLBACK');
         $this->printMessage('Upgrade process failed!', true);
         return false;
      } // if
      
      if (mysql_query('COMMIT')) {
        $this->printMessage('ProjectPier has been upgraded. You are now running ProjectPier 0.8.6. Enjoy!');
        return true;
      } else {
        $this->printMessage('Failed to commit updates. Upgrade process failed!', true);
        return false;
      } // if
    } // execute
    
    function upgradePermissions() {
      $this->printMessage('Migrating to new permissions system.');
      $permissions_table = TABLE_PREFIX . 'permissions';
      $project_user_permissions_table = TABLE_PREFIX . 'project_user_permissions';
      $project_users_table = TABLE_PREFIX . 'project_users';

      $permissionMap = array();
      $permissionMap["can_manage_files"] = 1;
      $permissionMap["can_upload_files"] = 2;
      $permissionMap["can_manage_milestones"] = 3;
      $permissionMap["can_manage_messages"] = 4;
      $permissionMap["can_manage_tasks"] = 5;
      $permissionMap["can_assign_to_owners"] = 6;
      $permissionMap["can_assign_to_other"] = 7;

      $insert_permissions_query = "INSERT INTO `$permissions_table` (id,source,permission) VALUES
(1,'files','manage'),
(2,'files','upload'),
(3,'milestones','manage'),
(4,'messages','manage'),
(5,'tasks','manage'),
(6,'tasks','assign to other clients'),
(7,'tasks','assign to owner company'),
(8,'tickets','manage'),
(9,'projects','manage'),
(10,'milestones','change status'),
(11,'times','manage')";

      $create_project_user_permissions_table_query = "CREATE TABLE `$project_user_permissions_table` (
`user_id` int(10) unsigned NOT NULL,
`project_id` int(10) unsigned NOT NULL,
`permission_id` int(10) unsigned NOT NULL,
PRIMARY KEY(`user_id`,`project_id`,`permission_id`)
) ENGINE=InnoDB ".$this->default_charset;

      $create_permissions_table_query = "CREATE TABLE `$permissions_table` (
        `id` int(10) unsigned NOT NULL auto_increment,
        `source` varchar(50) ".$this->default_collation." NOT NULL default '',
        `permission` varchar(100) NOT NULL default '',
        PRIMARY KEY  (`id`)
      ) ".$this->default_charset;
      
      if (!mysql_query($create_permissions_table_query)) {
        $this->printMessage("Failed to create permissions table. Error ".mysql_errno($this->database_connection) . ": " . mysql_error($this->database_connection),true);
        return false;
      } // if
      
      if (!mysql_query($insert_permissions_query)) {
        $this->printMessage("Failed to insert permissions tuples. Error ".mysql_errno($this->database_connection) . ": " . mysql_error($this->database_connection),true);
        return false;
      } // if

      if (!mysql_query($create_project_user_permissions_table_query)) {
        $this->printMessage("Failed to create project_user_permissions table. Error ".mysql_errno($this->database_connection) . ": " . mysql_error($this->database_connection),true);
        return false;
      } // if

      $pup_query = "select project_id, user_id, project_users.* FROM project_users";
      if ($result = mysql_query($pup_query)) {
        while ($row = mysql_fetch_assoc($result)) {
          $project_id = array_shift($row);
          $user_id = array_shift($row);
          foreach ($row as $permission => $value) {
            if ($value == 1) {
              if ($permission == 'created_by_id') {
                continue;
              } // if
              if (!isset($permissionMap[$permission])) {
                $this->printMessage("Ignoring permission $permission.  Migrate it yourself.\n");
                continue;
              } // if
              $sql = sprintf("INSERT INTO `%s` (`project_id`,`user_id`,`permission_id`) VALUES (%d,%d,%d)",$project_user_permissions_table,$project_id,$user_id,$permissionMap[$permission]);
              if(!mysql_query($sql)) {
                $this->printMessage("Failed to insert a (project,user,permission) tuple. Error ".mysql_errno($this->database_connection) . ": " . mysql_error($this->database_connection),true);
                return false;
              } // if
            } // if
          } // foreach
        } // while
        foreach (array_keys($permissionMap) as $column) {
          $alter_query = "ALTER TABLE `$project_users_table` drop column $column";
          if (!mysql_query($alter_query)) {
            $this->printMessage("Failed to drop permission columns from project_users table. Error ".mysql_errno($this->database_connection) . ": " . mysql_error($this->database_connection),true);
            return false;
          } // if
        } // foreach
      } else {
        $this->printMessage("Failed to retrieve current (project,user) permissions. Error ".mysql_errno($this->database_connection) . ": " . mysql_error($this->database_connection),true);
        return false;
      } // if
      return true;
    } // upgradePermissions


    function addPluginsTable() {
      $this->printMessage('Adding plugins table.');
      $plugins_table = TABLE_PREFIX.'plugins';
      $create_plugins_table_query = "CREATE TABLE `$plugins_table` (
  `plugin_id` int(10) unsigned NOT NULL auto_increment,
  `name` varchar(100) ".$this->default_collation." NOT NULL default '',
  `installed` tinyint NOT NULL default '1',
  PRIMARY KEY  (`plugin_id`)
) ENGINE=InnoDB ".$this->default_charset;

      if (!mysql_query($create_plugins_table_query)) {
        return false;
      } // if
      return true;
    } // addPluginTable
    
    /**
    * This function will fix configuration file
    *
    * @param void
    * @return null
    */
    function fixConfigFile() {
      $this->printMessage('Updating configuration file');
      $constants = array(
        'DB_ADAPTER'           => DB_ADAPTER,
        'DB_HOST'              => DB_HOST,
        'DB_USER'              => DB_USER,
        'DB_PASS'              => DB_PASS,
        'DB_NAME'              => DB_NAME,
        'DB_PERSIST'           => false,
        'DB_CHARSET'           => DB_CHARSET,
      ); // array
      tpl_assign('config_file_constants', $constants);
      if (file_put_contents(INSTALLATION_PATH . '/config/config.php', tpl_fetch(get_template_path('config_file')))) {
        $this->printMessage('Configuration file updated');
        return true;
      } else {
        $this->printMessage('Failed to update configuration file', true);
        return false;
      } // if
    } // fixConfigFile
      
  } // PearUpgradeScript
?>