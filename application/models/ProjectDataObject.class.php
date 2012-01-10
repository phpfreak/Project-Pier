<?php

  /**
  * Abstract class that implements methods that share all project objects (tags manipulation, 
  * retrieving data about object creator etc.)
  * 
  * Project object is application object with few extra functions
  *
  * @version 1.0
  * @http://www.projectpier.org/
  */
  abstract class ProjectDataObject extends ApplicationDataObject {
    
    /**
    * Cached parent project reference
    *
    * @var Project
    */
    protected $project = null;
    
    // ---------------------------------------------------
    //  Tags
    // ---------------------------------------------------
    
    /**
    * If true this object will not throw object not taggable exception and will make tag methods available
    *
    * @var boolean
    */
    protected $is_taggable = false;

    // ---------------------------------------------------
    //  Subscribers
    // ---------------------------------------------------
    
    /**
    * Mark this object as subscribable
    *
    * @var boolean
    */
    protected $is_subscribable = false;
        
    // ---------------------------------------------------
    //  Search
    // ---------------------------------------------------
    
    /**
    * If this object is searchable search related methods will be unlocked for it. Else this methods will 
    * throw exceptions pointing that this object is not searchable
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
    
    // ---------------------------------------------------
    //  Comments
    // ---------------------------------------------------
    
    /**
    * Set this property to true if you want to let users post comments on this objects
    *
    * @var boolean
    */
    protected $is_commentable = false;
    
    /**
    * Cached array of all comments
    *
    * @var array
    */
    protected $all_comments;
    
    /**
    * Cached array of comments
    *
    * @var array
    */
    protected $comments;
    
    /**
    * Number of all comments
    *
    * @var integer
    */
    protected $all_comments_count;
    
    /**
    * Number of comments. If user is not member of owner company private comments 
    * will be excluded from the count
    *
    * @var integer
    */
    protected $comments_count;
    
    // ---------------------------------------------------
    //  Files
    // ---------------------------------------------------
    
    /**
    * Mark this object as file container (in this case files can be attached to 
    * this object)
    *
    * @var boolean
    */
    protected $is_file_container = false;
    
    /**
    * Array of all attached files
    *
    * @var array
    */
    protected $all_attached_files;
    
    /**
    * Cached array of attached files (filtered by users access permissions)
    *
    * @var array
    */
    protected $attached_files;
    
    /**
    * Return owner project. If project_id field does not exists NULL is returned
    *
    * @param void
    * @return Project
    */
    function getProject() {
      if ($this->isNew() && function_exists('active_project')) {
        return active_project();
      } // if
      
      if (is_null($this->project)) {
        if ($this->columnExists('project_id')) {
          $this->project = Projects::findById($this->getProjectId());
        }
      } // if
      return $this->project;
    } // getProject
    
    // ---------------------------------------------------
    //  Permissions
    // ---------------------------------------------------
    
    /**
    * Can $user view this object
    *
    * @param User $user
    * @return boolean
    */
    abstract function canView(User $user);
    
    /**
    * Check if this user can add a new object to this project. This method is called statically
    *
    * @param User $user
    * @param Project $project
    * @return boolean
    */
    abstract function canAdd(User $user, Project $project);
    
    /**
    * Returns true if this user can edit this object
    *
    * @param User $user
    * @return boolean
    */
    abstract function canEdit(User $user);
    
    /**
    * Returns true if this user can delete this object
    *
    * @param User $user
    * @return boolean
    */
    abstract function canDelete(User $user);
    
    /**
    * Check if specific user can comment on this object
    *
    * @param User $user
    * @return boolean
    * @throws InvalidInstanceError if $user is not instance of User or AnonymousUser
    */
    function canComment($user) {
      if (!($user instanceof User) && !($user instanceof AnonymousUser)) {
        throw new InvalidInstanceError('user', $user, 'User or AnonymousUser');
      } // if
      
      // Access permissions
      if ($user instanceof User) {
        if ($user->isAdministrator()) return true; // admins have all the permissions
        $project = $this->getProject();
        if (!($project instanceof Project)) {
          return false;
        }
        if (!$user->isProjectUser($project)) {
          return false; // not a project member
        }
      } // if
      
      if (!$this->isCommentable()) {
        return false;
      }
      if ($this->columnExists('comments_enabled') && !$this->getCommentsEnabled()) {
        return false;
      }
      if ($user instanceof AnonymousUser) {
        if ($this->columnExists('anonymous_comments_enabled') && !$this->getAnonymousCommentsEnabled()) {
          return false;
        }
      } // if
      return true;
    } // canComment
    
    /**
    * Returns true if user can attach file to this object
    *
    * @param User $user
    * @param Project $project
    * @return boolean
    */
    function canAttachFile(User $user, Project $project) {
      if (!$this->isFileContainer()) {
        return false;
      }
      if ($this->isNew()) {
        return $user->getProjectPermission($project, PermissionManager::CAN_UPLOAD_FILES);
      } else {
        return $this->canEdit($user);
      } // if
    } // canAttachFile
    
    /**
    * Check if $user can detach $file from this object
    *
    * @param User $user
    * @param ProjectFile $file
    * @return boolean
    */
    function canDetachFile(User $user, ProjectFile $file) {
      return $this->canEdit($user);
    } // canDetachFile
    
    // ---------------------------------------------------
    //  Private
    // ---------------------------------------------------
    
    /**
    * Returns true if this object is private, false otherwise
    *
    * @param void
    * @return boolean
    */
    function isPrivate() {
      if ($this->columnExists('is_private')) {
        return $this->getIsPrivate();
      } else {
        return false;
      } // if
    } // isPrivate
    
    // ---------------------------------------------------
    //  Tags
    // ---------------------------------------------------
    
    /**
    * Returns true if this project is taggable
    *
    * @param void
    * @return boolean
    */
    function isTaggable() {
      return $this->is_taggable;
    } // isTaggable
    
    /**
    * Return tags for this object
    *
    * @param void
    * @return array
    */
    function getTags() {
      if (!$this->isTaggable()) {
        throw new Error('Object not taggable');
      }
      return Tags::getTagsByObject($this, get_class($this->manager()));
    } // getTags
    
    /**
    * Return tag names for this object
    *
    * @access public
    * @param void
    * @return array
    */
    function getTagNames() {
      if (!$this->isTaggable()) {
        throw new Error('Object not taggable');
      }
      return Tags::getTagNamesByObject($this, get_class($this->manager()));
    } // getTagNames
    
    /**
    * Explode input string and set array of tags
    *
    * @param string $input
    * @return boolean
    */
    function setTagsFromCSV($input = '') {
      $tag_names = array();
      if (trim($input)) {
        $tag_names = explode(',', $input);
        foreach ($tag_names as $k => $v) {
          if (trim($v) <> '') {
            $tag_names[$k] = trim($v);
          }
        } // foreach
      } // if
      return $this->setTags($tag_names);
    } // setTagsFromCSV
    
    /**
    * Set object tags. This function accepts tags as params
    *
    * @access public
    * @param void
    * @return boolean
    */
    function setTags() {
      if(!plugin_active('tags')) { return null; }
      if (!$this->isTaggable()) {
        throw new Error('Object not taggable');
      }
      $args = array_flat(func_get_args());
      return Tags::setObjectTags($args, $this, get_class($this->manager()), $this->getProject());
    } // setTags
    
    /**
    * Clear object tags
    *
    * @access public
    * @param void
    * @return boolean
    */
    function clearTags() {
      if(!plugin_active('tags')) { return null; }
      if (!$this->isTaggable()) {
        throw new Error('Object not taggable');
      }
      return Tags::clearObjectTags($this, get_class($this->manager()));
    } // clearTags
    
    // ---------------------------------------------------
    //  Searchable
    // ---------------------------------------------------
    
    /**
    * Returns true if this object is searchable (maked as searchable and has searchable columns)
    *
    * @param void
    * @return boolean
    */
    function isSearchable() {
      return $this->is_searchable && is_array($this->searchable_columns) && count($this->searchable_columns);
    } // isSearchable
    
    /**
    * Returns array of searchable columns or NULL if this object is not searchable or there 
    * is no searchable columns
    *
    * @param void
    * @return array
    */
    function getSearchableColumns() {
      if (!$this->isSearchable()) {
        return null;
      }
      return $this->searchable_columns;
    } // getSearchableColumns
    
    /**
    * This function will return content of specific searchable column. It can be overriden in child 
    * classes to implement extra behaviour (like reading file contents for project files)
    *
    * @param string $column_name Column name
    * @return string
    */
    function getSearchableColumnContent($column_name) {
      if (!$this->columnExists($column_name)) {
        throw new Error("Object column '$column_name' does not exist");
      }
      return (string) $this->getColumnValue($column_name);
    } // getSearchableColumnContent
    
    /**
    * Clear search index that is associated with this object
    *
    * @param void
    * @return boolean
    */
    function clearSearchIndex() {
      return SearchableObjects::dropContentByObject($this);
    } // clearSearchIndex
    
    // ---------------------------------------------------
    //  Commentable
    // ---------------------------------------------------
    
    /**
    * Returns true if users can post comments on this object
    *
    * @param void
    * @return boolean
    */
    function isCommentable() {
      return (boolean) $this->is_commentable;
    } // isCommentable
    
    /**
    * Attach comment to this object
    *
    * @param Comment $comment
    * @return Comment
    */
    function attachComment(Comment $comment) {
      $manager_class = get_class($this->manager());
      $object_id = $this->getObjectId();
      
      if (($object_id == $comment->getRelObjectId()) && ($manager_class == $comment->getRelObjectManager())) {
        return true;
      } // if
      
      $comment->setRelObjectId($object_id);
      $comment->setRelObjectManager($manager_class);
      
      $comment->save();
      return $comment;
    } // attachComment
    
    /**
    * Return all comments
    *
    * @param void
    * @return boolean
    */
    function getAllComments() {
      if (is_null($this->all_comments)) {
        $this->all_comments = Comments::getCommentsByObject($this);
      } // if
      return $this->all_comments;
    } // getAllComments
    
    /**
    * Return object comments, filter private comments if user is not member of owner company
    *
    * @param void
    * @return array
    */
    function getComments() {
      if (logged_user()->isMemberOfOwnerCompany()) {
        return $this->getAllComments();
      } // if
      if (is_null($this->comments)) {
        $this->comments = Comments::getCommentsByObject($this, true);
      } // if
      return $this->comments;
    } // getComments
    
    /**
    * This function will return number of all comments
    *
    * @param void
    * @return integer
    */
    function countAllComments() {
      if (is_null($this->all_comments_count)) {
        $this->all_comments_count = Comments::countCommentsByObject($this);
      } // if
      return $this->all_comments_count;
    } // countAllComments
    
    /**
    * Return total number of comments
    *
    * @param void
    * @return integer
    */
    function countComments() {
      if (logged_user()->isMemberOfOwnerCompany()) {
        return $this->countAllComments();
      } // if
      if (is_null($this->comments_count)) {
        $this->comments_count = Comments::countCommentsByObject($this, true);
      } // if
      return $this->comments_count;
    } // countComments
    
    /**
    * Return # of specific object
    *
    * @param Comment $comment
    * @return integer
    */
    function getCommentNum(Comment $comment) {
      $comments = $this->getComments();
      if (is_array($comments)) {
        $counter = 0;
        foreach ($comments as $object_comment) {
          $counter++;
          if ($comment->getId() == $object_comment->getId()) {
            return $counter;
          } // if
        } // foreach
      } // if
      return 0;
    } // getCommentNum
    
    /**
    * Returns true if this function has associated comments
    *
    * @param void
    * @return boolean
    */
    function hasComments() {
      return (boolean) $this->countComments();
    } // hasComments
    
    /**
    * Clear object comments
    *
    * @param void
    * @return boolean
    */
    function clearComments() {
      return Comments::dropCommentsByObject($this);
    } // clearComments
    
    /**
    * This event is triggered when we create a new comments
    *
    * @param Comment $comment
    * @return boolean
    */
    function onAddComment(Comment $comment) {
      return true;
    } // onAddComment
    
    /**
    * This event is triggered when comment that belongs to this object is updated
    *
    * @param Comment $comment
    * @return boolean
    */
    function onEditComment(Comment $comment) {
      return true;
    } // onEditComment
    
    /**
    * This event is triggered when comment that belongs to this object is deleted
    *
    * @param Comment $comment
    * @return boolean
    */
    function onDeleteComment(Comment $comment) {
      return true;
    } // onDeleteComment
    
    /**
    * Per object comments lock. If there is no `comments_enabled` column this
    * function will return false
    *
    * @param void
    * @return boolean
    */
    function commentsEnabled() {
      return $this->columnExists('comments_enabled') ? (boolean) $this->getCommentsEnabled() : false;
    } // commentsEnabled
    
    /**
    * This function will return true if anonymous users can post comments on 
    * this object. If column `anonymous_comments_enabled` does not exists this 
    * function will return true
    *
    * @param void
    * @return boolean
    */
    function anonymousCommentsEnabled() {
      return $this->columnExists('anonymous_comments_enabled') ? (boolean) $this->getAnonymousCommentsEnabled() : false;
    } // anonymousCommentsEnabled
    
    // ---------------------------------------------------
    //  Files
    // ---------------------------------------------------
    
    /**
    * This function will return true if this object can have files attached to it
    *
    * @param void
    * @return boolean
    */
    function isFileContainer() {
      return (boolean) $this->is_file_container;
    } // isFileContainer
    
    /**
    * Attach project file to this object
    *
    * @param ProjectFile $file
    * @return AttachedFiles
    */
    function attachFile(ProjectFile $file) {
      $manager_class = get_class($this->manager());
      $object_id = $this->getObjectId();
      
      $attached_file = AttachedFiles::findById(array(
        'rel_object_manager' => $manager_class,
        'rel_object_id' => $object_id,
        'file_id' => $file->getId(),
      )); // findById
      
      if ($attached_file instanceof AttachedFile) {
        return $attached_file; // Already attached
      } // if
      
      $attached_file = new AttachedFile();
      $attached_file->setRelObjectManager($manager_class);
      $attached_file->setRelObjectId($object_id);
      $attached_file->setFileId($file->getId());
      
      $attached_file->save();
      
      if (!$file->getIsVisible()) {
        $file->setIsVisible(true);
        $file->setExpirationTime(EMPTY_DATETIME);
        $file->save();
      } // if
      
      return $attached_file;
    } // attachFile
    
    /**
    * Return all attached files
    *
    * @param void
    * @return array
    */
    function getAllAttachedFiles() {
      if (is_null($this->all_attached_files)) {
        $this->all_attached_files = AttachedFiles::getFilesByObject($this);
      } // if
      return $this->all_attached_files;
    } // getAllAttachedFiles
    
    /**
    * Return attached files but filter the private ones if user is not a member 
    * of the owner company
    *
    * @param void
    * @return array
    */
    function getAttachedFiles() {
      if (logged_user()->isMemberOfOwnerCompany()) {
        return $this->getAllAttachedFiles();
      } // if
      if (is_null($this->attached_files)) {
        $this->attached_files = AttachedFiles::getFilesByObject($this, true);
      } // if
      return $this->attached_files;
    } // getAttachedFiles
    
    /**
    * Drop all relations with files for this object
    *
    * @param void
    * @return null
    */
    function clearAttachedFiles() {
      return AttachedFiles::clearRelationsByObject($this);
    } // clearAttachedFiles
    
    /**
    * Return attach files url
    *
    * @param void
    * @return string
    */
    function getAttachFilesUrl() {
      return get_url('files', 'attach_to_object', array(
        'manager' => get_class($this->manager()),
        'object_id' => $this->getObjectId(),
        'active_project' => $this->getProject()->getId()
      )); // get_url
    } // getAttachFilesUrl
    
    /**
    * Return detach file URL
    *
    * @param ProjectFile $file
    * @return string
    */
    function getDetachFileUrl(ProjectFile $file) {
      return get_url('files', 'detach_from_object', array(
        'manager' => get_class($this->manager()),
        'object_id' => $this->getObjectId(),
        'file_id' => $file->getId(),
        'active_project' => $this->getProject()->getId()
      )); // get_url
    } // getDetachFileUrl

    /**
    * This event is triggered when we attach new files
    *
    * @param array $files
    * @return boolean
    */
    function onAttachFiles($files) {
      return true;
    } // onAttachFiles
    
    /**
    * This event is triggered when we detach files
    *
    * @param array $files
    * @return boolean
    */
    function onDetachFiles($files) {
      return true;
    } // onDetachFiles
    
    // ---------------------------------------------------
    //  Subscribable
    // ---------------------------------------------------
    
    /**
    * Returns true if users can subscribe to this object
    *
    * @param void
    * @return boolean
    */
    function isSubscribable() {
      return (boolean) $this->is_subscribable;
    } // isSubscribable
    
    // ---------------------------------------------------
    //  System
    // ---------------------------------------------------
    
    /**
    * Save object. If object is searchable this function will add conetent of searchable fields 
    * to search index
    *
    * @param void
    * @return boolean
    */
    function save() {
      $result = parent::save();
      
      // If searchable refresh content in search table
      if ($this->isSearchable()) {
        SearchableObjects::dropContentByObject($this);
        $project = $this->getProject();
        
        foreach ($this->getSearchableColumns() as $column_name) {
          $content = $this->getSearchableColumnContent($column_name);
          if (trim($content) <> '') {
            $searchable_object = new SearchableObject();
            
            $searchable_object->setRelObjectManager(get_class($this->manager()));
            $searchable_object->setRelObjectId($this->getObjectId());
            $searchable_object->setColumnName($column_name);
            $searchable_object->setContent($content);
            if ($project instanceof Project) {
              $searchable_object->setProjectId($project->getId());
            }
            $searchable_object->setIsPrivate($this->isPrivate());
            
            $searchable_object->save();
          } // if
        } // if
        
      } // if
      
      return $result;
    } // save

    /**
    * Copy object
    *
    * @param void
    * @return boolean
    */
    function copy(&$source) {
      if ($source->isTaggable()) {
        //$this->copyTags($source);
      } // if
      if ($source->isSearchable()) {
        //$this->clearSearchIndex();
      } // if
      if ($this->isCommentable()) {
        //$this->copyComments($source);
      } // if
      if ($this->isFileContainer($source)) {
        //$this->copyAttachedFiles($source);
      } // if
      return parent::copy($source);
    } // copy
    
    /**
    * Delete object and drop content from search table
    *
    * @param void
    * @return boolean
    */
    function delete() {
      if ($this->isTaggable()) {
        $this->clearTags();
      } // if
      if ($this->isSearchable()) {
        $this->clearSearchIndex();
      } // if
      if ($this->isCommentable()) {
        $this->clearComments();
      } // if
      if ($this->isFileContainer()) {
        $this->clearAttachedFiles();
      } // if
      return parent::delete();
    } // delete

    /**
    * Return object path (location of the object)
    *
    * @param void
    * @return string
    */
    function getObjectPath() {
      $path = parent::getObjectPath();
      $p = $this->getProject();
      if (!is_null($p)) $path[] = $p->getObjectName();
      return $path;
    } // getObjectPath
    
  } // ProjectDataObject

?>