<?php

  /**
  * ConfigCategory class
  * Generated on Wed, 02 Aug 2006 21:22:22 +0200 by DataObject generation tool
  *
  * @http://www.projectpier.org/
  */
  class ConfigCategory extends BaseConfigCategory {
    
    /**
    * Cached array of config options listed per user permissions (only account owner can see all the options)
    *
    * @var array
    */
    private $config_options;
    
    /**
    * Cached number of config options that current user can see
    *
    * @var integer
    */
    private $count_config_options;
    
    /**
    * In DB we store uniqe name. This function will convert that name to the catetory display name in propert language
    *
    * @param void
    * @return string
    */
    function getDisplayName() {
      return lang('config category name ' . $this->getName());
    } // getDisplayName
    
    /**
    * Get DB description from lang based on category name
    *
    * @param void
    * @return string
    */
    function getDisplayDescription() {
      $key = 'config category desc ' . $this->getName();
      $desc = lang($key);
      return strpos($desc,$key)===false ? $desc : '';
    } // getDisplayDescription
    
    /**
    * Return options array
    *
    * @param boolean $include_system_options Include system options in the result
    * @return array
    */
    function getOptions($include_system_options = false) {
      if (is_null($this->config_options)) {
        $this->config_options = ConfigOptions::getOptionsByCategory($this, $include_system_options);
      } // if
      return $this->config_options;
    } // getOptions
    
    /**
    * Return the number of option in category that logged user can see
    *
    * @param boolean $include_system_options Include system options
    * @return integer
    */
    function countOptions($include_system_options = false) {
      if (is_null($this->count_config_options)) {
        $this->count_config_options = ConfigOptions::countOptionsByCategory($this, $include_system_options);
      } // if
      return $this->count_config_options;
    } // countOptions
    
    /**
    * Returns true if this category does not have any options to show to the user
    *
    * @param void
    * @return boolean
    */
    function isEmpty() {
      return $this->countOptions() < 1;
    } // isEmpty
  
    // ---------------------------------------------------
    //  Urls
    // ---------------------------------------------------
    
    /**
    * View config category
    *
    * @param void
    * @return null
    */
    function getUpdateUrl() {
      return get_url('config', 'update_category', $this->getId());
    } // getUpdateUrl
    
  } // ConfigCategory 

?>