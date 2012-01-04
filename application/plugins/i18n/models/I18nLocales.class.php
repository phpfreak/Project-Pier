<?php

  /**
  * I18nLocales 
  *
  */
  class I18nLocales extends BaseI18nLocales {
  
    /**
    * Return array of all links for project
    *
    * @param Project
    * @return array I18nLocale
    */
    static function getAllLocales() {
      trace(__FILE__,'getAllLocales():begin');
      
      $conditions = array();
      
      return self::findAll(array(
        'conditions' => $conditions,
        'order' => '`language_code` ASC, `country_code` ASC',
      )); // findAll
      trace(__FILE__,'getAllLocales():end');
    } // getAllLocales

  } // I18nLocales

?>