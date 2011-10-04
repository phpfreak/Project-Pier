<?php

  /**
  * Project settings controller
  *
  * @version 1.0
  * @http://www.projectpier.org/
  */
  class ProjectSettingsController extends ApplicationController {
  
    /**
    * Construct the ProjectSettingsController
    *
    * @access public
    * @param void
    * @return ProjectSettingsController
    */
    function __construct() {
      parent::__construct();
      prepare_company_website_controller($this, 'project_website');
      
      // Access permissions
      if (!logged_user()->isAdministrator(owner_company())) {
        flash_error(lang('no access permissions'));
        $this->redirectTo('dashboard');
      } // if
    } // __construct
    
    /**
    * Show project settings index
    *
    * @access public
    * @param void
    * @return null
    */
    function index() {
      if (!active_project()->canChangePermissions(logged_user()) && !logged_user()->isAdministrator() && !active_project()->canEdit(logged_user())) {
        flash_error(lang('no access permissions'));
        $this->redirectTo('dashboard');
      } // if
      tpl_assign('project', active_project());
    } // index
    
    /**
    * Show project users and permissions
    *
    * @access public
    * @param void
    * @return null
    */
    function users() {
      if (!logged_user()->isProjectUser(active_project())) {
        flash_error(lang('no access permissions'));
        $this->redirectTo('dashboard');
      } // if
      
      tpl_assign('project_companies', active_project()->getCompanies());
    } // users
    
    /**
    * Show permission update form
    *
    * @param void
    * @return null
    */
    function permissions() {
      if (!active_project()->canChangePermissions(logged_user())) {
        flash_error(lang('no access permissions'));
        $this->redirectToUrl(active_project()->getOverviewUrl());
      } // if

      $project_init = array_var($_GET, 'project_init');
      
      tpl_assign('project_init', $project_init);
      tpl_assign('project_users', active_project()->getUsers(false));
      tpl_assign('project_companies', active_project()->getCompanies());
      tpl_assign('user_projects', logged_user()->getProjects());
      
      $permissions = PermissionManager::getPermissionsText();
      tpl_assign('permissions', $permissions);
      
      $companies = array(owner_company());
      $clients = owner_company()->getClientCompanies();
      if (is_array($clients)) {
        $companies = array_merge($companies, $clients);
      } // if
      tpl_assign('companies', $companies);
      
      if (array_var($_POST, 'process') == 'process') {
        try {
          DB::beginWork();
          
          active_project()->clearCompanies();
          active_project()->clearUsers();
          
          $companies = array(owner_company());
          $client_companies = owner_company()->getClientCompanies();
          if (is_array($client_companies)) {
            $companies = array_merge($companies, $client_companies);
          } // if
          
          foreach ($companies as $company) {
            
            // Company is selected!
            if (array_var($_POST, 'project_company_' . $company->getId()) == 'checked') {
              
              // Owner company is automaticly included so it does not need to be in project_companies table
              if (!$company->isOwner()) {
                $project_company = new ProjectCompany();
                $project_company->setProjectId(active_project()->getId());
                $project_company->setCompanyId($company->getId());
                $project_company->save();
              } // if
              
              $users = $company->getUsers();
              if (is_array($users)) {
                $counter = 0;
                foreach ($users as $user) {
                  $user_id = $user->getId();
                  $counter++;
                  if (array_var($_POST, "project_user_$user_id") == 'checked') {
                    
                    $project_user = new ProjectUser();
                    $project_user->setProjectId(active_project()->getId());
                    $project_user->setUserId($user_id);
                    
                    foreach ($permissions as $permission => $permission_text) {
                      
                      // Owner company members have all permissions
                      $permission_value = $company->isOwner() ? true : array_var($_POST, 'project_user_' . $user_id . '_' . $permission) == 'checked';
                      
                      $setter = 'set' . Inflector::camelize($permission);
                      $project_user->$setter($permission_value);
                      
                    } // if
                    
                    $project_user->save();
                    
                  } // if
                  
                } // foreach
              } // if
            } // if
          } // foreach
          
          DB::commit();
          
          flash_success(lang('success update project permissions'));
          
          if ($project_init) {
            $this->redirectToUrl(active_project()->getEditUrl(active_project()->getOverviewUrl()));
          } else {
            $this->redirectTo('project_settings', 'users');
          } // if
        } catch(Exception $e) {
          DB::rollback();
          flash_error(lang('error update project permissions'));
          $this->redirectTo('project_settings', 'permissions');
        } // try
      } // if
    } // permissions
  
} // ProjectSettingsController
?>