<?php

  /**
  * ProjectFileRevision class
  *
  * @http://www.projectpier.org/
  */
  class ProjectFileRevision extends BaseProjectFileRevision {
  
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
    protected $searchable_columns = array('comment', 'filecontent');
    
    /**
    * Parent file object
    *
    * @var ProjectFile
    */
    private $file;
    
    /**
    * Cached file type object
    *
    * @var FileType
    */
    private $file_type;
    
    /**
    * Cached show thumbnails configuration option
    *
    * @var String
    */
    private $show_thumbnail;

    /**
    * Construct file revision object
    *
    * @param void
    * @return ProjectFileRevision
    */
    function __construct() {
      $this->addProtectedAttribute('file_id', 'file_type_id', 'system_filename', 'thumb_filename', 'revision_number', 'type_string', 'filesize');
      parent::__construct();
      $this->show_thumbnail = (config_option('files_show_thumbnails', '1') == '1');
    } // __construct
    
    /**
    * Return parent file object
    *
    * @param void
    * @return ProjectFile
    */
    function getFile() {
      if (is_null($this->file)) {
        $this->file = ProjectFiles::findById($this->getFileId());
      } // if
      return $this->file;
    } // getFile
    
    /**
    * Return parent project
    *
    * @param void
    * @return Project
    */
    function getProject() {
      if (is_null($this->project)) {
        $file = $this->getFile();
        if ($file instanceof ProjectFile) {
          $this->project = $file->getProject();
        }
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
    * Return file type object
    *
    * @param void
    * @return FileType
    */
    function getFileType() {
      if (is_null($this->file_type)) {
        $this->file_type = FileTypes::findById($this->getFileTypeId());
      } // if
      return $this->file_type;
    } // getFileType

    /**
    * Return content of this file
    *
    * @param void
    * @return string
    */
    function getFilePath() {
      return FileRepository::getFilePath($this->getRepositoryId());
    } // getFilePath

    /**
    * Return value of 'filename' field
    *
    * @access public
    * @param void
    * @return string 
    */
    function getFilename() {
      $filename = $this->getColumnValue('filename');
      if (!$filename) {
         $filename = $this->getFile()->getFilename();
      }
      return $filename;
    } // getFilename()
    

    
    /**
    * Return content of this file
    *
    * @param void
    * @return string
    */
    function getFileContent() {
      try {
        return FileRepository::getFileContent($this->getRepositoryId());
      } catch(Exception $e) {
        return '';
      }
    } // getFileContent
    
    // ---------------------------------------------------
    //  Utils
    // ---------------------------------------------------
    
    /**
    * This function will return content of specific searchable column. It uses inherited
    * behaviour for all columns except for `filecontent`. In case of this column function
    * will return file content if file type is marked as searchable (text documents, office 
    * documents etc).
    *
    * @param string $column_name Column name
    * @return string
    */
    function getSearchableColumnContent($column_name) {
      if ($column_name == 'filecontent') {

        // Unknown type or type not searchable
        $file_type = $this->getFileType();
        if (!($file_type instanceof FileType) || !$file_type->getIsSearchable()) {
          return null;
        } // if
        
        $content = $this->getFileContent();
        if (strlen($content) <= MAX_SEARCHABLE_FILE_SIZE) {
          return $content;
        }
        
      } else {
        return parent::getSearchableColumnContent($column_name);
      } // if
    } // getSearchableColumnContent
    
    /**
    * Create image thumbnail. This function will return true on success, false otherwise
    *
    * @param void
    * @return boolean
    */
    protected function createThumb() {
      do {
        $source_file = CACHE_DIR . '/' . sha1(uniqid(rand(), true));
      } while (is_file($source_file));
      
      if (!file_put_contents($source_file, $this->getFileContent()) || !is_readable($source_file)) {
        return false;
      } // if
      
      do {
        $temp_file = CACHE_DIR . '/' . sha1(uniqid(rand(), true));
      } while (is_file($temp_file));
      
      try {
        Env::useLibrary('simplegd');
        
        $image = new SimpleGdImage($source_file);
        $thumb = $image->scale(100, 100, SimpleGdImage::BOUNDARY_DECREASE_ONLY, false);
        $thumb->saveAs($temp_file, IMAGETYPE_PNG);
        
        $public_filename = PublicFiles::addFile($temp_file, 'png');
        if ($public_filename) {
          $this->setThumbFilename($public_filename);
          $this->save();
        } // if
        
        $result = true;
      } catch(Exception $e) {
        $result = false;
      } // try
      
      @unlink($source_file);
      @unlink($temp_file);
      return $result;
    } // createThumb
    
    // ---------------------------------------------------
    //  URLs
    // ---------------------------------------------------
    
    /**
    * Return revision details URL
    *
    * @param void
    * @return string
    */
    function getDetailsUrl() {
      $file = $this->getFile();
      return $file instanceof ProjectFile ? $file->getDetailsUrl() . '#revision' . $this->getId() : null;
    } // getDetailsUrl
    
    /**
    * Show download URL
    *
    * @param void
    * @return string
    */
    function getDownloadUrl() {
      return get_url('files', 'download_revision', array('id' => $this->getId(), 'active_project' => $this->getProjectId()));
    } // getDownloadUrl
    
    /**
    * Return edit revision URL
    *
    * @param void
    * @return string
    */
    function getEditUrl() {
      return get_url('files', 'edit_revision', array('id' => $this->getId(), 'active_project' => $this->getProjectId()));
    } // getEditUrl
    
    /**
    * Return delete revision URL
    *
    * @param void
    * @return string
    */
    function getDeleteUrl() {
      return get_url('files', 'delete_revision', array('id' => $this->getId(), 'active_project' => $this->getProjectId()));
    } // getDeleteUrl
    
    /**
    * Return thumb URL
    *
    * @param void
    * @return string
    */
    function getThumbUrl() {
      if ($this->getThumbFilename() == '') {
        $this->createThumb();
      } // if
      
      if (trim($this->getThumbFilename())) {
        return PublicFiles::getFileUrl($this->getThumbFilename());
      } else {
        return '';
      } // if
    } // getThumbUrl
    
    /**
    * Return URL of file type icon. If we are working with image file type this function
    * will return thumb URL if it success in creating it
    *
    * @param void
    * @return string
    */
    function getTypeIconUrl() {
      $file_type = $this->getFileType();
      if ($file_type instanceof FileType) {
        if ($this->show_thumbnail && $file_type->getIsImage()) {
          $thumb_url = $this->getThumbUrl();
          
          if (trim($thumb_url)) {
            return $thumb_url; // we have the thumb!
          } // if
        } // if
      } // if
      $icon_file = $file_type instanceof FileType ? $file_type->getIcon() : 'unknown.png';
      return get_image_url("filetypes/$icon_file");
    } // getTypeIconUrl
    
    // ---------------------------------------------------
    //  Permissions
    // ---------------------------------------------------
    
    /**
    * Check CAN_MANAGE_DOCUMENS permission
    *
    * @access public
    * @param User $user
    * @return boolean
    */
    function canManage(User $user) {
      if (!$user->isProjectUser($this->getProject())) {
        return false;
      }
      return $user->getProjectPermission($this->getProject(), PermissionManager::CAN_MANAGE_FILES);
    } // canManage
    
    /**
    * Empty implementation of abstract method. Message determins if user have view access
    *
    * @param void
    * @return boolean
    */
    function canView(User $user) {
      //if (!$user->isProjectUser($this->getProject())) return false;
      if ($this->isPrivate() && !$user->isMemberOfOwnerCompany()) {
        return false;
      }
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
      }
      if (!$this->canManage(logged_user())) {
        return false; // user don't have access to this project or can't manage files
      }
      return false;
    } // canEdit
    
    /**
    * Check if specific user can delete this comment
    *
    * @access public
    * @param User $user
    * @return boolean
    */
    function canDelete(User $user) {
      if ($user->isAdministrator()) {
        return true; // give access to admin
      }
      if (!$user->isProjectUser($this->getProject())) {
        return false;
      } // if
      
      $file = $this->getFile();
      if (!($file instanceof ProjectFile)) {
        return false;
      } // if
      
      if ($file->countRevisions() == 1) {
        return false; // this is the only file revision! it can't be deleted!
      } // if
      
      return false;
    } // canDelete
    
    // ---------------------------------------------------
    //  System
    // ---------------------------------------------------
    
    /**
    * Validate before save. This one is used to keep the data in sync. Users
    * can't create revisions directly...
    *
    * @param array $errors
    * @return null
    */
    function validate(&$errors) {
      if (!$this->validatePresenceOf('file_id')) {
        $errors[] = lang('file revision file_id required');
      } // if
      if (!$this->validatePresenceOf('repository_id')) {
        $errors[] = lang('file revision filename required');
      } // if
      if (!$this->validatePresenceOf('type_string')) {
        $errors[] = lang('file revision type_string required');
      } // if
    } // validate
    
    /**
    * Delete from DB and from the disk
    *
    * @param void
    * @return boolean
    */
    function delete() {
      FileRepository::deleteFile($this->getRepositoryId());
      $this->deleteThumb(false);
      return parent::delete();
    } // delete
    
    /**
    * Delete thumb
    *
    * @param boolean $save
    * @return boolean
    */
    function deleteThumb($save = true) {
      $thumb_filename = $this->getThumbFilename();
      if ($thumb_filename) {
        $this->setThumbFilename('');
        PublicFiles::deleteFile($this->getThumbFilename());
      } // if
      
      if ($save) {
        return $this->save();
      } // if
      
      return true;
    } // deleteThumb
    
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
      $file = $this->getFile();
      return $file instanceof ProjectFile ? $file->getObjectName() . ' revision #' . $this->getRevisionNumber() : 'Unknown file revision';
    } // getObjectName
    
    /**
    * Return object type name
    *
    * @param void
    * @return string
    */
    function getObjectTypeName() {
      return lang('file revision');
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
    
  } // ProjectFileRevision 

?>