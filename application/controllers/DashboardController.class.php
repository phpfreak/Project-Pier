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
      trace(__FILE__, '__construct() - begin');
      parent::__construct();
      trace(__FILE__, '__construct() - prepare_company_website_controller');
      prepare_company_website_controller($this, 'dashboard');
    } // __construct
  
    /**
    * Show dashboard index page
    *
    * @param void
    * @return null
    */
    function index() {
      trace(__FILE__, 'index() - begin');
      $logged_user = logged_user();
      $active_projects = $logged_user->getActiveProjects();
      $activity_log = null;
      $projects_activity_log = array();
      if (is_array($active_projects) && count($active_projects)) {
        $include_private = $logged_user->isMemberOfOwnerCompany();
        $include_silent = $logged_user->isAdministrator();
        
        $project_ids = array();
        foreach ($active_projects as $active_project) {
          $project_ids[] = $active_project->getId();
          $temp_project_logs = ApplicationLogs::getProjectLogs($active_project, $include_private, $include_silent, config_option('dashboard_project_logs_count',7));
          if (isset($temp_project_logs) && is_array($temp_project_logs) && count($temp_project_logs))
          {
            $projects_activity_log[$temp_project_logs[0]->getCreatedOn()->getTimestamp()] = $temp_project_logs;
          }
          krsort($projects_activity_log);
        } // if
        $activity_log = ApplicationLogs::getOverallLogs($include_private, $include_silent, $project_ids, config_option('dashboard_logs_count', 15));
      } // if
      trace(__FILE__, 'index() - tpl_assign...');

      tpl_assign('today_milestones', $logged_user->getTodayMilestones());
      tpl_assign('late_milestones', $logged_user->getLateMilestones());
      tpl_assign('active_projects', $active_projects);
      tpl_assign('activity_log', $activity_log);
      tpl_assign('projects_activity_log', $projects_activity_log);
      
      // Sidebar
      tpl_assign('online_users', Users::getWhoIsOnline());
      tpl_assign('my_projects', $active_projects);
      $this->setSidebar(get_template_path('index_sidebar', 'dashboard'));
      trace(__FILE__, 'index() - end');
    } // index
    
    /**
    * Show my projects page
    *
    * @param void
    * @return null
    */
    function my_projects() {
      trace(__FILE__, 'my_projects');
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
      trace(__FILE__, 'my_tasks');
      $this->addHelper('textile');
      tpl_assign('active_projects', logged_user()->getActiveProjects());
      $this->setSidebar(get_template_path('my_tasks_sidebar', 'dashboard'));
    } // my_tasks

    /**
    * Show my projects page order by name
    *
    * @param void
    * @return null
    */
    function my_projects_by_name() {
      $this->setTemplate('my_projects');
      $this->addHelper('textile');
      $this->my_projects();
    } // my_projects_by_name

    /**
    * Show my projects page order by priority
    *
    * @param void
    * @return null
    */
    function my_projects_by_priority() {
      $this->setTemplate('my_projects');
      $this->addHelper('textile');
      tpl_assign('active_projects', logged_user()->getActiveProjects('priority'));
      tpl_assign('finished_projects', logged_user()->getFinishedProjects());
      $this->setSidebar(get_template_path('my_projects_sidebar', 'dashboard'));
    } // my_projects_by_priority

    /**
    * Show my projects page order by milestone
    *
    * @param void
    * @return null
    */
    function my_projects_by_milestone() {
      $this->setTemplate('my_projects');
      $this->addHelper('textile');
      tpl_assign('active_projects', logged_user()->getActiveProjects('milestone'));
      tpl_assign('finished_projects', logged_user()->getFinishedProjects());
      $this->setSidebar(get_template_path('my_projects_sidebar', 'dashboard'));
    } // my_projects_by_milestone


    /**
    * Show my tasks page order by name
    *
    * @param void
    * @return null
    */
    function my_tasks_by_name() {
      $this->setTemplate('my_tasks');
      $this->addHelper('textile');
      tpl_assign('active_projects', logged_user()->getActiveProjects());
      tpl_assign('sort_order', 'by_name');
      $this->setSidebar(get_template_path('my_tasks_sidebar', 'dashboard'));
    } // my_tasks_by_name

    /**
    * Show my tasks page order by priority
    *
    * @param void
    * @return null
    */
    function my_tasks_by_priority() {
      $this->setTemplate('my_tasks');
      $this->addHelper('textile');
      tpl_assign('active_projects', logged_user()->getActiveProjects('priority'));
      tpl_assign('sort_order', 'by_priority');
      // $this->setSidebar(get_template_path('my_tasks_sidebar', 'dashboard'));
    } // my_tasks_by_priority

    /**
    * Show my tasks page order by milestone
    *
    * @param void
    * @return null
    */
    function my_tasks_by_milestone() {
      $this->setTemplate('my_tasks');
      $this->addHelper('textile');
      tpl_assign('active_projects', logged_user()->getActiveProjects('milestone'));
      tpl_assign('sort_order', 'by_milestone');
      // $this->setSidebar(get_template_path('my_tasks_sidebar', 'dashboard'));
    } // my_tasks_by_milestone

  } // DashboardController

?>
