<?php

  /**
  * Config controller is responsible for handling all config related operations
  *
  * @version 1.0
  * @http://www.projectpier.org/
  */
  class ConfigController extends ApplicationController {
  
    /**
    * Construct the ApplicationController 
    *
    * @param void
    * @return ApplicationController 
    */
    function __construct() {
      parent::__construct();
      prepare_company_website_controller($this, 'administration');
      
      // Access permissios
      if (!logged_user()->isAdministrator(owner_company())) {
        flash_error(lang('no access permissions'));
        $this->redirectTo('dashboard');
      } // if
    } // __construct
    
    /**
    * Show and process config category form
    *
    * @param void
    * @return null
    */
    function update_category() {
      $category = ConfigCategories::findById(get_id());
      if (!($category instanceof ConfigCategory)) {
        flash_error(lang('config category dnx'));
        $this->redirectToReferer(get_url('administration'));
      } // if
      
      if ($category->isEmpty()) {
        flash_error(lang('config category is empty'));
        $this->redirectToReferer(get_url('administration'));
      } // if
      
      $this->addHelper('textile');
      $options = $category->getOptions(false);
      $categories = ConfigCategories::getAll(false);
      
      tpl_assign('category', $category);
      tpl_assign('options', $options);
      tpl_assign('config_categories', $categories);
      
      $submitted_values = array_var($_POST, 'options');
      if (is_array($submitted_values)) {
        foreach ($options as $option) {
          $new_value = array_var($submitted_values, $option->getName());
          if (is_null($new_value) || ($new_value == $option->getValue())) {
            continue;
          }
          
          $option->setValue($new_value);
          $option->save();
        } // foreach
        flash_success(lang('success update config category', $category->getDisplayName()));
        $this->redirectTo('administration', 'configuration');
      } // if
      
      $this->setSidebar(get_template_path('update_category_sidebar', 'config'));
    } // update_category
  
  } // ConfigController

?>