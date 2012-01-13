<?php

  /**
  * Internationalization Controller
  *
  */
  class I18nController extends ApplicationController {
  
    /**
    * Construct the I18nController
    *
    * @access public
    * @param void
    * @return I18nController 
    */
    function __construct() {
      parent::__construct();
      prepare_company_website_controller($this, 'administration');
    } // __construct
    
    /**
    * Show locales
    *
    * @access public
    * @param void
    * @return null
    */
    function index() {
      trace(__FILE__,'index()');
      $locales = I18nLocales::getAllLocales();
      tpl_assign('order', null);
      tpl_assign('page', null);
      tpl_assign('locales', $locales);
      //$this->setSidebar(get_template_path('index_sidebar'));    
    } // index
    
    function add_locale() {
      $this->setTemplate('edit_locale');
      
      if (!I18nLocale::canAdd(logged_user())) {
        flash_error(lang('no access permissions'));
        $this->redirectTo('i18n','index');
      } // if
      
      $locale = new I18nLocale();
      $locale_data = array_var($_POST, 'locale');
      
      if (is_array(array_var($_POST, 'locale'))) {
        $locale->setFromAttributes($locale_data);
        
        try {
          DB::beginWork();
          $locale->save();
          ApplicationLogs::createLog($locale, 0, ApplicationLogs::ACTION_ADD);
          if (plugin_active('tags')) {
            //$locale->setTagsFromCSV($locale_data['tags']);
          }
          DB::commit();
          
          flash_success(lang('success add locale'));
          $this->redirectTo('i18n');
        } catch(Exception $e) {
          DB::rollback();
          tpl_assign('error', $e);
          flash_success(lang('error add locale'));
        } // try
      }
      
      tpl_assign('locale', $locale);
      tpl_assign('locale_data', $locale_data);

    } // add_locale
    
    /**
    * Edit locale
    *
    * @param void
    * @return null
    */
    function edit_locale() {
      $locale = I18nLocales::findById(get_id());
      if (!($locale instanceof I18nLocale)) {
        flash_error(lang('locale dnx'));
        $this->redirectTo('i18n', 'index');
      } // if
      
      if (!$locale->canEdit(logged_user())) {
        flash_error(lang('no access permissions'));
        $this->redirectTo('i18n','index');
      } // if
      
      $this->setTemplate('edit_locale');

      $locale_data = array_var($_POST, 'locale');
      if (!is_array($locale_data)) {
        $tag_names = '';
        //$tag_names = plugin_active('tags') ? $locale->getTagNames() : '';
        $locale_data = array(
          'name'          => $locale->getName(),
          'description'   => $locale->getDescription(),
          'language_code' => $locale->getLanguageCode(),
          'country_code'  => $locale->getCountryCode(),
          'editor_id'     => $locale->getEditorId(),
          'tags'          => is_array($tag_names) ? implode(', ', $tag_names) : '',
        ); // array
      } // if

      //tpl_assign('locale_data', $locale_data);
      //tpl_assign('locale', $locale);
      
      if (is_array(array_var($_POST, 'locale'))) {
        $locale->setFromAttributes($locale_data);
        
        try {
          DB::beginWork();
          $locale->save();
          ApplicationLogs::createLog($locale, 0, ApplicationLogs::ACTION_EDIT);
          if (plugin_active('tags')) {
            // tags currently at project level and locale NOT project level
            //$locale->setTagsFromCSV($locale_data['tags']);
          }
          DB::commit();
          
          flash_success(lang('success edit locale'));
          $this->redirectTo('i18n', 'index');
        } catch(Exception $e) {
          DB::rollback();
          tpl_assign('error', $e);
        } // try
      }
      tpl_assign('locale', $locale);
      tpl_assign('locale_data', $locale_data);
    } // edit_locale

    /**
    * Edit values
    *
    * @param void
    * @return null
    */
    function edit_values() {
      $locale = I18nLocales::findById(get_id());
      if (!($locale instanceof I18nLocale)) {
        flash_error(lang('locale dnx'));
        $this->redirectTo('i18n', 'index');
      } // if
      
      if (!$locale->canEdit(logged_user())) {
        flash_error(lang('no access permissions'));
        $this->redirectTo('i18n','index');
      } // if
      
      $this->setTemplate('edit_values');
      tpl_assign('locale', $locale);
      tpl_assign('values', I18nLocaleValues::instance()->getLocaleValues(get_id()));
      //tpl_assign('categories', I18nLocaleValues::instance()->getCategories($locale));
      //$this->setSidebar(get_template_path('index_sidebar'));    
    } // edit_values

    /**
    * Edit value (used in Ajax calls, so die() instead of redirectTo())
    *
    * @param id     format <id>_<column name>
    * @param value  new value
    * @return string
    */
    function edit_value() {
      $id_column = array_var($_POST,'id','_');
      $id_column = explode('_', $id_column);

      $locale_value = I18nLocaleValues::findById($id_column[0]);
      if (!($locale_value instanceof I18nLocaleValue)) {
        die(lang('locale value dnx'));
      } // if
      if (!$locale_value->canEdit(logged_user())) {
        die(lang('no access permissions'));
      } // if
      if ($id_column[1] == 'name') {
        $value = array_var($_POST,'value',$locale_value->Name());
        $locale_value->setName($value);
      }
      if ($id_column[1] == 'description') {
        $value = array_var($_POST,'value',$locale_value->getDescription());
        $locale_value->setDescription($value);
      }

      try {
        DB::beginWork();
        $locale_value->save();
        ApplicationLogs::createLog($locale_value, 0, ApplicationLogs::ACTION_EDIT);
        DB::commit();
        
        die($value);
        //die(lang('success edit locale value'));
      } catch(Exception $e) {
        DB::rollback();
        die(lang('error', $e));
      } // try
    } // edit_value

    /**
    * Load values
    *
    * @param  $_REQUEST['id']
    * @return null
    */
    function load_values() {
      $locale = I18nLocales::findById(get_id());
      if (!($locale instanceof I18nLocale)) {
        flash_error(lang('locale dnx'));
        $this->redirectTo('i18n', 'index');
      } // if
      if (!$locale->canEdit(logged_user())) {
        flash_error(lang('no access permissions'));
        $this->redirectTo('i18n','index');
      } // if
      $this->setTemplate('load_values');

      $load = array_var($_POST, 'load');
      if (!is_array($load)) {
        $load = array(
          'replace'       => false,
        );
      }

      if (is_array(array_var($_POST, 'load'))) {
        try {
          DB::beginWork();
          $replace = (int)$load['replace'];
          if ($load['what']=='locale') {
            $locale->copyValues($load['locale'], $replace);
            ApplicationLogs::createLog($locale, 0, ApplicationLogs::ACTION_EDIT);
          }
          if ($load['what']=='file') {
            $locale->loadValues($load['file'], $replace);
            ApplicationLogs::createLog($locale, 0, ApplicationLogs::ACTION_EDIT);
          }
          DB::commit();
          
          flash_success(lang('success load locale'));
          $this->redirectTo('i18n', 'index');
        } catch(Exception $e) {
          DB::rollback();
          tpl_assign('error', $e);
        } // try
      }
      
      $load['locale']   = $locale;
      $load['locales1'] = I18nLocales::getAllLocales($locale->getId());
      $load['locales2'] = getLocalesFromFileSystem();
      $load['max_time'] = ini_get('max_execution_time');
      tpl_assign('load_data', $load);
    } // load_values
    
    /**
    * Delete locale
    *
    * @param void
    * @return null
    */
    function delete_locale() {
      
      $locale = I18nLocales::findById(get_id());
      if (!($locale instanceof I18nLocale)) {
        flash_error(lang('locale dnx'));
        $this->redirectTo('i18n');
      } // if
      
      if (!$locale->canEdit(logged_user())) {
        flash_error(lang('no access permissions'));
        $this->redirectTo('i18n','index');
      } // if
      
      try {
        DB::beginWork();
        $locale->delete();
        ApplicationLogs::createLog($locale, 0, ApplicationLogs::ACTION_DELETE);
        DB::commit();
        
        flash_success(lang('success delete locale', $locale->getName()));
        $this->redirectTo('i18n');
      } catch(Exception $e) {
        DB::rollback();
        tpl_assign('error', $e);
      } // try
      
    } // delete_locale

    /**
    * Show and process edit locale logo form
    *
    * @param void
    * @return null
    */
    function edit_logo() {
      $locale = I18nLocales::findById(get_id());
      if (!($locale instanceof I18nLocale)) {
        flash_error(lang('locale dnx'));
        $this->redirectToReferer(get_url('i18n', 'index'));
      } // if

      if (!$locale->canEdit(logged_user())) {
        flash_error(lang('no access permissions'));
        $this->redirectToReferer(get_url('i18n'));
      } // if

      if (!function_exists('imagecreatefromjpeg')) {
        flash_error(lang('no image functions'));
        $this->redirectTo('i18n');
      } // if

      $this->setTemplate('edit_logo');
      //$this->setLayout('administration');
      
      tpl_assign('locale', $locale);
      
      $logo = array_var($_FILES, 'new_logo');

      if (is_array($logo)) {
        try {
          move_uploaded_file($logo["tmp_name"], ROOT . "/tmp/" . $logo["name"]);
          $logo["tmp_name"] = ROOT . "/tmp/" . $logo["name"];
          if (!isset($logo['name']) || !isset($logo['type']) || !isset($logo['size']) || !isset($logo['tmp_name']) || !is_readable($logo['tmp_name'])) {
            throw new InvalidUploadError($logo, lang('error upload file'));
          } // if
          
          $valid_types = array('image/jpg', 'image/jpeg', 'image/pjpeg', 'image/gif', 'image/png');
          $max_width   = config_option('max_logo_width', 50);
          $max_height  = config_option('max_logo_height', 50);
          
          if (!in_array($logo['type'], $valid_types) || !($image = getimagesize($logo['tmp_name']))) {
            throw new InvalidUploadError($logo, lang('invalid upload type', 'JPG, GIF, PNG'));
          } // if
          
          $old_file = $locale->getLogoPath();
          
          DB::beginWork();
          
          if (!$locale->setLogo($logo['tmp_name'], $max_width, $max_height, true)) {
            DB::rollback();
            flash_error(lang('error edit locale logo', $e));
            $this->redirectToUrl($locale->getEditLogoUrl());
          } // if
          
          ApplicationLogs::createLog($locale, 0, ApplicationLogs::ACTION_EDIT);
          
          flash_success(lang('success edit logo'));
          DB::commit();
          
          if (is_file($old_file)) {
            @unlink($old_file);
          } // uf
          
        } catch(Exception $e) {
          flash_error(lang('error edit logo', $e));
          DB::rollback();
        } // try
        
        $this->redirectToUrl($locale->getEditLogoUrl());
      } // if
    } // edit_logo
    
    /**
    * Delete locale logo
    *
    * @param void
    * @return null
    */
    function delete_logo() {
      $locale = I18nLocales::findById(get_id());
      if (!($locale instanceof I18nLocale)) {
        flash_error(lang('locale dnx'));
        $this->redirectToReferer(get_url('i18n', 'index'));
      } // if
      
      if (!$locale->canEdit(logged_user())) {
        flash_error(lang('no access permissions'));
        $this->redirectTo('i18n', 'index');
      } // if
      
      try {
        DB::beginWork();
        $locale->deleteLogo();
        $locale->save();
        ApplicationLogs::createLog($locale, 0, ApplicationLogs::ACTION_EDIT);
        DB::commit();
        
        flash_success(lang('success delete logo'));
      } catch(Exception $e) {
        DB::rollback();
        flash_error(lang('error delete logo', $e));
      } // try
      
      $this->redirectToUrl($locale->getEditLogoUrl());
    } // delete_logo
        
  } // I18nLocaleController

?>