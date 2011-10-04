<?php

  /**
  * AdministrationTools class
  *
  * @http://www.projectpier.org/
  */
  class AdministrationTools extends BaseAdministrationTools {
  
    /**
    * Return all available tools
    *
    * @param void
    * @return array
    */
    function getAll() {
      return self::findAll(array(
        'order' => '`order`'
      )); // findAll
    } // getAll
    
    /**
    * Return tool by name
    *
    * @param string $name
    * @return AdministrationTool
    */
    function getByName($name) {
      return self::findOne(array(
        'conditions' => array('`name` = ?', $name),
      )); // findOne
    } // getByName
    
  } // AdministrationTools 

?>