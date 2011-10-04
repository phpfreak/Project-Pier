<?php

  /**
  * Tag class
  *
  * @http://www.projectpier.org/
  */
  class Tag extends BaseTag {
  
    /**
    * Return object connected with this action
    *
    * @access public
    * @param void
    * @return ApplicationDataObject
    */
    function getObject() {
      return get_object_by_manager_and_id($this->getRelObjectId(), $this->getRelObjectManager());
    } // getObject
    
    /**
    * Return tag URL
    *
    * @param void
    * @return string
    */
    function getViewUrl() {
      $project = $this->getProject();
      return $project instanceof Project ? $project->getTagUrl($this->getTag()) : null;
    } // getViewUrl
    
    // ---------------------------------------------------
    //  Permissions
    // ---------------------------------------------------
    
    /**
    * Can $user view this object
    *
    * @param User $user
    * @return boolean
    */
    function canView(User $user) {
      return $user->isProjectUser($this->getProject());
    } // canView
    
    /**
    * Empty implementation of static method. Update tag permissions are check by the taggable
    * object, not tag itself
    *
    * @param User $user
    * @param Project $project
    * @return boolean
    */
    function canAdd(User $user, Project $project) {
      return false;
    } // canAdd
    
    /**
    * Empty implementation of static method. Update tag permissions are check by the taggable
    * object, not tag itself
    *
    * @param User $user
    * @return boolean
    */
    function canEdit(User $user) {
      return false;
    } // canEdit
    
    /**
    * Empty implementation of static method. Update tag permissions are check by the taggable
    * object, not tag itself
    *
    * @param User $user
    * @return boolean
    */
    function canDelete(User $user) {
      return false;
    } // canDelete
    
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
      return lang('tag');
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
    
  } // Tag 

?>