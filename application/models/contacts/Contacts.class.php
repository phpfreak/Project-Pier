<?php

  /**
  * Contacts
  *
  * @http://www.projectpier.org/
  */
  class Contacts extends BaseContacts {
    
    /**
    * Return all contacts
    *
    * @param void
    * @return array
    */
    function getAll() {
      return self::findAll();
    } // getAll
    
    /**
    * Return contacts grouped by company
    *
    * @param void
    * @return array
    */
    static function getGroupedByCompany() {
      $companies = Companies::getAll();
      if (!is_array($companies) || !count($companies)) {
        return null;
      } // if
      
      $result = array();
      foreach ($companies as $company) {
        $contacts = $company->getContacts();
        if (is_array($contacts) && count($contacts)) {
          $result[$company->getName()] = array(
            'details' => $company,
            'contacts' => $contacts,
          ); // array
        } // if
      } // foreach
      
      return count($result) ? $result : null;
    } // getGroupedByCompany
    
    /**
    * Returns array of initials
    *
    * @param void
    * @return array
    */
    function getInitials() {
      $sql = "SELECT DISTINCT UPPER(SUBSTRING(`display_name`,1,1)) AS 'initial' FROM `".TABLE_PREFIX."contacts` ORDER BY `display_name` ASC";
      $rows = DB::executeAll($sql);
      $initials = array();
      foreach ($rows as $row) {
        if (preg_match('/^\d$/', $row['initial'])) {
          if (!in_array('_', $initials)) {
            $initials[] = '_';
          } // if
        } else {
          $initials[] = $row['initial'];
        } // if
      } // foreach
      return $initials;
    } // getInitials

  } // Contacts 

?>