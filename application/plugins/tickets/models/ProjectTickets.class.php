<?php

  /**
  * ProjectTickets class
  *
  * @http://www.projectpier.org/
  */
  class ProjectTickets extends BaseProjectTickets {    

    /**
    * Return late tickets from active projects given user has access on.
    *
    * @param User $user
    * @return array or null
    */
    function getOpenTicketsByUser(User $user) {
      $due_date = DateTimeValueLib::now()->beginningOfDay();
      
      $projects = $user->getActiveProjects();
      if (!is_array($projects) || !count($projects)) {
        return null;
      }
      
      $project_ids = array();
      foreach ($projects as $project) {
        $project_ids[] = $project->getId();
      } // foreach
      
      return self::findAll(array(
        'conditions' => array('`closed_on` = ? AND `project_id` IN (?)', EMPTY_DATETIME, $project_ids),
        'order' => '`priority`'
      )); // findAll
    } // getOpenTicketsByUser
    
    /**
    * Return tickets that belong to specific project
    *
    * @param Project $project
    * @param boolean $include_private Include private tickets in the result
    * @return array
    */
    static function getProjectTickets(Project $project, $include_private = false) {
      if($include_private) {
        $conditions = array('`project_id` = ?', $project->getId());
      } else {
        $conditions = array('`project_id` = ? AND `is_private` = ?', $project->getId(), false);
      } // if
      
      return self::findAll(array(
        'conditions' => $conditions,
        'order' => '`created_on` DESC',
      )); // findAll
    } // getProjectTickets
    
    /**
    * Return open tickets for specific project
    *
    * @param Project $project
    * @param boolean $include_private Include private tickets
    * @return array
    */
    static function getOpenProjectTickets(Project $project, $include_private = false) {
      if($include_private) {
        $conditions = array('`project_id` = ? AND `closed_on` = ?', $project->getId(), EMPTY_DATETIME);
      } else {
        $conditions = array('`project_id` = ? AND `closed_on` = ? AND `is_private` = ?', $project->getId(), EMPTY_DATETIME, false);
      } // if
      
      return self::findAll(array(
        'conditions' => $conditions,
        'order' => '`created_on` DESC',
      )); // findAll
    } // getOpenProjectTickets
    
    /**
    * Return closed tickets for specific project
    *
    * @param Project $project
    * @param boolean $include_private Include private tickets
    * @return array
    */
    static function getClosedProjectTickets(Project $project, $include_private = false) {
      if($include_private) {
        $conditions = array('`project_id` = ? AND `closed_on` > ?', $project->getId(), EMPTY_DATETIME);
      } else {
        $conditions = array('`project_id` = ? AND `closed_on` > ? AND `is_private` = ?', $project->getId(), EMPTY_DATETIME, false);
      } // if
      
      return self::findAll(array(
        'conditions' => $conditions,
        'order' => '`created_on` DESC',
      )); // findAll
    } // getClosedProjectTickets
  
    /**
    * Return index page
    *
    * @param string $order_by
    * @param integer $page
    * @return string
    */
    static function getIndexUrl($closed = false) {
      if ($closed) {
        $options = array('closed' => true);
      } else {
        $options = array();
      } // if
      return get_url('tickets', 'index', $options);
    } // getIndexUrl

  } // ProjectTickets 

?>
