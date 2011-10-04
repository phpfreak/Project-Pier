<?php

  /**
  * ProjectMilestones, generated on Sat, 04 Mar 2006 12:50:11 +0100 by 
  * DataObject generation tool
  *
  * @http://www.projectpier.org/
  */
  class ProjectMilestones extends BaseProjectMilestones {
  
    /**
    * Return all late milestones in active projects of a specific company.
    * This function will exclude milestones marked for today
    *
    * @param void
    * @return array
    */
    function getLateMilestonesByCompany(Company $company) {
      $due_date = DateTimeValueLib::now()->beginningOfDay();
      
      $projects = $company->getActiveProjects();
      if (!is_array($projects) || !count($projects)) {
        return null;
      }
      
      $project_ids = array();
      foreach ($projects as $project) {
        $project_ids[] = $project->getId();
      } // foreach
      
      return self::findAll(array(
        'conditions' => array('`due_date` < ? AND `completed_on` = ? AND `project_id` IN (?)', $due_date, EMPTY_DATETIME, $project_ids),
        'order' => '`due_date`',
      )); // findAll
    } // getLateMilestonesByCompany
    
    /**
    * Return milestones scheduled for today from projects related with specific company
    *
    * @param Company $company
    * @return array
    */
    function getTodayMilestonesByCompany(Company $company) {
      $from_date = DateTimeValueLib::now()->beginningOfDay();
      $to_date = DateTimeValueLib::now()->endOfDay();
      
      $projects = $company->getActiveProjects();
      if (!is_array($projects) || !count($projects)) {
        return null;
      }
      
      $project_ids = array();
      foreach ($projects as $project) {
        $project_ids[] = $project->getId();
      } // foreach
      
      return self::findAll(array(
        'conditions' => array('`completed_on` = ? AND (`due_date` >= ? AND `due_date` < ?) AND `project_id` IN (?)', EMPTY_DATETIME, $from_date, $to_date, $project_ids),
        'order' => '`due_date`'
      )); // findAll
    } // getTodayMilestonesByCompany
    
    /**
    * Return all milestones that are assigned to the user
    *
    * @param User $user
    * @return array
    */
    static function getActiveMilestonesByUser(User $user) {
      $projects = $user->getActiveProjects();
      if (!is_array($projects) || !count($projects)) {
        return null;
      } // if
      
      $project_ids = array();
      foreach ($projects as $project) {
        $project_ids[] = $project->getId();
      } // foreach
      
      return self::findAll(array(
        'conditions' => array('(`assigned_to_user_id` = ? OR (`assigned_to_user_id` = ? AND `assigned_to_company_id` = ?)) AND `project_id` IN (?) AND `completed_on` = ?', $user->getId(), 0, 0, $project_ids, EMPTY_DATETIME),
        'order' => '`due_date`'
      )); // findAll
    } // getActiveMilestonesByUser
    
    /**
    * Return active milestones that are assigned to the specific user and belongs to specific project
    *
    * @param User $user
    * @param Project $project
    * @return array
    */
    static function getActiveMilestonesByUserAndProject(User $user, Project $project) {
      return self::findAll(array(
        'conditions' => array('(`assigned_to_user_id` = ? OR (`assigned_to_user_id` = ? AND `assigned_to_company_id` = ?)) AND `project_id` = ? AND `completed_on` = ?', $user->getId(), 0, 0, $project->getId(), EMPTY_DATETIME),
        'order' => '`due_date`'
      )); // findAll
    } // getActiveMilestonesByUserAndProject
    
    /**
    * Return late milestones from active projects this user have access on. Today milestones are excluded
    *
    * @param User $user
    * @return array
    */
    function getLateMilestonesByUser(User $user) {
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
        'conditions' => array('`due_date` < ? AND `completed_on` = ? AND `project_id` IN (?)', $due_date, EMPTY_DATETIME, $project_ids),
        'order' => '`due_date`'
      )); // findAll
    } // getLateMilestonesByUser
    
    /**
    * Return today milestones from active projects this user have access on
    *
    * @access public
    * @param void
    * @return array
    */
    function getTodayMilestonesByUser(User $user) {
      $from_date = DateTimeValueLib::now()->beginningOfDay();
      $to_date = DateTimeValueLib::now()->endOfDay();
      
      $projects = $user->getActiveProjects();
      if (!is_array($projects) || !count($projects)) {
        return null;
      }
      
      $project_ids = array();
      foreach ($projects as $project) {
        $project_ids[] = $project->getId();
      } // foreach
      
      return self::findAll(array(
        'conditions' => array('`completed_on` = ? AND (`due_date` >= ? AND `due_date` < ?) AND `project_id` IN (?)', EMPTY_DATETIME, $from_date, $to_date, $project_ids)
      )); // findAll
    } // getTodayMilestonesByUser

    /**
    * Return active milestones due in specified period
    *
    * @access public
    * @param User $user
    * @param DateTimeValue $from_date
    * @param DateTimeValue $to_date
    * @return array
    */
    function getActiveMilestonesInPeriodByUser(User $user, DateTimeValue $from_date, DateTimeValue $to_date) {
      $projects = $user->getActiveProjects();
      if (!is_array($projects) || !count($projects)) {
        return null;
      }
      
      $project_ids = array();
      foreach ($projects as $project) {
        $project_ids[] = $project->getId();
      } // foreach
      
      return self::findAll(array(
        'conditions' => array('`completed_on` = ? AND (`due_date` >= ? AND `due_date` < ?) AND `project_id` IN (?)', EMPTY_DATETIME, $from_date, $to_date, $project_ids),
        'order' => '`due_date` ASC'
      )); // findAll
    } // getActiveMilestonesInPeriodByUser
    
  } // ProjectMilestones 

?>