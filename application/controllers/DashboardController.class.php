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
        if (logged_user()->isAdministrator()) {
          $activity_log = ApplicationLogs::getOverallLogs($include_private, $include_silent, null, config_option('dashboard_logs_count', 150));
        } else {
          $activity_log = ApplicationLogs::getOverallLogs($include_private, $include_silent, $project_ids, config_option('dashboard_logs_count', 150));
        }
      } // if
      if (plugin_active('files')) {
        $my_files = $logged_user->getImportantFiles();
      } else {
        $my_files = array();
      }
      trace(__FILE__, 'index() - tpl_assign...');

      tpl_assign('today_milestones', $logged_user->getTodayMilestones());
      tpl_assign('late_milestones', $logged_user->getLateMilestones());
      tpl_assign('active_projects', $active_projects);
      tpl_assign('activity_log', $activity_log);
      tpl_assign('projects_activity_log', $projects_activity_log);
      
      // Sidebar
      tpl_assign('online_users', Users::getWhoIsOnline());
      tpl_assign('my_projects', $active_projects);
      tpl_assign('my_files', $my_files);
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

    /**
      * Lists all company contacts
      * 
      * @param void
      * @return null
      */
    function contacts() {
      if (!logged_user()->isMemberOfOwnerCompany()) {
        flash_error(lang('no access permissions'));
        $this->redirectTo('dashboard');
      } // if

      $page = (integer) array_var($_GET, 'page', 1);
      if ($page < 0) {
        $page = 1;
      } // if
      
      $contacts_per_page = array_var($_GET, 'per_page', Cookie::getValue('contactsPerPage', '20'));
      $expiration = Cookie::getValue('remember'.TOKEN_COOKIE_NAME) ? REMEMBER_LOGIN_LIFETIME : null;
      Cookie::setValue('contactsPerPage', $contacts_per_page, $expiration);
      
      $view_type = array_var($_GET, 'view', Cookie::getValue('contactsViewType', 'detail'));
      $expiration = Cookie::getValue('remember'.TOKEN_COOKIE_NAME) ? REMEMBER_LOGIN_LIFETIME : null;
      Cookie::setValue('contactsViewType', $view_type, $expiration);
      
      $initial = array_var($_GET, 'initial', '');
      if (trim($initial) == '') {
        $conditions = '';
      } elseif ($initial == "_") {
        $conditions = "`display_name` REGEXP '^[^a-z]'";
      } else {
        $conditions = "`display_name` LIKE '$initial%'";
      } // if
      
      list($contacts, $pagination) = Contacts::paginate(
        array(
          'conditions' => $conditions,
          'order' => '`display_name` ASC'
        ),
        $contacts_per_page,
        $page
      ); // paginate
      
      $favorite_companies = Companies::getFavorites();
      
      tpl_assign('view_type', $view_type);
      tpl_assign('tags', array());
      if (plugin_active('tags')) {
        tpl_assign('tags', Tags::getClassTagNames('Contacts', false));
      }
      tpl_assign('contacts', $contacts);
      tpl_assign('contacts_pagination', $pagination);
      tpl_assign('favorite_companies', $favorite_companies);
      tpl_assign('initial', $initial);
      tpl_assign('initials', Contacts::getInitials());
      $this->setSidebar(get_template_path('contacts_sidebar', 'dashboard'));
    } // contacts
    
    /**
    * Contact search
    *
    * @param void
    * @return null
    */
    function search_contacts() {
      if (!logged_user()->isMemberOfOwnerCompany()) {
        flash_error(lang('no access permissions'));
        $this->redirectTo('dashboard');
      } // if

      $page = (integer) array_var($_GET, 'page', 1);
      if ($page < 0) {
        $page = 1;
      } // if
      
      $contacts_per_page = array_var($_GET, 'per_page', Cookie::getValue('contactsPerPage', '10'));
      $expiration = Cookie::getValue('remember'.TOKEN_COOKIE_NAME) ? REMEMBER_LOGIN_LIFETIME : null;
      Cookie::setValue('contactsPerPage', $contacts_per_page, $expiration);
      
      $search_term = array_var($_GET, 'search_for', '');
      $fuzzy_search_term = '%'.$search_term.'%';
      $conditions = array('`display_name` LIKE ? OR `email` LIKE ? OR `title` LIKE ?', $fuzzy_search_term, $fuzzy_search_term, $fuzzy_search_term);
      
      list($contacts, $pagination) = Contacts::paginate(
        array(
          'conditions' => $conditions,
          'order' => '`display_name` ASC'
        ),
        $contacts_per_page,
        $page
      ); // paginate
      
      tpl_assign('contacts', $contacts);
      tpl_assign('contacts_pagination', $pagination);
      tpl_assign('search_term', $search_term);

    } // search_contacts

    /**
    * Search contacts by tag
    *
    * @param void
    * @return null
    */
    function search_by_tag() {
      $tag = array_var($_GET, 'tag');
      if (trim($tag) == '') {
        flash_error(lang('tag dnx'));
        $this->redirectTo('dashboard', 'contacts');
      } // if

      tpl_assign('contacts', Tags::getTaggedObjects(null, $tag, 'Contacts', false));
      tpl_assign('search_term', $tag);
    } // search_by_tag

    /**
      * Shows weekly schedule in a calendar view
      * 
      * @param void
      * @return null
      */
    function weekly_schedule() {
      $this->addHelper('textile');
      
      // Gets desired view 'detail', 'list' or 'calendar'
      // $view_type is from URL, Cookie or set to default: 'calendar'
      $view_type = array_var($_GET, 'view', Cookie::getValue('weeklyScheduleViewType', 'calendar'));
      $expiration = Cookie::getValue('remember'.TOKEN_COOKIE_NAME) ? REMEMBER_LOGIN_LIFETIME : null;
      Cookie::setValue('weeklyScheduleViewType', $view_type, $expiration);
      
      $monthYear = array_var($_GET, 'month');
      if (!isset($monthYear) || trim($monthYear) == '' || preg_match('/^(\d{4})(\d{2})$/', $monthYear, $matches) == 0) {
        $year = gmdate('Y');
        $month = gmdate('m');
      } else {
        list(, $year, $month) = $matches;
      }
      
      // TODO make first day of week configurable
      $from_date = DateTimeValueLib::makeFromString('monday'.(date('w')==1?'':' last week'));
      $to_date = $from_date->advance(60*60*24*7*3, false); // +3 weeks
      $upcoming_milestones = ProjectMilestones::getActiveMilestonesInPeriodByUser(logged_user(), $from_date, $to_date);
      $upcoming_tickets = array();
      if (plugin_active('tickets')) {
        $upcoming_tickets = ProjectTickets::getOpenTicketsInPeriodByUser(logged_user(), $from_date, $to_date);
      }
      
      $active_projects = array();
      $projects_index = array();
      $counter = 1;

      if (is_array($upcoming_milestones)) {
        foreach ($upcoming_milestones as $milestone) {
          if (!isset($projects_index[$milestone->getProjectId()])) {
            $projects_index[$milestone->getProjectId()] = $counter;
            $active_projects[] = $milestone->getProject();
            $counter++;
          } // if
        } // foreach
      } // if

      if (is_array($upcoming_tickets)) {
        foreach ($upcoming_tickets as $ticket) {
          if (!isset($projects_index[$ticket->getProjectId()])) {
            $projects_index[$ticket->getProjectId()] = $counter;
            $active_projects[] = $ticket->getProject();
            $counter++;
          } // if
        } // foreach
      } // if
      
      tpl_assign('from_date', $from_date);
      tpl_assign('to_date', $to_date);
      tpl_assign('view_type', $view_type);
      tpl_assign('upcoming_tickets', $upcoming_tickets);
      tpl_assign('late_tickets', array() ); // logged_user()->getLateTickets());
      tpl_assign('upcoming_milestones', $upcoming_milestones);
      tpl_assign('late_milestones', array() ); // logged_user()->getLateMilestones());
      tpl_assign('projects', $active_projects);
      tpl_assign('projects_index', $projects_index);
    } // weekly_schedule

  } // DashboardController

?>