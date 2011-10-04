<?php

  /**
  * Companies, generated on Sat, 25 Feb 2006 17:37:12 +0100 by 
  * DataObject generation tool
  *
  * @http://www.projectpier.org/
  */
  class Companies extends BaseCompanies {
    
    /**
    * Return all registered companies
    *
    * @param void
    * @return array
    */
    static function getAll() {
      return Companies::findAll(array(
        'order' => '`client_of_id`'
      )); // findAll
    } // getAll
  
    /**
    * Return owner company
    *
    * @access public
    * @param void
    * @return Company
    */
    static function getOwnerCompany() {
      return Companies::findOne(array(
        'conditions' => array('`client_of_id` = ?', 0)
      )); // findOne
    } // getOwnerCompany
    
    /**
    * Return company clients
    *
    * @param Company $company
    * @return array
    */
    static function getCompanyClients(Company $company) {
      return Companies::findAll(array(
        'conditions' => array('`client_of_id` = ?', $company->getId()),
        'order' => '`name`'
      )); // array
    } // getCompanyClients

    /**
    * Return favorite companies
    *
    * @param void
    * @return array
    */
    static function getFavorites() {
      return Companies::findAll(array(
        'conditions' => array('`is_favorite` = ?', 1),
        'order' => '`id`'));
    } // getFavorites
    
  } // Companies

?>