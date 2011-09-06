<?php

  /**
  * Onion upgrade script will upgrade alpha1 or activeCollab 0.6 to activeCollab 0.7
  *
  * @package ScriptUpgrader.scripts
  * @version 1.0
  * @http://www.projectpier.org/
  */
  class OnionUpgradeScript extends ScriptUpgraderScript {
    
    /**
    * Database connection link
    *
    * @var resource
    */
    private $database_connection = null;
    
    /**
    * Array of files and folders that need to be writable
    *
    * @var array
    */
    private $check_is_writable = array(
      '/config/config.php',
      '/public/files',
      '/cache',
      '/upload'
    ); // array
      
    /**
    * Array of extensions taht need to be loaded
    *
    * @var array
    */
    private $check_extensions = array(
      'mysql', 'gd', 'simplexml'
    ); // array
  
    /**
    * Construct the OnionUpgradeScript
    *
    * @param Output $output
    * @return OnionUpgradeScript
    */
    function __construct(Output $output) {
      parent::__construct($output);
      $this->setVersionFrom('0.6');
      $this->setVersionTo('0.7');
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
      } // if
      
      // ---------------------------------------------------
      //  Check for version match (pre-0.7.0 had no version?)
      // ---------------------------------------------------

      if (defined('PRODUCT_VERSION') && PRODUCT_VERSION !== '0.6') {
        $this->printMessage('This upgrade script can be used only to upgrade 0.6 to 0.7', true);
        return false;
      } // if

      // ---------------------------------------------------
      //  Check if files and folders are writable
      // ---------------------------------------------------
      
      foreach ($this->check_is_writable as $relative_path) {
        $path = ROOT . $relative_path;
        if (is_file($path)) {
          if (file_is_writable($path)) {
            $this->printMessage("File '$relative_path' exists and is writable");
          } else {
            $this->printMessage("File '$relative_path' is not writable", true);
            return false;
          } // if
        } elseif (is_dir($path)) {
          if (folder_is_writable($path)) {
            $this->printMessage("Folder '$relative_path' exists and is writable");
          } else {
            $this->printMessage("Folder '$relative_path' is not writable", true);
            return false;
          } // if
        } else {
          $this->printMessage("'$relative_path' does not exists on the system", true);
          return false;
        } // if
      } // foreach
      
      // ---------------------------------------------------
      //  Check if extensions are loaded
      // ---------------------------------------------------
      
      foreach ($this->check_extensions as $extension_name) {
        if (extension_loaded($extension_name)) {
          $this->printMessage("Extension '$extension_name' is loaded");
        } else {
          $this->printMessage("Extension '$extension_name' is not loaded", true);
          return false;
        } // if
      } // foreach
      
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
        @mysql_query("SET NAMES 'utf8'", $this->database_connection);
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
      
      if (@mysql_query($test_table_sql, $this->database_connection)) {
        $this->printMessage('Test query has been executed. Its safe to proceed with database migration.');
        @mysql_query("DROP TABLE `$test_table_name`", $this->database_connection);
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
      $upgrade_script = tpl_fetch(get_template_path('db_migration/onion'));
      
      if ($this->executeMultipleQueries($upgrade_script, $total_queries, $executed_queries, $this->database_connection)) {
        $this->printMessage("Database schema transformations executed (total queries: $total_queries)");
      } else {
        $this->printMessage('Failed to execute DB schema transformations. MySQL said: ' . mysql_error(), true);
        return false;
      } // if
      
      if (!$this->importMessageComments()) {
        return false;
      } // if
      if (!$this->importProjectDocuments()) {
        return false;
      } // if
      $this->cleanApplicationLogs();
      $this->fixConfigFile();
      
      $this->printMessage('ProjectPier has been upgraded. You are now running ProjectPier 0.7. Enjoy!');
    } // execute
    
    /**
    * Import message comments
    *
    * @param void
    * @return boolean
    */
    private function importMessageComments() {
      $this->printMessage('Starting to import comments...');
      
      if ($result = mysql_query('SELECT * FROM `' . TABLE_PREFIX . 'message_comments', $this->database_connection)) {
        mysql_query('BEGIN WORK', $this->database_connection);
        
        $counter = 0;
        while ($row = mysql_fetch_assoc($result)) {
          $sql = sprintf("INSERT INTO `%scomments` (`rel_object_id`, `rel_object_manager`, `text`, `is_private`, `created_on`, `created_by_id`, `updated_on`, `updated_by_id`) VALUES ('%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s')",
            TABLE_PREFIX, $row['message_id'], 'ProjectMessages', mysql_real_escape_string($row['text']), $row['is_private'], $row['created_on'], $row['created_by_id'], $row['updated_on'], $row['updated_by_id']);
          if (!mysql_query($sql, $this->database_connection)) {
            mysql_query('ROLLBACK', $this->database_connection);
            $this->printMessage('Failed to move message comments. MySQL said: ' . mysql_error(), true);
            return false;
          } // if
          $counter++;
        } // while
        
        mysql_query('COMMIT');
        $this->printMessage("$counter message comments moved");
        
        if (mysql_query('DROP TABLE IF EXISTS `' . TABLE_PREFIX . 'message_comments', $this->database_connection)) {
          $this->printMessage('`' . TABLE_PREFIX . 'message_comments` table dropped');
        } else {
          $this->printMessage('Warning: Failed to drop old message comments table. MySQL said: ' . mysql_error(), true);
        }
      } // if
      
      return true;
    } // importMessageComments
    
    /**
    * This function will import project documents into the new files section and preserve message / file relations
    *
    * @param void
    * @return boolean
    */
    function importProjectDocuments() {
      $this->printMessage('Starting to import documents...');
      
      if ($result = mysql_query('SELECT * FROM `' . TABLE_PREFIX . 'project_documents`')) {
        mysql_query('BEGIN WORK', $this->database_connection);
        
        $counter = 0;
        while ($row = mysql_fetch_assoc($result)) {
          $sql = sprintf("INSERT INTO `%sproject_files` (`project_id`, `filename`, `description`, `is_private`, `is_visible`, `created_on`, `created_by_id`, `updated_on`, `updated_by_id`) VALUES ('%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s')",
            TABLE_PREFIX, $row['project_id'], mysql_real_escape_string($row['filename']), mysql_real_escape_string($row['description']), $row['is_private'], 1, $row['created_on'], $row['created_by_id'], $row['updated_on'], $row['updated_by_id']);
          
          if (!mysql_query($sql, $this->database_connection)) {
            mysql_query('ROLLBACK', $this->database_connection);
            $this->printMessage('Failed to move project documents. MySQL said: ' . mysql_error(), true);
            return false;
          } // if
          
          $file_id = mysql_insert_id($this->database_connection);
          $file_type_id = 0;
          $sql = sprintf("SELECT `id` FROM `%sfile_types` WHERE `extension` = '%s'", TABLE_PREFIX, mysql_real_escape_string(strtolower(get_file_extension($row['filename']))));
          if ($file_type_result = mysql_query($sql)) {
            if ($file_type_row = mysql_fetch_assoc($file_type_result)) {
              $file_type_id = (integer) $file_type_row['id'];
            } // if
          } // if
          
          $repository_id = '';
          $file_path = INSTALLATION_PATH . '/public/files/project_documents/' . $row['project_id'] . '/' . $row['filename'];
          if (is_file($file_path)) {
            do {
              $repository_id = sha1(uniqid(rand(), true));
              $repository_entry_exists = false;
              if ($check_repository_id_result = mysql_query(sprintf(("SELECT COUNT (`id`) AS 'row_count' FROM `%sfile_repo` WHERE `id` = '%s'"), TABLE_PREFIX, $repository_id))) {
                if ($check_repository_id_row = mysql_fetch_assoc($check_repository_id_result)) {
                  $repository_entry_exists = (boolean) $check_repository_id_row['row_count'];
                } // if
              } // if
            } while ($repository_entry_exists);
            
            $sql = sprintf("INSERT INTO `%sfile_repo` (`id`, `content`) VALUES ('%s', '%s')",
              TABLE_PREFIX, $repository_id, mysql_real_escape_string(file_get_contents($file_path), $this->database_connection)
            ); // sprintf
            if (!mysql_query($sql, $this->database_connection)) {
              mysql_query('ROLLBACK', $this->database_connection);
              $this->printMessage('Failed to insert file content into file repository. MySQL said: ' . mysql_error(), true);
              return false;
            } // if
          } // if
          
          $sql = sprintf("INSERT INTO `%sproject_file_revisions` (`file_id`, `file_type_id`, `repository_id`, `revision_number`, `type_string`, `filesize`, `created_on`, `created_by_id`, `updated_on`, `updated_by_id`) VALUES ('%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s')", 
            TABLE_PREFIX, $file_id, $file_type_id, $repository_id, 1, $row['type'], $row['size'], $row['created_on'], $row['created_by_id'], $row['updated_on'], $row['updated_by_id']
          ); // sprintf
          
          if (!mysql_query($sql, $this->database_connection)) {
            mysql_query('ROLLBACK', $this->database_connection);
            $this->printMessage('Failed to move project documents. MySQL said: ' . mysql_error(), true);
            return false;
          } // if
          
          // Now, relations with messages...
          if ($related_messages_result = mysql_query(sprintf("SELECT * FROM `%smessage_documents` WHERE `document_id` = '%s'", TABLE_PREFIX, $row['id']), $this->database_connection)) {
            while ($related_messages_row = mysql_fetch_assoc($related_messages_result)) {
              $sql = sprintf("INSERT INTO `%sattached_files` (`rel_object_manager`, `rel_object_id`, `file_id`, `created_on`, `created_by_id`) VALUES ('%s', '%s', '%s', '%s', '%s')",
                TABLE_PREFIX, 'ProjectMessages', $related_messages_row['message_id'], $file_id, $row['created_on'], $row['created_by_id']
              ); // sprintf
              if (!mysql_query($sql, $this->database_connection)) {
                mysql_query('ROLLBACK', $this->database_connection);
                $this->printMessage('Failed to add message - file relation. MySQL said: ' . mysql_error(), true);
                return false;
              } // if
            } // while
          } // if
          
          $counter++;
        } // while
        
        mysql_query('COMMIT');
        $this->printMessage("$counter documents moved");
        
        // Drop tables
        if (mysql_query('DROP TABLE IF EXISTS `' . TABLE_PREFIX . 'project_documents', $this->database_connection)) {
          $this->printMessage('`' . TABLE_PREFIX . 'project_documents` table dropped');
        } else {
          $this->printMessage('Warning: Failed to drop old documents table. MySQL said: ' . mysql_error(), true);
        } // if
        
        if (mysql_query('DROP TABLE IF EXISTS `' . TABLE_PREFIX . 'document_downloads', $this->database_connection)) {
          $this->printMessage('`' . TABLE_PREFIX . 'document_downloads` table dropped');
        } else {
          $this->printMessage('Warning: Failed to drop old document downloads table. MySQL said: ' . mysql_error(), true);
        } // if
        
        if (mysql_query('DROP TABLE IF EXISTS `' . TABLE_PREFIX . 'message_documents', $this->database_connection)) {
          $this->printMessage('`' . TABLE_PREFIX . 'message_documents` table dropped');
        } else {
          $this->printMessage('Warning: Failed to drop old message - documents table. MySQL said: ' . mysql_error(), true);
        } // if
      } // if
      
      return true;
    } // importProjectDocuments
    
    /**
    * This function will clean up application logs and remove entries related to objects that are removed in 0.7 
    * (message comments and project documents)
    *
    * @param void
    * @return null
    */
    function cleanApplicationLogs() {
      $this->printMessage('Updating application logs');
      mysql_query(sprintf("DELETE FROM `%sapplication_logs` WHERE `rel_object_manager` = '%s'", TABLE_PREFIX, 'MessageComments'));
      mysql_query(sprintf("DELETE FROM `%sapplication_logs` WHERE `rel_object_manager` = '%s'", TABLE_PREFIX, 'ProjectDocuments'));
      $this->printMessage('Application logs updated');
    } // cleanApplicationLogs
    
    /**
    * This function will configuration file
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
        'DB_PERSIST'           => true,
        'TABLE_PREFIX'         => TABLE_PREFIX,
        'ROOT_URL'             => ROOT_URL,
        'DEFAULT_LOCALIZATION' => DEFAULT_LOCALIZATION,
        'DEBUG'                => false,
        'PRODUCT_VERSION'      => $this->getVersionTo(),
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
  
  } // OnionUpgradeScript

?>
