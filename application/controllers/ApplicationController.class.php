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
  
  } // ApplicationController

?>
