<?php

  /**
  * I18nLocaleValues 
  *
  */
  class I18nLocaleValues extends BaseI18nLocaleValues {
  
    /**
    * Return array of all locale values
    *
    * @param Locale
    * @return array I18nLocaleValue
    */
    function getLocaleValues($locale) {
      trace(__FILE__,'getLocaleValues():begin');
      
      $conditions = array('locale_id' => $locale->getId());
      
      return self::findAll(array(
        'conditions' => $conditions,
        'order' => '`id` ASC',
      )); // findAll
      trace(__FILE__,'getLocaleValues():end');
    } // getLocaleValues

    function getCategories($locale) {
      trace(__FILE__,'getCategories():begin');
      
      // Prepare SQL
      $set1 = "(SELECT DISTINCT `category_id` FROM " . $this->getTableName(true) . " WHERE `locale_id` = {$locale->getId()})";
      //$sql = "SELECT * FROM " . I18nCategories::getTableName(true) . " WHERE `id` IN $set1";
      $sql = "SELECT * FROM " . 'pp088_i18n_section' . " WHERE `id` IN $set1";
      trace(__FILE__,'find():'.$sql);
      
      // Run!
      $rows = DB::executeAll($sql);
      
      // Empty?
      if (!is_array($rows) || (count($rows) < 1)) {
        trace(__FILE__,'find():found 0');
        return null;
      } // if
      
      // If we have one load it, else loop and load many
      trace(__FILE__,'find():found '.count($rows));
      $objects = array();
      foreach ($rows as $row) {
        $object = $this->loadFromRow($row);
        if (instance_of($object, $this->getItemClass())) {
          $objects[] = $object;
        } // if
      } // foreach
      return count($objects) ? $objects : null;
      trace(__FILE__,'getCategories():end');
    } // getLocaleValues


  } // I18nLocaleValues

?>