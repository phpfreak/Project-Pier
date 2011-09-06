<?php

  /**
  * ProjectTimes, generated on Sat, 04 Mar 2006 12:50:11 +0100 by 
  * DataObject generation tool
  *
  */
  class ProjectTimes extends BaseProjectTimes {
  
    /**
    * Return all times that are assigned to the user
    *
    * @param User $user
    * @return array
    */
    static function getTimeByUser(User $user) {
      $projects = $user->getActiveProjects();
      if(!is_array($projects) || !count($projects)) {
        return null;
      } // if
      
      $project_ids = array();
      foreach($projects as $project) {
        $project_ids[] = $project->getId();
      } // foreach
      
      return self::findAll(array(
        'conditions' => array('(`assigned_to_user_id` = ? OR (`assigned_to_user_id` = ? AND `assigned_to_company_id` = ?)) AND `project_id` IN (?)', $user->getId(), 0, 0, $project_ids),
        'order' => '`done_date`'
      )); // findAll
    } // getTimeByUser
    

    /**
    * Return all times by their status: closed or not
    *
    * @param integer $status
    * @return array
    */
    static function getTimeByStatus($status = 0) {
 
      $order_by = ($status) ? '`done_date` DESC' : '`done_date` ASC';      

      return self::findAll(array(
        'conditions' => array('`is_closed` = ? ', $status),
        'order' => $order_by
      )); // findAll
    } // getTimeByStatus

    /**
    * Return the total hours by status and user
    *
    * @param User $user
    * @param Int $status
    * @param String $return one of 'times', 'hours'
    * @return array
    */
    static function getTimeByUserStatus(User $user, $status = 0, $return = 'times') {
 
      $projects = $user->getActiveProjects();
      if(!is_array($projects) || !count($projects)) {
        return 0;
      } // if
      
      $project_ids = array();
      foreach($projects as $project) {
        $project_ids[] = $project->getId();
      } // foreach
      
      $order_by = ($status) ? '`done_date` DESC' : '`done_date` ASC';    
      $times = self::findAll(array(
        'conditions' => array('(`assigned_to_user_id` = ? OR (`assigned_to_user_id` = ? AND `assigned_to_company_id` = ?)) AND `is_closed` = ? AND `project_id` IN (?)', $user->getId(), 0, 0, $status, $project_ids),
        'order' => $order_by
      )); // findAll

      if ($return == 'times') {
	 return $times;
      } // if

      $hours = 0;
      if (!is_array($times) && !count($times)) {
	 return 0;
      } // if

      foreach ($times as $time) {
        $hours += $time->getHours();
      } // foreach

      return $hours;
    } // getTimeByUserStatus

    /**
    * Return the total hours by status and project
    *
    * @param Project $project
    * @param Int $status
    * @param String $return one of 'times', 'hours'
    * @return array
    */
    static function getTimeByProjectStatus(Project $project, $status = 0, $return = 'times') {
      
      $order_by = ($status) ? '`done_date` DESC' : '`done_date` ASC';    
      $times = self::findAll(array(
        'conditions' => array('`is_closed` = ? AND `project_id` = ?', $status, $project->getId()),
        'order' => $order_by
      )); // findAll

      if ($return == 'times') {
	 return $times;
      } // if

      $hours = 0;
      if (!is_array($times) && !count($times)) {
	 return 0;
      } // if

      foreach ($times as $time) {
        $hours += $time->getHours();
      } // foreach

      return $hours;
    } // getTimeByProjectStatus

    /**
    * Return all times that are assigned to the task
    *
    * @param ProjectTask $task
    * @return array
    */
    static function getTimeByTask(ProjectTask $task) {
      
      return self::findAll(array(
        'conditions' => array('`task_id` = ? ', $task->getId()),
        'order' => '`done_date`'
      )); // findAll
    } // getTimeByTask

    /**
    * Return all times that are assigned to the task_list
    *
    * @param ProjectTaskList $task
    * @return array
    */
    static function getTimeByTaskList(ProjectTaskList $task) {
      
      return self::findAll(array(
        'conditions' => array('`task_list_id` = ? ', $task->getId()),
        'order' => '`done_date`'
      )); // findAll
    } // getTimeByTaskList

    /**
    * Return times that are assigned to the specific user and belongs to specific project
    *
    * @param User $user
    * @param Project $project
    * @return array
    */
    static function getTimeByUserAndProject(User $user, Project $project) {
      return self::findAll(array(
        'conditions' => array('(`assigned_to_user_id` = ? OR (`assigned_to_user_id` = ? AND `assigned_to_company_id` = ?)) AND `project_id` = ?', $user->getId(), 0, 0, $project->getId()),
        'order' => '`done_date`'
      )); // findAll
    } // getTimeByUserAndProject
    
  } // ProjectTimes

?>