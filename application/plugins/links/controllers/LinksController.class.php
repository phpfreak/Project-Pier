<?php

  /**
  * Links Controller
  *
  * @http://www.activeingredient.com.au
  */
  class LinksController extends ApplicationController {
  
    /**
    * Construct the LinksController
    *
    * @access public
    * @param void
    * @return LinksController
    */
    function __construct() {
      parent::__construct();
      prepare_company_website_controller($this, 'project_website');
    } // __construct
    
    /**
    * Show links for project
    *
    * @access public
    * @param void
    * @return null
    */
    function index() {
      trace(__FILE__,'index()');
      $this->addHelper('textile');
      $links = ProjectLinks::getAllProjectLinks(active_project());
      tpl_assign('links', $links);
    } // index
    
    function add_link() {
      
      $this->setTemplate('edit_link');
      
      if (!ProjectLink::canAdd(logged_user(), active_project())) {
        flash_error(lang('no access permissions'));
        $this->redirectTo('links','index');
      } // if
      
      $project_link = new ProjectLink();
      $project_link_data = array_var($_POST, 'project_link');
      
      if (is_array(array_var($_POST, 'project_link'))) {
        $project_link->setFromAttributes($project_link_data);
        $project_link->setCreatedById(logged_user()->getId());
        $project_link->setProjectId(active_project()->getId());
        
        try {
          DB::beginWork();
          $project_link->save();
          ApplicationLogs::createLog($project_link, active_project(), ApplicationLogs::ACTION_ADD);
          DB::commit();
          
          flash_success(lang('success add link'));
          $this->redirectTo('links');
        } catch(Exception $e) {
          DB::rollback();
          tpl_assign('error', $e);
        } // try
      }
      
      tpl_assign('project_link', $project_link);
      tpl_assign('project_link_data', $project_link_data);
    
    } // add_link
    
    /**
    * Edit project link
    *
    * @param void
    * @return null
    */
    function edit_link() {
      
      $this->setTemplate('edit_link');
      $project_link = ProjectLinks::findById(get_id());
      
      if (!ProjectLink::canEdit(logged_user())) {
        flash_error(lang('no access permissions'));
        $this->redirectTo('links','index');
      } // if
      
      if (!($project_link instanceof ProjectLink)) {
        flash_error(lang('project link dnx'));
        $this->redirectTo('links');
      } // if
      
      $project_link_data = array_var($_POST, 'project_link');
      
      if (!is_array($project_link_data)) {
        $project_link_data = array(
          'title'  => $project_link->getTitle(),
          'url'    => $project_link->getUrl(),
        ); // array
      } // if
      
      tpl_assign('project_link_data', $project_link_data);
      tpl_assign('project_link', $project_link);
      
      if (is_array(array_var($_POST, 'project_link'))) {
        $project_link->setFromAttributes($project_link_data);
        $project_link->setProjectId(active_project()->getId());
        
        try {
          DB::beginWork();
          $project_link->save();
          ApplicationLogs::createLog($project_link, active_project(), ApplicationLogs::ACTION_EDIT);
          DB::commit();
          
          flash_success(lang('success edit link'));
          $this->redirectTo('links');
        } catch(Exception $e) {
          DB::rollback();
          tpl_assign('error', $e);
        } // try
      }
      tpl_assign('project_link', $project_link);
      tpl_assign('project_link_data', $project_link_data);
    } // edit_link
    
    /**
    * Delete project link
    *
    * @param void
    * @return null
    */
    function delete_link() {
      
      $project_link = ProjectLinks::findById(get_id());
      
      if (!ProjectLink::canEdit(logged_user())) {
        flash_error(lang('no access permissions'));
        $this->redirectTo('links','index');
      } // if
      
      if (!($project_link instanceof ProjectLink)) {
        flash_error(lang('project link dnx'));
        $this->redirectTo('links');
      } // if
      
      try {
        DB::beginWork();
        $project_link->delete();
        ApplicationLogs::createLog($project_link, active_project(), ApplicationLogs::ACTION_DELETE);
        DB::commit();
        
        flash_success(lang('success delete link', $project_link->getTitle()));
        $this->redirectTo('links');
      } catch(Exception $e) {
        DB::rollback();
        tpl_assign('error', $e);
      } // try
      
    } // delete_link
    
  } // LinksController

?>
