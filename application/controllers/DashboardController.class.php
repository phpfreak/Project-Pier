<?php

  /**
  * Dashboard controller
  *
  * @http://www.projectpier.org/
  */
  class DashboardController extends ApplicationController {
    
    /**
    * Construct controller and check if we have logged in user
    *
    * @param void
    * @return null
    */
    function __construct() {
      parent::__construct();
      prepare_company_website_controller($this, 'dashboard');
    } // __construct
  
    /**
    * Show dashboard index page
    *
    * @param void
    * @return null
    */
    function index() {
      $logged_user = logged_user();
      
      $active_projects = $logged_user->getActiveProjects();
      $activity_log = null;
      if (is_array($active_projects) && count($active_projects)) {
        $include_private = $logged_user->isMemberOfOwnerCompany();
        $include_silent = $logged_user->isAdministrator();
        
        $project_ids = array();
        foreach ($active_projects as $active_project) {
          $project_ids[] = $active_project->getId();
        } // if
        
        $activity_log = ApplicationLogs::getOverallLogs($include_private, $include_silent, $project_ids, config_option('dashboard_logs_count', 15));
      } // if
      
      tpl_assign('today_milestones', $logged_user->getTodayMilestones());
      tpl_assign('late_milestones', $logged_user->getLateMilestones());
      tpl_assign('active_projects', $active_projects);
      tpl_assign('activity_log', $activity_log);
      
      // Sidebar
      tpl_assign('online_users', Users::getWhoIsOnline());
      tpl_assign('my_projects', $active_projects);
      $this->setSidebar(get_template_path('index_sidebar', 'dashboard'));
    } // index
    
    /**
    * Show my projects page
    *
    * @param void
    * @return null
    */
    function my_projects() {
      $this->addHelper('textile');
      tpl_assign('active_projects', logged_user()->getActiveProjects());
      tpl_assign('finished_projects', logged_user()->getFinishedProjects());
      $this->setSidebar(get_template_path('my_projects_sidebar', 'dashboard'));
    } // my_projects
    
    /**
    * Show milestones and tasks assigned to specific user
    *
    * @param void
    * @return null
    */
    function my_tasks() {
      tpl_assign('active_projects', logged_user()->getActiveProjects());
      $this->setSidebar(get_template_path('my_tasks_sidebar', 'dashboard'));
    } // my_tasks
  
  } // DashboardController

?>
