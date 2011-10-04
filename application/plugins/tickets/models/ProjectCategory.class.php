<?php

  /**
  * ProjectCategory class
  *
  * @http://www.projectpier.org/
  */
  class ProjectCategory extends BaseProjectCategory {
    
    /**
    * Return owner project object
    *
    * @access public
    * @param void
    * @return Project
    */
    function getProject() {
      return Projects::findById($this->getProjectId());
    } // getProject
    
    /**
    * Return shortened description
    *
    * @access public
    * @param void
    * @return string
    */
    function getShortDescription() {
      $return = substr_utf($this->getDescription(), 0, 50);
      return strlen_utf($this->getDescription()) > 50 ? $return . '...' : $return;
    } // getShortDescription
    
    // ---------------------------------------------------
    //  Permissions
    // ---------------------------------------------------
    
    /**
    * Return true if $user can view this category
    *
    * @param User $user
    * @return boolean
    */
    function canView(User $user) {
      if(!$user->isProjectUser($this->getProject())) {
        return false; // user have access to project
      } // if
      return true;
    } // canView
    
    /**
    * Check if user can add categories in specific project
    *
    * @param User $user
    * @param Project $project
    * @return boolean
    */
    function canAdd(User $user, Project $project) {
      if(!$user->isProjectUser($project)) {
        return false; // user is on project
      } // if
      if($user->isAdministrator()) {
        return true; // user is administrator or root
      } // if
      return $user->getProjectPermission($project, ProjectTicket::CAN_MANAGE_TICKETS);
    } // canAdd
    
    /**
    * Check if specific user can update this category
    *
    * @param User $user
    * @return boolean
    */
    function canEdit(User $user) {
      if(!$user->isProjectUser($this->getProject())) {
        return false; // user is on project
      } // if
      if($user->isAdministrator()) {
        return true; // user is administrator or root
      } // if
      return $user->getProjectPermission($this->getProject(), ProjectTicket::CAN_MANAGE_TICKETS);
    } // canEdit
    
    /**
    * Check if specific user can delete this <!--category-->
    *
    * @param User $user
    * @return boolean
    */
    function canDelete(User $user) {
      if(!$user->isProjectUser($this->getProject())) {
        return false; // user is on project
      } // if
      if($user->isAdministrator()) {
        return true; // user is administrator or root
      } // if
      return $user->getProjectPermission($this->getProject(), ProjectTicket::CAN_MANAGE_TICKETS);
    } // canDelete
    
    // ---------------------------------------------------
    //  URLs
    // ---------------------------------------------------
    
    /**
    * Return tag URL
    *
    * @param void
    * @return string
    */
    function getViewUrl() {
      return $this->getEditUrl();
    } // getViewUrl
    
    /**
    * Return edit URL
    *
    * @param void
    * @return string
    */
    function getEditUrl() {
      return get_url('tickets', 'edit_category', array('id' => $this->getId(), 'active_project' => $this->getProjectId()));
    } // getEditUrl
    
    /**
    * Return delete URL
    *
    * @param void
    * @return string
    */
    function getDeleteUrl() {
      return get_url('tickets', 'delete_category', array('id' => $this->getId(), 'active_project' => $this->getProjectId()));
    } // getDeleteUrl
    
    // ---------------------------------------------------
    //  System
    // ---------------------------------------------------
    
    /**
    * Validate before save
    *
    * @param array $error
    * @return null
    */
    function validate(&$errors) {
      if(!$this->validatePresenceOf('name')) {
        $errors[] = lang('category name required');
      } // if
    } // validate
    
    // ---------------------------------------------------
    //  ApplicationDataObject implementation
    // ---------------------------------------------------
    
    /**
    * Return object name
    *
    * @param void
    * @return string
    */
    function getObjectName() {
      return $this->getName();
    } // getObjectName
    
    /**
    * Return object type name
    *
    * @param void
    * @return string
    */
    function getObjectTypeName() {
      return lang('category');
    } // getObjectTypeName
    
    /**
    * Return view tag URL
    *
    * @param void
    * @return string
    */
    function getObjectUrl() {
      return $this->getViewUrl();
    } // getObjectUrl
    
  } // ProjectCategory

?>