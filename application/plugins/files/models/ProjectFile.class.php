<?php

  /**
  * ProjectFile class
  *
  * @http://www.projectpier.org/
  */
  class ProjectFile extends BaseProjectFile {
    
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
    protected $searchable_columns = array('filename', 'filecontent', 'description');
    
    /**
    * Project file is commentable object
    *
    * @var boolean
    */
    protected $is_commentable = true;
  
    /**
    * Cached parent folder object
    *
    * @var ProjectFolder
    */
    private $folder;
    
    /**
    * Cached file type object
    *
    * @var FileType
    */
    private $file_type;
    
    /**
    * Last revision instance
    *
    * @var ProjectFileRevision
    */
    private $last_revision;
    
    /**
    * Contruct the object
    *
    * @param void
    * @return null
    */
    function __construct() {
      $this->addProtectedAttribute('system_filename', 'filename', 'type_string', 'filesize');
      parent::__construct();
    } // __construct
    
    /**
    * Return parent folder instance
    *
    * @param void
    * @return ProjectFolder
    */
    function getFolder() {
      if (is_null($this->folder)) {
        $this->folder = ProjectFolders::findById($this->getFolderId());
        if (($this->folder instanceof ProjectFolder) && ($this->folder->getProjectId() <> $this->getProjectId())) {
          $this->folder = null;
        } // if
      } // if
      return $this->folder;
    } // getFolder
    
    /**
    * Return parent project instance
    *
    * @param void
    * @return Project
    */
    function xgetProject() {
      if (is_null($this->project)) {
        $this->project = Projects::findById($this->getProjectId());
      } // if
      return $this->project;
    } // getProject
    
    /**
    * Return all file revisions
    *
    * @param void
    * @return array
    */
    function getRevisions($exclude_last = false) {
      if ($exclude_last) {
        $last_revision = $this->getLastRevision();
        if ($last_revision instanceof ProjectFileRevision) {
          $conditions = DB::prepareString('`id` <> ? AND `file_id` = ?', array($last_revision->getId(), $this->getId()));
        }
      } // if
      
      if (!isset($conditions)) {
        $conditions = DB::prepareString('`file_id` = ?', array($this->getId()));
      }
      
      return ProjectFileRevisions::find(array(
        'conditions' => $conditions,
        'order' => '`created_on` DESC'
      )); // find
    } // getRevisions
    
    /**
    * Return the number of file revisions
    *
    * @param void
    * @return integer
    */
    function countRevisions() {
      return ProjectFileRevisions::count(array(
        '`file_id` = ?', $this->getId()
      )); // count
    } // countRevisions
    
    /**
    * Return revision number of last revision. If there is no revisions return 0
    *
    * @param void
    * @return integer
    */
    function getRevisionNumber() {
      $last_revision = $this->getLastRevision();
      return $last_revision instanceof ProjectFileRevision ? $last_revision->getRevisionNumber() : 0;
    } // getRevisionNumber
    
    /**
    * Return last revision of this file
    *
    * @param void
    * @return ProjectFileRevision
    */
    function getLastRevision() {
      if (is_null($this->last_revision)) {
        $this->last_revision = ProjectFileRevisions::findOne(array(
          'conditions' => array('`file_id` = ?', $this->getId()),
          'order' => '`created_on` DESC',
          'limit' => 1,
        )); // findOne
      } // if
      return $this->last_revision;
    } // getLastRevision
    
    /**
    * Return file type object
    *
    * @param void
    * @return FileType
    */
    function getFileType() {
      $revision = $this->getLastRevision();
      return $revision instanceof ProjectFileRevision ? $revision->getFileType() : null;
    } // getFileType

    /**
    * Return URL of file type icon
    *
    * @access public
    * @param void
    * @return string
    */
    function getTypeIconUrl() {
      $last_revision = $this->getLastRevision();
      return $last_revision instanceof ProjectFileRevision ? $last_revision->getTypeIconUrl() : '';
    } // getTypeIconUrl
    
    // ---------------------------------------------------
    //  Revision interface
    // ---------------------------------------------------
    
    /**
    * Return file type ID
    *
    * @param void
    * @return integer
    */
    function getFileTypeId() {
      $revision = $this->getLastRevision();
      return $revision instanceof ProjectFileRevision ? $revision->getFileTypeId() : null;
    } // getFileTypeId
    
    /**
    * Return type string. We need to know mime type when forwarding file 
    * to the client
    *
    * @param void
    * @return string
    */
    function getTypeString() {
      $revision = $this->getLastRevision();
      return $revision instanceof ProjectFileRevision ? $revision->getTypeString() : '';
    } // getTypeString
    
    /**
    * Return file size in bytes
    *
    * @param void
    * @return integer
    */
    function getFileSize() {
      $revision = $this->getLastRevision();
      return $revision instanceof ProjectFileRevision ? $revision->getFileSize() : null;
    } // getFileSize
    
    /**
    * Return file content
    *
    * @param void
    * @return string
    */
    function getFileContent() {
      $revision = $this->getLastRevision();
      return $revision instanceof ProjectFileRevision ? $revision->getFileContent() : null;
    } // getFileContent
    
    // ---------------------------------------------------
    //  Util functions
    // ---------------------------------------------------
    
    /**
    * This function will process uploaded file
    *
    * @param array $uploaded_file
    * @param boolean $create_revision Create new revision or update last one
    * @param string $revision_comment Revision comment, if any
    * @return ProjectFileRevision
    */
    function handleUploadedFile($uploaded_file, $create_revision = true, $revision_comment = '') {
      $revision = null;
      if (!$create_revision) {
        $revision = $this->getLastRevision();
      } // if
      
      if (!($revision instanceof ProjectFileRevision)) {
        $revision = new ProjectFileRevision();
        $revision->setFileId($this->getId());
        $revision->setRevisionNumber($this->getNextRevisionNumber());
        
        if ((trim($revision_comment) == '') && ($this->countRevisions() < 1)) {
          $revision_comment = lang('initial versions');
        } // if
      } // if
      
      $revision->deleteThumb(false); // remove thumb
      
      // We have a file to handle!
      if (!is_array($uploaded_file) || !isset($uploaded_file['name']) || !isset($uploaded_file['size']) || !isset($uploaded_file['type']) || !isset($uploaded_file['tmp_name']) || !is_readable($uploaded_file['tmp_name'])) {
        throw new InvalidUploadError($uploaded_file);
      } // if
      if (isset($uploaded_file['error']) && ($uploaded_file['error'] > UPLOAD_ERR_OK)) {
        throw new InvalidUploadError($uploaded_file);
      } // if

      // http://www.projectpier.org/node/2069
      if (empty($uploaded_file['type'])) {
        $uploaded_file['type'] = 'application/octet-stream';  // TODO get_mime_type_for_filename($uploaded_file['name']);
      }
      
      $repository_id = FileRepository::addFile($uploaded_file['tmp_name'], array('name' => $uploaded_file['name'], 'type' => $uploaded_file['type'], 'size' => $uploaded_file['size']));
      
      $revision->setRepositoryId($repository_id);
      $revision->deleteThumb(false);
      $revision->setFilesize($uploaded_file['size']);
      $revision->setFilename($uploaded_file['name']);
      $revision->setTypeString($uploaded_file['type']);
      
      $extension = get_file_extension(basename($uploaded_file['name']));
      if (trim($extension)) {
        $file_type = FileTypes::getByExtension($extension);
        if ($file_type instanceof Filetype) {
          $revision->setFileTypeId($file_type->getId());
        } // if
      } // if
      
      $revision->setComment($revision_comment);
      $revision->save();
      
      $this->last_revision = $revision; // update last revision
      
      return $revision;
    } // handleUploadedFile
    
    /**
    * Return next revision number
    *
    * @param void
    * @return integer
    */
    protected function getNextRevisionNumber() {
      $last_revision = $this->getLastRevision();
      return $last_revision instanceof ProjectFileRevision ? $last_revision->getRevisionNumber() + 1 : 1;
    } // getNextRevisionNumber
    
    // ---------------------------------------------------
    //  URLs
    // ---------------------------------------------------
    
    /**
    * Return view message URL
    *
    * @access public
    * @param void
    * @return string
    */
    function getViewUrl() {
      return get_url('files', 'file_details', array('id' => $this->getId(), 'active_project' => $this->getProjectId()));
    } // getViewUrl

    /**
    * Return file details URL
    *
    * @param void
    * @return string
    */
    function getDetailsUrl() {
      return get_url('files', 'file_details', array(
        'id' => $this->getId(), 
        'active_project' => $this->getProjectId())
      ); // get_url
    } // getDetailsUrl
    
    /**
    * Return revisions URL
    *
    * @param void
    * @return string
    */
    function getRevisionsUrl() {
      return $this->getDetailsUrl() . '#revisions';
    } // getRevisionsUrl
    
    /**
    * Return comments URL
    *
    * @param void
    * @return string
    */
    function getCommentsUrl() {
      return $this->getDetailsUrl() . '#objectComments';
    } // getCommentsUrl
    
    /**
    * Return file download URL
    *
    * @param void
    * @return string
    */
    function getDownloadUrl() {
      return get_url(
        'files', 
        'download_file', 
        array(
          'id' => $this->getId(), 
          'active_project' => $this->getProjectId()
        )
      ); // get_url
    } // getDownloadUrl
    
    /**
    * Return add revision URL
    *
    * @param void
    * @return string
    */
    function getAddRevisionUrl() {
      return get_url(
        'files', 
        'add_revision', 
        array(
          'id' => $this->getId(), 
          'active_project' => $this->getProjectId()
        )
      ); // get_url
    } // getAddRevisionUrl
    
    /**
    * Return edit file URL
    *
    * @param void
    * @return string
    */
    function getEditUrl() {
      return get_url('files', 'edit_file', array(
        'id' => $this->getId(), 
        'active_project' => $this->getProjectId())
      ); // get_url
    } // getEditUrl
    
    /**
    * Return move file URL
    *
    * @param void
    * @return string
    */
    function getMoveUrl() {
      return get_url('files', 'move', array(
        'id' => $this->getId(), 
        'active_project' => $this->getProjectId())
      ); // get_url
    } // getMoveUrl
    
    /**
    * Return delete file URL
    *
    * @param void
    * @return string
    */
    function getDeleteUrl() {
      return get_url('files', 'delete_file', array(
        'id' => $this->getId(), 
        'active_project' => $this->getProjectId())
      ); // get_url
    } // getDeleteUrl
    
    // ---------------------------------------------------
    //  Permissions
    // ---------------------------------------------------
    
    /**
    * Check CAN_MANAGE_FILES permission
    *
    * @access public
    * @param User $user
    * @return boolean
    */
    function canManage(User $user) {
      trace(__FILE__,'canManage');
      if (!$user->isProjectUser($this->getProject())) {
        return false;
      } // if
      return $user->getProjectPermission($this->getProject(), PermissionManager::CAN_MANAGE_FILES);
    } // canManage
    
    /**
    * Returns value of CAN_UPLOAD_FILES permission
    *
    * @param User $user
    * @param Project $project
    * @return boolean
    */
    function canUpload(User $user, Project $project) {
      trace(__FILE__,'canUpload');
      if (!$user->isProjectUser($project)) {
        return false;
      } // if
      return $user->getProjectPermission($project, PermissionManager::CAN_UPLOAD_FILES);
    } // canUpload
    
    /**
    * Empty implementation of abstract method. Message determins if user have view access
    *
    * @param void
    * @return boolean
    */
    function canView(User $user) {
      if ($this->isPrivate() && !$user->isMemberOfOwnerCompany()) {
        return false;
      } // if
      return true;
    } // canView
    
    /**
    * Returns true if user can download this file
    *
    * @param User $user
    * @return boolean
    */
    function canDownload(User $user) {
      return $this->canView($user);
    } // canDownload
    
    /**
    * Empty implementation of abstract methods. Messages determine does user have
    * permissions to add comment
    *
    * @param void
    * @return null
    */
    function canAdd(User $user, Project $project) {
      return $user->isAdministrator() || ProjectFile::canUpload($user, $project);
    } // canAdd
    
    /**
    * Check if specific user can edit this file
    *
    * @access public
    * @param User $user
    * @return boolean
    */
    function canEdit(User $user) {
      if ($user->isAdministrator()) {
        return true; // give access to admin
      } // if
      if (!$user->isProjectUser($this->getProject())) {
        return false;
      } // if
      if (!$this->canManage($user)) {
        return false; // user don't have access to this project or can't manage files
      } // if
      if ($this->isPrivate() && !$user->isMemberOfOwnerCompany()) {
        return false; // reserved only for members of owner company
      } // if
      return true;
    } // canEdit
    
    /**
    * Returns true if $user can update file options
    *
    * @param User $user
    * @return boolean
    */
    function canUpdateOptions(User $user) {
      return $this->canEdit($user) && $user->isMemberOfOwnerCompany();
    } // canUpdateOptions
    
    /**
    * Check if specific user can delete this comment
    *
    * @access public
    * @param User $user
    * @return boolean
    */
    function canDelete(User $user) {
      if ($user->isAdministrator()) {
        return true;
      } // if
      if (!$user->isProjectUser($this->getProject())) {
        return false;
      } // if
      if (!$this->canManage(logged_user())) {
        return false; // user don't have access to this project or can't manage files
      } // if
      if ($this->isPrivate() && !$user->isMemberOfOwnerCompany()) {
        return false; // reserved only for members of owner company
      } // if
      return true;
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
      if (!$this->validatePresenceOf('filename')) {
        $errors[] = lang('filename required');
      } // if
    } // validate
    
    /**
    * Delete this file and all of its revisions
    *
    * @param void
    * @return boolean
    */
    function delete() {
      $this->clearRevisions();
      $this->clearObjectRelations();
      return parent::delete();
    } // delete
    
    /**
    * Remove all revisions associate with this file
    *
    * @param void
    * @return null
    */
    function clearRevisions() {
      $revisions = $this->getRevisions();
      if (is_array($revisions)) {
        foreach ($revisions as $revision) {
          $revision->delete();
        } // foreach
      } // if
    } // clearRevisions
    
    /**
    * Remove all object relations from the database
    *
    * @param void
    * @return boolean
    */
    function clearObjectRelations() {
      return AttachedFiles::clearRelationsByFile($this);
    } // clearObjectRelations
    
    /**
    * This function will return content of specific searchable column. 
    * 
    * It uses inherited behaviour for all columns except for `filecontent`. In case of this column function will return 
    * file content if file type is marked as searchable (text documents, office documents etc).
    *
    * @param string $column_name
    * @return string
    */
    function getSearchableColumnContent($column_name) {
      if ($column_name == 'filecontent') {
        $file_type = $this->getFileType();
        
        // Unknown type or type not searchable
        if (!($file_type instanceof FileType) || !$file_type->getIsSearchable()) {
          return null;
        } // if
        
        $content = $this->getFileContent();
        if (strlen($content) < MAX_SEARCHABLE_FILE_SIZE) {
          return $content;
        } // if
      } else {
        return parent::getSearchableColumnContent($column_name);
      } // if
    } // getSearchableColumnContent
    
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
      return end(explode('/',$this->getFilename()));
    } // getObjectName
    
    /**
    * Return object type name
    *
    * @param void
    * @return string
    */
    function getObjectTypeName() {
      return lang('file');
    } // getObjectTypeName
    
    /**
    * Return object URl
    *
    * @access public
    * @param void
    * @return string
    */
    function getObjectUrl() {
      return $this->getDetailsurl();
    } // getObjectUrl

    /**
    * Return object path (location of the object)
    *
    * @param void
    * @return string
    */
    function getObjectPath() {
      $f = $this->getFolder();
      if (is_null($f)) return parent::getObjectPath();
      return $f->getObjectPath();
    } // getObjectPath
    
  } // ProjectFile 

?>