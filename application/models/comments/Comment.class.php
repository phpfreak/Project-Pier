<?php

  /**
  * Comment class
  *
  * @http://www.projectpier.org/
  */
  class Comment extends BaseComment {
    
    /**
    * Comment # for specific object
    *
    * @var integer
    */
    protected $comment_num = null;
    
    /**
    * We can attach files to comments
    *
    * @var array
    */
    protected $is_file_container = true;
  
    /**
    * Return object connected with this action
    *
    * @access public
    * @param void
    * @return ProjectDataObject
    */
    function getObject() {
      return get_object_by_manager_and_id($this->getRelObjectId(), $this->getRelObjectManager());
    } // getObject
    
    /**
    * Return project object
    *
    * @param void
    * @return Project
    */
    function getProject() {
      if (is_null($this->project)) {
        $object = $this->getObject();
        if ($object instanceof ProjectDataobject) {
          $project = $object->getproject();
          $this->project = $project instanceof Project ? $project : null;
        } // if
      } // if
      return $this->project;
    } // getProject
    
    /**
    * Return project ID
    *
    * @param void
    * @return integer
    */
    function getProjectId() {
      $project = $this->getProject();
      return $project instanceof Project ? $project->getId() : null;
    } // getProjectId
    
    /**
    * Return comment #
    *
    * @param void
    * @return integer
    */
    function getCommentNum() {
      if (is_null($this->comment_num)) {
        $object = $this->getObject();
        $this->comment_num = $object instanceof ProjectDataObject ? $object->getCommentNum($this) : 0;
      } // if
      return $this->comment_num;
    } // getCommentNum
    
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
      $object = $this->getObject();
      return $object instanceof ProjectDataObject ? $object->getObjectUrl() . '#comment' . $this->getId() : '';
    } // getViewUrl
    
    /**
    * Return add comment URL for specific object
    *
    * @param ProjectDataObject $object
    * @return string
    */
    static function getAddUrl(ProjectDataObject $object) {
      return get_url('comment', 'add', array(
        'object_id' => $object->getObjectId(),
        'object_manager' => get_class($object->manager()),
        'active_project' => $object->getProject()->getId(),
      )); // get_url
    } // getAddUrl
    
    /**
    * Return edit URL
    *
    * @param void
    * @return string
    */
    function getEditUrl() {
      return get_url('comment', 'edit', array('id' => $this->getId(), 'active_project' => $this->getProjectId()));
    } // getEditUrl
    
    /**
    * Return delete URL
    *
    * @param void
    * @return string
    */
    function getDeleteUrl() {
      return get_url('comment', 'delete', array('id' => $this->getId(), 'active_project' => $this->getProjectId()));
    } // getDeleteUrl
    
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
      $project = $this->getProject();
      if (!($project instanceof Project) || !$user->isProjectUser($this->getProject())) {
        return false;
      } // if
      $object = $this->getObject();
      if ($object instanceof ProjectDataObject) {
        return $object->canView($user);
      } else {
        return false;
      } // if
    } // canView
    
    /**
    * Empty implementation of static method.
    * 
    * Add tag permissions are done through ProjectDataObject::canComment() method. This
    * will return comment permissions for specified object
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
      $project = $this->getProject();
      if (!($project instanceof Project) || !$user->isProjectUser($this->getProject())) {
        return false;
      } // if
      $object = $this->getObject();
      if ($object instanceof ProjectDataObject) {
        if ($user->isAdministrator()) {
          return true;
        } // if
        if (!$user->isMemberOfOwnerCompany() && $this->isPrivate()) {
          return false; // private object
        } // if
        
        $edit_limit = DateTimeValueLib::now();
        $edit_limit->advance(180);
        if (($this->getCreatedById() == $user->getId()) && ($this->getCreatedOn()->getTimestamp() < $edit_limit->getTimestamp())) {
          return true; // author withing three minutes
        } // if
      } // if
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
      $project = $this->getProject();
      if (!($project instanceof Project) || !$user->isProjectUser($this->getProject())) {
        return false;
      } // if
      $object = $this->getObject();
      if ($object instanceof ProjectDataObject) {
        return $user->isAdministrator();
      } // if
      return false;
    } // canDelete
    
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
      if (!$this->validatePresenceOf('text')) {
        $errors[] = lang('comment text required');
      } // if
    } // validate
    
    /**
    * Save the object
    *
    * @param void
    * @return boolean
    */
    function save() {
      $is_new = $this->isNew();
      $saved = parent::save();
      if ($saved) {
        $object = $this->getObject();
        if ($object instanceof ProjectDataObject) {
          if ($is_new) {
            $object->onAddComment($this);
          } else {
            $object->onEditComment($this);
          } // if
        } // if
      } // if
      return $saved;
    } // save
    
    /**
    * Delete comment
    *
    * @param void
    * @return null
    */
    function delete() {
      $deleted = parent::delete();
      if ($deleted) {
        $object = $this->getObject();
        if ($object instanceof ProjectDataObject) {
          $object->onDeleteComment($this);
        } // if
      } // if
      return $deleted;
    } // delete
    
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
      $object = $this->getObject();
      return $object instanceof ProjectDataObject ? lang('comment on object', substr_utf($this->getText(), 0, 50) . '...', $object->getObjectName()) : $this->getObjectTypeName();
    } // getObjectName
    
    /**
    * Return object type name
    *
    * @param void
    * @return string
    */
    function getObjectTypeName() {
      return lang('comment');
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
    
  } // Comment 

?>