<?php

  /**
  * Last step of ProjectPier installation - prepare the database, insert initial data and create company and administrator account
  *
  * @package ScriptInstaller
  * @subpackage installation
  * @version 1.0
  * @http://www.projectpier.org/
  */
  class FinishStep extends ScriptInstallerStep {
    
    /**
    * Cached database connection resource
    *
    * @var resource
    */
    private $database_connection;
  
    /**
    * Construct the FinishStep
    *
    * @access public
    * @param void
    * @return FinishStep
    */
    function __construct() {
      $this->setName('Finish');
    } // __construct
    
    /**
    * Prepare and process config form
    *
    * @access public
    * @param void
    * @return boolean
    */
    function execute() {
      if (!$this->installer->isExecutedStep(INSTALL_SYSTEM_CONFIG)) {
        $this->goToStep(INSTALL_SYSTEM_CONFIG);
      } // if
      
      $installation = new installation(new Output_Html());
      $installation->setDatabaseType((string) trim($this->getFromStorage('database_type')));
      $installation->setDatabaseHost((string) trim($this->getFromStorage('database_host')));
      $installation->setDatabaseUsername((string) trim($this->getFromStorage('database_user')));
      $installation->setDatabasePassword((string) $this->getFromStorage('database_pass'));
      $installation->setDatabaseName((string) trim($this->getFromStorage('database_name')));
      $installation->setTablePrefix((string) trim($this->getFromStorage('database_prefix')));
      
      ob_start();
      if ($installation->execute()) {
        $all_ok = true;
        $this->installer->clearStorage(); // lets clear data from session... its a DB pass we are talking about here
        $path=$_SERVER['PHP_SELF'];
        $path=substr($path, 0, strpos($path, 'public'));
      } else {
        $all_ok = false;
        $path='';
      } // if
      
      tpl_assign('all_ok', $all_ok);
      tpl_assign('relative_url', $path);
      tpl_assign('status_messages', explode("\n", trim(ob_get_clean())));
      
      $this->setContentFromTemplate('finish.php');
      return false;
    } // execute
  
  } // FinishStep

?>