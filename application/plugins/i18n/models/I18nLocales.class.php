<?php

  /**
  * I18nLocales 
  *
  */
  class I18nLocales extends BaseI18nLocales {
    /**
    * Cached locales
    *
    * @var array
    */
    protected $locales;
  
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

    /**
    * Return locale identified by language code and country code
    *
    * @param 
    * @return I18nLocale
    */
    function getLocale($language_cd, $country_code) {
      trace(__FILE__,"getLocale($language_cd, $country_code):begin");
      if (!isset($this->locales)) $this->locales = array();
      $key = $language_cd . '_' . $country_code;
      if (array_key_exists($key, $this->locales)) return $this->locales[$key];

      $conditions = array('`language_code` = ? and `country_code` = ?', $language_cd, $country_code);

      $locale = self::findOne(array(
        'conditions' => $conditions
      )); // findOne
      if ($locale instanceof I18nLocale) {
        $this->locales[$key] = $locale;
      }
      trace(__FILE__,"getLocale($language_cd, $country_code):end");
    } // getLocale

  } // I18nLocales

?>