<?php

  /**
  * Company controller
  *
  * @version 1.0
  * @http://www.projectpier.org/
  */
  class CompanyController extends ApplicationController {
  
    /**
    * Construct the CompanyController
    *
    * @param void
    * @return CompanyController
    */
    function __construct() {
      parent::__construct();
      prepare_company_website_controller($this, 'administration');
    } // __construct
    
    /**
    * Show company card page
    *
    * @param void
    * @return null
    */
    function card() {
      $this->setLayout('dashboard');
      
      $company = Companies::findById(get_id());
      if (!($company instanceof Company)) {
        flash_error(lang('company dnx'));
        $this->redirectToReferer(ROOT_URL);
      } // if
      
      if (!logged_user()->canSeeCompany($company)) {
        flash_error(lang('no access permissions'));
        $this->redirectToReferer(ROOT_URL);
      } // if
      
      $contacts = $company->getContacts();
      $active_projects = $company->getActiveProjects();
      
      tpl_assign('company', $company);
      tpl_assign('contacts', $contacts);
      tpl_assign('active_projects', $active_projects);
      $this->setSidebar(get_template_path('company_card_sidebar', 'company'));
    } // card
    
    /**
    * View specific company
    *
    * @param void
    * @return null
    */
    function view_client() {
      $this->addHelper('textile');
      $this->setTemplate('view_company');
      
      if (!logged_user()->isAdministrator(owner_company())) {
        flash_error(lang('no access permissions'));
        $this->redirectTo('dashboard');
      } // if
      
      $company = Companies::findById(get_id());
      if (!($company instanceof Company)) {
        flash_error(lang('company dnx'));
        $this->redirectTo('administration');
      } // if
      
      tpl_assign('company', $company);
      tpl_assign('active_projects', Projects::getActiveProjects(Projects::ORDER_BY_NAME));
      tpl_assign('finished_projects', Projects::getFinishedProjects(Projects::ORDER_BY_NAME));
      
      $this->setSidebar(get_template_path('view_client_sidebar', 'company'));
    } // view_client
    
    /**
    * Edit owner company
    *
    * @param void
    * @return null
    */
    function edit() {
      $this->setTemplate('add_company');
      
      if (!logged_user()->isAdministrator(owner_company())) {
        flash_error(lang('no access permissions'));
        $this->redirectTo('dashboard');
      } // if
      
      // Owner company
      $company = owner_company();
      
      $company_data = array_var($_POST, 'company');
      if (!is_array($company_data)) {
        $company_data = array(
          'name' => $company->getName(),
          'timezone' => $company->getTimezone(),
          'email' => $company->getEmail(),
          'homepage' => $company->getHomepage(),
          'address' => $company->getAddress(),
          'address2' => $company->getAddress2(),
          'city' => $company->getCity(),
          'state' => $company->getState(),
          'zipcode' => $company->getZipcode(),
          'country' => $company->getCountry(),
          'phone_number' => $company->getPhoneNumber(),
          'fax_number' => $company->getFaxNumber()
        ); // array
      } // if
      
      tpl_assign('company', $company);
      tpl_assign('company_data', $company_data);
      
      if (is_array(array_var($_POST, 'company'))) {
        $company->setFromAttributes($company_data);
        $company->setClientOfId(0);
        $company->setHomepage(array_var($company_data, 'homepage'));
        
        try {
          DB::beginWork();
          $company->save();
          ApplicationLogs::createLog($company, null, ApplicationLogs::ACTION_EDIT);
          DB::commit();
          
          flash_success(lang('success edit company', $company->getName()));
          $this->redirectTo('administration', 'company');
          
        } catch(Exception $e) {
          DB::rollback();
          tpl_assign('error', $e);
        } // try
      } // if
      
    } // edit
    
    /**
    * Add client
    *
    * @param void
    * @return null
    */
    function add_client() {
      $this->setTemplate('add_company');
      
      if (!logged_user()->isAdministrator(owner_company())) {
        flash_error(lang('no access permissions'));
        $this->redirectTo('dashboard');
      } // if
      
      $company = new Company();
      $company_data = array_var($_POST, 'company');
      if ($company->isNew()) {
        $company_data['timezone'] = owner_company()->getTimezone();
      } // if
      tpl_assign('company', $company);
      tpl_assign('company_data', $company_data);
      
      if (array_var($_POST, 'company')) {
        $company->setFromAttributes($company_data);
        $company->setClientOfId(owner_company()->getId());
        
        try {
          
          DB::beginWork();
          $company->save();
          ApplicationLogs::createLog($company, null, ApplicationLogs::ACTION_ADD);
          DB::commit();
          
          flash_success(lang('success add client', $company->getName()));
          $this->redirectTo('administration', 'clients');
          
        } catch(Exception $e) {
          DB::rollback();
          tpl_assign('error', $e);
        } // try
      } // if
    } // add_client
    
    /**
    * Edit client
    *
    * @param void
    * @return null
    */
    function edit_client() {
      $this->setTemplate('add_company');
      
      if (!logged_user()->isAdministrator(owner_company())) {
        flash_error(lang('no access permissions'));
        $this->redirectTo('dashboard');
      } // if
      
      $company = Companies::findById(get_id());
      if (!($company instanceof Company)) {
        flash_error(lang('client dnx'));
        $this->redirectTo('administration', 'clients');
      } // if
      
      $company_data = array_var($_POST, 'company');
      if (!is_array($company_data)) {
        $company_data = array(
          'name' => $company->getName(),
          'timezone' => $company->getTimezone(),
          'email' => $company->getEmail(),
          'homepage' => $company->getHomepage(),
          'address' => $company->getAddress(),
          'address2' => $company->getAddress2(),
          'city' => $company->getCity(),
          'state' => $company->getState(),
          'zipcode' => $company->getZipcode(),
          'country' => $company->getCountry(),
          'phone_number' => $company->getPhoneNumber(),
          'fax_number' => $company->getFaxNumber()
        ); // array
      } // if
      
      tpl_assign('company', $company);
      tpl_assign('company_data', $company_data);
      
      if (is_array(array_var($_POST, 'company'))) {
        $company->setFromAttributes($company_data);
        $company->setClientOfId(owner_company()->getId());
        $company->setHomepage(array_var($company_data, 'homepage'));
        
        try {
          DB::beginWork();
          $company->save();
          ApplicationLogs::createLog($company, null, ApplicationLogs::ACTION_EDIT);
          DB::commit();
          
          flash_success(lang('success edit client', $company->getName()));
          $this->redirectTo('administration', 'clients');
          
        } catch(Exception $e) {
          DB::rollback();
          tpl_assign('error', $e);
        } // try
      } // if
    } // edit_client
    
    /**
    * Delete client
    *
    * @param void
    * @return null
    */
    function delete_client() {
      $this->setTemplate('del_company');

      if (!logged_user()->isAdministrator(owner_company())) {
        flash_error(lang('no access permissions'));
        $this->redirectTo('dashboard');
      } // if
    
      $company = Companies::findById(get_id());
      if (!($company instanceof Company)) {
        flash_error(lang('client dnx'));
        $this->redirectTo('administration', 'clients');
      } // if
      
      $delete_data = array_var($_POST, 'deleteCompany');
      tpl_assign('company', $company);
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
          $this->render();
        }
        if (!logged_user()->isValidPassword($password)) {
          tpl_assign('error', new Error(lang('invalid login data')));
          $this->render();
        } // if

        try {
          DB::beginWork();
          $company->delete();
          ApplicationLogs::createLog($company, null, ApplicationLogs::ACTION_DELETE);
          DB::commit();

          flash_success(lang('success delete client', $company->getName()));
        } catch(Exception $e) {
          DB::rollback();
          flash_error(lang('error delete client'));
        } // try

        $this->redirectTo('administration', 'clients');
      } else {
        flash_error(lang('error delete client'));
        $this->redirectTo('administration', 'clients');
      }
    } // delete_client
    
    /**
    * Update company permissions
    *
    * @param void
    * @return null
    */
    function update_permissions() {
      if (!logged_user()->isAdministrator(owner_company())) {
        flash_error(lang('no access permissions'));
        $this->redirectTo('dashboard');
      } // if
      
      $company = Companies::findById(get_id());
      if (!($company instanceof Company)) {
        flash_error(lang('company dnx'));
        $this->redirectToReferer(get_url('administration'));
      } // if
      
      if ($company->isOwner()) {
        flash_error(lang('error owner company has all permissions'));
        $this->redirectToReferer(get_url('administration'));
      } // if
      
      $projects = Projects::getAll(Projects::ORDER_BY_NAME);
      if (!is_array($projects) || !count($projects)) {
        flash_error(lang('no projects in db'));
        $this->redirectToUrl($company->getViewUrl());
      } // if
      
      tpl_assign('projects', $projects);
      tpl_assign('company', $company);
      
      if (array_var($_POST, 'submitted') == 'submitted') {
        $counter = 0;
        $logged_user = logged_user(); // reuse...
        
        foreach ($projects as $project) {
          if (!$logged_user->isProjectUser($project)) {
            continue;
          } // if
          
          $new_value = array_var($_POST, 'project_' . $project->getId()) == 'checked';
          $relation = ProjectCompanies::findById(array(
            'project_id' => $project->getId(), 
            'company_id' => $company->getId()
          )); // findById
          $current_value = $relation instanceof ProjectCompany;
          
          try {
            if ($current_value <> $new_value) {
              if ($new_value) {
                $relation = new ProjectCompany();
                $relation->setProjectId($project->getId());
                $relation->setCompanyId($company->getId());
                $relation->save();
              } else {
                $relation->delete();
              } // if
              $counter++;
            } // if
          } catch(Exception $e) {
            die($e->__toString());
          } // if
        } // foreach
        
        flash_success(lang('success update company permissions', $counter));
        $this->redirectToUrl($company->getViewUrl());
      } // if
    } // update_permissions
    
    /**
    * Show and process edit company logo form
    *
    * @param void
    * @return null
    */
    function edit_logo() {
      if (!logged_user()->isAdministrator(owner_company())) {
        flash_error(lang('no access permissions'));
        $this->redirectTo('dashboard');
      } // if
      
      $company = Companies::findById(get_id());
      if (!($company instanceof Company)) {
        flash_error(lang('company dnx'));
        $this->redirectToReferer(get_url('administration', 'clients'));
      } // if

      if (!function_exists('imagecreatefromjpeg')) {
        flash_error(lang('no image functions'));
        $this->redirectTo('dashboard');
      } // if
      
      tpl_assign('company', $company);
      
      $logo = array_var($_FILES, 'new_logo');
      if (is_array($logo)) {
        try {
          if (!isset($logo['name']) || !isset($logo['type']) || !isset($logo['size']) || !isset($logo['tmp_name']) || !is_readable($logo['tmp_name'])) {
            throw new InvalidUploadError($logo, lang('error upload file'));
          } // if
          
          $valid_types = array('image/jpg', 'image/jpeg', 'image/pjpeg', 'image/gif', 'image/png');
          $max_width   = config_option('max_logo_width', 50);
          $max_height  = config_option('max_logo_height', 50);
          
          if (!in_array($logo['type'], $valid_types) || !($image = getimagesize($logo['tmp_name']))) {
            throw new InvalidUploadError($logo, lang('invalid upload type', 'JPG, GIF, PNG'));
          } // if
          
          $old_file = $company->getLogoPath();
          
          DB::beginWork();
          
          if (!$company->setLogo($logo['tmp_name'], $max_width, $max_height, true)) {
            DB::rollback();
            flash_error(lang('error edit company logo'));
            $this->redirectToUrl($company->getEditLogoUrl());
          } // if
          
          ApplicationLogs::createLog($company, null, ApplicationLogs::ACTION_EDIT);
          
          flash_success(lang('success edit company logo'));
          DB::commit();
          
          if (is_file($old_file)) {
            @unlink($old_file);
          } // uf
          
        } catch(Exception $e) {
          flash_error(lang('error edit company logo'));
          DB::rollback();
        } // try
        
        $this->redirectToUrl($company->getEditLogoUrl());
      } // if
    } // edit_logo
    
    /**
    * Delete company logo
    *
    * @param void
    * @return null
    */
    function delete_logo() {
      if (!logged_user()->isAdministrator(owner_company())) {
        flash_error(lang('no access permissions'));
        $this->redirectTo('dashboard');
      } // if
      
      $company = Companies::findById(get_id());
      if (!($company instanceof Company)) {
        flash_error(lang('company dnx'));
        $this->redirectToReferer(get_url('administration', 'clients'));
      } // if
      
      try {
        DB::beginWork();
        $company->deleteLogo();
        $company->save();
        ApplicationLogs::createLog($company, null, ApplicationLogs::ACTION_EDIT);
        DB::commit();
        
        flash_success(lang('success delete company logo'));
      } catch(Exception $e) {
        DB::rollback();
        flash_error(lang('error delete company logo'));
      } // try
      
      $this->redirectToUrl($company->getEditLogoUrl());
    } // delete_logo
    
    /**
    * Hide welcome info message
    *
    * @param void
    * @return null
    */
    function hide_welcome_info() {
      if (!logged_user()->isAdministrator(owner_company())) {
        flash_error(lang('no access permissions'));
        $this->redirectTo('dashboard');
      } // if
      
      try {
        owner_company()->setHideWelcomeInfo(true);
        owner_company()->save();
        
        flash_success(lang('success hide welcome info'));
      } catch(Exception $e) {
        flash_error(lang('error hide welcome info'));
      } // try
      
      $this->redirectTo('dashboard');
    } // hide_welcome_info

    /**
    * Toggle favorite status
    *
    * @param void
    * @return null
    */
    function toggle_favorite() {
      if (!logged_user()->isAdministrator()) {
        flash_error('no access permisssions');
        $this->redirectToReferer(get_url('dashboard'));
      }

      $company = Companies::findById(get_id());
      if (!($company instanceof Company)) {
        flash_error(lang('company dnx'));
        $this->redirectToReferer(get_url('administration'));
      } // if
      
      if ($company->isOwner()) {
        flash_error('no access permissions');
        $this->redirectToReferer(get_url('dashboard'));
      } // if
      
      $company->setIsFavorite(!$company->isFavorite());

      if (!$company->save()) {
        flash_error(lang('could not save info'));
      }
      
      $redirect_to = urldecode(array_var($_GET, 'redirect_to'));
      if ((trim($redirect_to)) == '' || !is_valid_url($redirect_to)) {
        $redirect_to = $company->getViewUrl();
      } // if
      
      $this->redirectToUrl($redirect_to);
    } // toggle_favorite
  
  } // CompanyController

?>