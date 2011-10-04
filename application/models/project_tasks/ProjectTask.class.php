<?php

  /**
  * ProjectTask class
  * Generated on Sat, 04 Mar 2006 12:50:11 +0100 by DataObject generation tool
  *
  * @http://www.projectpier.org/
  */
  class ProjectTask extends BaseProjectTask {
    
    /**
    * Task comments are searchable
    *
    * @var boolean
    */
    protected $is_searchable = true;
    
    /**
    * Project Tasks are commentable
    *
    * @var boolean
    */
    protected $is_commentable = true;
    
    /**
    * Array of searchable columns
    *
    * @var array
    */
    protected $searchable_columns = array('text');
    
    /**
    * Return parent task lists
    *
    * @access public
    * @param void
    * @return ProjectTaskList
    */
    function getTaskList() {
      return ProjectTaskLists::findById($this->getTaskListId());
    } // getTaskList
    
    /**
    * Return project that this task belongs to
    *
    * @param void
    * @return Project
    */
    function getProject() {
      $task_list = $this->getTaskList();
      return $task_list instanceof ProjectTaskList ? $task_list->getProject() : null;
    } // getProject
    
    /**
    * Return project ID if project exists
    *
    * @param void
    * @return integer
    */
    function getProjectId() {
      $project = $this->getProject();
      return $project instanceof Project ? $project->getId() : null;
    } // getProjectId
    
    /**
    * Return user object of person who completed this task
    *
    * @access public
    * @param void
    * @return User
    */
    function getCompletedBy() {
      return Users::findById($this->getCompletedById());
    } // getCompletedBy
    
    /**
    * Return owner user or company
    *
    * @access public
    * @param void
    * @return ApplicationDataObject
    */
    function getAssignedTo() {
      if ($this->getAssignedToUserId() > 0) {
        return $this->getAssignedToUser();
      } elseif ($this->getAssignedToCompanyId() > 0) {
        return $this->getAssignedToCompany();
      } else {
        return null;
      } // if
    } // getAssignedTo
    
    /**
    * Return owner company
    *
    * @access public
    * @param void
    * @return Company
    */
    function getAssignedToCompany() {
      return Companies::findById($this->getAssignedToCompanyId());
    } // getAssignedToCompany
    
    /**
    * Return owner user
    *
    * @access public
    * @param void
    * @return User
    */
    function getAssignedToUser() {
      return Users::findById($this->getAssignedToUserId());
    } // getAssignedToUser
    
    /**
    * Returns true if this task was not completed
    *
    * @access public
    * @param void
    * @return boolean
    */
    function isOpen() {
      return !$this->isCompleted();
    } // isOpen
    
    /**
    * Returns true if this task is completed
    *
    * @access public
    * @param void
    * @return boolean
    */
    function isCompleted() {
      return $this->getCompletedOn() instanceof DateTimeValue;
    } // isCompleted
    
    /**
    * Returns value of is private flag inherited from parent task list
    *
    * @param void
    * @return boolean
    */
    function isPrivate() {
      $parent_list = $this->getTaskList();
      return $parent_list instanceof ProjectTaskList ? $parent_list->isPrivate() : true;
    } // isPrivate

    /**
    * Returns value of is private flag 
    *
    * @param void
    * @return boolean
    */
    function getIsPrivate() {
      return $this->isPrivate();
    } // getIsPrivate
    
    // ---------------------------------------------------
    //  Permissions
    // ---------------------------------------------------
    
    /**
    * Empty implementation. Task list is responsible for this check
    *
    * @param User $user
    * @return boolean
    */
    function canView(User $user) {
      if (!$user->isProjectUser($this->getProject())) {
        return false; // user does not have access to project
      } // if
      if ($this->isPrivate() && !$user->isMemberOfOwnerCompany()) {
        return false; // user not member of owner company can't access private objects
      } // if
      return true;
    } // canView
    
    /**
    * Empty implementation. Owner list will check for add permissions
    *
    * @param User $user
    * @param Project $project
    * @return boolean
    */
    function canAdd(User $user, Project $project) {
      return false;
    } // canAdd
    
    /**
    * Check if specific user can update this task
    *
    * @access public
    * @param User $user
    * @return boolean
    */
    function canEdit(User $user) {
      if (!$user->isProjectUser($this->getProject())) {
        return false;
      } // if
      if ($user->isAdministrator()) {
        return true;
      } // if
      
      $assigned_to = $this->getAssignedTo();
      if ($assigned_to instanceof User) {
        if ($user->getId() == $assigned_to->getId()) {
          return true;
        } // if
      } elseif ($assigned_to instanceof Company) {
        if ($user->getCompanyId() == $assigned_to->getId()) {
          return true;
        } // if
      } else {
        return true;
      } // if
      
      // Client who created the task can edit it for the next 3 minutes
      if ($this->getCreatedById() == logged_user()->getId()) {
        $valid_time = DateTimeValueLib::now();
        $valid_time->advance(180);
        if ($this->getCreatedOn()->getTimestamp() < $valid_time->getTimestamp()) {
          return true;
        } // if
      } // if
      
      $task_list = $this->getTaskList();
      return $task_list instanceof ProjectTaskList ? $task_list->canEdit($user) : false;
    } // canEdit
    
    /**
    * Check if specific user can change task status
    *
    * @access public
    * @param User $user
    * @return boolean
    */
    function canChangeStatus(User $user) {
      if ($this->canEdit($user)) {
        return true; // can edit? cool...
      } // if
      
      // Additional check - is this task assigned to this user or its company
      if ($this->getAssignedTo() instanceof User) {
        if ($user->getId() == $this->getAssignedTo()->getObjectId()) {
          return true;
        }
      } elseif ($this->getAssignedTo() instanceof Company) {
        if ($user->getCompanyId() == $this->getAssignedTo()->getObjectId()) {
          return true;
        }
      } // if
      return false;
    } // canChangeStatus
    
    /**
    * Check if specific user can delete this task
    *
    * @access public
    * @param User $user
    * @return boolean
    */
    function canDelete(User $user) {
      if (!$user->isProjectUser($this->getProject())) {
        return false;
      } // if
      if ($user->isAdministrator()) {
        return true;
      } // if
      
      $task_list = $this->getTaskList();
      return $task_list instanceof ProjectTaskList ? $task_list->canDelete($user) : false;
    } // canDelete
    
    // ---------------------------------------------------
    //  Operations
    // ---------------------------------------------------
    
    /**
    * Complete this task and check if we need to complete the list
    *
    * @access public
    * @param void
    * @return null
    */
    function completeTask() {
      $this->setCompletedOn(DateTimeValueLib::now());
      $this->setCompletedById(logged_user()->getId());
      $this->save();
      
      $task_list = $this->getTaskList();
      if (($task_list instanceof ProjectTaskList) && $task_list->isOpen()) {
        $open_tasks = $task_list->getOpenTasks();
        if (empty($open_tasks)) {
          $task_list->complete(DateTimeValueLib::now(), logged_user());
        }
      } // if
    } // completeTask
    
    /**
    * Open this task and check if we need to reopen list again
    *
    * @access public
    * @param void
    * @return null
    */
    function openTask() {
      $this->setCompletedOn(null);
      $this->setCompletedById(0);
      $this->save();
      
      $task_list = $this->getTaskList();
      if (($task_list instanceof ProjectTaskList) && $task_list->isCompleted()) {
        $open_tasks = $task_list->getOpenTasks();
        if (!empty($open_tasks)) {
          $task_list->open();
        }
      } // if
    } // openTask
    
    // ---------------------------------------------------
    //  URLs
    // ---------------------------------------------------
    
    /**
    * Return edit task URL
    *
    * @access public
    * @param void
    * @return string
    */
    function getEditUrl() {
      return get_url('task', 'edit_task', array('id' => $this->getId(), 'active_project' => $this->getProjectId()));
    } // getEditUrl

    /**
    * Return details task URL
    * http://haris.tv htv edit
    * 
    * @access public
    * @param void
    * @return string
    */
    function getDetailsUrl() {
      return get_url('task', 'task_details', array('id' => $this->getId(), 'active_project' => $this->getProjectId()));
    } // getDetailsUrl

    /**
    * Return view task URL
    *
    * @access public
    * @param void
    * @return string
    */
    function getViewUrl() {
      return get_url('task', 'view_task', array('id' => $this->getId(), 'active_project' => $this->getProjectId()));
    } // getViewUrl

    /**
    * Return delete task URL
    *
    * @access public
    * @param void
    * @return string
    */
    function getDeleteUrl() {
      return get_url('task', 'delete_task', array('id' => $this->getId(), 'active_project' => $this->getProjectId()));
    } // getDeleteUrl
    
    /**
    * Return comete task URL
    *
    * @access public
    * @param string $redirect_to Redirect to this URL (referer will be used if this URL is not provided)
    * @return string
    */
    function getCompleteUrl($redirect_to = null) {
      $params = array(
        'id' => $this->getId(), 
        'active_project' => $this->getProjectId()
      ); // array
      
      if (trim($redirect_to)) {
        $params['redirect_to'] = $redirect_to;
      } // if
      
      return get_url('task', 'complete_task', $params);
    } // getCompleteUrl
    
    /**
    * Return open task URL
    *
    * @access public
    * @param string $redirect_to Redirect to this URL (referer will be used if this URL is not provided)
    * @return string
    */
    function getOpenUrl($redirect_to = null) {
      $params = array(
        'id' => $this->getId(), 
        'active_project' => $this->getProjectId()
      ); // array
      
      if (trim($redirect_to)) {
        $params['redirect_to'] = $redirect_to;
      } // if
      
      return get_url('task', 'open_task', $params);
    } // getOpenUrl
    
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
      if (!$this->validatePresenceOf('text')) {
        $errors[] = lang('task text required');
      }
    } // validate
    
    /**
    * Delete this task
    *
    * @access public
    * @param void
    * @return boolean
    */
    function delete() {
      $task_list = $this->getTaskList();
      if ($task_list instanceof ProjectTaskList) {
        $task_list->detachTask($this);
      }
      return parent::delete();
    } // delete
    
    // ---------------------------------------------------
    //  ApplicationDataObject implementation
    // ---------------------------------------------------
    
    /**
    * Return object name
    *
    * @access public
    * @param void
    * @return string
    */
    function getObjectName() {
      $name = $this->getText();
      $len = strlen_utf($name);
      $i = strpos($name, "\n");
      if ($i !== false ) {
        $name = substr_utf($name, 0, $i-1);
      }
      $return = substr_utf($name, 0, 50);
      return $len > 50 ? $return . '...' : $return;
    } // getObjectName
    
    /**
    * Return object type name
    *
    * @param void
    * @return string
    */
    function getObjectTypeName() {
      return lang('task');
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

      $list = $this->getTaskList();
      return $list instanceof ProjectTaskList ? $list->getViewUrl() : null;
    } // getObjectUrl
  
  } // ProjectTask 

?>