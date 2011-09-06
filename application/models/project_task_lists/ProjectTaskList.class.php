<?php

  /**
  * ProjectTaskList class
  * Generated on Wed, 08 Mar 2006 15:51:26 +0100 by DataObject generation tool
  *
  * @http://www.projectpier.org/
  */
  class ProjectTaskList extends BaseProjectTaskList {
    
    /**
    * This project object is taggable
    *
    * @var boolean
    */
    protected $is_taggable = true;
    
    /**
    * Message comments are searchable
    *
    * @var boolean
    */
    protected $is_searchable = true;
    
    /**
    * Array of searchable columns
    *
    * @var array
    */
    protected $searchable_columns = array('name', 'description');
    
    /**
    * Cached task array
    *
    * @var array
    */
    private $all_tasks;
    
    /**
    * Cached open task array
    *
    * @var array
    */
    private $open_tasks;
    
    /**
    * Cached completed task array
    *
    * @var array
    */
    private $completed_tasks;
    
    /**
    * Cached number of open tasks
    *
    * @var integer
    */
    private $count_all_tasks;
    
    /**
    * Cached number of open tasks in this list
    *
    * @var integer
    */
    private $count_open_tasks = null;
    
    /**
    * Cached number of completed tasks in this list
    *
    * @var integer
    */
    private $count_completed_tasks = null;
    
    /**
    * Cached array of related forms
    *
    * @var array
    */
    private $related_forms;
    
    /**
    * Cached completed by reference
    *
    * @var User
    */
    private $completed_by;
  
    // ---------------------------------------------------
    //  Operations
    // ---------------------------------------------------
    
    /**
    * Add task to this list
    *
    * @param string $text
    * @param User $assigned_to_user
    * @param Company $assigned_to_company
    * @return ProjectTask
    * @throws DAOValidationError
    */
    function addTask($text, $assigned_to_user = null, $assigned_to_company = null) {
      $task = new ProjectTask();
      $task->setText($text);
      
      if ($assigned_to_user instanceof User) {
        $task->setAssignedToUserId($assigned_to_user->getId());
        $task->setAssignedToCompanyId($assigned_to_user->getCompanyId());
      } elseif ($assigned_to_company instanceof Company) {
        $task->setAssignedToCompanyId($assigned_to_company->getId());
      } // if
      
      $this->attachTask($task); // this one will save task
      return $task;
    } // addTask
    
    /**
    * Attach task to this lists
    *
    * @param ProjectTask $task
    * @return null
    */
    function attachTask(ProjectTask $task) {
      if ($task->getTaskListId() == $this->getId()) {
        return;
      }
      
      $task->setTaskListId($this->getId());
      $task->save();
        
      if ($this->isCompleted()) {
        $this->open();
      }
    } // attachTask
    
    /**
    * Detach task from this list
    *
    * @param ProjectTask $task
    * @param ProjectTaskList $attach_to If you wish you can detach and attach task to
    *   other list with one save query
    * @return null
    */
    function detachTask(ProjectTask $task, $attach_to = null) {
      if ($task->getTaskListId() <> $this->getId()) {
        return;
      }
      
      if ($attach_to instanceof ProjectTaskList) {
        $attach_to->attachTask($task);
      } else {
        $task->setTaskListId(0);
        $task->save();
      } // if
      
      $close = true;
      $open_tasks = $this->getOpenTasks();
      if (is_array($open_tasks)) {
        foreach ($open_tasks as $open_task) {
          if ($open_task->getId() <> $task->getId()) {
            $close = false;
          }
        } // if
      } // if
      
      if ($close) {
        $this->complete(DateTimeValueLib::now(), logged_user());
      }
    } // detachTask
    
    /**
    * Complete this task lists
    *
    * @access public
    * @param DateTimeValue $on Completed on
    * @param User $by Completed by
    * @return null
    */
    function complete(DateTimeValue $on, User $by) {
      $this->setCompletedOn($on);
      $this->setCompletedById($by->getId());
      $this->save();
      ApplicationLogs::createLog($this, $this->getProject(), ApplicationLogs::ACTION_CLOSE);
    } // complete
    
    /**
    * Open this list
    *
    * @access public
    * @param void
    * @return null
    */
    function open() {
      $this->setCompletedOn(NULL);
      $this->setCompletedById(0);
      $this->save();
      ApplicationLogs::createLog($this, $this->getProject(), ApplicationLogs::ACTION_OPEN);
    } // open
    
    // ---------------------------------------------------
    //  Related object
    // ---------------------------------------------------
    
    /**
    * Return all tasks from this list
    *
    * @access public
    * @param void
    * @return array
    */
    function getTasks() {
      if (is_null($this->all_tasks)) {
        $this->all_tasks = ProjectTasks::findAll(array(
          'conditions' => '`task_list_id` = ' . DB::escape($this->getId()),
          'order' => '`order`, `created_on`'
        )); // findAll
      } // if
      
      return $this->all_tasks;
    } // getTasks
    
    /**
    * Return open tasks
    *
    * @access public
    * @param void
    * @return array
    */
    function getOpenTasks() {
      if (is_null($this->open_tasks)) {
        $this->open_tasks = ProjectTasks::findAll(array(
          'conditions' => '`task_list_id` = ' . DB::escape($this->getId()) . ' AND `completed_on` = ' . DB::escape(EMPTY_DATETIME),
          'order' => '`order`, `created_on`'
        )); // findAll
      } // if
      
      return $this->open_tasks;
    } // getOpenTasks
    
    /**
    * Return completed tasks
    *
    * @access public
    * @param void
    * @return array
    */
    function getCompletedTasks() {
      if (is_null($this->completed_tasks)) {
        $this->completed_tasks = ProjectTasks::findAll(array(
          'conditions' => '`task_list_id` = ' . DB::escape($this->getId()) . ' AND `completed_on` > ' . DB::escape(EMPTY_DATETIME),
          'order' => '`completed_on` DESC'
        )); // findAll
      } // if
      
      return $this->completed_tasks;
    } // getCompletedTasks
    
    /**
    * Return number of all tasks in this list
    *
    * @access public
    * @param void
    * @return integer
    */
    function countAllTasks() {
      if (is_null($this->count_all_tasks)) {
        if (is_array($this->all_tasks)) {
          $this->count_all_tasks = count($this->all_tasks);
        } else {
          $this->count_all_tasks = ProjectTasks::count('`task_list_id` = ' . DB::escape($this->getId()));
        } // if
      } // if
      return $this->count_all_tasks;
    } // countAllTasks
    
    /**
    * Return number of open tasks
    *
    * @access public
    * @param void
    * @return integer
    */
    function countOpenTasks() {
      if (is_null($this->count_open_tasks)) {
        if (is_array($this->open_tasks)) {
          $this->count_open_tasks = count($this->open_tasks);
        } else {
          $this->count_open_tasks = ProjectTasks::count('`task_list_id` = ' . DB::escape($this->getId()) . ' AND `completed_on` = ' . DB::escape(EMPTY_DATETIME));
        } // if
      } // if
      return $this->count_open_tasks;
    } // countOpenTasks
    
    /**
    * Return number of completed tasks
    *
    * @access public
    * @param void
    * @return integer
    */
    function countCompletedTasks() {
      if (is_null($this->count_completed_tasks)) {
        if (is_array($this->completed_tasks)) {
          $this->count_completed_tasks = count($this->completed_tasks);
        } else {
          $this->count_completed_tasks = ProjectTasks::count('`task_list_id` = ' . DB::escape($this->getId()) . ' AND `completed_on` > ' . DB::escape(EMPTY_DATETIME));
        } // if
      } // if
      return $this->count_completed_tasks;
    } // countCompletedTasks
    
    /**
    * Return owner project obj
    *
    * @access public
    * @param void
    * @return Project
    */
    function getProject() {
      return Projects::findById($this->getProjectId());
    } // getProject
    
    /**
    * Get project forms that are in relation with this task list
    *
    * @param void
    * @return array
    */
    function getRelatedForms() {
      if (is_null($this->related_forms)) {
        $this->related_forms = ProjectForms::findAll(array(
          'conditions' => '`action` = ' . DB::escape(ProjectForm::ADD_TASK_ACTION) . ' AND `in_object_id` = ' . DB::escape($this->getId()),
          'order' => '`order`'
        )); // findAll
      } // if
      return $this->related_forms;
    } // getRelatedForms
    
    /**
    * Return user who completed this task
    *
    * @access public
    * @param void
    * @return User
    */
    function getCompletedBy() {
      if (!($this->completed_by instanceof User)) {
        $this->completed_by = Users::findById($this->getCompletedById());
      } // if
      return $this->completed_by;
    } // getCompletedBy
    
    /**
    * Check if this list is completed
    *
    * @access public
    * @param void
    * @return boolean
    */
    function isCompleted() {
      return (boolean) $this->getCompletedOn();
    } // isCompleted
    
    /**
    * Returns true if this list is open
    *
    * @access public
    * @param void
    * @return boolean
    */
    function isOpen() {
      return !$this->isCompleted();
    } // isOpen
    
    // ---------------------------------------------------
    //  Permissions
    // ---------------------------------------------------
    
    /**
    * Check if user have task management permissions for project this list belongs to
    *
    * @param User $user
    * @return boolean
    */
    function canManage(User $user) {
      return $user->getProjectPermission($this->getProject(), ProjectUsers::CAN_MANAGE_TASKS);
    } // canManage
    
    /**
    * Return true if $user can view this task lists
    *
    * @param User $user
    * @return boolean
    */
    function canView(User $user) {
      if (!$user->isProjectUser($this->getProject())) {
        return false; // user have access to project
      } // if
      if ($this->isPrivate() && !$user->isMemberOfOwnerCompany()) {
        return false; // user that is not member of owner company can't access private objects
      } // if
      return true;
    } // canView
    
    /**
    * Check if user can add task lists in specific project
    *
    * @param User $user
    * @param Project $project
    * @return boolean
    */
    function canAdd(User $user, Project $project) {
      if ($user->isAccountOwner()) {
        return true;
      } // if
      return $user->getProjectPermission($project, ProjectUsers::CAN_MANAGE_TASKS);
    } // canAdd
    
    /**
    * Check if specific user can update this list
    *
    * @param User $user
    * @return boolean
    */
    function canEdit(User $user) {
      if (!$user->isProjectUser($this->getProject())) {
        return false; // user is on project
      } // if
      if ($user->isAdministrator()) {
        return true; // user is administrator or root
      } // if
      if ($this->isPrivate() && !$user->isMemberOfOwnerCompany()) {
        return false; // user that is not member of owner company can't edit private objects
      } // if
      if ($user->getId() == $this->getCreatedById()) {
        return true; // user is list author
      } // if
      return false; // no no
    } // canEdit
    
    /**
    * Check if specific user can delete this list
    *
    * @param User $user
    * @return boolean
    */
    function canDelete(User $user) {
      if (!$user->isProjectUser($this->getProject())) {
        return false; // user is on project
      } // if
      if ($user->isAdministrator()) {
        return true; // user is administrator or root
      } // if
      return false; // no no
    } // canDelete
    
    /**
    * Check if specific user can add task to this list
    *
    * @param User $user
    * @return boolean
    */
    function canAddTask(User $user) {
      if (!$user->isProjectUser($this->getProject())) {
        return false; // user is on project
      } // if
      if ($user->isAdministrator()) {
        return true; // user is administrator or root
      } // if
      if ($this->isPrivate() && !$user->isMemberOfOwnerCompany()) {
        return false; // user that is not member of owner company can't add task lists
      } // if
      return $this->canManage($user, $this->getProject());
    } // canAddTask
    
    /**
    * Check if user can reorder tasks in this list
    *
    * @param User $user
    * @return boolean
    */
    function canReorderTasks(User $user) {
      if (!$user->isProjectUser($this->getProject())) {
        return false; // user is on project
      } // if
      if ($user->isAdministrator()) {
        return true; // user is administrator or root
      } // if
      if ($this->isPrivate() && !$user->isMemberOfOwnerCompany()) {
        return false; // user that is not member of owner company can't add task lists
      } // if
      return $this->canManage($user, $this->getProject());
    } // canReorderTasks
    
    // ---------------------------------------------------
    //  URLs
    // ---------------------------------------------------
    
    /**
    * Return view list URL
    *
    * @param void
    * @return string
    */
    function getViewUrl() {
      return get_url('task', 'view_list', array('id' => $this->getId(), 'active_project' => $this->getProjectId()));
    } // getViewUrl
    
    /**
    * This function will return URL of this specific list on project tasks page
    *
    * @param void
    * @return string
    */
    function getOverviewUrl() {
      $project = $this->getProject();
      if ($project instanceof Project) {
        return $project->getTasksUrl() . '#taskList' . $this->getId();
      } // if
      return '';
    } // getOverviewUrl
    
    /**
    * Edit this task list
    *
    * @param void
    * @return string
    */
    function getEditUrl() {
      return get_url('task', 'edit_list', array('id' => $this->getId(), 'active_project' => $this->getProjectId()));
    } // getEditUrl
    
    /**
    * Delete this task list
    *
    * @param void
    * @return string
    */
    function getDeleteUrl() {
      return get_url('task', 'delete_list', array('id' => $this->getId(), 'active_project' => $this->getProjectId()));
    } // getDeleteUrl
    
    /**
    * Return add task url
    *
    * @param boolean $redirect_to_list Redirect back to the list when task is added. If false
    *   after submission user will be redirected to projects tasks page
    * @return string
    */
    function getAddTaskUrl($redirect_to_list = true) {
      $attributes = array('task_list_id' => $this->getId(), 'active_project' => $this->getProjectId());
      if ($redirect_to_list) {
        $attributes['back_to_list'] = true;
      } // if
      return get_url('task', 'add_task', $attributes);
    } // getAddTaskUrl
    
    /**
    * Return reorder tasks URL
    *
    * @param boolean $redirect_to_list
    * @return string
    */
    function getReorderTasksUrl($redirect_to_list = true) {
      $attributes = array('task_list_id' => $this->getId(), 'active_project' => $this->getProjectId());
      if ($redirect_to_list) {
        $attributes['back_to_list'] = true;
      } // if
      return get_url('task', 'reorder_tasks', $attributes);
    } // getReorderTasksUrl
    
    // ---------------------------------------------------
    //  System
    // ---------------------------------------------------
    
    /**
    * Validate before save
    *
    * @access public
    * @param array $errors
    * @return null
    */
    function validate(&$errors) {
      if (!$this->validatePresenceOf('name')) {
        $errors[] = lang('task list name required');
      } // if
    } // validate
    
    /**
    * Delete this task lists
    *
    * @access public
    * @param void
    * @return boolean
    */
    function delete() {
      $this->deleteTasks();
      
      $related_forms = $this->getRelatedForms();
      if (is_array($related_forms)) {
        foreach ($related_forms as $related_form) {
          $related_form->setInObjectId(0);
          $related_form->save();
        } // foreach
      } // if
      
      return parent::delete();
    } // delete
    
    /**
    * Save this list
    *
    * @param void
    * @return boolean
    */
    function save() {
      parent::save();
      
      $tasks = $this->getTasks();
      if (is_array($tasks)) {
        $task_ids = array();
        foreach ($tasks as $task) {
          $task_ids[] = $task->getId();
        } // if
        
        if (count($task_ids)) {
          ApplicationLogs::setIsPrivateForType($this->isPrivate(), 'ProjectTasks', $task_ids);
        } // if
      } // if
      
      return true;
    } // save
    
    /**
    * Drop all tasks that are in this list
    *
    * @access public
    * @param void
    * @return boolean
    */
    function deleteTasks() {
      return ProjectTasks::delete(DB::escapeField('task_list_id') . ' = ' . DB::escape($this->getId()));
    } // deleteTasks
    
    // ---------------------------------------------------
    //  ApplicationDataObject implementation
    // ---------------------------------------------------
    
    /**
    * Return object type name
    *
    * @param void
    * @return string
    */
    function getObjectTypeName() {
      return lang('task list');
    } // getObjectTypeName
    
    /**
    * Return object URl
    *
    * @access public
    * @param void
    * @return string
    */
    function getObjectUrl() {
      return $this->getViewUrl();
    } // getObjectUrl
    
  } // ProjectTaskList 

?>
