<?php

  /**
  * Third step of ProjectPier installation -> user is required to enter 
  * database connection settings. Script tries the connection params and 
  * if correct saves them in /config/config.php file
  *
  * @package ScriptInstaller
  * @subpackage installation
  * @version 1.0
  * @http://www.projectpier.org/
  */
  class SystemConfigStep extends ScriptInstallerStep {
    
    /**
    * Cached database connection resource
    *
    * @var resource
    */
    private $database_connection;
  
    /**
    * Construct the ConfigStep
    *
    * @access public
    * @param void
    * @return ConfigStep
    */
    function __construct() {
      $this->setName('Database configuration');
    } // __construct
    
    /**
    * Prepare and process config form
    *
    * @param void
    * @return boolean
    */
    function execute() {
      if ((strtolower(array_var($_SERVER, 'HTTPS')) == 'on') || (array_var($_SERVER, 'SERVER_PORT') == 443)) {
        $protocol = 'https://';
      } else {
        $protocol = 'http://';
      } // if
      
      $request_url = without_slash($protocol . dirname($_SERVER['HTTP_HOST'] . $_SERVER['SCRIPT_NAME']));
      if (($rpos = strrpos($request_url, '/')) !== false) {
        $installation_url = substr($request_url, 0, $rpos - 7); // remove /public ;)
      } else {
        $installation_url = '';
      } // if
      
      $config_form_data = array_var($_POST, 'config_form');
      if (!is_array($config_form_data)) {
        $config_form_data = array(
          'database_type'    => $this->getFromStorage('database_type', 'MySQL'),
          'database_host'    => $this->getFromStorage('database_host', 'localhost'),
          'database_user'    => $this->getFromStorage('database_user', 'root'),
          'database_pass'    => $this->getFromStorage('database_pass'),
          'database_name'    => $this->getFromStorage('database_name', 'pp'),
          'database_create'  => $this->getFromStorage('database_create' ),
          'database_charset' => $this->getFromStorage('database_charset', 'utf8'),
          'database_prefix'  => $this->getFromStorage('database_prefix', 'pp088_'),
        ); // array
      } // if
      tpl_assign('config_form_data', $config_form_data);
      
      if ($this->isSubmitted()) {
        $database_type    = (string) array_var($config_form_data, 'database_type');
        $database_host    = (string) array_var($config_form_data, 'database_host');
        $database_user    = (string) array_var($config_form_data, 'database_user');
        $database_pass    = (string) array_var($config_form_data, 'database_pass');
        $database_name    = (string) array_var($config_form_data, 'database_name');
        $database_create  = (string) array_var($config_form_data, 'database_create');
        $database_charset = (string) array_var($config_form_data, 'database_charset');
        $database_prefix  = (string) array_var($config_form_data, 'database_prefix');
        
        if ($this->database_connection = @mysql_connect($database_host, $database_user, $database_pass)) {
          // ---------------------------------------------------
          //  Check if we have at least 4.1
          // ---------------------------------------------------
          $mysql_version = mysql_get_server_info($this->database_connection);
          if ($mysql_version && version_compare($mysql_version, '4.1', '>=')) {
            $this->addToStorage('database_type', $database_type);
            $this->addToStorage('database_host', $database_host);
            $this->addToStorage('database_user', $database_user);
            $this->addToStorage('database_pass', $database_pass);
            $try_select = true;
            if ($database_create=='yes') {
              $try_select = false;
              if (@mysql_select_db(array_var($config_form_data, 'database_name'), $this->database_connection)) {
                  $this->addError("Database create failed, $database_name exists. Choose another name or uncheck create option.");
              } else {
                $sql = "CREATE DATABASE `$database_name`";
                if (mysql_query($sql, $this->database_connection)) {
                  $try_select = true;
                } else {
                  $this->addError('Error creating database: ' . mysql_error() );
                }
              }
            }
            if ($try_select) {
              if (@mysql_select_db(array_var($config_form_data, 'database_name'), $this->database_connection)) {
                $this->addToStorage('database_name', $database_name);
                $this->addToStorage('database_charset', $database_charset);
                $this->addToStorage('database_prefix', $database_prefix);

                $exist = 0;
                $result = @mysql_query("show tables like '$database_prefix%'", $this->database_connection);
                while ($row = @mysql_fetch_row($result)) {
                  $exist++;
                }
                if ($exist==0) {
                  return true;
                }
                $this->addError("There are $exist tables present with prefix '$database_prefix'. Remove those tables or use another prefix.");
              } else {
                $this->addError("Database '$database_name' not available on host '$database_host'.");
              }
            }
          } else {
            $this->addError('Database version is '.$mysql_version.'. Minimum is 4.1. Choose another host or upgrade.');
          }
        } else {
          $this->addError("Failed to connect to database server '$database_host' with user '$database_user' and provided password");
        } // if
      } // if
      
      $this->setContentFromTemplate('system_config_form.php');
      return false;
    } // execute
    
    /**
    * Add error message to all messages and break the execution
    *
    * @access public
    * @param string $error_message Reason why we are breaking execution
    * @return boolean
    */
    function breakExecution($error_message) {
      $this->addToChecklist($error_message, false);
      if (is_resource($this->database_connection)) {
        @mysql_query('ROLLBACK', $this->database_connection);
      }
      $this->setContentFromTemplate('finish.php');
      return false;
    } // breakExecution
    
    /**
    * Write $constants in config file
    *
    * @access public
    * @param array $constants
    * @return boolean
    */
    function writeConfigFile($constants) {
      tpl_assign('config_file_constants', $constants);
      return file_put_contents(INSTALLATION_PATH . '/config/config.php', tpl_fetch(get_template_path('config_file.php')));
    } // writeConfigFile
    
    /**
    * Execute multiple queries
    * 
    * This one is really quick and dirty because I want to finish this and catch
    * the bus. Need to be redone ASAP
    * 
    * This function returns true if all queries are executed successfully
    *
    * @access public
    * @todo Make a better implementation
    * @param string $sql
    * @param integer $total_queries Total number of queries in SQL
    * @param integer $executed_queries Total number of successfully executed queries
    * @return boolean
    */
    function executeMultipleQueries($sql, &$total_queries, &$executed_queries) {
      if (!trim($sql)) {
        $total_queries = 0;
        $executed_queries = 0;
        return true;
      } // if
      
      // Make it work on PHP 5.0.4
      $sql = str_replace(array("\r\n", "\r"), array("\n", "\n"), $sql);
      
      $queries = explode(";\n", $sql);
      if (!is_array($queries) || !count($queries)) {
        $total_queries = 0;
        $executed_queries = 0;
        return true;
      } // if
      
      $total_queries = count($queries);
      foreach ($queries as $query) {
        if (trim($query)) {
          if (@mysql_query(trim($query))) {
            $executed_queries++;
          } else {
            return false;
          } // if
        } // if
      } // if
      
      return true;
    } // executeMultipleQueries
  
  } // ConfigStep

?>