<?php

  /**
  * ProjectCompany class
  *
  * @http://www.projectpier.org/
  */
  class ProjectCompany extends BaseProjectCompany {
    
    /**
    * Cached company part of the relation
    *
    * @var Company
    */
    private $company;
    
    /**
    * Project part of the relation
    *
    * @var Project
    */
    private $project;
    
    /**
    * Return relation company
    *
    * @param void
    * @return Company
    */
    function getCompany() {
      if (is_null($this->company)) {
        $this->company = Companies::findById($this->getCompanyId());
      } // if
      return $this->company;
    } // getCompany
    
    /**
    * Return project part of the relationship
    *
    * @param void
    * @return Project
    */
    function getProject() {
      if (is_null($this->project)) {
        $this->project = Projects::findById($this->getProjectId());
      } // if
      return $this->project;
    } // getProject
    
    /**
    * Delete project - company relation
    * 
    * This function needs to remove relation from the database and all user - project relations
    *
    * @param void
    * @return boolean
    */
    function delete() {
      $company = $this->getCompany();
      $project = $this->getProject();
      
      if (($company instanceof Company) && ($project instanceof Project)) {
        $users = $company->getUsers();
        if (is_array($users)) {
          foreach ($users as $user) {
            $relation = ProjectUsers::findById(array(
              'project_id' => $project->getId(),
              'user_id' => $user->getId(),
            )); //findById
            
            if ($relation instanceof ProjectUser) {
              $relation->delete();
            } // if
          } // foreach
        } // if
      } // if
      
      return parent::delete();
    } // delete
    
  } // ProjectCompany 

?>