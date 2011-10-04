<?php

  /**
  * Tag controller
  *
  * @version 1.0
  * @http://www.projectpier.org/
  */
  class TagsController extends ApplicationController {
  
    /**
    * Construct the TagController
    *
    * @access public
    * @param void
    * @return TagController
    */
    function __construct() {
      parent::__construct();
      prepare_company_website_controller($this, 'project_website');
    } // __construct
    
    /**
    * Show project objects tagged with specific tag
    *
    * @access public
    * @param void
    * @return null
    */
    function project_tag() {
      
      $tag = array_var($_GET, 'tag');
      if (trim($tag) == '') {
        flash_error(lang('tag dnx'));
        $this->redirectTo('project', 'tags');
      } // if
      
      $tagged_objects = active_project()->getObjectsByTag($tag);
      $total_tagged_objects = 0;
      if (is_array($tagged_objects)) {
        foreach ($tagged_objects as $type => $objects) {
          if (is_array($objects)) {
            $total_tagged_objects += count($objects);
          }
        } // foreach
      } // if
      
      tpl_assign('tag', $tag);
      tpl_assign('tagged_objects', $tagged_objects);
      tpl_assign('total_tagged_objects', $total_tagged_objects);
      
    } // project_tag
  
  } // TagController

?>