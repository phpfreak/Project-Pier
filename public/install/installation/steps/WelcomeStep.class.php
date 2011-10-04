<?php

  /**
  * First step in aC installation process - Welcome message
  *
  * @package ScriptInstaller
  * @subpackage installation
  * @http://www.projectpier.org/
  */
  class WelcomeStep extends ScriptInstallerStep {
  
    /**
    * Construct the WelcomeStep
    *
    * @access public
    * @param void
    * @return WelcomeStep
    */
    function __construct() {
      $this->setName('Welcome');
    } // __construct
    
    /**
    * Show welcome message
    *
    * @access public
    * @param void
    * @return boolean
    */
    function execute() {
      $this->setContentFromTemplate('welcome.php');
      return array_var($_POST, 'submitted') == 'submitted';
    } // execute
  
  } // WelcomeStep

?>