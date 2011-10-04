<?php

  /**
  * ProjectUser class
  *
  * @http://www.projectpier.org/
  */
  class ProjectUser extends BaseProjectUser {

    private $permissions = array();
   
    function getPermissions() {
      trace(__FILE__,'getPermissions()');
      if (count($this->permissions) == 0) {
        $this->permissions = ProjectUserPermissions::getPermissionsForProjectUser($this);
      }
      return $this->permissions;
    } // getPermissions
  
  } // ProjectUser 
?>