<?php

  /**
  * Milestone controller
  *
  * @http://www.projectpier.org/
  */
  class MilestoneController extends ApplicationController {
  
    /**
    * Construct the MilestoneController
    *
    * @access public
    * @param void
    * @return MilestoneController
    */
    function __construct() {
      parent::__construct();
      prepare_company_website_controller($this, 'project_website');
    } // __construct
    
    /**
    * List all milestones in specific (this) project
    *
    * @access public
    * @param void
    * @return null
    */
    function index() {
      $this->addHelper('textile');
      $project = active_project();

      $this->canGoOn();

      // Gets desired view 'detail' or 'list'
      // $view_type is from URL, Cookie or set to default: 'list'
      $view_type = array_var($_GET, 'view', Cookie::getValue('milestonesViewType', 'list'));
      $expiration = Cookie::getValue('remember'.TOKEN_COOKIE_NAME) ? REMEMBER_LOGIN_LIFETIME : null;
      Cookie::setValue('milestonesViewType', $view_type, $expiration);
      $filter_assigned = array_var($_GET, 'assigned', Cookie::getValue('milestonesFilterAssigned', 'all'));
      $expiration = Cookie::getValue('remember'.TOKEN_COOKIE_NAME) ? REMEMBER_LOGIN_LIFETIME : null;
      Cookie::setValue('milestonesFilterAssigned', $filter_assigned, $expiration);
  
      $all_milestones_visible_to_user = $project->getMilestones();
      
      $all_assigned_to = array();
      if (logged_user()->isMemberOfOwnerCompany() && is_array($all_milestones_visible_to_user) ) {
        foreach($all_milestones_visible_to_user as $milestone) {
          $assigned_to = $milestone->getAssignedTo();
          if ($assigned_to) {
            $all_assigned_to[$assigned_to->getDisplayName()]=$assigned_to;
          }
        }
      }
   
      tpl_assign('filter_assigned', $filter_assigned);
      tpl_assign('view_type', $view_type);
      tpl_assign('late_milestones', $project->getLateMilestones());
      tpl_assign('today_milestones', $project->getTodayMilestones());
      tpl_assign('upcoming_milestones', $project->getUpcomingMilestones());
      tpl_assign('completed_milestones', $project->getCompletedMilestones());
      tpl_assign('all_visible_milestones', $all_milestones_visible_to_user);
      tpl_assign('assigned_to_milestones', $all_assigned_to);
      
      $this->setSidebar(get_template_path('index_sidebar', 'milestone'));
    } // index
    
    /**
    * Show view milestone page
    *
    * @access public
    * @param void
    * @return null
    */
    function view() {
      $this->addHelper('textile');
      
      $milestone = ProjectMilestones::findById(get_id());
      if (!($milestone instanceof ProjectMilestone)) {
        flash_error(lang('milestone dnx'));
        $this->redirectTo('milestone', 'index');
      } // if
      
      if (!$milestone->canView(logged_user())) {
        flash_error(lang('no access permissions'));
        $this->redirectToReferer(get_url('milestone', 'index'));
      } // if
      
      tpl_assign('milestone', $milestone);
    } // view
    
    /**
    * Show and process add milestone form
    *
    * @access public
    * @param void
    * @return null
    */
    function add() {
      $this->addHelper('textile');
      $this->setTemplate('add_milestone');
      
      if (!ProjectMilestone::canAdd(logged_user(), active_project())) {
        flash_error(lang('no access permissions'));
        $this->redirectToReferer(get_url('milestone', 'index'));
      } // if
      
      $milestone_data = array_var($_POST, 'milestone');
      if (!is_array($milestone_data)) {
        $milestone_data = array(
          'due_date' => DateTimeValueLib::now(),
          'is_private' => config_option('default_private', false),
          'send_notification' => config_option('send_notification_default', false),
        ); // array
      } // if
      $milestone = new ProjectMilestone();
      $milestone->setProjectId(active_project()->getId());
      tpl_assign('milestone_data', $milestone_data);
      tpl_assign('milestone', $milestone);
      $this->setSidebar(get_template_path('textile_help_sidebar'));
      
      if (is_array(array_var($_POST, 'milestone'))) {
        if (isset($_POST['milestone_due_date'])) {
          $milestone_data['due_date'] = DateTimeValueLib::makeFromString($_POST['milestone_due_date']);
        } else {
          $milestone_data['due_date'] = DateTimeValueLib::make(0, 0, 0, array_var($_POST, 'milestone_due_date_month', 1), array_var($_POST, 'milestone_due_date_day', 1), array_var($_POST, 'milestone_due_date_year', 1970));
        }
        
        $assigned_to = explode(':', array_var($milestone_data, 'assigned_to', ''));
        
        $milestone->setFromAttributes($milestone_data);
        if (!logged_user()->isMemberOfOwnerCompany()) {
          $milestone->setIsPrivate(false);
        }
        
        $milestone->setAssignedToCompanyId(array_var($assigned_to, 0, 0));
        $milestone->setAssignedToUserId(array_var($assigned_to, 1, 0));
        
        try {
          DB::beginWork();
          
          $milestone->save();
          if (plugin_active('tags')) {
            $milestone->setTagsFromCSV(array_var($milestone_data, 'tags'));
          }
          ApplicationLogs::createLog($milestone, active_project(), ApplicationLogs::ACTION_ADD);
          
          DB::commit();
          
          // Send notification
          try {
            if (array_var($milestone_data, 'send_notification') == 'checked') {
              Notifier::milestoneAssigned($milestone); // send notification
            } // if
          } catch(Exception $e) {
          
          } // try
          
          flash_success(lang('success add milestone', $milestone->getName()));
          $this->redirectTo('milestone', 'index');
          
        } catch(Exception $e) {
          DB::rollback();
          tpl_assign('error', $e);
        } // try
      } // if
    } // add
    
    /**
    * Show and process edit milestone form
    *
    * @access public
    * @param void
    * @return null
    */
    function edit() {
      $this->addHelper('textile');
      $this->setTemplate('add_milestone');
      
      $milestone = ProjectMilestones::findById(get_id());
      if (!($milestone instanceof ProjectMilestone)) {
        flash_error(lang('milestone dnx'));
        $this->redirectTo('milestone', 'index');
      } // if
      
      if (!$milestone->canEdit(logged_user())) {
        flash_error(lang('no access permissions'));
        $this->redirectToReferer(get_url('milestone', 'index'));
      }
      
      $milestone_data = array_var($_POST, 'milestone');
      if (!is_array($milestone_data)) {
        $tag_names = plugin_active('tags') ? $milestone->getTagNames() : '';
        $milestone_data = array(
          'name'        => $milestone->getName(),
          'goal'        => $milestone->getGoal(),
          'due_date'    => $milestone->getDueDate(),
          'description' => $milestone->getDescription(),
          'assigned_to' => $milestone->getAssignedToCompanyId() . ':' . $milestone->getAssignedToUserId(),
          'tags'        => is_array($tag_names) ? implode(', ', $tag_names) : '',
          'is_private'  => $milestone->isPrivate(),
          'send_notification' => config_option('send_notification_default', false),
        ); // array
      } // if
      
      tpl_assign('milestone_data', $milestone_data);
      tpl_assign('milestone', $milestone);
      $this->setSidebar(get_template_path('textile_help_sidebar'));
      
      if (is_array(array_var($_POST, 'milestone'))) {
        $old_owner = $milestone->getAssignedTo(); // remember the old owner
        if (isset($_POST['milestone_due_date'])) {
          $milestone_data['due_date'] = DateTimeValueLib::makeFromString($_POST['milestone_due_date']);
        } else {
          $milestone_data['due_date'] = DateTimeValueLib::make(0, 0, 0, array_var($_POST, 'milestone_due_date_month', 1), array_var($_POST, 'milestone_due_date_day', 1), array_var($_POST, 'milestone_due_date_year', 1970));
        }
        //$milestone_data['due_date'] = DateTimeValueLib::make(0, 0, 0, array_var($_POST, 'milestone_due_date_month', 1), array_var($_POST, 'milestone_due_date_day', 1), array_var($_POST, 'milestone_due_date_year', 1970));
        
        $assigned_to = explode(':', array_var($milestone_data, 'assigned_to', ''));
        
        $old_is_private  = $milestone->isPrivate();
        $milestone->setFromAttributes($milestone_data);
        if (!logged_user()->isMemberOfOwnerCompany()) {
          $milestone->setIsPrivate($old_is_private);
        }
        
        $milestone->setProjectId(active_project()->getId());
        $milestone->setAssignedToCompanyId(array_var($assigned_to, 0, 0));
        $milestone->setAssignedToUserId(array_var($assigned_to, 1, 0));
        
        try {
          DB::beginWork();
          $milestone->save();
          if (plugin_active('tags')) {
            $milestone->setTagsFromCSV(array_var($milestone_data, 'tags'));
          }
          
          ApplicationLogs::createLog($milestone, active_project(), ApplicationLogs::ACTION_EDIT);
          DB::commit();
          
          // If owner is changed send notification but don't break submission
          try {
            $new_owner = $milestone->getAssignedTo();
            if (array_var($milestone_data, 'send_notification') == 'checked') {
              if ($old_owner instanceof User) {
                // We have a new owner and it is different than old owner
                if ($new_owner instanceof User && $new_owner->getId() <> $old_owner->getId()) {
                  Notifier::milestoneAssigned($milestone);
                }
              } else {
                // We have new owner
                if ($new_owner instanceof User) {
                  Notifier::milestoneAssigned($milestone);
                }
              } // if
            } // if
          } catch(Exception $e) {
          
          } // try
          
          flash_success(lang('success edit milestone', $milestone->getName()));
          $this->redirectTo('milestone', 'index');
          
        } catch(Exception $e) {
          DB::rollback();
          tpl_assign('error', $e);
        } // try
      } // if
    } // edit
    
    /**
    * Delete single milestone
    *
    * @access public
    * @param void
    * @return null
    */
    function delete() {
      $this->setTemplate('del_milestone');

      $milestone = ProjectMilestones::findById(get_id());
      if (!($milestone instanceof ProjectMilestone)) {
        flash_error(lang('milestone dnx'));
        $this->redirectTo('milestone', 'index');
      } // if
      
      if (!$milestone->canDelete(logged_user())) {
        flash_error(lang('no access permissions'));
        $this->redirectToReferer(get_url('milestone', 'index'));
      } // if
      
      $delete_data = array_var($_POST, 'deleteMilestone');
      tpl_assign('milestone', $milestone);
      tpl_assign('delete_data', $delete_data);

      if (!is_array($delete_data)) {
        $delete_data = array(
          'really' => 0,
          'password' => '',
          ); // array
        tpl_assign('delete_data', $delete_data);
      } else if ($delete_data['really'] == 1) {
        $password = $delete_data['password'];
        if (trim($password) == '') {
          tpl_assign('error', new Error(lang('password value missing')));
          return $this->render();
        }
        if (!logged_user()->isValidPassword($password)) {
          tpl_assign('error', new Error(lang('invalid login data')));
          return $this->render();
        }
        try {

          DB::beginWork();
          $milestone->delete();
          ApplicationLogs::createLog($milestone, $milestone->getProject(), ApplicationLogs::ACTION_DELETE);
          DB::commit();

          flash_success(lang('success deleted milestone', $milestone->getName()));
        } catch(Exception $e) {
          DB::rollback();
          flash_error(lang('error delete milestone'));
        } // try

        $this->redirectTo('milestone', 'index');
      } else {
        flash_error(lang('error delete milestone'));
        $this->redirectTo('milestone', 'index');
      }
    } // delete
    
    /**
    * Complete specific milestone
    *
    * @access public
    * @param void
    * @return null
    */
    function complete() {
      $milestone = ProjectMilestones::findById(get_id());
      if (!($milestone instanceof ProjectMilestone)) {
        flash_error(lang('milestone dnx'));
        $this->redirectTo('milestone', 'index');
      } // if
      
      if (!$milestone->canChangeStatus(logged_user())) {
        flash_error(lang('no access permissions'));
        $this->redirectToReferer(get_url('milestone', 'index'));
      } // if
      
      try {
        
        $milestone->setCompletedOn(DateTimeValueLib::now());
        $milestone->setCompletedById(logged_user()->getId());
        
        DB::beginWork();
        $milestone->save();
        ApplicationLogs::createLog($milestone, active_project(), ApplicationLogs::ACTION_CLOSE);
        DB::commit();
        
        flash_success(lang('success complete milestone', $milestone->getName()));
        
      } catch(Exception $e) {
        DB::rollback();
        flash_error(lang('error complete milestone'));
      } // try
      
      $this->redirectToReferer($milestone->getViewUrl());
    } // complete
    
    /**
    * Open specific milestone
    *
    * @access public
    * @param void
    * @return null
    */
    function open() {
      $milestone = ProjectMilestones::findById(get_id());
      if (!($milestone instanceof ProjectMilestone)) {
        flash_error(lang('milestone dnx'));
        $this->redirectTo('milestone', 'index');
      } // if
      
      if (!$milestone->canChangeStatus(logged_user())) {
        flash_error(lang('no access permissions'));
        $this->redirectToReferer(get_url('milestone', 'index'));
      } // if
      
      try {
        
        $milestone->setCompletedOn(null);
        $milestone->setCompletedById(0);
        
        DB::beginWork();
        $milestone->save();
        ApplicationLogs::createLog($milestone, active_project(), ApplicationLogs::ACTION_OPEN);
        DB::commit();
        
        flash_success(lang('success open milestone', $milestone->getName()));
        
      } catch(Exception $e) {
        DB::rollback();
        flash_error(lang('error open milestone'));
      } // try
      
      $this->redirectToReferer($milestone->getViewUrl());
    } // open
  
    /**
    * Show calendar view milestone page
    *
    * @access public
    * @param void
    * @return null
    */
    function calendar() {
      $this->addHelper('textile');

      $project = active_project();
      $id = get_id();
      if (strlen($id) == 0) {
        $id = gmdate('Ym');
      }
      if (preg_match('/^(\d{4})(\d{2})$/', $id, $matches)) {
        list (, $year, $month) = $matches;
        tpl_assign('year', $year);
        tpl_assign('month', $month);
      } else {
        flash_error(lang('id missing'));
        $this->redirectToReferer(get_url('milestone', 'index'));
      }

      $view_type = array_var($_GET, 'view', Cookie::getValue('milestonesViewType', 'list'));
      $expiration = Cookie::getValue('remember'.TOKEN_COOKIE_NAME) ? REMEMBER_LOGIN_LIFETIME : null;
      Cookie::setValue('milestonesViewType', $view_type, $expiration);

      tpl_assign('view_type', $view_type);
      tpl_assign('milestones', $project->getMilestonesByMonth($year, $month));
      tpl_assign('task_lists', $project->getTaskListsByMonth($year, $month));
    } // calendar

  } // MilestoneController

?>