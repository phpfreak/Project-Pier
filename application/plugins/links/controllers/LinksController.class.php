<?php

  /**
  * Links Controller
  *
  * @http://www.activeingredient.com.au
  */
  class LinksController extends ApplicationController {
  
    /**
    * Construct the LinksController
    *
    * @access public
    * @param void
    * @return LinksController
    */
    function __construct() {
      parent::__construct();
      prepare_company_website_controller($this, 'project_website');
    } // __construct
    
    /**
    * Show links for project
    *
    * @access public
    * @param void
    * @return null
    */
    function index() {
      trace(__FILE__,'index()');
      $this->addHelper('textile');
      $this->addHelper('files', 'files');
      $links = ProjectLinks::getAllProjectLinks(active_project());
      tpl_assign('current_folder', null);
      tpl_assign('order', null);
      tpl_assign('page', null);
      tpl_assign('links', $links);
      tpl_assign('folders', active_project()->getFolders());
      //tpl_assign('folder_tree', ProjectFolders::getProjectFolderTree(active_project())); 
      tpl_assign('folder_tree', array() ); 
      $this->setSidebar(get_template_path('index_sidebar', 'files'));    
    } // index
    
    function add_link() {
      
      $this->setTemplate('edit_link');
      $this->addHelper('files', 'files');
      
      if (!ProjectLink::canAdd(logged_user(), active_project())) {
        flash_error(lang('no access permissions'));
        $this->redirectTo('links','index');
      } // if
      
      $project_link = new ProjectLink();
      $project_link_data = array_var($_POST, 'project_link');
      
      if (is_array(array_var($_POST, 'project_link'))) {
        $project_link->setFromAttributes($project_link_data);
        $project_link->setCreatedById(logged_user()->getId());
        $project_link->setProjectId(active_project()->getId());
        
        try {
          DB::beginWork();
          $project_link->save();
          ApplicationLogs::createLog($project_link, active_project(), ApplicationLogs::ACTION_ADD);
          if (plugin_active('tags')) {
            $project_link->setTagsFromCSV($project_link_data['tags']);
          }
          DB::commit();
          
          flash_success(lang('success add link'));
          $this->redirectTo('links');
        } catch(Exception $e) {
          DB::rollback();
          tpl_assign('error', $e);
        } // try
      }
      
      tpl_assign('project_link', $project_link);
      tpl_assign('project_link_data', $project_link_data);

    } // add_link
    
    /**
    * Edit project link
    *
    * @param void
    * @return null
    */
    function edit_link() {
      
      $project_link = ProjectLinks::findById(get_id());
      
      if (!ProjectLink::canEdit(logged_user())) {
        flash_error(lang('no access permissions'));
        $this->redirectTo('links','index');
      } // if
      
      if (!($project_link instanceof ProjectLink)) {
        flash_error(lang('project link dnx'));
        $this->redirectTo('links');
      } // if
      
      $this->setTemplate('edit_link');
      $this->addHelper('files', 'files');

      $project_link_data = array_var($_POST, 'project_link');
      
      if (!is_array($project_link_data)) {
        $tag_names = plugin_active('tags') ? $project_link->getTagNames() : '';
        $project_link_data = array(
          'title'       => $project_link->getTitle(),
          'url'         => $project_link->getUrl(),
          'description' => $project_link->getDescription(),
          'folder_id'   => $project_link->getFolderId(),
          'tags' => is_array($tag_names) ? implode(', ', $tag_names) : '',
        ); // array
      } // if

      tpl_assign('project_link_data', $project_link_data);
      tpl_assign('project_link', $project_link);
      
      if (is_array(array_var($_POST, 'project_link'))) {
        $project_link->setFromAttributes($project_link_data);
        $project_link->setProjectId(active_project()->getId());
        
        try {
          DB::beginWork();
          $project_link->save();
          ApplicationLogs::createLog($project_link, active_project(), ApplicationLogs::ACTION_EDIT);
          if (plugin_active('tags')) {
            $project_link->setTagsFromCSV($project_link_data['tags']);
          }
          DB::commit();
          
          flash_success(lang('success edit link'));
          $this->redirectTo('links');
        } catch(Exception $e) {
          DB::rollback();
          tpl_assign('error', $e);
        } // try
      }
      tpl_assign('project_link', $project_link);
      tpl_assign('project_link_data', $project_link_data);
    } // edit_link
    
    /**
    * Delete project link
    *
    * @param void
    * @return null
    */
    function delete_link() {
      
      $project_link = ProjectLinks::findById(get_id());
      
      if (!ProjectLink::canEdit(logged_user())) {
        flash_error(lang('no access permissions'));
        $this->redirectTo('links','index');
      } // if
      
      if (!($project_link instanceof ProjectLink)) {
        flash_error(lang('project link dnx'));
        $this->redirectTo('links');
      } // if
      
      try {
        DB::beginWork();
        $project_link->delete();
        ApplicationLogs::createLog($project_link, active_project(), ApplicationLogs::ACTION_DELETE);
        DB::commit();
        
        flash_success(lang('success delete link', $project_link->getTitle()));
        $this->redirectTo('links');
      } catch(Exception $e) {
        DB::rollback();
        tpl_assign('error', $e);
      } // try
      
    } // delete_link

    /**
    * Show and process edit link logo form
    *
    * @param void
    * @return null
    */
    function edit_logo() {
      $link = ProjectLinks::findById(get_id());
      if (!($link instanceof ProjectLink)) {
        flash_error(lang('link dnx'));
        $this->redirectToReferer(get_url('links', 'index'));
      } // if

      if (!$link->canEdit(logged_user())) {
        flash_error(lang('no access permissions'));
        $this->redirectToReferer(get_url('links'));
      } // if

      if (!function_exists('imagecreatefromjpeg')) {
        flash_error(lang('no image functions'));
        $this->redirectTo('links');
      } // if

      $this->setTemplate('edit_logo');
      //$this->setLayout('administration');
      
      tpl_assign('link', $link);
      
      $logo = array_var($_FILES, 'new_logo');

      if (is_array($logo)) {
        try {
          $uploaded_file_size = array_var($logo, 'size', 0);
          if ($uploaded_file_size == 0) {
            $x1 = 0 + array_var($_POST, 'x1');
            $y1 = 0 + array_var($_POST, 'y1');
            $x2 = 0 + array_var($_POST, 'x2');
            $y2 = 0 + array_var($_POST, 'y2');
            $url = $link->getUrl();
            if (!string_begins_with($url, 'http://')) $url = 'http://' . $url;
            //die("$x1 $y1 $x2 $y2 $url");
            $img_data = get_content_from_url('wimg.ca', 80, $url);
            if ($img_data) {
              $src_img = imagecreatefromstring($img_data);
              $dst_img = imagecreatetruecolor(50, 50);
              imagecopyresized($dst_img, $src_img, 0, 0, $x1, $y1, 50, 50, abs($x2-$x1), abs($y2-$y1) );

              // Output and free from memory
              //header('Content-Type: image/png');
              $tempname = tempnam(ROOT . '/tmp/', 'links-snapshot' );
              imagepng($dst_img, $tempname);

              $logo["name"]='links-snapshot';
              $logo["tmp_name"]=$tempname;
              $logo["type"]='image/png';
              $logo["size"]='1';

              imagedestroy($dst_img);
              imagedestroy($src_img);
            }
          } else {
            move_uploaded_file($logo["tmp_name"], ROOT . "/tmp/" . $logo["name"]);
            $logo["tmp_name"] = ROOT . "/tmp/" . $logo["name"];
            if (!isset($logo['name']) || !isset($logo['type']) || !isset($logo['size']) || !isset($logo['tmp_name']) || !is_readable($logo['tmp_name'])) {
              throw new InvalidUploadError($logo, lang('error upload file'));
            } // if
          }
          
          $valid_types = array('image/jpg', 'image/jpeg', 'image/pjpeg', 'image/gif', 'image/png');
          $max_width   = config_option('max_logo_width', 50);
          $max_height  = config_option('max_logo_height', 50);
          
          if (!in_array($logo['type'], $valid_types) || !($image = getimagesize($logo['tmp_name']))) {
            throw new InvalidUploadError($logo, lang('invalid upload type', 'JPG, GIF, PNG'));
          } // if
          
          $old_file = $link->getLogoPath();
          
          DB::beginWork();
          
          if (!$link->setLogo($logo['tmp_name'], $max_width, $max_height, true)) {
            DB::rollback();
            flash_error(lang('error edit link logo', $e));
            $this->redirectToUrl($link->getEditLogoUrl());
          } // if
          
          ApplicationLogs::createLog($link, active_project(), ApplicationLogs::ACTION_EDIT);
          
          flash_success(lang('success edit logo'));
          DB::commit();
          
          if (is_file($old_file)) {
            @unlink($old_file);
          } // uf
          
        } catch(Exception $e) {
          flash_error(lang('error edit logo', $e));
          DB::rollback();
        } // try
        
        $this->redirectToUrl($link->getEditLogoUrl());
      } // if
    } // edit_logo
    
    /**
    * Delete link logo
    *
    * @param void
    * @return null
    */
    function delete_logo() {
      if (!logged_user()->isAdministrator(owner_company())) {
        flash_error(lang('no access permissions'));
        $this->redirectTo('links', 'index');
      } // if
      
      $link = links::findById(get_id());
      if (!($link instanceof link)) {
        flash_error(lang('link dnx'));
        $this->redirectToReferer(get_url('links', 'index'));
      } // if
      
      try {
        DB::beginWork();
        $link->deleteLogo();
        $link->save();
        ApplicationLogs::createLog($link, active_project(), ApplicationLogs::ACTION_EDIT);
        DB::commit();
        
        flash_success(lang('success delete logo'));
      } catch(Exception $e) {
        DB::rollback();
        flash_error(lang('error delete logo'));
      } // try
      
      $this->redirectToUrl($link->getEditLogoUrl());
    } // delete_logo
        
  } // LinksController

?>