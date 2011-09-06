<?php

  /**
  * Upgrade from 0.7.1/0.8.0.x to 0.8.0.3
  *
  * @package ScriptUpgrader.scripts
  * @http://www.projectpier.org/
  */
  class RhubarbUpgradeScript extends ScriptUpgraderScript {
  
    /**
    * Database connection link
    *
    * @var resource
    */
    private $database_connection = null;
  
    /**
    * Construct the RhubarbUpgradeScript
    *
    * @param Output $output
    * @return RhubarbUpgradeScript
    */
    function __construct(Output $output) {
      parent::__construct($output);
      $this->setVersionFrom('0.8.0');
      $this->setVersionTo('0.8.0.3');
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
        $this->printMessage('Valid config file was not found!', true);
        return false;
      } else {
        $this->printMessage('Config file found and loaded.');
      } 
      
      if (PRODUCT_VERSION == '0.8.0.3') {
        $this->printMessage('You are already running ProjectPier 0.8.0.3');
        return true;
      }
      
      if (PRODUCT_VERSION !== '0.7.1' &&
          preg_match('/^0\.8\.0(?:\.[0-3])?$/', PRODUCT_VERSION) == 0) {
        $this->printMessage('This upgrade script can be used only to upgrade 0.7.1 or 0.8.0.x to 0.8.0.3', true);
        return false;
      }
      
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
        $this->printMessage('Failed to connect to database');
        return false;
      } // if
      
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
        $this->printMessage('Test query has been executed. Its safe to proceed with database migration.');
        mysql_query("DROP TABLE `$test_table_name`", $this->database_connection);
      } else {
        $this->printMessage('Failed to executed test query. MySQL said: ' . mysql_error($this->database_connection), true);
        return false;
      } 
      
      //return ;
      
      // ---------------------------------------------------
      //  Execute migration
      // ---------------------------------------------------
      
      mysql_query('BEGIN WORK');
      
      if ($this->fixTimezone() === false) {
        mysql_query('ROLLBACK');
        $this->printMessage('Upgrade process failed!', true);
        return false;
      }
      
      if (!mysql_query('COMMIT')) {
        $this->printMessage('Failed to commit updates. Upgrade process failed!', true);
        return false;
      }

      $this->fixConfigFile();

      $this->printMessage('ProjectPier has been upgraded. You are now running ProjectPier '.$this->getVersionTo().' Enjoy!');
    }

    /**
    * Fix the timezone columns
    *
    * @param void
    * @return null
    */
    function fixTimezone() {
      $users_table = TABLE_PREFIX . 'users';
      if (mysql_query("ALTER TABLE `$users_table` MODIFY COLUMN `timezone` FLOAT(3,1) NOT NULL DEFAULT '0.0'", $this->database_connection)) {
        $this->printMessage('Users table has been updated');
      } else {
        $this->printMessage('Failed to update users table. MySQL said: ' . mysql_error($this->database_connection), true);
        return false;
      }
      $companies_table = TABLE_PREFIX . 'companies';
      if (mysql_query("ALTER TABLE `$companies_table` MODIFY COLUMN `timezone` FLOAT(3,1) NOT NULL DEFAULT '0.0'", $this->database_connection)) {
        $this->printMessage('Companies table has been updated');
      } else {
        $this->printMessage('Failed to update companies table. MySQL said: ' . mysql_error($this->database_connection), true);
        return false;
      }
      return true;
    }
    
      
    /**
    * This function will update the configuration file
    *
    * @param void
    * @return null
    */
    function fixConfigFile() {
      $this->printMessage('Updating configuration file');

      //----------------------------------------------------------
      // Set up constants array with known values and defaults
      //----------------------------------------------------------
      $constants = array(
        'DB_ADAPTER'           => DB_ADAPTER,
        'DB_HOST'              => DB_HOST,
        'DB_USER'              => DB_USER,
        'DB_PASS'              => DB_PASS,
        'DB_NAME'              => DB_NAME,
        'DB_CHARSET'           => 'utf8',
        'DB_PERSIST'           => true,
        'TABLE_PREFIX'         => TABLE_PREFIX,
        'ROOT_URL'             => ROOT_URL,
        'DEBUG'                => false,
        'DEFAULT_LOCALIZATION' => 'en_us',
        'DEBUG'                => false,
        'SHOW_MESSAGE_BODY'    => true,
        'SHOW_COMMENT_BODY'    => true,
        'SHOW_MILESTONE_BODY'  => true,
      ); // array

      //----------------------------------------------------------
      // Provide token_cookie_name only if defined
      //----------------------------------------------------------
      if (defined('TOKEN_COOKIE_NAME') ) {
        $constants['TOKEN_COOKIE_NAME'] = TOKEN_COOKIE_NAME ;
      } 

      //----------------------------------------------------------
      // Replace default values with previously-defined values, if they exist.
      //----------------------------------------------------------
      foreach ($constants as $config_key => $config_value) {
        if (defined($config_key)) {
          $constants[$config_key] = constant($config_key);
        } // if
      } // foreach 

      //----------------------------------------------------------
      // Insert changes to existing config
      //----------------------------------------------------------
      $constants['PRODUCT_VERSION'] = $this->getVersionTo() ;

      //----------------------------------------------------------
      // Write the config file out using a template
      //----------------------------------------------------------
      tpl_assign('config_file_constants', $constants);
      if (file_put_contents(INSTALLATION_PATH . '/config/config.php', tpl_fetch(get_template_path('config_file')))) {
        $this->printMessage('Configuration file updated');
        return true;
      } else {
        $this->printMessage('Failed to update configuration file', true);
        return false;
      } // if
    } // fixConfigFile
  

  } // RhubarbUpgradeScript

?>
