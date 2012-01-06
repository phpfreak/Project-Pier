<?php

  /**
  * I18nLocales 
  *
  */
  class I18nLocales extends BaseI18nLocales {
  
    /**
    * Return array of all links for project
    *
    * @param $exclude_id_list
    * @return array I18nLocale
    */
    static function getAllLocales($exclude_id_list = null) {
      trace(__FILE__,'getAllLocales():begin');

      $conditions = array();
      if (is_array($exclude_id_list)) {
        $id_list = join(',', $exclude_id_list);
        $conditions = array('`id` NOT IN (?)', $id_list);
      }
      if (is_numeric($exclude_id_list)) {
        $conditions = array('`id` NOT IN (?)', $exclude_id_list);
      }

      return self::findAll(array(
        'conditions' => $conditions,
        'order' => '`language_code` ASC, `country_code` ASC',
      )); // findAll
      trace(__FILE__,'getAllLocales():end');
    } // getAllLocales

  } // I18nLocales

?>