<?php

  /**
  * ProjectTime class
  *
  */
  class ProjectTime extends BaseProjectTime {

    const CAN_MANAGE_TIME = 'times-manage';

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
    * Time is file container
    *
    * @var boolean
    */
    protected $is_file_container = true;

    /**
    * Array of searchable columns
    *
    * @var array
    */
    protected $searchable_columns = array('name', 'description');
    
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
    * Return assigned to object. It can be User, Company or nobady (NULL)
    *
    * @access public
    * @param void
    * @return ApplicationDataObject
    */
    function getAssignedTo() {
      if($this->getAssignedToUserId() > 0) {
        return $this->getAssignedToUser();
      } elseif($this->getAssignedToCompanyId() > 0) {
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
    * Returns true if this time log is made today
    *
    * @access public
    * @param void
    * @return boolean
    */
    function isToday() {
      $now = DateTimeValueLib::now();
      $created_on = $this->getDoneDate();
      
      // getCreatedOn and similar functions can return NULL
      if(!($created_on instanceof DateTimeValue)) return false;
    
      return $now->getDay() == $created_on->getDay() &&
             $now->getMonth() == $created_on->getMonth() &&
             $now->getYear() == $created_on->getYear();
    } // isToday
    
    /**
    * Returnst true if this application log was made yesterday
    * 
    * @param void
    * @return boolean
    */
    function isYesterday() {
      $created_on = $this->getDoneDate();
      if(!($created_on instanceof DateTimeValue)) return false;
      
      $day_after = $created_on->advance(24 * 60 * 60, false);
      $now = DateTimeValueLib::now();
      
      return $now->getDay() == $day_after->getDay() &&
             $now->getMonth() == $day_after->getMonth() &&
             $now->getYear() == $day_after->getYear();
    } // isYesterday

    
    // ---------------------------------------------------
    //  Permissions
    // ---------------------------------------------------
    
    /**
    * Returns true if specific user has CAN_MANAGE_TIME permission set to true
    *
    * @access public
    * @param User $user
    * @return boolean
    */
    function canManage(User $user) {
      return $user->getProjectPermission($this->getProject(), ProjectTime::CAN_MANAGE_TIME);
    } // canManage
    
    /**
    * Returns true if $user can view this time
    *
    * @param User $user
    * @return boolean
    */
    function canView(User $user) {
      if($user->isAdministrator()) return true;
      if($this->isPrivate() && $user->isMemberOfOwnerCompany()) return true;
      if($user->isProjectUser($this->getProject())) return true;
      return false;
    } // canView
    
    /**
    * Check if specific user can add new time to specific project
    *
    * @access public
    * @param User $user
    * @param Project $project
    * @return boolean
    */
    function canAdd(User $user, Project $project) {
      if($user->isAdministrator()) return true;
      if(!$user->isProjectUser($project)) return false;
      return $user->getProjectPermission($project, ProjectTime::CAN_MANAGE_TIME);
    } // canAdd
    
    /**
    * Check if specific user can edit this time
    *
    * @access public
    * @param User $user
    * @return boolean
    */
    function canEdit(User $user) {
      if($user->isAdministrator()) return true;
      if($this->getCreatedById() == $user->getId()) return true;
      if($user->isProjectUser($this->getProject())) return true;
      return false;
    } // canEdit
    
    /**
    * Can change status of this time
    *
    * @access public
    * @param User $user
    * @return boolean
    */
    function canChangeStatus(User $user) {
      if($this->canEdit($user)) return true;
      
      // Additional check - is this time assigned to this user or its company
      if($this->getAssignedTo() instanceof User) {
        if($user->getId() == $this->getAssignedTo()->getObjectId()) return true;
      } elseif($this->getAssignedTo() instanceof Company) {
        if($user->getCompanyId() == $this->getAssignedTo()->getObjectId()) return true;
      } // if
      return false;
    } // canChangeStatus
    
    /**
    * Check if specific user can delete this time
    *
    * @access public
    * @param User $user
    * @return boolean
    */
    function canDelete(User $user) {
      if(!$user->isProjectUser($this->getProject())) return false;
      if($user->isAdministrator()) return true;
      return false;
    } // canDelete
    
    // ---------------------------------------------------
    //  URL
    // ---------------------------------------------------
    
    function getViewUrl() {
      return get_url('time', 'view', array('id' => $this->getId(), 'active_project' => $this->getProjectId()));
    } // getViewUrl
    
    /**
    * Return edit time URL
    *
    * @access public
    * @param void
    * @return string
    */
    function getEditUrl() {
      return get_url('time', 'edit', array('id' => $this->getId(), 'active_project' => $this->getProjectId()));
    } // getEditUrl
    
    /**
    * Return delete time URL
    *
    * @access public
    * @param void
    * @return string
    */
    function getDeleteUrl() {
      return get_url('time', 'delete', array('id' => $this->getId(), 'active_project' => $this->getProjectId()));
    } // getDeleteUrl
    
    /**
    * Return complete time url
    *
    * @access public
    * @param void
    * @return string
    */
    function getCompleteUrl() {
      return get_url('time', 'complete', array('id' => $this->getId(), 'active_project' => $this->getProjectId()));
    } // getCompleteUrl
    
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
      if(!$this->validatePresenceOf('name')) $errors[] = lang('time name required');
      #if(!$this->validatePresenceOf('done_date')) $errors[] = lang('time date required');
      #if(!$this->validatePresenceOf('hours')) $errors[] = lang('time hours required');
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
      return lang('time');
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
    
  } // ProjectTime

?>