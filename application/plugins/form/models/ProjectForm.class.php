<?php

  /**
  * ProjectForm class
  * Generated on Wed, 07 Jun 2006 10:14:23 +0200 by DataObject generation tool
  *
  * @http://www.projectpier.org/
  */
  class ProjectForm extends BaseProjectForm {
    
    const ADD_COMMENT_ACTION = 'add_comment';
    const ADD_TASK_ACTION = 'add_task';
    
    /**
    * Cached in object
    *
    * @var ApplicationDataObject
    */
    private $in_object;
    
    /**
    * This function will return application data object that matches action and in object ID
    *
    * @param void
    * @return ApplicationDataObject
    */
    function getInObject() {
      if (is_null($this->in_object)) {
        if ($this->getAction() == self::ADD_COMMENT_ACTION) {
          $this->in_object = ProjectMessages::findById($this->getInObjectId());
        } elseif ($this->getAction() == self::ADD_TASK_ACTION) {
          $this->in_object = ProjectTaskLists::findById($this->getInObjectId());
        } // if
      } // if
      return $this->in_object;
    } // getInObject
    
    /**
    * Get in object name
    *
    * @param void
    * @return string
    */
    function getInObjectName() {
      $in_object = $this->getInObject();
      return $in_object instanceof ApplicationDataObject ? $in_object->getObjectName() : null;
    } // getInObjectName
    
    /**
    * Return in object URL
    *
    * @param void
    * @return string
    */
    function getInObjectUrl() {
      $in_object = $this->getInObject();
      return $in_object instanceof ApplicationDataObject ? $in_object->getObjectUrl() : null;
    } // getInObjectUrl
    
    // ---------------------------------------------------
    //  URLs
    // ---------------------------------------------------
    
    /**
    * Return edit form URL
    *
    * @param void
    * @return string
    */
    function getEditUrl() {
      return get_url('form', 'edit', array('id' => $this->getId(), 'active_project' => $this->getProjectId()));
    } // getEditUrl
    
    /**
    * Return delete form URL
    *
    * @param void
    * @return string
    */
    function getDeleteUrl() {
      return get_url('form', 'delete', array('id' => $this->getId(), 'active_project' => $this->getProjectId()));
    } // getDeleteUrl
    
    /**
    * Return submit form URL
    *
    * @param void
    * @return string
    */
    function getSubmitUrl() {
      return get_url('form', 'submit', array('id' => $this->getId(), 'active_project' => $this->getProjectId()));
    } // getSubmitUrl
    
    // ---------------------------------------------------
    //  Permissions
    // ---------------------------------------------------
    
    /**
    * Returns true if $user can submit this form
    *
    * @param User $user
    * @return boolean
    */
    function canSubmit(User $user) {
      return $this->canView($user);
    } // canSubmit
  
    /**
    * Returns true if $user can view and submit this form
    *
    * @param User $user
    * @return boolean
    */
    function canView(User $user) {
      return $user->isProjectUser($this->getProject());
    } // canView
    
    /**
    * Check if specific user can add messages to specific project
    *
    * @access public
    * @param User $user
    * @param Project $project
    * @return booelean
    */
    function canAdd(User $user, Project $project) {
      if (!$user->isProjectUser($project)) {
        return false; // user is on project
      }
      if ($user->isAdministrator()) {
        return true; // user is administrator or root
      }
      return false; // no no
    } // canAdd
    
    /**
    * Check if specific user can edit this messages
    *
    * @access public
    * @param User $user
    * @return boolean
    */
    function canEdit(User $user) {
      if (!$user->isProjectUser($this->getProject())) {
        return false; // user is on project
      }
      if ($user->isAdministrator()) {
        return true; // user is administrator or root
      }
      return false; // no no
    } // canEdit
    
    /**
    * Check if specific user can delete this messages
    *
    * @access public
    * @param User $user
    * @return boolean
    */
    function canDelete(User $user) {
      if (!$user->isProjectUser($this->getProject())) {
        return false; // user is on project
      }
      if ($user->isAdministrator()) {
        return true; // user is administrator or root
      }
      return false; // no no
    } // canDelete
    
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
      if ($this->validatePresenceOf('name')) {
        if (!$this->validateUniquenessOf('name', 'project_id')) {
          $errors[] = lang('form name unique');
        }
      } else {
        $errors[] = lang('form name required');
      } // if
      if (!$this->validatePresenceOf('success_message')) {
        $errors[] = lang('form success message required');
      }
      if (!$this->validatePresenceOf('action')) {
        $errors[] = lang('form action required');
      }
    } // validate
    
    // ---------------------------------------------------
    //  Override ApplicationDataObject methods
    // ---------------------------------------------------
    
    /**
    * Return object type name
    *
    * @param void
    * @return string
    */
    function getObjectTypeName() {
      return lang('form');
    } // getObjectTypeName
    
    /**
    * Return object URl
    *
    * @access public
    * @param void
    * @return string
    */
    function getObjectUrl() {
      return $this->getSubmitUrl();
    } // getObjectUrl
    
  } // ProjectForm 

?>