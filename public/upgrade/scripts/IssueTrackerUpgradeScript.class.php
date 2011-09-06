<?php

  /**
  * Upgrade ProjectPier to support issue tracker
  *
  * @package ScriptUpgrader.scripts
  * @http://www.projectpier.org/
  */
  class IssueTrackerUpgradeScript extends ScriptUpgraderScript {
  
    /**
    * Database connection link
    *
    * @var resource
    */
    private $database_connection = null;
  
    /**
    * Construct the IssueTrackerUpgradeScript
    *
    * @param Output $output
    * @return IssueTrackerUpgradeScript
    */
    function __construct(Output $output) {
      parent::__construct($output);
      $this->setVersionFrom('0.8.0');
      $this->setVersionTo('0.8.0');
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
      
      if (substr(PRODUCT_VERSION, 0, 3) !== '0.8') {
        $this->printMessage('This upgrade script is intended for version 0.8.x. You\'re running ProjectPier v.'.PRODUCT_VERSION.'.', true);
        return false;
      } // if
      
      // ---------------------------------------------------
      //  Connect to database
      // ---------------------------------------------------
      
      if ($this->database_connection = mysql_connect(DB_HOST, DB_USER, DB_PASS)) {
        if (mysql_select_db(DB_NAME, $this->database_connection)) {
          $this->printMessage('Upgrade script has connected to the database.');
        } else {
          $this->printMessage('Failed to select database ' . DB_NAME);
          return false;
        } // if
      } else {
        $this->printMessage('Failed to connect to database', true);
        return false;
      } // if
      
      
      // ---------------------------------------------------
      //  Check existence of tables for Tickets
      // ---------------------------------------------------
      
      $tables_to_check = array('project_categories', 'project_tickets', 'ticket_changes', 'ticket_subscriptions');
      
      foreach ($tables_to_check as $table) {
        $test_table_exists_sql = "SHOW TABLES LIKE '".TABLE_PREFIX."$table';";
        if (mysql_num_rows(mysql_query($test_table_exists_sql, $this->database_connection))) {
          $this->printMessage("Table ".TABLE_PREFIX."$table already exists. It is recommended to proceed with the upgrade manually.", true);
          return false;
        }
      } // foreach
      $this->printMessage('The tables that need to be created do not exist already. It is safe to proceed with the database migration.');
      
      // ---------------------------------------------------
      //  Check MySQL version
      // ---------------------------------------------------
      
      $mysql_version = mysql_get_server_info($this->database_connection);
      if ($mysql_version && version_compare($mysql_version, '4.1', '>=')) {
        $constants['DB_CHARSET'] = 'utf8';
        mysql_query("SET NAMES 'utf8'", $this->database_connection);
        tpl_assign('default_collation', $default_collation = 'collate utf8_unicode_ci');
        tpl_assign('default_charset', $default_charset = 'DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci');
      } else {
        tpl_assign('default_collation', $default_collation = '');
        tpl_assign('default_charset', $default_charset = '');
      } // if
      
      tpl_assign('table_prefix', TABLE_PREFIX);
      
      // ---------------------------------------------------
      //  Check test query
      // ---------------------------------------------------
      
      $test_table_name = TABLE_PREFIX . 'test_table';
      $test_table_sql = "CREATE TABLE `$test_table_name` (
        `id` int(10) unsigned NOT NULL auto_increment,
        `name` varchar(50) $default_collation NOT NULL default '',
        PRIMARY KEY  (`id`)
      ) ENGINE=InnoDB $default_charset;";
      
      if (mysql_query($test_table_sql, $this->database_connection)) {
        $this->printMessage('Test query has been executed. It\'s safe to proceed with database migration.');
        mysql_query("DROP TABLE `$test_table_name`", $this->database_connection);
      } else {
        $this->printMessage('Failed to executed test query. MySQL said: ' . mysql_error($this->database_connection), true);
        return false;
      } // if
      
      //return ;
      
      // ---------------------------------------------------
      //  Execute migration
      // ---------------------------------------------------

      $total_queries = 0;
      $executed_queries = 0;
      $upgrade_script = tpl_fetch(get_template_path('db_migration/issuetracker'));
      
      mysql_query('BEGIN WORK');
      if ($this->executeMultipleQueries($upgrade_script, $total_queries, $executed_queries, $this->database_connection)) {
        $this->printMessage("Database schema transformations executed (total queries: $total_queries)");
        mysql_query('COMMIT');
      } else {
        $this->printMessage('Failed to execute DB schema transformations. MySQL said: ' . mysql_error(), true);
        mysql_query('ROLLBACK');
        return false;
      } // if
            
      $this->printMessage('ProjectPier has been patched for Issue Tracker. Enjoy!');
    } // execute
    

    /**
    * Return script name.
    *
    * @param void
    * @return string
    */
    function getScriptName() {
      return 'Upgrade of DB for Issue Tracker patch';
    } // getName
    
  
  } // IssueTrackerUpgradeScript

?>