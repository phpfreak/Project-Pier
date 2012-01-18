<?php

  /**
  * Controller that is responsible for handling project files related requests
  *
  * @version 1.0
  * @http://www.projectpier.org/
  */
  class FilesController extends ApplicationController {
  
    /**
    * Construct the FilesController
    *
    * @access public
    * @param void
    * @return FilesController
    */
    function __construct() {
      parent::__construct();
      prepare_company_website_controller($this, 'project_website');
    } // __construct
    
    /**
    * Show files index page (list recent files)
    *
    * @param void
    * @return null
    */
    function index() {
      $this->addHelper('textile');
      
      $order = array_var($_GET, 'order');
      if (($order <> ProjectFiles::ORDER_BY_NAME) && ($order <> ProjectFiles::ORDER_BY_POSTTIME) && ($order <> ProjectFiles::ORDER_BY_FOLDER)) {
        $order = ProjectFiles::ORDER_BY_FOLDER;
      } // if
      $page = (integer) array_var($_GET, 'page', 1);
      if ((integer) $page < 1) {
        $page = 1;
      }
     
      $this->canGoOn();
      $hide_private = !logged_user()->isMemberOfOwnerCompany();
      $result = ProjectFiles::getProjectFiles(active_project(), null, $hide_private, $order, $page, config_option('files_per_page'), true);
      if (is_array($result)) {
        list($files, $pagination) = $result;
      } else {
        $files = null;
        $pagination = null;
      } // if
      
      tpl_assign('project', active_project());
      tpl_assign('current_folder', null);
      tpl_assign('order', $order);
      tpl_assign('page', $page);
      tpl_assign('files', $files);
      tpl_assign('pagination', $pagination);
      tpl_assign('folders', active_project()->getFolders());
      tpl_assign('folder_tree', ProjectFolders::getProjectFolderTree(active_project())); 
      trace(__FILE__,'index() - important_files');
      tpl_assign('important_files', active_project()->getImportantFiles());
      
      trace(__FILE__,'index() - setSidebar');
      $this->setSidebar(get_template_path('index_sidebar', 'files'));
    } // index
    
    /**
    * List files in specific folder
    *
    * @param void
    * @return null
    */
    function browse_folder() {
      $this->addHelper('textile');
      $this->setTemplate('index'); // use index template
      
      $folder = ProjectFolders::findById(get_id());
      if (!($folder instanceof ProjectFolder)) {
        flash_error(lang('folder dnx'));
        $this->redirectTo('files');
      } // if
      
      $order = array_var($_GET, 'order');
      if (($order <> ProjectFiles::ORDER_BY_NAME) && ($order <> ProjectFiles::ORDER_BY_POSTTIME)) {
        $order = ProjectFiles::ORDER_BY_POSTTIME;
      } // if
      $page = (integer) array_var($_GET, 'page', 1);
      if ((integer) $page < 1) {
        $page = 1;
      }
      
      $this->canGoOn();
      $hide_private = !logged_user()->isMemberOfOwnerCompany();
      $result = ProjectFiles::getProjectFiles(active_project(), $folder, $hide_private, $order, $page, config_option('files_per_page'), true);
      if (is_array($result)) {
        list($files, $pagination) = $result;
      } else {
        $files = null;
        $pagination = null;
      } // if
      
      tpl_assign('current_folder', $folder);
      tpl_assign('order', $order);
      tpl_assign('page', $page);
      tpl_assign('files', $files);
      tpl_assign('pagination', $pagination);
      tpl_assign('important_files', active_project()->getImportantFiles());
      
      $this->setSidebar(get_template_path('index_sidebar', 'files'));
    } // browse_folder
    
    // ---------------------------------------------------
    //  Folders
    // ---------------------------------------------------
    
    /**
    * Add folder
    *
    * @access public
    * @param void
    * @return null
    */
    function add_folder() {
      if (!ProjectFolder::canAdd(logged_user(), active_project())) {
        flash_error(lang('no access permissions'));
        $this->redirectToReferer(get_url('files'));
      } // if
      
      $folder = new ProjectFolder();
      $folder_data = array_var($_POST, 'folder');
      if (!is_array($folder_data)) {
        $folder_data = array(
          'parent_id' => get_id('folder_id'),
          'is_private' => config_option('default_private', false)
        ); // array
      } // if
      
      tpl_assign('folder', $folder);
      tpl_assign('folder_data', $folder_data);
      
      if (is_array(array_var($_POST, 'folder'))) {
        $folder->setFromAttributes($folder_data);
        $folder->setProjectId(active_project()->getId());
        
        try {
          DB::beginWork();
          $folder->save();
          ApplicationLogs::createLog($folder, active_project(), ApplicationLogs::ACTION_ADD);
          DB::commit();
          
          flash_success(lang('success add folder', $folder->getName()));
          $this->redirectToUrl($folder->getBrowseUrl());
        } catch(Exception $e) {
          DB::rollback();
          tpl_assign('error', $e);
        } // try
      } // if
    } // add_folder
    
    /**
    * Edit folder
    *
    * @access public
    * @param void
    * @return null
    */
    function edit_folder() {
      $this->setTemplate('add_folder');
      
      $folder = ProjectFolders::findById(get_id());
      if (!($folder instanceof ProjectFolder)) {
        flash_error(lang('folder dnx'));
        $this->redirectTo('files');
      } // if
      
      if (!$folder->canEdit(logged_user())) {
        flash_error(lang('no access permissions'));
        $this->redirectToReferer(get_url('files'));
      } // if
      
      $folder_data = array_var($_POST, 'folder');
      if (!is_array($folder_data)) {
        $folder_data = array(
          'name' => $folder->getName(),
          'parent_id' => $folder->getParentId()
        );
      } // if
      
      tpl_assign('folder', $folder);
      tpl_assign('folder_data', $folder_data);
      
      if (is_array(array_var($_POST, 'folder'))) {
        $old_name = $folder->getName();
        
        $folder->setFromAttributes($folder_data);
        $folder->setProjectId(active_project()->getId());
        
        try {
          DB::beginWork();
          $folder->save();
          ApplicationLogs::createLog($folder, active_project(), ApplicationLogs::ACTION_EDIT);
          DB::commit();
          
          flash_success(lang('success edit folder', $old_name));
          $this->redirectToUrl($folder->getBrowseUrl());
        } catch(Exception $e) {
          DB::rollback();
          tpl_assign('error', $e);
        } // try
      } // if
    } // edit_folder
    
    /**
    * Delete folder
    *
    * @access public
    * @param void
    * @return null
    */
    function delete_folder() {
      $this->setTemplate('del_folder');

      $folder = ProjectFolders::findById(get_id());
      if (!($folder instanceof ProjectFolder)) {
        flash_error(lang('folder dnx'));
        $this->redirectTo('files');
      } // if
      
      if (!$folder->canDelete(logged_user())) {
        flash_error(lang('no access permissions'));
        $this->redirectToReferer(get_url('files'));
      } // if

      $delete_data = array_var($_POST, 'deleteFolder');
      tpl_assign('folder', $folder);
      tpl_assign('delete_data', $delete_data);
      
      if (!is_array($delete_data)) {
        $delete_data = array(
          'really' => 0,
          'password' => '',
          ); // array
        tpl_assign('delete_data', $delete_data);
      } else if ($delete_data['really'] == 1) {
        $password = $delete_data['password'];
        if (trim($password) == '') {
          tpl_assign('error', new Error(lang('password value missing')));
          return $this->render();
        }
        if (!logged_user()->isValidPassword($password)) {
          tpl_assign('error', new Error(lang('invalid login data')));
          return $this->render();
        }
      
        try {
          DB::beginWork();
          $folder->delete();
          ApplicationLogs::createLog($folder, active_project(), ApplicationLogs::ACTION_DELETE);
          DB::commit();
          
          flash_success(lang('success delete folder', $folder->getName()));
        } catch(Exception $e) {
          DB::rollback();
          flash_error(lang('error delete folder'));
        } // try
      
        $this->redirectTo('files');
      } else {
        flash_error(lang('error delete folder'));
        $this->redirectToUrl($folder->getDetailsUrl());
      }
    } // delete_folder
    
    // ---------------------------------------------------
    //  Files
    // ---------------------------------------------------
    
    /**
    * Show file details
    *
    * @param void
    * @return null
    */
    function file_details() {
      $this->addHelper('textile');
      
      $file = ProjectFiles::findById(get_id());
      if (!($file instanceof ProjectFile)) {
        flash_error(lang('file dnx'));
        $this->redirectToReferer(get_url('files'));
      } // if
      
      if (!$file->canView(logged_user())) {
        flash_error(lang('no access permissions'));
        $this->redirectToReferer(get_url('files'));
      } // if
      
      $revisions = $file->getRevisions();
      if (!count($revisions)) {
        flash_error(lang('no file revisions in file'));
        $this->redirectToReferer(get_url('files'));
      } // if
      
      $this->canGoOn();
      tpl_assign('file', $file);
      tpl_assign('folder', $file->getFolder());
      tpl_assign('last_revision', $file->getLastRevision());
      tpl_assign('revisions', $revisions);
      
      // This variables are required for the sidebar
      tpl_assign('current_folder', $file->getFolder());
      tpl_assign('order', null);
      tpl_assign('page', null);
      tpl_assign('folders', active_project()->getFolders());
      tpl_assign('folder_tree', ProjectFolders::getProjectFolderTree(active_project()));
      tpl_assign('important_files', active_project()->getImportantFiles());
      
      $this->setSidebar(get_template_path('index_sidebar', 'files'));
    } // file_details
    
    /**
    * Download specific file
    *
    * @param void
    * @return null
    */
    function download_file() {
      trace(__FILE__,'download_file()');
      $inline = (boolean) array_var($_GET, 'inline', false);
      $html = (boolean) array_var($_GET, 'html', false);
      
      trace(__FILE__,'download_file():findById()');
      $file = ProjectFiles::findById(get_id());
      if (!($file instanceof ProjectFile)) {
        flash_error(lang('file dnx'));
        $this->redirectToReferer(get_url('files'));
      } // if
      
      trace(__FILE__,'download_file():canDownload()');
      if (!$file->canDownload(logged_user())) {
        flash_error(lang('no access permissions'));
        $this->redirectToReferer(get_url('files'));
      } // if
      
      trace(__FILE__,'download_file():canGoOn()');
      $this->canGoOn();
      $revision = $file->getLastRevision();
      $this->_download_revision($revision, !$inline, $html);
/*
      $download_name = $revision->getFileName() ? $revision->getFileName() : $file->getFileName();
      trace(__FILE__,"download_file():config_option('file_storage_adapter','fs')");
      if ( 'fs'==config_option('file_storage_adapter','fs') ) {
        $repository_id = $revision->getRepositoryId();
        trace(__FILE__,'download_file():'.$file_id);
        download_contents(FileRepository::getFilePath($repository_id), $revision->getTypeString(), $download_name, $revision->getFileSize(), !$inline, true);
      } else {
        download_contents($file->getFileContent(), $file->getTypeString(), $file->getFilename(), $file->getFileSize(), !$inline);
        //download_contents($revision->getFileContent(), $revision->getTypeString(), $download_name, $file->getFileSize());
      }
*/
      die();
    } // download_file
    
    /**
    * Download specific revision
    *
    * @param void
    * @return null
    */
    function download_revision() {
      trace(__FILE__,'download_revision()');
      $inline = (boolean) array_var($_GET, 'inline', false);
      $html = (boolean) array_var($_GET, 'html', false);

      $revision = ProjectFileRevisions::findById(get_id());
      if (!($revision instanceof ProjectFileRevision)) {
        flash_error(lang('file revision dnx'));
        $this->redirectToReferer(get_url('files'));
      } // if
      
      $file = $revision->getFile();
      if (!($file instanceof ProjectFile)) {
        flash_error(lang('file dnx'));
        $this->redirectToReferer(get_url('files'));
      } // if
      
      if (!($revision->canDownload(logged_user()))) {
        flash_error(lang('no access permissions'));
        $this->redirectToReferer(get_url('files'));
      } // if
      
      $this->canGoOn();

      $this->_download_revision($revision, !$inline, $html);
/*
      $revision = $file->getLastRevision();
      $download_name = $revision->getFileName() ? $revision->getFileName() : $file->getFileName();
      if ( 'fs'==config_option('file_storage_adapter','fs') ) {
        $repository_id = $revision->getRepositoryId();
        trace(__FILE__,'download_revision():'.$file_id);
        download_contents(FileRepository::getFilePath($repository_id), $revision->getTypeString(), $download_name, $file->getFileSize(), !$inline, true);
      } else {
        download_contents($revision->getFileContent(), $revision->getTypeString(), $download_name, $file->getFileSize());
      }
*/
      die();
    } // download_revision

    /**
    * Download specific revision 
    *
    * @param string $revision_id
    * @return null
    */
    private function _download_revision($revision = null, $inline, $html) {
      trace(__FILE__,"_download_revision(...):");
      if (!($revision instanceof ProjectFileRevision)) {
        flash_error(lang('file revision dnx'));
        $this->redirectToReferer(get_url('files'));
      } // if
      
      $repository_id = $revision->getRepositoryId();
      if ( 'fs'==config_option('file_storage_adapter','fs') ) {
        trace(__FILE__,"_download_revision(...):from fs");
        $is_fs = true;
        $contents = FileRepository::getFilePath($repository_id);
      } else {
        trace(__FILE__,"_download_revision(...):from db");
        $is_fs = false;
        //$contents = &$revision->getFileContent();
        $contents = $repository_id;
      }
      if ($html) {
        echo '<html><img src='.$revision->getDownloadUrl().'></html>'; die();
      }
      trace(__FILE__,"_download_revision($contents, ..., $inline, $is_fs):$repository_id");
      download_contents($contents, $revision->getTypeString(), $revision->getFileName(), $revision->getFileSize(), $inline, $is_fs);
    } // _download_revision
    
    /**
    * Add file
    *
    * @access public
    * @param void
    * @return null
    */
    function add_file() {
      if (!ProjectFile::canAdd(logged_user(), active_project())) {
        flash_error(lang('no access permissions'));
        $this->redirectToReferer(get_url('files'));
      } // if

      $file = new ProjectFile();
      $file_data = array_var($_POST, 'file');
      if (!is_array($file_data)) {
        $file_data = array(
          'folder_id' => get_id('folder_id'),
          'is_private' => config_option('default_private', false)
        ); // array
      } // if
            
      tpl_assign('file', $file);
      tpl_assign('file_data', $file_data);
      
      if (is_array(array_var($_POST, 'file'))) {
        try {
          DB::beginWork();

          $uploaded_file = array_var($_FILES, 'file_file');
          // move uploaded file to folder where I can read and write
          move_uploaded_file($uploaded_file['tmp_name'], ROOT . '/tmp/' . $uploaded_file['name']);
          $uploaded_file['tmp_name'] = ROOT . '/tmp/' . $uploaded_file['name'];
          $file->setFromAttributes($file_data);
          
          if (!logged_user()->isMemberOfOwnerCompany()) {
            $file->setIsPrivate(false);
            $file->setIsImportant(false);
            $file->setCommentsEnabled(true);
            $file->setAnonymousCommentsEnabled(false);
          } // if
          $file->setFilename(array_var($uploaded_file, 'name'));
          $file->setProjectId(active_project()->getId());
          $file->setIsVisible(true);
          $file->save();
          
          if (plugin_active('tags')) {
            $file->setTagsFromCSV(array_var($file_data, 'tags'));
          }
          $revision = $file->handleUploadedFile($uploaded_file, true); // handle uploaded file
          
          ApplicationLogs::createLog($file, active_project(), ApplicationLogs::ACTION_ADD);
          DB::commit();

          // Try to send notifications but don't break submission in case of an error
          // define all the users to be notified - here all project users, from all companies.
          // Restrictions if comment is private is taken into account in newOtherComment()
          try {
            $notify_people = array();
            $project_companies = active_project()->getCompanies();
            foreach ($project_companies as $project_company) {
              $company_users = $project_company->getUsersOnProject(active_project());
              if (is_array($company_users)) {
                foreach ($company_users as $company_user) {
                  if ((array_var($file_data, 'notify_company_' . $project_company->getId()) == 'checked') || (array_var($file_data, 'notify_user_' . $company_user->getId()))) {
                    $notify_people[] = $company_user;
                  } // if
                } // if
              } // if
            } // if

            Notifier::newFile($file, $notify_people); // send notification email...
          } catch(Exception $e) {                  
            Logger::log("Error: Notification failed, " . $e->getMessage(), Logger::ERROR);
          } // try
          
          flash_success(lang('success add file', $file->getFilename()));
          $this->redirectToUrl($file->getDetailsUrl());
        } catch(Exception $e) {
          DB::rollback();

          tpl_assign('error', $e);
          tpl_assign('file', new ProjectFile()); // reset file
          
          // If we uploaded the file remove it from repository
          if (isset($revision) && ($revision instanceof ProjectFileRevision) && FileRepository::isInRepository($revision->getRepositoryId())) {
            FileRepository::deleteFile($revision->getRepositoryId());
          } // if
        } // try
      } // if
    } // add_file


    /**
    * Add revision
    *
    * @access public
    * @param void
    * @return null
    */
    function add_revision() {
      $this->setTemplate('add_revision');

      $file = ProjectFiles::findById(get_id());
      if (!($file instanceof ProjectFile)) {
        flash_error(lang('file dnx'));
        $this->redirectToReferer(get_url('files'));
      } // if
      
      if (!$file->canEdit(logged_user())) {
        flash_error(lang('no access permissions'));
        $this->redirectToReferer(get_url('files'));
      } // if

      $file_data = array_var($_POST, 'file');
      $revision_data = array_var($_POST, 'revision');
      
      tpl_assign('file', $file);
      tpl_assign('file_data', $file_data);
      tpl_assign('revision_data', $revision_data);
      
      if (is_array($revision_data)) {
        try {
          DB::beginWork();
          $uploaded_file = array_var($_FILES, 'file_file');

          //$file->setFilename(array_var($uploaded_file, 'name'));
          //$file->save();
          $revision = $file->handleUploadedFile($uploaded_file, true); // handle uploaded file
          $revision->setComment(array_var($revision_data, 'comment'));
          $revision->save();
          
          ApplicationLogs::createLog($file, active_project(), ApplicationLogs::ACTION_ADD);
          DB::commit();
          
          flash_success(lang('success add revision', $revision->getFilename()));
          $this->redirectToUrl($file->getDetailsUrl());
        } catch(Exception $e) {
          DB::rollback();
          tpl_assign('error', $e);
          tpl_assign('file', new ProjectFile()); // reset file
          
          // If we uploaded the file remove it from repository
          if (isset($revision) && ($revision instanceof ProjectFileRevision) && FileRepository::isInRepository($revision->getRepositoryId())) {
            FileRepository::deleteFile($revision->getRepositoryId());
          } // if
        } // try
      } // if
    } // add_revision
    

    
    /**
    * Edit file
    *
    * @access public
    * @param void
    * @return null
    */
    function edit_file() {
      $this->setTemplate('add_file');
      
      $file = ProjectFiles::findById(get_id());
      if (!($file instanceof ProjectFile)) {
        flash_error(lang('file dnx'));
        $this->redirectToReferer(get_url('files'));
      } // if
      
      if (!$file->canEdit(logged_user())) {
        flash_error(lang('no access permissions'));
        $this->redirectToReferer(get_url('files'));
      } // if
      
      $file_data = array_var($_POST, 'file');
      if (!is_array($file_data)) {
        $tag_names = plugin_active('tags') ? $file->getTagNames() : '';
        $file_data = array(
          'folder_id' => $file->getFolderId(),
          'description' => $file->getDescription(),
          'is_private' => $file->getIsPrivate(),
          'is_important' => $file->getIsImportant(),
          'comments_enabled' => $file->getCommentsEnabled(),
          'anonymous_comments_enabled' => $file->getAnonymousCommentsEnabled(),
          'tags' => is_array($tag_names) && count($tag_names) ? implode(', ', $tag_names) : '',
        ); // array
      } // if
      
      tpl_assign('file', $file);
      tpl_assign('file_data', $file_data);
      
      if (is_array(array_var($_POST, 'file'))) {
        try {
          $old_is_private = $file->isPrivate();
          $old_is_important = $file->getIsImportant();
          $old_comments_enabled = $file->getCommentsEnabled();
          $old_anonymous_comments_enabled = $file->getAnonymousCommentsEnabled();
          
          DB::beginWork();
          $handle_file      = array_var($file_data, 'update_file') == 'checked'; // change file?
          $post_revision    = $handle_file && array_var($file_data, 'version_file_change') == 'checked'; // post revision?
          $revision_comment = $post_revision ? trim(array_var($file_data, 'revision_comment')) : ''; // user comment?
          
          $file->setFromAttributes($file_data);
          
          if (!logged_user()->isMemberOfOwnerCompany()) {
            $file->setIsPrivate($old_is_private);
            $file->setIsImportant($old_is_important);
            $file->setCommentsEnabled($old_comments_enabled);
            $file->setAnonymousCommentsEnabled($old_anonymous_comments_enabled);
          } // if
          $file->save();
          if (plugin_active('tags')) {
            $file->setTagsFromCSV(array_var($file_data, 'tags'));
          }
          $msg_name = basename($file->getFilename());
          if ($handle_file) {
            $file->handleUploadedFile(array_var($_FILES, 'file_file'), $post_revision, $revision_comment);
            $msg_name .= '('.')';
          } // if
          ApplicationLogs::createLog($file, active_project(), ApplicationLogs::ACTION_EDIT);
          DB::commit();
          
          flash_success(lang('success edit file', $msg_name));
          $this->redirectToUrl($file->getDetailsUrl());
        } catch(Exception $e) {
          //@unlink($file->getFilePath());
          DB::rollback();
          tpl_assign('error', $e);
        } // try
      } // if
    } // edit_file

    /**
    * Move message
    *
    * @access public
    * @param void
    * @return null
    */
    function move() {
      $this->setTemplate('move_file');
      
      $file = ProjectFiles::findById(get_id());
      if (!($file instanceof ProjectFile)) {
        flash_error(lang('file dnx'));
        $this->redirectTo('file', 'index');
      } // if
      
      if (!$file->canDelete(logged_user(), active_project())) {
        flash_error(lang('no access permissions'));
        $this->redirectTo('file', 'index');
      } // if
      
      $move_data = array_var($_POST, 'move_data');
      tpl_assign('file', $file);
      tpl_assign('move_data', $move_data);

      if (is_array($move_data)) {
        $target_project_id = $move_data['target_project_id'];
        $target_project = Projects::findById($target_project_id);
        if (!($target_project instanceof Project)) {
          flash_error(lang('project dnx'));
          $this->redirectToUrl($file->getMoveUrl());
        } // if
        if (!$file->canAdd(logged_user(), $target_project)) {
          flash_error(lang('no access permissions'));
          $this->redirectToUrl($file->getMoveUrl());
        } // if
        try {
          DB::beginWork();
          $file->setProjectId($target_project_id);
          $file->save();
          ApplicationLogs::createLog($file, active_project(), ApplicationLogs::ACTION_DELETE);
          ApplicationLogs::createLog($file, $target_project, ApplicationLogs::ACTION_ADD);
          DB::commit();

          flash_success(lang('success move file', $file->getObjectName(), active_project()->getName(), $target_project->getName() ));
        } catch(Exception $e) {
          DB::rollback();
          flash_error(lang('error move file', $e->getMessage()));
        } // try

        $this->redirectToUrl($file->getViewUrl());
      }
    } // move_file
    
    /**
    * Delete file
    *
    * @access public
    * @param void
    * @return null
    */
    function delete_file() {
      $this->setTemplate('del_file');

      $file = ProjectFiles::findById(get_id());
      if (!($file instanceof ProjectFile)) {
        flash_error(lang('file dnx'));
        $this->redirectToReferer(get_url('files'));
      } // if

      if (!$file->canEdit(logged_user())) {
        flash_error(lang('no access permissions'));
        $this->redirectToReferer(get_url('files'));
      } // if

      $delete_data = array_var($_POST, 'deleteFile');
      tpl_assign('file', $file);
      tpl_assign('delete_data', $delete_data);

      if (!is_array($delete_data)) {
        $delete_data = array(
          'really' => 0,
          'password' => '',
          ); // array
        tpl_assign('delete_data', $delete_data);
      } else if ($delete_data['really'] == 1) {
        $password = $delete_data['password'];
        if (trim($password) == '') {
          tpl_assign('error', new Error(lang('password value missing')));
          return $this->render();
        }
        if (!logged_user()->isValidPassword($password)) {
          tpl_assign('error', new Error(lang('invalid login data')));
          return $this->render();
        }
        try {
          DB::beginWork();
          $file->delete();
          ApplicationLogs::createLog($file, $file->getProject(), ApplicationLogs::ACTION_DELETE);
          DB::commit();

          flash_success(lang('success delete file', $file->getFilename()));
        } catch(Exception $e) {
          flash_error(lang('error delete file'));
        } // try

        $this->redirectTo('files');
      } else {
        flash_error(lang('error delete file'));
        $this->redirectToUrl($file->getDetailsUrl());
      }
    } // delete_file
    
    // ---------------------------------------------------
    //  Revisions
    // ---------------------------------------------------
    
    /**
    * Update file revision (comment)
    *
    * @param void
    * @return null
    */
    function edit_revision() {
      $this->setTemplate('edit_revision');
      
      $revision = ProjectFileRevisions::findById(get_id());
      if (!($revision instanceof ProjectFileRevision)) {
        flash_error(lang('file revision dnx'));
        $this->redirectToReferer(get_url('files'));
      } // if
      
      $file = $revision->getFile();
      if (!($file instanceof ProjectFile)) {
        flash_error(lang('file dnx'));
        $this->redirectToReferer(get_url('files'));
      } // if
      
      if (!$revision->canDelete(logged_user())) {
        flash_error(lang('no access permissions'));
        $this->redirectToReferer(get_url('files'));
      } // if
      
      $revision_data = array_var($_POST, 'revision');
      if (!is_array($revision_data)) {
        $revision_data = array(
          'comment' => $revision->getComment(),
        ); // array
      } // if
      
      tpl_assign('revision', $revision);
      tpl_assign('file', $file);
      tpl_assign('revision_data', $revision_data);
      
      if (is_array(array_var($_POST, 'revision'))) {
        try {
          DB::beginWork();
          $revision->setComment(array_var($revision_data, 'comment'));
          $revision->save();
          ApplicationLogs::createLog($revision, $revision->getProject(), ApplicationLogs::ACTION_EDIT, $revision->isPrivate());
          DB::commit();
          
          flash_success(lang('success edit file revision'));
          $this->redirectToUrl($revision->getDetailsUrl());
        } catch(Exception $e) {
          tpl_assign('error', $e);
          DB::rollback();
        } // try
      } // if
    } // edit_file_revision
    
    /**
    * Delete selected revision (if you have proper permissions)
    *
    * @param void
    * @return null
    */
    function delete_revision() {
      $this->setTemplate('del_revision');

      $revision = ProjectFileRevisions::findById(get_id());
      if (!($revision instanceof ProjectFileRevision)) {
        flash_error(lang('file revision dnx'));
        $this->redirectToReferer(get_url('files'));
      } // if
      
      $file = $revision->getFile();
      if (!($file instanceof ProjectFile)) {
        flash_error(lang('file dnx'));
        $this->redirectToReferer(get_url('files'));
      } // if
      
      $all_revisions = $file->getRevisions();
      if (count($all_revisions) == 1) {
        flash_error(lang('cant delete only revision'));
        $this->redirectToReferer($file->getDetailsUrl());
      } // if
      
      if (!$revision->canDelete(logged_user())) {
        flash_error(lang('no access permissions'));
        $this->redirectToReferer(get_url('files'));
      } // if
      
      $delete_data = array_var($_POST, 'deleteFileRevision');
      tpl_assign('file', $file);
      tpl_assign('revision', $revision);
      tpl_assign('delete_data', $delete_data);

      if (!is_array($delete_data)) {
        $delete_data = array(
          'really' => 0,
          'password' => '',
        ); // array
        tpl_assign('delete_data', $delete_data);
      } else if ($delete_data['really'] == 1) {
        $password = $delete_data['password'];
        if (trim($password) == '') {
          tpl_assign('error', new Error(lang('password value missing')));
          return $this->render();
        }
        if (!logged_user()->isValidPassword($password)) {
          tpl_assign('error', new Error(lang('invalid login data')));
          return $this->render();
        }

        try {
          DB::beginWork();
          $revision->delete();
          ApplicationLogs::createLog($revision, $revision->getProject(), ApplicationLogs::ACTION_DELETE);
          DB::commit();

          flash_success(lang('success delete file revision'));
        } catch(Exception $e) {
          DB::rollback();
          flash_error(lang('error delete file revision'));
        } // try

        $this->redirectToUrl($file->getDetailsUrl());
      } else {
        flash_error(lang('error delete file revision'));
        $this->redirectToUrl($file->getDetailsUrl());
      }
    } // delete_file_revision

    // ---------------------------------------------------
    //  Attach / detach
    // ---------------------------------------------------
    
    /**
    * Attach files to the object
    *
    * @param void
    * @return null
    */
    function attach_to_object() {
      $manager_class = array_var($_GET, 'manager');
      $object_id = get_id('object_id');
      
      $object = get_object_by_manager_and_id($object_id, $manager_class);
      if (!($object instanceof ProjectDataObject)) {
        flash_error(lang('no access permissions'));
        $this->redirectToReferer(get_url('dashboard'));
      } // if
      
      $already_attached_files = $object->getAttachedFiles();
      $already_attached_file_ids = null;
      if (is_array($already_attached_files)) {
        $already_attached_file_ids = array();
        foreach ($already_attached_files as $already_attached_file) {
          $already_attached_file_ids[] = $already_attached_file->getId();
        } // foreach
      } // if
      
      $attach_data = array_var($_POST, 'attach');
      if (!is_array($attach_data)) {
        $attach_data = array('what' => 'existing_file');
      } // if
      
      tpl_assign('attach_to_object', $object);
      tpl_assign('attach_data', $attach_data);
      tpl_assign('already_attached_file_ids', $already_attached_file_ids);
      
      if (is_array(array_var($_POST, 'attach'))) {
        $attach_files = array();
          
        if (array_var($attach_data, 'what') == 'existing_file') {
          $file = ProjectFiles::findById(array_var($attach_data, 'file_id'));
          if (!($file instanceof ProjectFile)) {
            flash_error(lang('no files to attach'));
            $this->redirectToUrl($object->getAttachFilesUrl());
          } // if
          $attach_files[] = $file;
        } elseif (array_var($attach_data, 'what') == 'new_file') {
          try {
            $attach_files = ProjectFiles::handleHelperUploads(active_project());
          } catch(Exception $e) {
            flash_error(lang('error upload file'));
            $this->redirectToUrl($object->getAttachFilesUrl());
          } // try
        } // if
        
        if (!is_array($attach_files) || !count($attach_files)) {
          flash_error(lang('no files to attach'));
          $this->redirectToUrl($object->getAttachFilesUrl());
        } // if
        
        try {
          DB::beginWork();
          
          $counter = 0;
          foreach ($attach_files as $attach_file) {
            $object->attachFile($attach_file);
            $counter++;
          } // foreach
          
          DB::commit();
          $object->onAttachFiles($attach_files);
          flash_success(lang('success attach files', $counter));
          $this->redirectToUrl($object->getObjectUrl());
          
        } catch(Exception $e) {
          DB::rollback();
          
          if (array_var($attach_data, 'what') == 'new_file' && count($attach_files)) {
            foreach ($attach_files as $attach_file) {
              $attach_file->delete();
            } // foreach
          } // if
          
          tpl_assign('error', $e);
        } // try
      } // if
    } // attach_to_object
    
    /**
    * Detach file from related object
    *
    * @param void
    * @return null
    */
    function detach_from_object() {
      $manager_class = array_var($_GET, 'manager');
      $object_id = get_id('object_id');
      $file_id = get_id('file_id');
      
      $object = get_object_by_manager_and_id($object_id, $manager_class);
      if (!($object instanceof ProjectDataObject)) {
        flash_error(lang('no access permissions'));
        $this->redirectToReferer(get_url('dashboard'));
      } // if
      
      $file = ProjectFiles::findById($file_id);
      if (!($file instanceof ProjectFile)) {
        flash_error(lang('file dnx'));
        $this->redirectToReferer(get_url('dashboard'));
      } // if
      
      $attached_file = AttachedFiles::findById(array(
        'rel_object_manager' => $manager_class,
        'rel_object_id' => $object_id,
        'file_id' => $file_id,
      )); // findById
      
      if (!($attached_file instanceof AttachedFile)) {
        flash_error(lang('file not attached to object'));
        $this->redirectToReferer(get_url('dashboard'));
      } // if
      
      try {
        DB::beginWork();
        $attached_file->delete();
        DB::commit();
        flash_success(lang('success detach file'));
      } catch(Exception $e) {
        flash_error(lang('error detach file'));
        DB::rollback();
      } // try
      
      $this->redirectToReferer($object->getObjectUrl());
    } // detach_from_object

    /**
    * Restore project file revisions from attributes.php 
    * Use this when table ProjectFileRevisions is empty
    * @param void
    * @return null
    */
    function repair() {

      $attributes = include ROOT . '/upload/attributes.php';
      foreach ($attributes as $k => $v) {

        $files = ProjectFiles::findAll(array(
          'conditions' => array('`filename` = ?', $v['name'])
        )); // findAll
        foreach ($files as $file) {
          $id = $file->getId();
  
          $repository_id = $k;

          $revision = new ProjectFileRevision();
          $revision->setFileId($id);
          $revision->setRepositoryId($repository_id);
          $revision->deleteThumb(false);
          $revision->setFilesize($v['size']);
          $revision->setFilename($v['name']);
          $revision->setTypeString($v['type']);
      
          $extension = get_file_extension(basename($v['name']));
          if (trim($extension)) {
            $file_type = FileTypes::getByExtension($extension);
            if ($file_type instanceof Filetype) {
              $revision->setFileTypeId($file_type->getId());
            } // if
          } // if
      
          $revision->setComment('-- Initial version --');
          $revision->save();

        }
      }
      $this->redirectTo('files', 'index');
    }
  
  } // FilesController

?>