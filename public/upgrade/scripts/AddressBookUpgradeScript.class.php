<?php

  /**
  * Upgrade for Address Book patch for ProjectPier 0.8.x
  *
  * @package ScriptUpgrader.scripts
  * @http://www.projectpier.org/
  */
  class AddressBookUpgradeScript extends ScriptUpgraderScript {
  
    /**
    * Database connection link
    *
    * @var resource
    */
    private $database_connection = null;
  
    /**
    * Construct the AddressBookUpgradeScript
    *
    * @param Output $output
    * @return AddressBookUpgradeScript
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
      //  Check existence of tables for Address Book
      // ---------------------------------------------------
      
      $tables_to_check = array('contacts');
      
      foreach ($tables_to_check as $table) {
        $test_table_exists_sql = "SHOW TABLES LIKE '".TABLE_PREFIX."$table';";
        if (mysql_num_rows(mysql_query($test_table_exists_sql, $this->database_connection))) {
          $this->printMessage("Table ".TABLE_PREFIX."$table already exists. You might have done that upgrade already. It is recommended to proceed with the upgrade manually.", true);
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
            
      mysql_query('BEGIN WORK');

      // ---------------------------------------------------
      //  Contact table creation
      // ---------------------------------------------------

      $total_queries = 0;
      $executed_queries = 0;
      $upgrade_script = tpl_fetch(get_template_path('db_migration/addressbook_contactcreation'));
      
      if ($this->executeMultipleQueries($upgrade_script, $total_queries, $executed_queries, $this->database_connection)) {
        $this->printMessage("'Contacts' table correctly executed (total queries: $total_queries)");
      } else {
        $this->printMessage('Failed to execute DB schema transformations. MySQL said: ' . mysql_error(), true);
        mysql_query('ROLLBACK');
        return false;
      } // if
      
      // ---------------------------------------------------------------
      //  Migration of existing users to contacts with associated users.
      // ---------------------------------------------------------------
      
      $contacts_created = 0;
      $users_table = TABLE_PREFIX.'users';
      $contacts_table = TABLE_PREFIX.'contacts';
      
      
      $rows = mysql_query("SELECT * FROM `$users_table`");
      while ($row = mysql_fetch_assoc($rows)) {
        if (!mysql_query("INSERT INTO $contacts_table (`company_id` , `user_id` , `email` , `display_name` , `title` , `avatar_file` , `office_number` , `fax_number` , `mobile_number` , `home_number` , `created_on` , `created_by_id` , `updated_on`) VALUES ('".$row['company_id']."',  '".$row['id']."', '".$row['email']."', '".$row['display_name']."', '".$row['title']."', '".$row['avatar_file']."', '".$row['office_number']."', '".$row['fax_number']."' , '".$row['mobile_number']."' , '".$row['home_number']."' , '".$row['created_on']."', '".$row['created_by_id']."', '".$row['updated_on']."');")) {
            
          $this->printMessage("Error while creating contact. Operation aborted. MySQL said: ".mysql_error($this->database_connection), true);
          mysql_query('ROLLBACK');
          return false;
        }
        $contacts_created++;
      } // while
      
      $this->printMessage("$contacts_created contacts properly imported.");

      // ---------------------------------------------------------------
      //  Modification of existing User table
      // ---------------------------------------------------------------
      
      $total_queries = 0;
      $executed_queries = 0;
      $upgrade_script = tpl_fetch(get_template_path('db_migration/addressbook_dbalteration'));
      
      if ($this->executeMultipleQueries($upgrade_script, $total_queries, $executed_queries, $this->database_connection)) {
        $this->printMessage("Database tables correctly modified. (total queries: $total_queries)");
      } else {
        $this->printMessage('Failed to execute DB schema transformations. MySQL said: ' . mysql_error(), true);
        mysql_query('ROLLBACK');
        return false;
      } // if
      
      // ---------------------------------------------------------------
      //  Migration of UserIm to ContactIm (change user_id to contact_id)
      // ---------------------------------------------------------------
      
      $contact_im_changed = 0;
      $contacts_table = TABLE_PREFIX.'contacts';
      $contact_im_table = TABLE_PREFIX.'contact_im_values';
      
      // NB: user_id was renamed contact_id in the previous step
      $rows = mysql_query("SELECT `$contacts_table`.`id`, `$contact_im_table`.`contact_id`, `$contact_im_table`.`im_type_id` FROM `$contacts_table`, `$contact_im_table` WHERE `$contacts_table`.`user_id` = `$contact_im_table`.`contact_id`");
      while ($row = mysql_fetch_assoc($rows)) {
        if (!mysql_query("UPDATE `$contact_im_table` SET `contact_id` = '".$row['id']."' WHERE `contact_id` = '".$row['contact_id']."' AND `im_type_id` = '".$row['im_type_id']."'")) {
          $this->printMessage("Error while updating Contact-IM table. Upgrade aborted. MySQL said: ".mysql_error($this->database_connection), true);
          mysql_query('ROLLBACK');
          return false;
        } // if
        
        $contact_im_changed++;
      } // while
      
      $this->printMessage("$contact_im_changed contact-IM associations properly imported.");

      mysql_query('COMMIT');
      $this->printMessage('ProjectPier has been patched for Address Book. Enjoy!');
    } // execute
    

    /**
    * Return script name.
    *
    * @param void
    * @return string
    */
    function getScriptName() {
      return 'Upgrade of DB for Address Book patch (separation of contacts and users)';
    } // getName
    
  
  } // AddressBookUpgradeScript

?>