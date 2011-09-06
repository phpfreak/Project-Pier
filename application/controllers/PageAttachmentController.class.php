<?php

  /**
  * Page attachment controller
  *
  * @version 1.0
  * @http://www.projectpier.org/
  */
  class PageAttachmentController extends ApplicationController {
  
    /**
    * Construct the PageAttachmentController
    *
    * @access public
    * @param void
    * @return PageAttachmentController
    */
    function __construct() {
      parent::__construct();
      prepare_company_website_controller($this, 'project_website');
    } // __construct
    
    /**
    * Attach object to specific page and redirects to specified page
    *
    * @access public
    * @param void
    * @return null
    */
    function add_attachment() {
      $project = active_project();
      if (!($project instanceof Project)) {
        flash_error(lang('project dnx'));
        $this->redirectToReferer(get_url('dashboard'));
      } // if
      
      if (!$project->canEdit(logged_user())) {
        flash_error(lang('no access permissions'));
        $this->redirectToReferer(get_url('dashboard'));
      } // if
      
      $page_attachment = new PageAttachment();
      $page_attachment->setText(lang('description'));
      $page_attachment->setRelObjectId('0');
      $page_attachment->setRelObjectManager(array_var($_GET, 'rel_object_manager'));
      $page_attachment->setProjectId($project->getId());
      $page_attachment->setPageName(array_var($_GET, 'page_name'));
      $page_attachment->setOrder(array_var($_GET, 'order'));
      $page_attachment->save();
      PageAttachments::reorder(array_var($_GET, 'page_name'), $project);
      $this->redirectToReferer(get_url('dashboard'));
    } // add_attachment
  }
  
?>