<?php

  /**
  * Time controller
  *
  * @package Taus.application
  * @subpackage controller
  * @version 1.0
  * @author Ilija Studen <ilija.studen@gmail.com>
  */
  class TimeController extends ApplicationController {
  
    /**
    * Construct the TimeController
    *
    * @access public
    * @param void
    * @return TimeController
    */
    function __construct() {
      parent::__construct();
      prepare_company_website_controller($this, 'project_website');
    } // __construct
    
    /**
    * List all time in specific (this) project
    *
    * @access public
    * @param void
    * @return null
    */
    function index() {
      $this->addHelper('textile');
      $project = active_project();

      // Attiks - BEGIN
      //      tpl_assign('times', $project->getTimes());
      $page = (integer) array_var($_GET, 'page', 1);
      if($page < 0) $page = 1;
      $conditions = array('`project_id` = ?', active_project()->getId());
      list($times, $pagination) = ProjectTimes::paginate(
        array(
          'conditions' => $conditions,
          'order' => '`created_on` DESC'
        ),
        config_option('messages_per_page', 10), 
        $page
      ); // paginate
      tpl_assign('times', $times);
      tpl_assign('times_pagination', $pagination);
      // Attiks - END
     
      $this->setSidebar(get_template_path('index_sidebar', 'time'));
    } // index
    
    // Attiks - BEGIN
    /**
    * List all time in specific (this) project by task
    *
    * @access public
    * @param void
    * @return null
    */
    function bytask() {
      $this->addHelper('textile');
    	$project = active_project();

    	$page = (integer) array_var($_GET, 'page', 1);
    	if($page < 0) $page = 1;

    	$conditions = array('`project_id` = ?', active_project()->getId());

    	list($times, $pagination) = ProjectTimes::paginate(
      	array(
      	  'conditions' => $conditions,
      	  'order' => '`created_on` DESC'
      	),
      	config_option('messages_per_page', 10), 
      	$page
    	); // paginate
    	tpl_assign('times', $times);
    	tpl_assign('times_pagination', $pagination);
    	tpl_assign('task_lists', active_project()->getTaskLists());
         
    	$this->setSidebar(get_template_path('index_sidebar', 'time'));
    } // bytask
    // Attiks - END


    /**
    * Show view time page
    *
    * @access public
    * @param void
    * @return null
    */
    function view() {
      $this->addHelper('textile');

      $time = ProjectTimes::findById(get_id());
      if(!($time instanceof ProjectTime)) {
        flash_error(lang('time dnx'));
        $this->redirectTo('time', 'index');
      } // if

      if(!$time->canView(logged_user())) {
        flash_error(lang('no access permissions'));
        $this->redirectToReferer(get_url('time'));
      } // if

      tpl_assign('time', $time);
    } // view
    
    /**
    * Process add time form
    *
    * @access public
    * @param void
    * @return null
    */
    function add() {
      $this->setTemplate('add_time');
      
      if(!ProjectTime::canAdd(logged_user(), active_project())) {
        flash_error(lang('no access permissions'));
        $this->redirectToReferer(get_url('time'));
      } // if
      
      $time = new ProjectTime();
      $time_data = array_var($_POST, 'time');
      if(!is_array($time_data)) {
        $user = logged_user();
        // phpfreak: accept incoming parameters
        $initial_name = '';
        $task_id = isset($_GET['task']) ? $_GET['task'] : 0;
        if ($task_id) {
          $task = ProjectTasks::findById($task_id);
          if ($task) {
            $initial_name = lang('times time spent on task', $task->getObjectName());
            $time->setTaskId($task_id);
          }
        }
        $time_data = array(
          'done_date' => DateTimeValueLib::now(),
          'is_billable' => true,
          'assigned_to' => logged_user()->getCompanyId() . ":" . logged_user()->getId(),
          'is_private' => config_option('default_private', false),
          'name' => $initial_name,
        ); // array
      } // if
      tpl_assign('time_data', $time_data);
      tpl_assign('time', $time);

      tpl_assign('open_task_lists', active_project()->getOpenTaskLists());
      
      if(is_array(array_var($_POST, 'time'))) {
        if (isset($_POST['time_done_date'])) {
          $time_data['done_date'] = DateTimeValueLib::makeFromString($_POST['time_done_date']);
        } else {
          $time_data['done_date'] = DateTimeValueLib::make(0, 0, 0, array_var($_POST, 'time_done_date_month', 1), array_var($_POST, 'time_done_date_day', 1), array_var($_POST, 'time_done_date_year', 1970));
        }
        
        $assigned_to = explode(':', array_var($time_data, 'assigned_to', ''));
        // Attiks - BEGIN
        if (isset($time_data['task_id'])) { 
          if (substr($time_data['task_id'], 0, 5) == 'task_') {
        		$time_data['task_id'] = substr($time_data['task_id'], 5);
        		$t = ProjectTasks::findById ($time_data['task_id']);
        		if(!($t instanceof ProjectTask)) {
        			flash_error(lang('task dnx'));
        			$this->redirectTo('task');
  		      } // if
            $time_data['task_list_id'] = $t->getTaskListId();
          } else {
            $time_data['task_list_id'] = $time_data['task_id'];
            $time_data['task_id'] = null;
          }
        }
        // Attiks - END
        
        $time->setFromAttributes($time_data);
        if(!logged_user()->isMemberOfOwnerCompany()) $time->setIsPrivate(false);
        
        $time->setProjectId(active_project()->getId());
        $time->setAssignedToCompanyId(array_var($assigned_to, 0, 0));
        $time->setAssignedToUserId(array_var($assigned_to, 1, 0));
        
        try {
          DB::beginWork();
          
          $time->save();
          ApplicationLogs::createLog($time, active_project(), ApplicationLogs::ACTION_ADD);
          
          DB::commit();
          
          flash_success(lang('success add time', $time->getName()));
          $this->redirectTo('time');
          
        } catch(Exception $e) {
          DB::rollback();
          tpl_assign('error', $e);
        } // try
      } // if
    } // add
    
    /**
    * Show and process edit time form
    *
    * @access public
    * @param void
    * @return null
    */
    function edit() {
      $this->setTemplate('add_time');
      
      $time = ProjectTimes::findById(get_id());
      if(!($time instanceof ProjectTime)) {
        flash_error(lang('time dnx'));
        $this->redirectTo('time', 'index');
      } // if
      
      if(!$time->canEdit(logged_user())) {
        flash_error(lang('no access permissions'));
        $this->redirectToReferer(get_url('time'));
      }
      
      $time_data = array_var($_POST, 'time');
      if(!is_array($time_data)) {
        $time_data = array(
          'name'        => $time->getName(),
          'hours'        => $time->getHours(),
          'is_billable'  => $time->getBillable(),
          'done_date'    => $time->getDoneDate(),
          'description' => $time->getDescription(),
          'assigned_to' => $time->getAssignedToCompanyId() . ':' . $time->getAssignedToUserId(),
          'is_private'  => $time->isPrivate(),
// Attiks - BEGIN
          'task_id'  => $time->getTaskId(),
          'task_list_id'  => $time->getTaskListId(),
// Attiks - END
        ); // array
      } // if
      
      tpl_assign('time_data', $time_data);
      tpl_assign('time', $time);
      // Attiks - BEGIN
      tpl_assign('open_task_lists', active_project()->getOpenTaskLists());
      // Attiks - END
      
      if(is_array(array_var($_POST, 'time'))) {
        $old_owner = $time->getAssignedTo(); // remember the old owner
        if (isset($_POST['time_done_date'])) {
          $time_data['done_date'] = DateTimeValueLib::makeFromString($_POST['time_done_date']);
        } else {
          $time_data['done_date'] = DateTimeValueLib::make(0, 0, 0, array_var($_POST, 'time_done_date_month', 1), array_var($_POST, 'time_done_date_day', 1), array_var($_POST, 'time_done_date_year', 1970));
        }
        // Attiks - BEGIN
        if (isset($time_data['task_id'])) { 
      	  if (substr($time_data['task_id'], 0, 5) == 'task_') {
            $time_data['task_id'] = substr($time_data['task_id'], 5);
            $t = ProjectTasks::findById ($time_data['task_id']);
      		  if(!($t instanceof ProjectTask)) {
              flash_error(lang('task dnx'));
              $this->redirectTo('task');
      		  } // if
            $time_data['task_list_id'] = $t->getTaskListId();
      	  } else {
            $time_data['task_list_id'] = $time_data['task_id'];
            $time_data['task_id'] = null;
        	}
      	}
        // Attiks - END
        
        $assigned_to = explode(':', array_var($time_data, 'assigned_to', ''));
        
        $old_is_private  = $time->isPrivate();
        $time->setFromAttributes($time_data);
        if(!logged_user()->isMemberOfOwnerCompany()) $time->setIsPrivate($old_is_private);
        
        $time->setProjectId(active_project()->getId());
        $time->setAssignedToCompanyId(array_var($assigned_to, 0, 0));
        $time->setAssignedToUserId(array_var($assigned_to, 1, 0));
        
        try {
          DB::beginWork();
          $time->save();
          
          ApplicationLogs::createLog($time, active_project(), ApplicationLogs::ACTION_EDIT);
          DB::commit();
          
          flash_success(lang('success edit time', $time->getName()));
          $this->redirectTo('time');
          
        } catch(Exception $e) {
          DB::rollback();
          tpl_assign('error', $e);
        } // try
      } // if
    } // edit
    
    /**
    * Delete single time
    *
    * @access public
    * @param void
    * @return null
    */
    function delete() {
      $time = ProjectTimes::findById(get_id());
      if(!($time instanceof ProjectTime)) {
        flash_error(lang('time dnx'));
        $this->redirectTo('time');
      } // if
      
      if(!$time->canDelete(logged_user())) {
        flash_error(lang('no access permissions'));
        $this->redirectToReferer(get_url('time'));
      } // if
      
      try {
        
        DB::beginWork();
        $time->delete();
        ApplicationLogs::createLog($time, $time->getProject(), ApplicationLogs::ACTION_DELETE);
        DB::commit();
        
        flash_success(lang('success deleted time', $time->getName()));
      } catch(Exception $e) {
        DB::rollback();
        flash_error(lang('error delete time'));
      } // try
      
      $this->redirectTo('time');
    } // delete

    /**
    * Set the status for marked time items
    *
    * @access public
    * @param void
    * @return null
    */
    function setstatus() {
      if (!logged_user()->isAdministrator(owner_company())) {
        flash_error(lang('no access permissions'));
        $this->redirectTo('dashboard');
      } // if

      $status = (array_var($_GET, 'status')) ? array_var($_GET, 'status') : 0;
      $new_status = abs($status - 1);
      $new_status_text = ($new_status) ? lang('billed') : lang('unbilled');
      $items = array_var($_POST, 'item');

      $redirect_to = array_var($_GET, 'redirect_to');
      if ($redirect_to == '') {
        $redirect_to = get_url('administration', 'time', array('status' => $status));
        $redirect_to = str_replace('&amp;', '&', trim($redirect_to));
      } // if

      if (is_array($items) && count($items)) {
        foreach ($items as $id => $status) {
          $time = ProjectTimes::findById($id);
          if(!($time instanceof ProjectTime)) {
            flash_error(lang('time dnx'));
            $this->redirectToUrl($redirect_to);
          } // if
          $time->setIsClosed($new_status);
          try {   
            DB::beginWork();
            $time->save();
            ApplicationLogs::createLog($time, $time->getProject(), ApplicationLogs::ACTION_EDIT);
            DB::commit();
          } catch(Exception $e) {
            DB::rollback();
            flash_error(lang('times error changing status'));
            $this->redirectToUrl($redirect_to);
          } // try
        } // foreach
        flash_success(lang('times items successfully marked', $new_status_text));
      } // if
      $this->redirectToUrl($redirect_to);
    } // setstatus

    /**
    * List all time total for a user (both billed and unbilled)
    *
    * @access public
    * @param void
    * @return null
    */
    function byuser() {
      $this->setLayout('administration');

      if (!logged_user()->isAdministrator(owner_company())) {
        flash_error(lang('no access permissions'));
        $this->redirectTo('dashboard');
      } // if

      $user_id = (integer) array_var($_GET, 'id', 0);
      if ($user_id < 0) $user_id = 0;

      $redirect_to = array_var($_GET, 'redirect_to');
      if ($redirect_to == '') {
        $redirect_to = get_url('time', 'byuser', array('id' => $user_id));
        $redirect_to = str_replace('&amp;', '&', trim($redirect_to));
      } // if

      $unbilled = ProjectTimes::getTimeByUserStatus(Users::findById($user_id));
      $billed = ProjectTimes::getTimeByUserStatus(Users::findById($user_id), 1);

      tpl_assign('unbilled', $unbilled);
      tpl_assign('billed', $billed);
      tpl_assign('user', Users::findById($user_id));
      tpl_assign('redirect_to', $redirect_to);

      $this->setSidebar(get_template_path('index_sidebar', 'time'));
    } // byuser

    /**
    * List all time total for a project (both billed and unbilled)
    *
    * @access public
    * @param void
    * @return null
    */
    function byproject() {
      $this->setLayout('administration');

      if (!logged_user()->isAdministrator(owner_company())) {
        flash_error(lang('no access permissions'));
        $this->redirectTo('dashboard');
      } // if

      $project_id = (integer) array_var($_GET, 'id', 0);
      if ($project_id < 0) $project_id = 0;

      $redirect_to = array_var($_GET, 'redirect_to');
      if ($redirect_to == '') {
        $redirect_to = get_url('time', 'byproject', array('id' => $project_id));
        $redirect_to = str_replace('&amp;', '&', trim($redirect_to));
      } // if

      $unbilled = ProjectTimes::getTimeByProjectStatus(Projects::findById($project_id));
      $billed = ProjectTimes::getTimeByProjectStatus(Projects::findById($project_id), 1);

      tpl_assign('unbilled', $unbilled);
      tpl_assign('billed', $billed);
      tpl_assign('project', Projects::findById($project_id));
      tpl_assign('redirect_to', $redirect_to);

      $this->setSidebar(get_template_path('index_sidebar', 'time'));
    } // byproject    
  } // TimeController

?>