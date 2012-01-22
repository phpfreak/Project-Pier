<?php

  /**
  * WikiPage
  * 
  * @package ProjectPier Wiki
  * @author Alex Mayhew
  * @copyright 2008
  * @version $Id$
  * @access public
  */
  class WikiPage extends BaseWikiPage {

    /**
    * This type of project object is taggable
    *
    * @var boolean
    */
    protected $is_taggable = true;
    
    /**
    * This type of project is searchable
    *
    * @var boolean
    */
    protected $is_searchable = false;
    
    /**
    * Array of searchable columns
    *
    * @var array
    */
    protected $searchable_columns = array();
    
    /**
    * This type of project is commentable
    *
    * @var boolean
    */
    protected $is_commentable = true;
    
    /**
    * This type of project is a file container
    *
    * @var boolean
    */
    protected $is_file_container = false;
    
    /**
    * This type of project is subscribable
    *
    * @var boolean
    */
    protected $is_subscribable = false;

    /**
    * Cached array of subscribers
    *
    * @var array
    */
    private $subscribers;
    
    /**
    * Cached array of related forms
    *
    * @var array
    */
    private $related_forms;
	
    /**
    * Cached array of all revisions of this page
    *
    * @var array
    */
    protected $revisions = array(); 

    /**
    * The current revision of this page
    *
    * @var array
    */
    protected $cur_revision;

    /**
    * The new revision of this page
    *
    * @var array
    */
    protected $new_revision;
	
    //////////////////////////////////////////
    //  Permissions
    //////////////////////////////////////////
	
    /**
    * Can the user add a wiki page?
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
    * Can the user edit this page
    * 
    * @param mixed User object
    * @return (bool)
    */
    function canEdit(User $user) {
      // Is the user a member of the owner company, or an admin?
      return $user->isAdministrator() || $user->isMemberOfOwnerCompany() || $user->isProjectUser(active_project());
    } // canEdit
	
    /**
    * Can the user delete this page
    * 
    * @param mixed User object
    * @return (bool)
    */
    function canDelete(User $user) {
      // Only admins can delete a page
      return $user->isAdministrator();
    } // canDelete

    /**
    * Can the user lock this page
    * 
    * @param User $user
    * @return boolean
    */
    function canLock(User $user) {
      // Only admins can lock a page
      return $user->isAdministrator();
    } // canLock

    /**
    * Can the user unlock this page
    * 
    * @param User $user
    * @return boolean
    */
    function canUnlock(User $user) {
      // Only admins can unlock a page
      return $user->isAdministrator();
    }
	
    /**
    * Can the user view this page
    * 
    * @param mixed $user
    * @return
    */
    function canView(User $user) {
      return $user->isProjectUser($this->getProject());
    } // canView
	
    //////////////////////////////////////////
    // Urls
    //////////////////////////////////////////
	
    /**
    * Get url to the add wiki page
    * 
    * @return string
    */
    function getAddUrl() {
      return $this->makeUrl('add', array('active_project' => active_project()->getId()), false);
    } // getAddUrl
	
    /**
    * Get url to edit this wiki page
    * 
    * @return string
    */
    function getEditUrl() {
      return $this->makeUrl('edit');
    } //getEditUrl
	
    /**
    * Get url to delete this wiki page
    * 
    * @return string
    */
    function getDeleteUrl() {
      return $this->makeUrl('delete');
    } //getDeleteUrl
	
    /**
    * Get url to view page's revision history
    * 
    * @return string
    */
    function getViewHistoryUrl() {
      return $this->makeUrl('history');
    } // getViewHistoryUrl
	
    /**
    * Get url to view this wiki page
    * 
    * @return string
    */
    function getViewUrl() {
      return $this->makeUrl('view');
    } // getViewUrl

    /**
    * Get url to all wiki pages
    * 
    * @return string
    */
    function getAllPagesUrl() {
      return $this->makeUrl('all_pages', array('active_project' => active_project()->getId()), false);
    } // getAllPagesUrl
  	
    /**
    * Generic function to make a url to a wiki page
    * 
    * 
    * @param string The action of the target page(e.g. view, delete etc.)
    * @param mixed Optional array of params 
    * @param bool Include the page id? Defaults true
    * @return
    */
    function makeUrl($action = 'index', $params = array(), $include_page_id = true) {
      //Merge params with the wiki page id
      $params = $include_page_id ?
        array_merge(array('id' => $this->getId(), 'active_project' => $this->getProjectId()), $params) :
        array_merge(array('active_project' => active_project()->getId()), $params);
	//:     $params;
      return get_url('wiki', $action, $params);
   
      // ----- DEPRECATED ------ ///
      //Decide if this link is for the wiki controller, or the dashboard
        return $this->getProjectId() == 0 ?
          get_url('dashboard', 'wiki', array_merge(array('s' => $action), $params), null, false)	:
          get_url('wiki', $action, $params);
    } //makeUrl

    //////////////////////////////////////////
    // Revisions
    //////////////////////////////////////////
	
    /**
    * Get a specific revision
    * 
    * @param mixed $revision
    * @return mixed
    */
    function getRevision($revision = null) {
      if($revision == null && instance_of($this->cur_revision, 'Revision')) {
        // If we want the latest revision, and we have it cached, return cache
        return $this->cur_revision;
      } else if (isset($this->revisions[$revision])) {
        // If we have the revision cached, return it
        return $this->revisions[$revision];
      } else if($revision === null) {
        // Update and return cache of latest revision
        return $this->cur_revision = Revisions::getRevision($this->getId(), $revision); 
      } else {
        // Cache and return the revision
        $revision = (int) $revision;
        return $this->revisions[$revision] = Revisions::getRevision($this->getId(), $revision); 
      } // if
    } // getRevision

    /**
    * Get the latest revision of this page
    * 
    * @return mixed
    */
    function getLatestRevision() {
      return $this->getRevision(null);
    } // getLatestRevision
	
    /**
    * Makes a new revision of this page
    * 
    * @return Revision object
    */
    function makeRevision() {
      // Make a new revision
      $this->new_revision = new Revision;
      // Set the project ID
      $this->new_revision->setProjectId($this->getProjectId());
      // Return a reference to the revision
      return $this->new_revision;
    } //makeRevision
		
    //////////////////////////////////////////
    // System
    //////////////////////////////////////////
	
    /**
    * Delete page & its revisions
    * 
    * @return
    */
    function delete() {
      $revisions = (array) Revisions::buildPageHistory($this->getId(), $this->getProject());
      foreach($revisions as $revision) {
        $revision->delete();
      }
      return parent::delete();
    } // delete
	
    /**
    * Return object type name
    *
    * @param void
    * @return string
    */
    function getObjectTypeName() {
      return lang('wiki');
     } // getObjectTypeName
  
    /**
    * Get page name
    * 
    * @return
    */
    function getObjectName() {
      return instance_of($this->new_revision, 'Revision') ? $this->new_revision->getName() : $this->getLatestRevision()->getName();
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
    * This function will return paginated result. Result is an array where first element is 
    * array of returned object and second populated pagination object that can be used for 
    * obtaining and rendering pagination data using various helpers.
    * 
    * Items and pagination array vars are indexed with 0 for items and 1 for pagination
    * because you can't use associative indexing with list() construct
    *
    * @access public
    * @param array $arguments Query argumens (@see find()) Limit and offset are ignored!
    * @param integer $items_per_page Number of items per page
    * @param integer $current_page Current page number
    * @return array
    */
    function paginateRevisions($arguments = array(), $items_per_page = 10, $current_page = 1) {
      if(is_array($arguments) && !isset($arguments['conditions'])){
        $arguments['conditions'] = array('`project_id` = ? AND `page_id` = ?', $this->getProjectId(), $this->getId());
      }
      if(is_array($arguments) && !isset($arguments['order'])){
        $arguments['order'] = '`revision` DESC';
      }
      return Revisions::instance()->paginate($arguments, $items_per_page, $current_page);
    } // paginateRevisions

    //////////////////////////////////////////
    // Locking
    //////////////////////////////////////////
    /**
    * Get the user object for the user which locked this page
    * 
    * Returns null if user DNX or page is not locked
    * 
    * @return
    */
    function getLockedByUser() {
      // Cache the user object
      static $user = null;
      return $this->getLocked() ? 
      // If the page is locked 
      (($user instanceof User) ? 
      // If we have cached the user's object
      $user : 
      // Else find it and cache it
      ($user = Users::findById($this->getLockedById()))) :
      // If the page is not locked, return null	
      null; 
    } // getLockedByUser

    /**
    * Answer if the page is locked
    * 
    * @return
    */
    function isLocked() {
      return (bool) $this->getColumnValue('locked');
    } // isLocked

    //////////////////////////////////////////
    // Parenting ;-)
    //////////////////////////////////////////
    /**
    * Return the parent page for this page or false if none
    * 
    * @return
    */
    function getParent() {
      return Wiki::findById($this->getParentId());
    } // getParent

  }
?>