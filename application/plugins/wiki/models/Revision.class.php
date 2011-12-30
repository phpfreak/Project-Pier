<?php

  /**
  * Revision
  * 
  * @package ProjectPier Wiki
  * @author Alex Mayhew
  * @copyright 2008
  * @version $Id$
  * @access public
  */
  class Revision extends BaseRevision {

    /**
    * This type of object is taggable
    *
    * @var boolean
    */
    protected $is_taggable = false;
    
    /**
    * This type of object is searchable
    *
    * @var boolean
    */
    protected $is_searchable = true;
    
    /**
    * Array of searchable columns
    *
    * @var array
    */
    protected $searchable_columns = array('name', 'content', 'log_message');
    
    /**
    * This type of object is commentable
    *
    * @var boolean
    */
    protected $is_commentable = false;
    
    /**
    * This type of object is a file container
    *
    * @var boolean
    */
    protected $is_file_container = false;
    
    /**
    * This type of object is subscribable
    *
    * @var boolean
    */
    protected $is_subscribable = false;

    /**
    * Validate before save
    *
    * @access public
    * @param array $errors
    * @return null
    */
    function validate(&$errors) {
      if (!$this->validatePresenceOf('name')) { 
        $errors[] = lang('wiki page name required');
      }
      if (!$this->validatePresenceOf('content')) {
        $errors[] = lang('wiki page content required');
      }
      if(!$this->validatePresenceOf('project_id')){
        $errors[] = lang('wiki project id required');
      }
      if(!$this->validatePresenceOf('page_id')){
        $errors[] = lang('wiki page id required');
      }			
    } // validate

    /**
    * Can the user view this revision
    * 
    * @param mixed $user
    * @return
    */
    function canView(User $user) {
      return $user->isProjectUser($this->getProject());
    } // canView

    /**
    * Can the user add a revision?
    * 
    * @param mixed User object
    * @param mixed Project Object
    * @return (bool)
    */
    function canAdd(User $user, Project $project) {
      // Is the user an admin, or a member of the owner company?
      return $user->isAdministrator() || $user->isMemberOfOwnerCompany() || $user->isProjectUser(active_project());
    } // canAdd
	
    /**
    * Can the user edit this revision
    * 
    * @param mixed User object
    * @return (bool)
    */
    function canEdit(User $user) {
      // Is the user a member of the owner company, or an admin?
      return $user->isAdministrator() || $user->isMemberOfOwnerCompany() || $user->isProjectUser(active_project());
    } // canEdit
	
    /**
    * Can the user delete this revision
    * 
    * @param mixed User object
    * @return (bool)
    */
    function canDelete(User $user) {
      // Only admins can delete a revision
      return $user->isAdministrator();
    } // canDelete    

    /**
    * Return object type name
    *
    * @param void
    * @return string
    */
    function getObjectTypeName() {
      return lang('revision');
     } // getObjectTypeName
  
    /**
    * Get page name
    * 
    * @return
    */
    function getObjectName() {
      return $this->getName() . ' (' . $this->getRevision() . ')';
    } // getObjectName
  
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
    * Get url to revert to this revision
    * 
    * @return
    */
    function getRevertUrl() {
      return get_url('wiki', 'revert', array('id' => $this->getPageId(), 'revision' => $this->getRevision()));
    }
		
    /**
    * Get url to view this revision
    * 
    * @return
    */
    function getViewUrl() {
      return get_url('wiki', 'view', array('id' => $this->getPageId(), 'revision' => $this->getRevision()));
    }
	
  } // Revision

?>