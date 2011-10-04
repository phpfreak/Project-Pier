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
    * Return late tickets that are assigned to the user
    *
    * @param User $user
    * @param boolean $include_company includes tickets assigned to whole company
    * @return array
    */
    function getLateTicketsByUser(User $user, $include_company = false) {
      $due_date = DateTimeValueLib::now()->beginningOfDay();

      $projects = $user->getActiveProjects();
      if (!is_array($projects) || !count($projects)) {
        return null;
      } // if
      
      $project_ids = array();
      foreach ($projects as $project) {
        $project_ids[] = $project->getId();
      } // foreach
      
      // TODO This request contains a hard-coded value for status. Might need to be changed
      // if ticket properties are made more generic
      if ($include_company) {
        return self::findAll(array(
          //'conditions' => array('(`assigned_to_user_id` = ? OR (`assigned_to_user_id` = ? AND `assigned_to_company_id` = ?)) AND `project_id` IN (?) AND `state` <> ? AND `due_date` < ?', $user->getId(), 0, $user->getCompanyId(), $project_ids, 'closed', $due_date),
          //'order' => '`due_date`'
          'conditions' => array('(`assigned_to_user_id` = ? OR (`assigned_to_user_id` = ? AND `assigned_to_company_id` = ?)) AND `project_id` IN (?) AND `state` <> ?', $user->getId(), 0, $user->getCompanyId(), $project_ids, 'closed'),
          'order' => '`state` ASC'
          )); // findAll
      } else {
        return self::findAll(array(
          //'conditions' => array('`assigned_to_user_id` = ? AND `project_id` IN (?) AND `state` <> ? AND `due_date` < ?', $user->getId(), $project_ids, 'closed', $due_date),
          //'order' => '`due_date`'
          'conditions' => array('`assigned_to_user_id` = ? AND `project_id` IN (?) AND `state` <> ?', $user->getId(), $project_ids, 'closed'),
          'order' => '`state` ASC'
        )); // findAll
      } // if
      
    } // getLateTicketsByUser
    
    /**
    * Return open tickets due in specified period
    *
    * @access public
    * @param User $user
    * @param DateTimeValue $from_date
    * @param DateTimeValue $to_date
    * @return array
    */
    function getOpenTicketsInPeriodByUser(User $user, DateTimeValue $from_date, DateTimeValue $to_date) {
      $projects = $user->getActiveProjects();
      if (!is_array($projects) || !count($projects)) {
        return null;
      }
      
      $project_ids = array();
      foreach ($projects as $project) {
        $project_ids[] = $project->getId();
      } // foreach
      
      // TODO status values hard-coded in query
      return self::findAll(array(
        //'conditions' => array('`state` IN (?) AND (`due_date` >= ? AND `due_date` < ?) AND `project_id` IN (?)', array('new', 'open', 'pending'), $from_date, $to_date, $project_ids),
        //'order' => '`due_date` ASC'
        'conditions' => array('`state` IN (?) AND `project_id` IN (?)', array('new', 'open', 'pending'), $project_ids),
        'order' => '`state` ASC'
      )); // findAll
    } // getOpenTicketsInPeriodByUser

    
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

    /**
    * Return index page
    *
    * @param string $order_by
    * @param integer $page
    * @return string
    */
    static function getDownload($project, $content_type = 'text/csv') {
      $name = $project->getName() . '-tickets-' . time() . '.txt';
      $content = '';
      $tickets = self::getProjectTickets($project, logged_user()->isMemberOfOwnerCompany());
      foreach($tickets as $ticket) {
        $content .= $ticket->getId() . "\t";
        $content .= $ticket->getSummary() . "\t";
        $content .= lang($ticket->getType()) . "\t";
        $content .= lang($ticket->getState()) . "\t";
        if ($ticket->getCategory()) {
          $content .= lang($ticket->getCategory()->getName());
        }
        $content .= "\t";
        if ($ticket->getCreatedBy()) {
          $content .= clean($ticket->getCreatedBy()->getDisplayName());
        }
        $content .= "\t";
        if($ticket->getAssignedTo()) { 
          $content .= clean($ticket->getAssignedTo()->getObjectName());
        }
        $content .= "\n";
      }
      return array('content' => $content, 'type' => $content_type, 'name' => $name);
    } // getIndexUrl


  } // ProjectTickets 

?>