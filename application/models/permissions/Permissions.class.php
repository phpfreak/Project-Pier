<?php

  /**
  * Permissions
  *
  * @author Brett Edgar (TheWalrus) True Digital Security, Inc. www.truedigitalsecurity.com
  * @http://www.projectpier.org/
  */
  class Permissions extends BasePermissions {
  
    /**
    * Get an array of all Permission objects
    * @param none
    * @return array of Permission objects
    */
    static function getAllPermissions() {
      $map = array();
      $permissions = Permissions::findAll(); // findAll
      if (is_array($permissions)) {
        foreach ($permissions as $permission) {
          $map[$permission->getId()] = array($permission->getSource(),$permission->getName());
        } // foreach
      } // if
      return $map;
    } // getAllPermissions

    static function getPermission($permission_id) {
      //$permission = Permissions::findOne(array('conditions' => '`id` = '.$permission_id));
      $permission = Permissions::findById($permission_id);
      return $permission;
    } // getPermission

    /*
     * Gets the permission (source,permission) combination as a string.
     * @return string in format "source-permission_name_with_underscores"
     */
    static function getPermissionString($permission_id) {
      $permission = Permissions::findById($permission_id);
      return $permission->getSource()."-".preg_replace('/ /','_',$permission->getName());
    } // getPermissionString
    
    static function getPermissionsBySource() {
      $sources = array();
      $permissions = Permissions::findAll(); //findAll
      if (is_array($permissions)) {
        foreach ($permissions as $permission) {
          if (!isset($sources[$permission->getSource()])) {
            $sources[$permission->getSource()] = array();
          } // if
          $sources[$permission->getSource()][] = array($permission->getName(),$permission->getId());
        } // foreach
      } // if
      return $sources;
    } // getSources

    static function getPermissionId($permission_string) {
      $index = strrpos($permission_string,'-');
      $source = substr($permission_string,0,$index);
      $name = substr($permission_string,$index+1);
      $name = preg_replace('/_/',' ',$name);
      $permission = Permissions::findOne(array('conditions' => "`source` = '".$source."' and `permission` = '".$name."'"));
      if (isset($permission)) {
        return $permission->getId();
      } // if
      return false;
    } // getPermissionId
    
  } // Permissions 

?>