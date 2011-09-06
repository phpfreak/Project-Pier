<?php

  /**
  * ProjectUsers, generated on Wed, 15 Mar 2006 22:57:46 +0100 by 
  * DataObject generation tool
  *
  * @http://www.projectpier.org/
  */
  class ProjectUsers extends BaseProjectUsers {
    
    /** All available user permissions **/
    const CAN_MANAGE_MESSAGES   = 'can_manage_messages';
    const CAN_MANAGE_TASKS      = 'can_manage_tasks';
    const CAN_MANAGE_MILESTONES = 'can_manage_milestones';
    const CAN_UPLOAD_FILES      = 'can_upload_files';
    const CAN_MANAGE_FILES      = 'can_manage_files';
    const CAN_ASSIGN_TO_OWNERS  = 'can_assign_to_owners';
    const CAN_ASSIGN_TO_OTHER   = 'can_assign_to_other';
  
    /**
    * Return all users that are involved in specific project
    *
    * @access public
    * @param Project $project
    * @param string $additional_conditions
    * @return array
    */
    function getUsersByProject(Project $project, $additional_conditions = null) {
      $users_table = Users::instance()->getTableName(true);
      $project_users_table=  ProjectUsers::instance()->getTableName(true);
      
      $users = array();
      
      $sql = "SELECT $users_table.* FROM $users_table, $project_users_table WHERE ($users_table.`id` = $project_users_table.`user_id` AND $project_users_table.`project_id` = " . DB::escape($project->getId()) . ')';
      if (trim($additional_conditions) <> '') {
        $sql .= " AND ($additional_conditions)";
      }
      
      $rows = DB::executeAll($sql);
      if (is_array($rows)) {
        foreach ($rows as $row) {
          $users[] = Users::instance()->loadFromRow($row);
        } // foreach
      } // if
      
      return count($users) ? $users : null;
    } // getUsersByProject
    
    /**
    * Return users of specific company involeved in specific project
    *
    * @access public
    * @param Company $company
    * @param Project $project
    * @return array
    */
    function getCompanyUsersByProject(Company $company, Project $project) {
      $users_table = Users::instance()->getTableName(true);
      return self::getUsersByProject($project, "$users_table.`company_id` = " . DB::escape($company->getId()));
    } // getCompanyUsersByProject
    
    /**
    * Return all projects that this user is part of
    *
    * @access public
    * @param User $user
    * @param 
    * @return array
    */
    function getProjectsByUser(User $user, $additional_conditions = null) {
      $projects_table = Projects::instance()->getTableName(true);
      $project_users_table=  ProjectUsers::instance()->getTableName(true);
      
      $projects = array();
      
      $sql = "SELECT $projects_table.* FROM $projects_table, $project_users_table WHERE ($projects_table.`id` = $project_users_table.`project_id` AND $project_users_table.`user_id` = " . DB::escape($user->getId()) . ')';
      if (trim($additional_conditions) <> '') {
        $sql .= " AND ($additional_conditions)";
      } // if
      $sql .= " ORDER BY $projects_table.`name`";
      
      $rows = DB::executeAll($sql);
      if (is_array($rows)) {
        foreach ($rows as $row) {
          $projects[] = Projects::instance()->loadFromRow($row);
        } // foreach
      } // if
      
      return count($projects) ? $projects : null;
    } // getProjectsByUser
    
    /**
    * Return all users associated with specific project
    *
    * @access public
    * @param Project $project
    * @return boolean
    */
    static function clearByProject(Project $project) {
      return self::delete(array('`project_id` = ?', $project->getId()));
    } // clearByProject
    
    /**
    * Clear permission by user
    *
    * @param User $user
    * @return boolean
    */
    static function clearByUser(User $user) {
      return self::delete(array('`user_id` = ?', $user->getId()));
    } // clearByUser
    
    /**
    * This function will return array of permission columns in table. Permission column name is 
    * used as permission ID in rest of the script
    *
    * @access public
    * @param void
    * @return array
    */
    function getPermissionColumns() {
      return array(
        self::CAN_MANAGE_MESSAGES,
        self::CAN_MANAGE_TASKS,
        self::CAN_MANAGE_MILESTONES,
        self::CAN_UPLOAD_FILES,
        self::CAN_MANAGE_FILES,
        self::CAN_ASSIGN_TO_OWNERS,
        self::CAN_ASSIGN_TO_OTHER,
      ); // array
    } // getPermissionColumns
    
    /**
    * Return permission name => permission text array
    *
    * @param void
    * @return array
    */
    static function getNameTextArray() {
      return array(
        ProjectUsers::CAN_MANAGE_MESSAGES   => lang('can manage messages'),
        ProjectUsers::CAN_MANAGE_TASKS      => lang('can manage tasks'),
        ProjectUsers::CAN_MANAGE_MILESTONES => lang('can manage milestones'),
        ProjectUsers::CAN_UPLOAD_FILES      => lang('can upload files'),
        ProjectUsers::CAN_MANAGE_FILES      => lang('can manage files'),
        ProjectUsers::CAN_ASSIGN_TO_OWNERS  => lang('can assign to owners'),
        ProjectUsers::CAN_ASSIGN_TO_OTHER   => lang('can assign to other'),
      ); // array
    } // getNameTextArray
    
  } // ProjectUsers 

?>
