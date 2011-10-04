<?php

  /**
  * ProjectMilestone class
  * Generated on Sat, 04 Mar 2006 12:50:11 +0100 by DataObject generation tool
  *
  * @http://www.projectpier.org/
  */
  class ProjectMilestone extends BaseProjectMilestone {
    
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
    * Milestones are commentable
    *
    * @var boolean
    */
    protected $is_commentable = true;

    /**
    * Cached User object of person who completed this milestone
    *
    * @var User
    */
    private $completed_by;
    
    /**
    * Return if this milestone is completed
    *
    * @access public
    * @param void
    * @return boolean
    */
    function isCompleted() {
      if (is_null($this->getDueDate())) {
        return false;
      }
      return (boolean) $this->getCompletedOn();
    } // isCompleted
    
    /**
    * Check if this milestone is late
    *
    * @access public
    * @param void
    * @return null
    */
    function isLate() {
      if ($this->isCompleted()) {
        return false;
      }
      if (is_null($this->getDueDate())) {
        return true;
      }
      return !$this->isToday() && ($this->getDueDate()->getTimestamp() < time());
    } // isLate
    
    /**
    * Check if this milestone is today
    *
    * @access public
    * @param void
    * @return null
    */
    function isToday() {
      $now = DateTimeValueLib::now();
      $due = $this->getDueDate();
      
      // getDueDate and similar functions can return NULL
      if (!($due instanceof DateTimeValue)) {
        return false;
      }
      
      return $now->getDay() == $due->getDay() && 
        $now->getMonth() == $due->getMonth() && 
        $now->getYear() == $due->getYear();
    } // isToday
    
    /**
    * Check if this is upcoming milestone
    *
    * @access public
    * @param void
    * @return null
    */
    function isUpcoming() {
      return !$this->isCompleted() && !$this->isToday() && ($this->getDueDate()->getTimestamp() > time());
    } // isUpcoming
    
    /**
    * Return number of days that this milestone is late for
    *
    * @access public
    * @param void
    * @return integer
    */
    function getLateInDays() {
      $due_date_start = $this->getDueDate()->beginningOfDay();
      return floor(abs($due_date_start->getTimestamp() - DateTimeValueLib::now()->getTimestamp()) / 86400);
    } // getLateInDays
    
    /**
    * Return number of days that is left
    *
    * @access public
    * @param void
    * @return integer
    */
    function getLeftInDays() {
      $due_date_start = $this->getDueDate()->endOfDay();
      return floor(abs($due_date_start->getTimestamp() - DateTimeValueLib::now()->beginningOfDay()->getTimestamp()) / 86400);
    } // getLeftInDays
    
    /**
    * Return difference between specific datetime and due date time in seconds
    *
    * @access public
    * @param DateTime $diff_to
    * @return integer
    */
    private function getDueDateDiff(DateTimeValue $diff_to) {
      return $this->getDueDate()->getTimestamp() - $diff_to->getTimestamp();
    } // getDueDateDiff

    // ---------------------------------------------------
    //  Related object
    // ---------------------------------------------------
    
    /**
    * Return project
    *
    * @access public
    * @param void
    * @return Project
    */
    function getProject() {
      return Projects::findById($this->getProjectId());
    } // getProject
    
    /**
    * Return all tasklists connected with this milestone
    *
    * @access public
    * @param void
    * @return array
    */
    function getTaskLists() {
      return ProjectTaskLists::findAll(array(
        'conditions' => '`milestone_id` = ' . DB::escape($this->getId()),
        'order' => 'created_on'
      )); // findAll
    } // getTaskLists
    
    /**
    * Returns true if there are task lists in this milestone
    *
    * @access public
    * @param void
    * @return boolean
    */
    function hasTaskLists() {
      return (boolean) ProjectTaskLists::count('`milestone_id` = ' . DB::escape($this->getId()));
    } // hasTaskLists
    
    /**
    * Return all messages related with this message
    *
    * @access public
    * @param void
    * @return array
    */
    function getMessages() {
      return ProjectMessages::findAll(array(
        'conditions' => '`milestone_id` = ' . DB::escape($this->getId()),
        'order' => 'created_on'
      )); // findAll
    } // getMessages
    
    /**
    * Returns true if there is messages in this milestone
    *
    * @access public
    * @param void
    * @return boolean
    */
    function hasMessages() {
      return (boolean) ProjectMessages::count('`milestone_id` = ' . DB::escape($this->getId()));
    } // hasMessages
    
    /**
    * Return all tickets related to this message
    *
    * @access public
    * @param void
    * @return array
    */
    function getTickets() {
      if (!plugin_active('tickets')) return array();
      return ProjectTickets::findAll(array(
        'conditions' => '`milestone_id` = ' . DB::escape($this->getId()),
        'order' => 'created_on'
      )); // findAll
    } // getTickets
    
    /**
    * Returns true if there are tickets in this milestone
    *
    * @access public
    * @param void
    * @return boolean
    */
    function hasTickets() {
      if (!plugin_active('tickets')) return false;
      return (boolean) ProjectTickets::count('`milestone_id` = ' . DB::escape($this->getId()));
    } // hasTickets
    
    /**
    * Return assigned to object. It can be User, Company or nobady (NULL)
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
    * Return responsible company
    *
    * @access public
    * @param void
    * @return Company
    */
    protected function getAssignedToCompany() {
      return Companies::findById($this->getAssignedToCompanyId());
    } // getAssignedToCompany
    
    /**
    * Return responsible user
    *
    * @access public
    * @param void
    * @return User
    */
    protected function getAssignedToUser() {
      return Users::findById($this->getAssignedToUserId());
    } // getAssignedToUser
    
    /**
    * Return User object of person who completed this milestone
    *
    * @param void
    * @return User
    */
    function getCompletedBy() {
      if (is_null($this->completed_by)) {
        $this->completed_by = Users::findById($this->getCompletedById());
      }
      return $this->completed_by;
    } // getCompletedBy
    
    // ---------------------------------------------------
    //  Permissions
    // ---------------------------------------------------
    
    /**
    * Returns true if specific user has CAN_MANAGE_MILESTONES permission set to true
    *
    * @access public
    * @param User $user
    * @return boolean
    */
    function canManage(User $user) {
      return $user->getProjectPermission($this->getProject(), PermissionManager::CAN_MANAGE_MILESTONES);
    } // canManage
    
    /**
    * Returns true if $user can view this milestone
    *
    * @param User $user
    * @return boolean
    */
    function canView(User $user) {
      if (!$user->isProjectUser($this->getProject())) {
        return false;
      }
      if ($user->isAdministrator()) {
        return true;
      }
      if ($this->isPrivate() && !$user->isMemberOfOwnerCompany()) {
        return false;
      }
      return true;
    } // canView
    
    /**
    * Check if specific user can add new milestones to specific project
    *
    * @access public
    * @param User $user
    * @param Project $project
    * @return boolean
    */
    function canAdd(User $user, Project $project) {
      if ($user->getProjectPermission($project, PermissionManager::CAN_MANAGE_MILESTONES)) {
        return true;
      }
      if ($user->isAdministrator()) {
        return true;
      }
      return false;
    } // canAdd
    
    /**
    * Check if specific user can edit this milestone
    *
    * @access public
    * @param User $user
    * @return boolean
    */
    function canEdit(User $user) {
      if ($user->getProjectPermission($this->getProject(), PermissionManager::CAN_MANAGE_MILESTONES)) {
        return true;
      }
      if ($this->getCreatedById() == $user->getId()) {
        return true;
      }
      if ($user->isAdministrator()) {
        return true;
      }
      return false;
    } // canEdit
    
    /**
    * Can change status of this milestone (completed / open)
    *
    * @access public
    * @param User $user
    * @return boolean
    */
    function canChangeStatus(User $user) {
      if ($user->getProjectPermission($this->getProject(), PermissionManager::CAN_CHANGE_STATUS_MILESTONES)) {
        return true;
      }
      if ($this->getCreatedById() == $user->getId()) {
        return true;
      }
      if ($user->isAdministrator()) {
        return true;
      }   
      // Additional check - is this milestone assigned to this user or its company
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
    * Check if specific user can delete this milestone
    *
    * @access public
    * @param User $user
    * @return boolean
    */
    function canDelete(User $user) {
      return $this->canEdit($user);
    } // canDelete
    
    // ---------------------------------------------------
    //  URL
    // ---------------------------------------------------
    
    function getViewUrl() {
      return get_url('milestone', 'view', array('id' => $this->getId(), 'active_project' => $this->getProjectId()));
    } // getViewUrl
    
    /**
    * Return edit milestone URL
    *
    * @access public
    * @param void
    * @return string
    */
    function getEditUrl() {
      return get_url('milestone', 'edit', array('id' => $this->getId(), 'active_project' => $this->getProjectId()));
    } // getEditUrl
    
    /**
    * Return delete milestone URL
    *
    * @access public
    * @param void
    * @return string
    */
    function getDeleteUrl() {
      return get_url('milestone', 'delete', array('id' => $this->getId(), 'active_project' => $this->getProjectId()));
    } // getDeleteUrl
    
    /**
    * Return complete milestone url
    *
    * @access public
    * @param void
    * @return string
    */
    function getCompleteUrl() {
      return get_url('milestone', 'complete', array('id' => $this->getId(), 'active_project' => $this->getProjectId()));
    } // getCompleteUrl
    
    /**
    * Return open milestone url
    *
    * @access public
    * @param void
    * @return string
    */
    function getOpenUrl() {
      return get_url('milestone', 'open', array('id' => $this->getId(), 'active_project' => $this->getProjectId()));
    } // getOpenUrl
    
    /**
    * Return add message URL
    *
    * @access public
    * @param void
    * @return string
    */
    function getAddMessageUrl() {
      return get_url('message', 'add', array('milestone_id' => $this->getId(), 'active_project' => $this->getProjectId()));
    } // getAddMessageUrl
    
    /**
    * Return add task list URL
    *
    * @access public
    * @param void
    * @return string
    */
    function getAddTaskListUrl() {
      return get_url('task', 'add_list', array('milestone_id' => $this->getId(), 'active_project' => $this->getProjectId()));
    } // getAddTaskListUrl
        
    /**
    * Return add ticket URL
    *
    * @access public
    * @param void
    * @return string
    */
    function getAddTicketUrl() {
      return get_url('ticket', 'add', array('milestone_id' => $this->getId(), 'active_project' => $this->getProjectId()));
    } // getAddTicketUrl
 
    // ---------------------------------------------------
    //  System functions
    // ---------------------------------------------------
  
    /**
    * Validate before save
    *
    * @access public
    * @param array $errors
    * @return boolean
    */
    function validate(&$errors) {
      if (!$this->validatePresenceOf('name')) {
        $errors[] = lang('milestone name required');
      }
      if (!$this->validatePresenceOf('due_date')) {
        $errors[] = lang('milestone due date required');
      }
    } // validate
    
    /**
    * Delete this object and reset all relationship. This function will not delete any of related objec
    *
    * @access public
    * @param void
    * @return boolean
    */
    function delete() {
      
      try {
        DB::execute("UPDATE " . ProjectMessages::instance()->getTableName(true) . " SET `milestone_id` = '0' WHERE `milestone_id` = " . DB::escape($this->getId()));
        DB::execute("UPDATE " . ProjectTaskLists::instance()->getTableName(true) . " SET `milestone_id` = '0' WHERE `milestone_id` = " . DB::escape($this->getId()));
        return parent::delete();
      } catch(Exception $e) {
        throw $e;
      } // try
      
    } // delete
    
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
      return lang('milestone');
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

    /**
    * Returns a count of tickets in this milestone by state
    *
    * @access public
    * @param void
    * @return string
    */
    function hasTicketsByState($state) {
      if (!plugin_active('tickets')) return 0;
      if ($state == 'open') {
        $new = ProjectTickets::count('`milestone_id` = ' . DB::escape($this->getId()) . ' AND `state` = ' . DB::escape('new') . '');
        $open = ProjectTickets::count('`milestone_id` = ' . DB::escape($this->getId()) . ' AND `state` = ' . DB::escape('open') . '');
        return $new + $open;
      }
      else if ($state == 'in_progress') {
        return ProjectTickets::count('`milestone_id` = ' . DB::escape($this->getId()) . ' AND `state` = ' . DB::escape('pending') . '');
      }
      else if ($state == 'resolved') {
        return ProjectTickets::count('`milestone_id` = ' . DB::escape($this->getId()) . ' AND `state` = ' . DB::escape('closed') . '');
      }
      
    } // hasTicketsByState

    /**
    * Returns a total count of all tickets.
    *
    * @access public
    * @param void
    * @return string
    */
    function getTotalTicketCount() {
      if (!plugin_active('tickets')) return 0;
      return ProjectTickets::count('`milestone_id` = ' . DB::escape($this->getId()));
    } // getTotalTicketCount

    /**
    * Returns a percentage value of a certain ticket status.
    *
    * @access public
    * @param void
    * @return string
    */
    function getPercentageByTicketState($state) {
      return floor(($this->hasTicketsByState($state) / $this->getTotalTicketCount()) * 100);
    } // getPercentageByTicketState
    
  } // ProjectMilestone 

?>