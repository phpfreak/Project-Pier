<?php

  /**
  * Projects, generated on Sun, 26 Feb 2006 23:10:34 +0100 by 
  * DataObject generation tool
  *
  * @http://www.projectpier.org/
  */
  class Projects extends BaseProjects {
    
    /**
    * This constants are used for retriving project data, to see how to order results
    */
    const ORDER_BY_DATE_CREATED = 'created_on';
    const ORDER_BY_NAME = 'name';
    const ORDER_BY_PRIORITY = 'priority';
    
    /**
    * Return all projects
    *
    * @param void
    * @return array
    */
    static function getAll($order_by = self::ORDER_BY_NAME) {
      return Projects::findAll(array(
        'order' => $order_by
      )); // findAll
    } // getAll
    
    /**
    * Return all active project from the database
    *
    * @param string $order_by
    * @return null
    */
    static function getActiveProjects($order_by = self::ORDER_BY_NAME) {
      return self::findAll(array(
        'conditions' => array('`completed_on` = ?', EMPTY_DATETIME),
        'order' => $order_by,
      )); // findAll
    } // getActiveProjects
    
    /**
    * Return finished projects
    *
    * @param string $order_by
    * @return array
    */
    static function getFinishedProjects($order_by = self::ORDER_BY_NAME) {
      return self::findAll(array(
        'conditions' => array('`completed_on` > ?', EMPTY_DATETIME),
        'order' => $order_by,
      )); // findAll
    } // getFinishedProjects
    
  } // Projects 

?>