<?php

  /**
  * ConfigOptions, generated on Mon, 27 Feb 2006 14:00:37 +0100 by 
  * DataObject generation tool
  *
  * @http://www.projectpier.org/
  */
  class ConfigOptions extends BaseConfigOptions {
    
    /**
    * Return all options in specific category
    *
    * @param ConfigCategory $category
    * @param boolean $include_system_options Include system options in the result array
    * @return array
    */
    static function getOptionsByCategory(ConfigCategory $category, $include_system_options = false) {
      $conditions = $include_system_options ? 
        array('`category_name` = ?', $category->getName()) : 
        array('`category_name` = ? AND `is_system` = ?', $category->getName(), false);
        
      return self::findAll(array(
        'conditions' => $conditions,
        'order' => '`option_order`'
      )); // findAll
    } // getOptionsByCategory
    
    /**
    * Return the number of config options in specific category
    *
    * @param ConfigCategory $category
    * @param boolean $include_system_options
    * @return integer
    */
    static function countOptionsByCategory(ConfigCategory $category, $include_system_options = false) {
      $conditions = $include_system_options ? 
        array('`category_name` = ?', $category->getName()) : 
        array('`category_name` = ? AND `is_system` = ?', $category->getName(), false);
   
      return self::count($conditions);
    } // countOptionsByCategory
    
    /**
    * Return value of specific option
    *
    * @access public
    * @param string $name
    * @param mixed $default Default value that is returned in case of any error
    * @return null
    */
    static function getOptionValue($name, $default = null) {
      $option = self::getByName($name);
      return $option instanceof ConfigOption ? $option->getValue() : $default;
    } // getOptionValue
  
    /**
    * Return config option by name
    *
    * @access public
    * @param string $name
    * @return ConfigOption
    */
    static function getByName($name) {
      return self::findOne(array(
        'conditions' => array('`name` = ?', $name)
      )); // if
    } // getByName
    
  } // ConfigOptions 

?>