<?php

  /**
  * Controller for handling task list and task related requests
  *
  * @version 1.0
  * @http://www.projectpier.org/
  */
  class TaskController extends ApplicationController {
  
    /**
    * Construct the TaskController
    *
    * @access public
    * @param void
    * @return TaskController
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
      $this->addHelper('textile');

      tpl_assign('open_task_lists', active_project()->getOpenTaskLists());
      tpl_assign('completed_task_lists', active_project()->getCompletedTaskLists());

      $this->canGoOn();

      $this->setSidebar(get_template_path('index_sidebar', 'task'));
    } // index

    /**
    * Download task list as attachment
    *
    * @access public
    * @param void
    * @return null
    */
    function download_list() {
      $task_list = ProjectTaskLists::findById(get_id());
      if (!($task_list instanceof ProjectTaskList)) {
        flash_error(lang('task list dnx'));
        $this->redirectTo('task');
      } // if
      $this->canGoOn();
      if (!$task_list->canView(logged_user())) {
        flash_error(lang('no access permissions'));
        $this->redirectToReferer(get_url('task'));
      } // if
      
      $output = array_var($_GET, 'output', 'csv');
      $project_name = active_project()->getName();
      $task_list_name = $task_list->getName();
      $task_count = 0;
      if ($output == 'pdf' ) {
        Env::useLibrary('fpdf');
        $download_name = "{$project_name}-{$task_list_name}-tasks.pdf";
        $download_type = 'application/pdf';
        $pdf = new FPDF();
        $pdf->AddPage();
        $pdf->SetTitle($task_list_name);
        $pdf->SetFont('Arial','B',16);
        $task_lists = active_project()->getOpenTaskLists();
        $pdf->Cell(0,10, lang('project') . ': ' . active_project()->getObjectName(), 'C');
        $pdf->Ln();
        foreach($task_lists as $task_list) {
          $pdf->SetFont('Arial','B',14);
          $pdf->Write(10, lang('task list') . ': ' . $task_list->getObjectName());
          $pdf->Ln();
          $tasks = $task_list->getTasks();
          $line = 0;
          // Column widths
          $w = array(10, 0, 0);
          // Header
          //for($i=0;$i<count($header);$i++)
          //  $this->Cell($w[$i],7,$header[$i],1,0,'C');
          //$this->Ln();
          $pdf->SetFont('Arial','I',14);
          foreach($tasks as $task) {
            $line++;
            if ($task->isCompleted()) {
              $task_status = lang('completed');
              $task_completion_info = format_date($task->getCompletedOn());
            } else {
              $task_status = lang('open');
              $task_completion_info = '                ';
              if ($task->getDueDate()) {
                $task_completion_info = format_date($task->getDueDate());
              }
            }
            if ($task->getAssignedTo()) {
              $task_assignee = $task->getAssignedTo()->getObjectName();
            } else {
              $task_assignee = lang('not assigned');
            }
            $pdf->Cell($w[0],6,$line);
            $pdf->Cell($w[1],6,$task_status . " / " . $task_completion_info . " / " . $task_assignee , "TLRB");
            $pdf->Ln();
            $pdf->Cell($w[0],6,'');
            $pdf->MultiCell($w[2],6,$task->getText());
            $pdf->Ln();
          }
        }
        $pdf->Output($download_name, 'D');
      } else {
        $download_name = "{$project_name}-{$task_list_name}-tasks.txt";
        $download_type = 'text/csv';
        $download_contents = $task_list->getDownloadText($task_count, "\t", true);
        download_contents($download_contents, $download_type, $download_name, strlen($download_contents));
      }
      die();
    }
    
    /**
    * View task lists page
    *
    * @access public
    * @param void
    * @return null
    */
    function view_list() {
      $this->addHelper('textile');
      $task_list = ProjectTaskLists::findById(get_id());
      if (!($task_list instanceof ProjectTaskList)) {
        flash_error(lang('task list dnx'));
        $this->redirectTo('task');
      } // if
      $this->canGoOn();
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
      $task_list->setProjectId(active_project()->getId());

      $task_list_data = array_var($_POST, 'task_list');
      if (!is_array($task_list_data)) {
        $task_list_data = array(
          'milestone_id' => array_var($_GET, 'milestone_id'),
          'start_date' => DateTimeValueLib::now(),
          'is_private' => config_option('default_private', false),
          'task0' => array( 'start_date' => DateTimeValueLib::now() ),
          'task1' => array( 'start_date' => DateTimeValueLib::now() ),
          'task2' => array( 'start_date' => DateTimeValueLib::now() ),
          'task3' => array( 'start_date' => DateTimeValueLib::now() ),
          'task4' => array( 'start_date' => DateTimeValueLib::now() ),
          'task5' => array( 'start_date' => DateTimeValueLib::now() ),
        ); // array
      } else {
        for ($i = 0; $i < 6; $i++) {
          $due_date = $_POST["task_list_task{$i}_due_date"];
          $task_list_data["task{$i}"]['due_date'] = $due_date;
          $start_date = $_POST["task_list_task{$i}_start_date"];
          $task_list_data["task{$i}"]['start_date'] = $start_date;
        }   
      } // if
      
      tpl_assign('task_list_data', $task_list_data);
      tpl_assign('task_list', $task_list);
      
      if (is_array(array_var($_POST, 'task_list'))) {
        if (isset($_POST['task_list_start_date'])) {
          $task_list_data['start_date'] = DateTimeValueLib::makeFromString($_POST['task_list_start_date']);
        }
        if (isset($_POST['task_list_due_date'])) {
          $task_list_data['due_date'] = DateTimeValueLib::makeFromString($_POST['task_list_due_date']);
        }
        //$task_list_data['due_date'] = DateTimeValueLib::make(0, 0, 0, array_var($_POST, 'task_list_due_date_month', 1), array_var($_POST, 'task_list_due_date_day', 1), array_var($_POST, 'task_list_due_date_year', 1970));
        $task_list->setFromAttributes($task_list_data);
        if (!logged_user()->isMemberOfOwnerCompany()) {
          $task_list->setIsPrivate(false);
        }
        
        $tasks = array();
        for ($i = 0; $i < 6; $i++) {
          if (isset($task_list_data["task{$i}"]) && is_array($task_list_data["task{$i}"]) && (trim(array_var($task_list_data["task{$i}"], 'text')) <> '')) {
            $assigned_to = explode(':', array_var($task_list_data["task{$i}"], 'assigned_to', ''));
            if (isset($_POST["task_list_task{$i}_start_date"])) {
              $start_date = DateTimeValueLib::makeFromString($_POST["task_list_task{$i}_start_date"]);
            }
            if (isset($_POST["task_list_task{$i}_due_date"])) {
              $due_date = DateTimeValueLib::makeFromString($_POST["task_list_task{$i}_due_date"]);
            }
            $tasks[] = array(
              'text' => array_var($task_list_data["task{$i}"], 'text'),
              'order' => 1 + $i ,
              'start_date' => $start_date,
              'due_date' => $due_date,
              'assigned_to_company_id' => array_var($assigned_to, 0, 0),
              'assigned_to_user_id' => array_var($assigned_to, 1, 0),
              'send_notification' => array_var($task_list_data["task{$i}"], 'send_notification')
            ); // array
          } // if
        } // for
        
        try {
          
          DB::beginWork();
          $task_list->save();
          if (plugin_active('tags')) {
            $task_list->setTagsFromCSV(array_var($task_list_data, 'tags'));
          }
          
          foreach ($tasks as $task_data) {
            $task = new ProjectTask();
            $task->setFromAttributes($task_data);
            $task_list->attachTask($task);
            $task->save();

            tpl_assign('task', $task);
            // notify user
            if (array_var($task_data, 'send_notification') == 'checked') {
              try {
                if (Notifier::notifyNeeded($task->getAssignedTo(), null)) {
                  Notifier::taskAssigned($task);
                }
              } catch(Exception $e) {
                Logger::log("Error: Notification failed, " . $e->getMessage(), Logger::ERROR);
              } // try
            } // if
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
        $tag_names = plugin_active('tags') ? $task_list->getTagNames() : '';
        $task_list_data = array(
          'name' => $task_list->getName(),
          'priority' => $task_list->getPriority(),
          'score' => $task_list->getScore(),
          'description' => $task_list->getDescription(),
          'start_date' => $task_list->getStartDate(),
          'due_date' => $task_list->getDueDate(),
          'milestone_id' => $task_list->getMilestoneId(),
          'tags' => is_array($tag_names) && count($tag_names) ? implode(', ', $tag_names) : '',
          'is_private' => $task_list->isPrivate()
        ); // array
      } // if
      tpl_assign('task_list', $task_list);
      tpl_assign('task_list_data', $task_list_data);
      
      if (is_array(array_var($_POST, 'task_list'))) {
        $old_is_private = $task_list->isPrivate();
       if (isset($_POST['task_list_start_date'])) {
          $task_list_data['start_date'] = DateTimeValueLib::makeFromString($_POST['task_list_start_date']);
        }
       if (isset($_POST['task_list_due_date'])) {
          $task_list_data['due_date'] = DateTimeValueLib::makeFromString($_POST['task_list_due_date']);
        }
        //$task_list_data['due_date'] = DateTimeValueLib::make(0, 0, 0, array_var($_POST, 'task_list_due_date_month', 1), array_var($_POST, 'task_list_due_date_day', 1), array_var($_POST, 'task_list_due_date_year', 1970));
        $task_list->setFromAttributes($task_list_data);
        if (!logged_user()->isMemberOfOwnerCompany()) {
          $task_list->setIsPrivate($old_is_private);
        }
        
        try {
          DB::beginWork();
          
          $task_list->save();
          if (plugin_active('tags')) {
            $task_list->setTagsFromCSV(array_var($task_list_data, 'tags'));
          }
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
    * Copy task list then redirect to edit
    *
    * @access public
    * @param void
    * @return null
    */
    function copy_list() {
      
      $task_list = ProjectTaskLists::findById(get_id());
      if (!($task_list instanceof ProjectTaskList)) {
        flash_error(lang('task list dnx'));
        $this->redirectTo('task', 'index');
      } // if
      
      if (!$task_list->canAdd(logged_user(), active_project())) {
        flash_error(lang('no access permissions'));
        $this->redirectTo('task', 'index');
      } // if

      try {
        DB::beginWork();

        $source_task_list = $task_list;
        $task_list = new ProjectTaskList();
        $task_list->setName($source_task_list->getName().' ('.lang('copy').')');
        $task_list->setPriority($source_task_list->getPriority());
        $task_list->setDescription($source_task_list->getDescription());
        $task_list->setMilestoneId($source_task_list->getMilestoneId());
        $task_list->setDueDate($source_task_list->getDueDate());
        $task_list->setIsPrivate($source_task_list->getIsPrivate());
        $task_list->setOrder($source_task_list->getOrder());
        $task_list->setProjectId($source_task_list->getProjectId());
        $task_list->save();
        $task_count = 0;
        $source_tasks = $source_task_list->getTasks();
        if (is_array($source_tasks)) {
          foreach($source_tasks as $source_task) {
            $task = new ProjectTask();
            $task->setText($source_task->getText());
            $task->setAssignedToUserId($source_task->getAssignedToUserId());
            $task->setAssignedToCompanyId($source_task->getAssignedToCompanyId());
            $task->setOrder($source_task->getOrder());
            $task->setDueDate($source_task->getDueDate());
            $task_list->attachTask($task);
            $task_count++;
          }
        }

        ApplicationLogs::createLog($task_list, active_project(), ApplicationLogs::ACTION_ADD);
        DB::commit();
          
        flash_success(lang('success copy task list', $source_task_list->getName(), $task_list->getName(), $task_count));
        //$this->redirectToUrl($task_list->getEditUrl());
        $this->redirectTo('task', 'index');
          
      } catch(Exception $e) {
        DB::rollback();
        tpl_assign('error', $e);
      } // try
    } // copy_list

    /**
    * Move task list
    *
    * @access public
    * @param void
    * @return null
    */
    function move_list() {
      $this->setTemplate('move_list');
      
      $task_list = ProjectTaskLists::findById(get_id());
      if (!($task_list instanceof ProjectTaskList)) {
        flash_error(lang('task list dnx'));
        $this->redirectTo('task', 'index');
      } // if
      
      if (!$task_list->canDelete(logged_user(), active_project())) {
        flash_error(lang('no access permissions'));
        $this->redirectTo('task', 'index');
      } // if
      
      $move_data = array_var($_POST, 'move_data');
      tpl_assign('task_list', $task_list);
      tpl_assign('move_data', $move_data);

      if (is_array($move_data)) {
        $target_project_id = $move_data['target_project_id'];
        $target_project = Projects::findById($target_project_id);
        if (!($target_project instanceof Project)) {
          flash_error(lang('project dnx'));
          $this->redirectToUrl($task_list->getMoveUrl());
        } // if
        if (!$task_list->canAdd(logged_user(), $target_project)) {
          flash_error(lang('no access permissions'));
          $this->redirectToUrl($task_list->getMoveUrl());
        } // if
        try {
          DB::beginWork();
          $task_list->setProjectId($target_project_id);
          $task_list->save();
          ApplicationLogs::createLog($task_list, active_project(), ApplicationLogs::ACTION_DELETE);
          ApplicationLogs::createLog($task_list, $target_project, ApplicationLogs::ACTION_ADD);
          DB::commit();

          flash_success(lang('success move task list', $task_list->getName(), active_project()->getName(), $target_project->getName() ));
        } catch(Exception $e) {
          DB::rollback();
          flash_error(lang('error move task list'));
        } // try

        $this->redirectToUrl($task_list->getViewUrl());
      }
    } // move_list
    
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
      if (!is_array($task_data)) {
        $task_data = array(
          'due_date' => DateTimeValueLib::now(),
        ); // array
      } // if
     
      tpl_assign('task', $task);
      tpl_assign('task_list', $task_list);
      tpl_assign('back_to_list', $back_to_list);
      tpl_assign('task_data', $task_data);
      
      // Form is submitted
      if (is_array(array_var($_POST, 'task'))) {
        $old_owner = $task->getAssignedTo();
        //$task_data['due_date'] = DateTimeValueLib::make(0, 0, 0, array_var($_POST, 'task_due_date_month', 1), array_var($_POST, 'task_due_date_day', 1), array_var($_POST, 'task_due_date_year', 1970));
        if (isset($_POST['task_start_date'])) {
          $task_data['start_date'] = DateTimeValueLib::makeFromString($_POST['task_start_date']);
        } else {
          $task_data['start_date'] = DateTimeValueLib::make(0, 0, 0, array_var($_POST, 'task_start_date_month', 1), array_var($_POST, 'task_start_date_day', 1), array_var($_POST, 'task_start_date_year', 1970));
        }
        if (isset($_POST['task_due_date'])) {
          $task_data['due_date'] = DateTimeValueLib::makeFromString($_POST['task_due_date']);
        } else {
          $task_data['due_date'] = DateTimeValueLib::make(0, 0, 0, array_var($_POST, 'task_due_date_month', 1), array_var($_POST, 'task_due_date_day', 1), array_var($_POST, 'task_due_date_year', 1970));
        }
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

          // notify user
          if (array_var($task_data, 'send_notification') == 'checked') {
            try {
              if (Notifier::notifyNeeded($task->getAssignedTo(), $old_owner)) {
                Notifier::taskAssigned($task);
              }
            } catch(Exception $e) {
              Logger::log("Error: Notification failed, " . $e->getMessage(), Logger::ERROR);
            } // try
          } // if
          
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
          'start_date' => $task->getStartDate(),
          'due_date' => $task->getDueDate(),
          'task_list_id' => $task->getTaskListId(),
          'assigned_to' => $task->getAssignedToCompanyId() . ':' . $task->getAssignedToUserId(),
          'send_notification' => config_option('send_notification_default', '0')
        ); // array
      } // if
      
      tpl_assign('task', $task);
      tpl_assign('task_list', $task_list);
      tpl_assign('task_data', $task_data);
      
      if (is_array(array_var($_POST, 'task'))) {
        $old_owner = $task->getAssignedTo();
        //$task_data['due_date'] = DateTimeValueLib::make(0, 0, 0, array_var($_POST, 'task_due_date_month', 1), array_var($_POST, 'task_due_date_day', 1), array_var($_POST, 'task_due_date_year', 1970));
        if (isset($_POST['task_start_date'])) {
          $task_data['start_date'] = DateTimeValueLib::makeFromString($_POST['task_start_date']);
        } else {
          $task_data['start_date'] = DateTimeValueLib::make(0, 0, 0, array_var($_POST, 'task_start_date_month', 1), array_var($_POST, 'task_start_date_day', 1), array_var($_POST, 'task_start_date_year', 1970));
        }
        if (isset($_POST['task_due_date'])) {
          $task_data['due_date'] = DateTimeValueLib::makeFromString($_POST['task_due_date']);
        } else {
          $task_data['due_date'] = DateTimeValueLib::make(0, 0, 0, array_var($_POST, 'task_due_date_month', 1), array_var($_POST, 'task_due_date_day', 1), array_var($_POST, 'task_due_date_year', 1970));
        }
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
          trace(__FILE__,'edit_task: notify user');
          // notify user
          if (array_var($task_data, 'send_notification') == 'checked') {
            try {
              if (Notifier::notifyNeeded($task->getAssignedTo(), $old_owner)) {
                Notifier::taskAssigned($task);
              }
            } catch(Exception $e) {
              Logger::log("Error: Notification failed, " . $e->getMessage(), Logger::ERROR);
            } // try
          } // if
          
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
    * http://haris.tv htv edit
    * View task details page
    *
    * @access public
    * @param void
    * @return null
    */
    function view_task() {
      $this->setTemplate('view_task');
      $this->addHelper('textile');
              
      // taken from edit_task - htv
      $task = ProjectTasks::findById(get_id());
      if(!($task instanceof ProjectTask)) {
        flash_error(lang('task dnx'));
        $this->redirectTo('task');
      } // if
          
      $task_list = $task->getTaskList();
      if(!($task_list instanceof ProjectTaskList)) {
        flash_error('task list dnx');
        $this->redirectTo('task');
      } // if
          
      if(!$task->canView(logged_user())) {
        flash_error(lang('no access permissions'));
        $this->redirectTo('task');
      } // if
          
      $task_data = array_var($_POST, 'task');
      if(!is_array($task_data)) {
        $task_data = array(
          'text' => $task->getText(),
          'due_date' => $task->getDueDate(),
          'task_list_id' => $task->getTaskListId(),
          'assigned_to' => $task->getAssignedToCompanyId() . ':' . $task->getAssignedToUserId()
        ); // array
      } // if
          
      tpl_assign('task', $task);
      tpl_assign('task_list', $task_list);
      tpl_assign('task_data', $task_data);
  
    } // task_details
    
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

    /**
    * Reopen completed project task
    *
    * @access public
    * @param void
    * @return null
    */
    function edit_score() {
      $task = ProjectTasks::findById(get_id());
      if (!($task instanceof ProjectTask)) {
        flash_error(lang('task dnx'));
        //$this->redirectTo('task');
      } // if
      
      include '../views/editscore.html';
      
    } // open_task

  
  } // TaskController

?>