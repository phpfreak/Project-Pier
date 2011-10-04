<?php

  /**
  * Error controller is here to display critical errors to the user when system is unable to serve 
  * users requests (failed to connect to database, unknown controller etc)
  *
  * @version 1.0
  * @http://www.projectpier.org/
  */
  class ErrorController extends PageController {
  
    /**
    * Construct the ErrorController
    *
    * @access public
    * @param void
    * @return ErrorController
    */
    function __construct() {
      parent::__construct();
      //$this->addHelper('form', 'breadcrumbs', 'pageactions', 'tabbednavigation', 'company_website', 'project_website');
    } // __construct
    
    /**
    * Show system error message
    *
    * @param void
    * @return null
    */
    function system() {
      $this->showError('system error message');
    } // system
    
    /**
    * This error is shown when we fail to execute action - controller dnx, action is not defined or something like that
    *
    * @param void
    * @return null
    */
    function execute_action() {
      $this->showError('execute action error message');
    } // execute_action
    
    /**
    * This message is shown when we fail to connect to the database. This template does not use language
    * files because localization resources are not available at the moment we are connecting to the database.
    *
    * @param void
    * @return null
    */
    function db_connect() {
      
    } // db_connect
    
    /**
    * Show error
    *
    * @param void
    * @return null
    */
    private function showError($message_lang_code) {
      tpl_assign('error_message', $message_lang_code);
      $this->setTemplate('error_message');
    } // showError
  
  } // ErrorController

?>