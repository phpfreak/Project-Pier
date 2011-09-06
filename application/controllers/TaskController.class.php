<?php

  /**
  * Controller for handling task list and task related requests
  *
  * @version 1.0
  * @http://www.projectpier.org/
  */
  class TaskController extends ApplicationController {
  
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
    * Show index page
    *
    * @access public
    * @param void
    * @return null
    */
    function index() {
      tpl_assign('open_task_lists', active_project()->getOpenTaskLists());
      tpl_assign('completed_task_lists', active_project()->getCompletedTaskLists());
      $this->setSidebar(get_template_path('index_sidebar', 'task'));
    } // index
    
    /**
    * View task lists page
    *
    * @access public
    * @param void
    * @return null
    */
    function view_list() {
      $task_list = ProjectTaskLists::findById(get_id());
      if (!($task_list instanceof ProjectTaskList)) {
        flash_error(lang('task list dnx'));
        $this->redirectTo('task');
      } // if
      
      if (!$task_list->canView(logged_user())) {
        flash_error(lang('no access permissions'));
        $this->redirectToReferer(get_url('task'));
      } // if
      
      tpl_assign('task_list', $task_list);
      
      // Sidebar
      tpl_assign('open_task_lists', active_project()->getOpenTaskLists());
      tpl_assign('completed_task_lists', active_project()->getCompletedTaskLists());
      $this->setSidebar(get_template_path('index_sidebar', 'task'));
    } // view_list
    
    /**
    * Add new task list
    *
    * @access public
    * @param void
    * @return null
    */
    function add_list() {
      
      if (!ProjectTaskList::canAdd(logged_user(), active_project())) {
        flash_error(lang('no access permissions'));
        $this->redirectToReferer(get_url('task'));
      } // if
      
      $task_list = new ProjectTaskList();
      $task_list_data = array_var($_POST, 'task_list');
      if (!is_array($task_list_data)) {
        $task_list_data = array(
          'milestone_id' => array_var($_GET, 'milestone_id')
        ); // array
      } // if
      
      tpl_assign('task_list_data', $task_list_data);
      tpl_assign('task_list', $task_list);
      
      if (is_array(array_var($_POST, 'task_list'))) {
        
        $task_list->setFromAttributes($task_list_data);
        $task_list->setProjectId(active_project()->getId());
        if (!logged_user()->isMemberOfOwnerCompany()) {
          $task_list->setIsPrivate(false);
        }
        
        $tasks = array();
        for ($i = 0; $i < 6; $i++) {
          if (isset($task_list_data["task$i"]) && is_array($task_list_data["task$i"]) && (trim(array_var($task_list_data["task$i"], 'text')) <> '')) {
            $assigned_to = explode(':', array_var($task_list_data["task$i"], 'assigned_to', ''));
            $tasks[] = array(
              'text' => array_var($task_list_data["task$i"], 'text'),
              'assigned_to_company_id' => array_var($assigned_to, 0, 0),
              'assigned_to_user_id' => array_var($assigned_to, 1, 0)
            ); // array
          } // if
        } // for
        
        try {
          
          DB::beginWork();
          $task_list->save();
          $task_list->setTagsFromCSV(array_var($task_list_data, 'tags'));
          
          foreach ($tasks as $task_data) {
            $task = new ProjectTask();
            $task->setFromAttributes($task_data);
            $task_list->attachTask($task);
            $task->save();
          } // foreach
          
          ApplicationLogs::createLog($task_list, active_project(), ApplicationLogs::ACTION_ADD);
          DB::commit();
          
          flash_success(lang('success add task list', $task_list->getName()));
          $this->redirectToUrl($task_list->getViewUrl());
          
        } catch(Exception $e) {
          DB::rollback();
          tpl_assign('error', $e);
        } // try
        
      } // if
      
    } // add_list
    
    /**
    * Edit task list
    *
    * @access public
    * @param void
    * @return null
    */
    function edit_list() {
      $this->setTemplate('add_list');
      
      $task_list = ProjectTaskLists::findById(get_id());
      if (!($task_list instanceof ProjectTaskList)) {
        flash_error(lang('task list dnx'));
        $this->redirectTo('task');
      } // if
      
      if (!$task_list->canEdit(logged_user())) {
        flash_error(lang('no access permissions'));
        $this->redirectTo('task');
      } // if
      
      $task_list_data = array_var($_POST, 'task_list');
      if (!is_array($task_list_data)) {
        $tag_names = $task_list->getTagNames();
        $task_list_data = array(
          'name' => $task_list->getName(),
          'description' => $task_list->getDescription(),
          'milestone_id' => $task_list->getMilestoneId(),
          'tags' => is_array($tag_names) && count($tag_names) ? implode(', ', $tag_names) : '',
          'is_private' => $task_list->isPrivate(),
        ); // array
      } // if
      tpl_assign('task_list', $task_list);
      tpl_assign('task_list_data', $task_list_data);
      
      if (is_array(array_var($_POST, 'task_list'))) {
        $old_is_private = $task_list->isPrivate();
        $task_list->setFromAttributes($task_list_data);
        if (!logged_user()->isMemberOfOwnerCompany()) {
          $task_list->setIsPrivate($old_is_private);
        }
        
        try {
          DB::beginWork();
          
          $task_list->save();
          $task_list->setTagsFromCSV(array_var($task_list_data, 'tags'));
          ApplicationLogs::createLog($task_list, active_project(), ApplicationLogs::ACTION_EDIT);
          
          DB::commit();
          
          flash_success(lang('success edit task list', $task_list->getName()));
          $this->redirectToUrl($task_list->getViewUrl());
          
        } catch(Exception $e) {
          DB::rollback();
          tpl_assign('error', $e);
        } // try
      } // if
    } // edit_list
    
    /**
    * Delete task list
    *
    * @access public
    * @param void
    * @return null
    */
    function delete_list() {
      $this->setTemplate('del_list');
      
      $task_list = ProjectTaskLists::findById(get_id());
      if (!($task_list instanceof ProjectTaskList)) {
        flash_error(lang('task list dnx'));
        $this->redirectTo('task');
      } // if
      
      if (!$task_list->canDelete(logged_user())) {
        flash_error(lang('no access permissions'));
        $this->redirectTo('task');
      } // if
      
      $delete_data = array_var($_POST, 'deleteTaskList');
      tpl_assign('task_list', $task_list);
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
          $task_list->delete();
          ApplicationLogs::createLog($task_list, active_project(), ApplicationLogs::ACTION_DELETE);
          DB::commit();

          flash_success(lang('success delete task list', $task_list->getName()));
        } catch(Exception $e) {
          DB::rollback();
          flash_error(lang('error delete task list'));
        } // try

        $this->redirectTo('task');
      } else {
        flash_error(lang('error delete task list'));
        $this->redirectToUrl($task_list->getViewUrl());
      }
    } // delete_list
    
    /**
    * Show and process reorder tasks form
    *
    * @param void
    * @return null
    */
    function reorder_tasks() {
      $task_list = ProjectTaskLists::findById(get_id('task_list_id'));
      if (!($task_list instanceof ProjectTaskList)) {
        flash_error(lang('task list dnx'));
        $this->redirectTo('task');
      } // if
      
      $back_to_list = (boolean) array_var($_GET, 'back_to_list');
      $redirect_to = $back_to_list ? $task_list->getViewUrl() : get_url('task');
      
      if (!$task_list->canReorderTasks(logged_user())) {
        flash_error(lang('no access permissions'));
        $this->redirectToUrl($redirect_to);
      } // if
      
      $tasks = $task_list->getOpenTasks();
      if (!is_array($tasks) || (count($tasks) < 1)) {
        flash_error(lang('no open task in task list'));
        $this->redirectToUrl($redirect_to);
      } // if
      
      tpl_assign('task_list', $task_list);
      tpl_assign('tasks', $tasks);
      tpl_assign('back_to_list', $back_to_list);
      
      if (array_var($_POST, 'submitted') == 'submitted') {
        $updated = 0;
        foreach ($tasks as $task) {
          $new_value = (integer) array_var($_POST, 'task_' . $task->getId());
          if ($new_value <> $task->getOrder()) {
            $task->setOrder($new_value);
            if ($task->save()) {
              $updated++;
            } // if
          } // if
        } // foreach
        
        flash_success(lang('success n tasks updated', $updated));
        $this->redirectToUrl($redirect_to);
      } // if
    } // reorder_tasks
    
    // ---------------------------------------------------
    //  Tasks
    // ---------------------------------------------------
    
    /**
    * Add single task
    *
    * @access public
    * @param void
    * @return null
    */
    function add_task() {
      $task_list = ProjectTaskLists::findById(get_id('task_list_id'));
      if (!($task_list instanceof ProjectTaskList)) {
        flash_error(lang('task list dnx'));
        $this->redirectTo('task');
      } // if
      
      if (!$task_list->canAddTask(logged_user())) {
        flash_error(lang('no access permissions'));
        $this->redirectTo('task');
      } // if
      
      $back_to_list = array_var($_GET, 'back_to_list');
      
      $task = new ProjectTask();
      $task_data = array_var($_POST, 'task');
      
      tpl_assign('task', $task);
      tpl_assign('task_list', $task_list);
      tpl_assign('back_to_list', $back_to_list);
      tpl_assign('task_data', $task_data);
      
      // Form is submited
      if (is_array($task_data)) {
        $task->setFromAttributes($task_data);
        
        $assigned_to = explode(':', array_var($task_data, 'assigned_to', ''));
        $task->setAssignedToCompanyId(array_var($assigned_to, 0, 0));
        $task->setAssignedToUserId(array_var($assigned_to, 1, 0));
        
        try {
          
          DB::beginWork();
          $task->save();
          $task_list->attachTask($task);
          ApplicationLogs::createLog($task, active_project(), ApplicationLogs::ACTION_ADD);
          DB::commit();
          
          flash_success(lang('success add task'));
          if ($back_to_list) {
            $this->redirectToUrl($task_list->getViewUrl());
          } else {
            $this->redirectTo('task');
          } // if
          
        } catch(Exception $e) {
          DB::rollback();
          tpl_assign('error', $e);
        } // try
        
      } // if
    } // add_task
    
    /**
    * Edit task
    *
    * @access public
    * @param void
    * @return null
    */
    function edit_task() {
      $this->setTemplate('add_task');
      
      $task = ProjectTasks::findById(get_id());
      if (!($task instanceof ProjectTask)) {
        flash_error(lang('task dnx'));
        $this->redirectTo('task');
      } // if
      
      $task_list = $task->getTaskList();
      if (!($task_list instanceof ProjectTaskList)) {
        flash_error('task list dnx');
        $this->redirectTo('task');
      } // if
      
      if (!$task->canEdit(logged_user())) {
        flash_error(lang('no access permissions'));
        $this->redirectTo('task');
      } // if
      
      $task_data = array_var($_POST, 'task');
      if (!is_array($task_data)) {
        $task_data = array(
          'text' => $task->getText(),
          'task_list_id' => $task->getTaskListId(),
          'assigned_to' => $task->getAssignedToCompanyId() . ':' . $task->getAssignedToUserId()
        ); // array
      } // if
      
      tpl_assign('task', $task);
      tpl_assign('task_list', $task_list);
      tpl_assign('task_data', $task_data);
      
      if (is_array(array_var($_POST, 'task'))) {
        $task->setFromAttributes($task_data);
        $task->setTaskListId($task_list->getId()); // keep old task list id
        
        $assigned_to = explode(':', array_var($task_data, 'assigned_to', ''));
        $task->setAssignedToCompanyId(array_var($assigned_to, 0, 0));
        $task->setAssignedToUserId(array_var($assigned_to, 1, 0));
        
        try {
          DB::beginWork();
          $task->save();
          
          // Move?
          $new_task_list_id = (integer) array_var($task_data, 'task_list_id');
          if ($new_task_list_id && ($task->getTaskListId() <> $new_task_list_id)) {
            
            // Move!
            $new_task_list = ProjectTaskLists::findById($new_task_list_id);
            if ($new_task_list instanceof ProjectTaskList) {
              $task_list->detachTask($task, $new_task_list); // detach from old and attach to new list
            } // if
            
          } // if
          
          ApplicationLogs::createLog($task, active_project(), ApplicationLogs::ACTION_EDIT);
          DB::commit();
          
          flash_success(lang('success edit task'));
          
          // Redirect to task list. Check if we have updated task list ID first
          if (isset($new_task_list) && ($new_task_list instanceof ProjectTaskList)) {
            $this->redirectToUrl($new_task_list->getViewUrl());
          } else {
            $this->redirectToUrl($task_list->getViewUrl());
          } // if
          
        } catch(Exception $e) {
          DB::rollback();
          tpl_assign('error', $e);
        } // try
        
      } // if
      
    } // edit_task
    
    /**
    * Delete specific task
    *
    * @access public
    * @param void
    * @return null
    */
    function delete_task() {
      $this->setTemplate('del_task');

      $task = ProjectTasks::findById(get_id());
      if (!($task instanceof ProjectTask)) {
        flash_error(lang('task dnx'));
        $this->redirectTo('task');
      } // if
      
      $task_list = $task->getTaskList();
      if (!($task_list instanceof ProjectTaskList)) {
        flash_error('task list dnx');
        $this->redirectTo('task');
      } // if
      
      if (!$task->canDelete(logged_user())) {
        flash_error(lang('no access permissions'));
        $this->redirectTo('task');
      } // if
      
      $delete_data = array_var($_POST, 'deleteTask');
      tpl_assign('task', $task);
      tpl_assign('task_list', $task_list);
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
          $task->delete();
          ApplicationLogs::createLog($task, active_project(), ApplicationLogs::ACTION_DELETE);
          DB::commit();

          flash_success(lang('success delete task'));
        } catch(Exception $e) {
          DB::rollback();
          flash_error(lang('error delete task'));
        } // try

        $this->redirectToUrl($task_list->getViewUrl());
      } else {
        flash_error(lang('error delete task'));
        $this->redirectToUrl($task_list->getViewUrl());
      }
    } // delete_task
    
    /**
    * Complete single project task
    *
    * @access public
    * @param void
    * @return null
    */
    function complete_task() {
      $task = ProjectTasks::findById(get_id());
      if (!($task instanceof ProjectTask)) {
        flash_error(lang('task dnx'));
        $this->redirectTo('task');
      } // if
      
      $task_list = $task->getTaskList();
      if (!($task_list instanceof ProjectTaskList)) {
        flash_error(lang('task list dnx'));
        $this->redirectTo('task');
      } // if
      
      if (!$task->canChangeStatus(logged_user())) {
        flash_error(lang('no access permissions'));
        $this->redirectTo('task');
      } // if
      
      $redirect_to = array_var($_GET, 'redirect_to');
      if (!is_valid_url($redirect_to)) {
        $redirect_to = get_referer($task_list->getViewUrl());
      } // if
      
      try {
        DB::beginWork();
        $task->completeTask();
        ApplicationLogs::createLog($task, active_project(), ApplicationLogs::ACTION_CLOSE);
        DB::commit();
        
        flash_success(lang('success complete task'));
      } catch(Exception $e) {
        flash_error(lang('error complete task'));
        DB::rollback();
      } // try
      
      $this->redirectToUrl($redirect_to);
    } // complete_task
    
    /**
    * Reopen completed project task
    *
    * @access public
    * @param void
    * @return null
    */
    function open_task() {
      $task = ProjectTasks::findById(get_id());
      if (!($task instanceof ProjectTask)) {
        flash_error(lang('task dnx'));
        $this->redirectTo('task');
      } // if
      
      $task_list = $task->getTaskList();
      if (!($task_list instanceof ProjectTaskList)) {
        flash_error(lang('task list dnx'));
        $this->redirectTo('task');
      } // if
      
      if (!$task->canChangeStatus(logged_user())) {
        flash_error(lang('no access permissions'));
        $this->redirectTo('task');
      } // if
      
      $redirect_to = array_var($_GET, 'redirect_to');
      if ((trim($redirect_to) == '') || !is_valid_url($redirect_to)) {
        $redirect_to = get_referer($task_list->getViewUrl());
      } // if
      
      try {
        DB::beginWork();
        $task->openTask();
        ApplicationLogs::createLog($task, active_project(), ApplicationLogs::ACTION_OPEN);
        DB::commit();
        
        flash_success(lang('success open task'));
      } catch(Exception $e) {
        flash_error(lang('error open task'));
        DB::rollback();
      } // try
      
      $this->redirectToUrl($redirect_to);
    } // open_task
  
  } // TaskController

?>
