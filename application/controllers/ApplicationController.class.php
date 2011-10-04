<?php

  /**
  * Base application controller
  *
  * @version 1.0
  * @http://www.projectpier.org/
  */
  abstract class ApplicationController extends PageController {
  
    /**
    * Add application level constroller
    *
    * @param void
    * @return null
    */
    function __construct() {
      trace(__FILE__,'__construct()');
      parent::__construct();
      $this->addHelper('application');
    } // __construct
    
    /**
    * Set page sidebar
    *
    * @access public
    * @param string $template Path of sidebar template
    * @return null
    * @throws FileDnxError if $template file does not exists
    */
    protected function setSidebar($template) {
      tpl_assign('content_for_sidebar', tpl_fetch($template));
    } // setSidebar

	/**
    * Determine if a user canGoOn to deny access to files in projects
    * to which the user has not been assigned.
    *
    * @access public
    * @return null
    */
    function canGoOn()
    {
      if(active_project() == null || !logged_user()->isProjectUser(active_project()))
      {
        flash_error(lang('no access permissions'));
        $this->redirectTo('dashboard', 'index');
      } // if
    }// end canGoOn
	
  } // ApplicationController

?>