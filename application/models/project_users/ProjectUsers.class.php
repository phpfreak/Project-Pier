<?php

  /**
  * ProjectUsers, generated on Wed, 15 Mar 2006 22:57:46 +0100 by 
  * DataObject generation tool
  *
  * @http://www.projectpier.org/
  */
  class ProjectUsers extends BaseProjectUsers {
    
    /**
    * Return all users that are involved in specific project
    *
    * @access public
    * @param Project $project
    * @param string $additional_conditions
    * @return array
    */
    function getUsersByProject(Project $project, $additional_conditions = null) {
      $contacts_table = Contacts::instance()->getTableName(true);
      $users_table = Users::instance()->getTableName(true);
      $project_users_table = ProjectUsers::instance()->getTableName(true);
      
      $users = array();
      
      $sql = "SELECT $users_table.* FROM $users_table, $project_users_table, $contacts_table WHERE ($users_table.`id` = $project_users_table.`user_id` AND $contacts_table.`user_id` = $users_table.`id` AND $project_users_table.`project_id` = " . DB::escape($project->getId()) . ')';
      if (trim($additional_conditions) <> '') {
        $sql .= " AND ($additional_conditions)";
      }
      $sql .= " ORDER BY ($contacts_table.`display_name`)";
      
      $rows = DB::executeAll($sql);
      if (is_array($rows)) {
        foreach ($rows as $row) {
          $users[] = Users::instance()->loadFromRow($row);
        } // foreach
      } // if
      
      return count($users) ? $users : null;
    } // getUsersByProject
    
    /**
    * Return users of specific company involved in specific project
    *
    * @access public
    * @param Company $company
    * @param Project $project
    * @return array
    */
    function getCompanyUsersByProject(Company $company, Project $project) {
      $contacts_table = Contacts::instance()->getTableName(true);
      return self::getUsersByProject($project, "$contacts_table.`company_id` = " . DB::escape($company->getId()));
    } // getCompanyUsersByProject
    
    /**
    * Return all projects that this user is part of
    *
    * @access public
    * @param User $user
    * @param 
    * @return array
    */
    function getProjectsByUser(User $user, $additional_conditions = null, $additional_sort = null) {
      trace(__FILE__, "getProjectsByUser(user, $additional_conditions, $additional_sort)");
      $projects_table = Projects::instance()->getTableName(true);
      trace(__FILE__, "getProjectsByUser():1");
      $project_users_table=  ProjectUsers::instance()->getTableName(true);
      trace(__FILE__, "getProjectsByUser():2");
      $project_milestones_table=  ProjectMilestones::instance()->getTableName(true);
      trace(__FILE__, "getProjectsByUser():3");
      $empty_datetime = DB::escape(EMPTY_DATETIME);
      $projects = array();

      if (trim($additional_sort) == 'milestone') {
        $sql = "SELECT distinct $projects_table.* FROM $projects_table";
        $sql .= " left outer join $project_milestones_table on $project_milestones_table.`project_id` = $projects_table.`id`";
        $sql .= " inner join $project_users_table on $projects_table.`id` = $project_users_table.`project_id`";
        $sql .= " where $project_users_table.`user_id` = " . DB::escape($user->getId()) . " and ($project_milestones_table.`completed_on` = $empty_datetime or isnull($project_milestones_table.`completed_on`))";
      } else {
        $sql = "SELECT $projects_table.* FROM $projects_table, $project_users_table WHERE ($projects_table.`id` = $project_users_table.`project_id` AND $project_users_table.`user_id` = " . DB::escape($user->getId()) . ')';
      }

      if(trim($additional_conditions) <> '') {
        $sql .= " AND ($additional_conditions)";
      } // if

      if(trim($additional_sort) == 'priority') {
        $sql .= " ORDER BY isnull($projects_table.`priority`), $projects_table.`priority`, $projects_table.`name`";
      } elseif (trim($additional_sort) == 'milestone') {
	      $sql .= " ORDER BY isnull($project_milestones_table.`due_date`), $project_milestones_table.`due_date`, $projects_table.`name` ";
      } else {
        $sql .= " ORDER BY $projects_table.`name`";
      }

      trace(__FILE__, "getProjectsByUser(): sql=$sql");
      $rows = DB::executeAll($sql);
      trace(__FILE__, "getProjectsByUser(): sql=$sql ok");
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
      ProjectUserPermissions::delete(array('`project_id` = ?', $project->getId()));
      return self::delete(array('`project_id` = ?', $project->getId()));
    } // clearByProject
    
    /**
    * Clear permission by user
    *
    * @param User $user
    * @return boolean
    */
    static function clearByUser(User $user) {
      // project_id 0 means permission outside any project like can manage projects
      ProjectUserPermissions::delete(array('`user_id` = ? AND `project_id` > 0', $user->getId()));
      return self::delete(array('`user_id` = ?', $user->getId()));
    } // clearByUser
    
  } // ProjectUsers 

?>