<?php
  /**
  * PermissionManager
  *
  * @author Brett Edgar (TheWalrus) True Digital Security, Inc. www.truedigitalsecurity.com
  * @version 1.1
  * @http://www.projectpier.org/
  * @update Reinier van Loon (phpfreak), CAN_MANAGE_PROJECTS
  * @update Reinier van Loon (phpfreak), CAN_CHANGE_STATUS_MILESTONES
  */
class PermissionManager {

  /** Built-in user permissions **/
  const CAN_ACCESS_MESSAGES          = 'messages-access';
  const CAN_MANAGE_MESSAGES          = 'messages-manage';
  const CAN_ACCESS_TASKS             = 'tasks-access';
  const CAN_MANAGE_TASKS             = 'tasks-manage';
  const CAN_MANAGE_MILESTONES        = 'milestones-manage';
  const CAN_ACCESS_FILES             = 'files-access';
  const CAN_UPLOAD_FILES             = 'files-upload';
  const CAN_MANAGE_FILES             = 'files-manage';
  const CAN_ASSIGN_TO_OWNERS         = 'tasks-assign_to_owner_company';
  const CAN_ASSIGN_TO_OTHER          = 'tasks-assign_to_other_clients';
  const CAN_MANAGE_PROJECTS          = 'projects-manage';
  const CAN_CHANGE_STATUS_MILESTONES = 'milestones-change_status';
  const CAN_ACCESS_FORMS             = 'forms-access';

  const CAN_ACCESS                   = 'access';
  const CAN_ADD                      = 'add';
  const CAN_VIEW                     = 'view';
  const CAN_DELETE                   = 'delete';
  
  function init() {
    if (isset($this) && ($this instanceof PermissionManager)) {
      
    } else {
      PermissionManager::instance()->init();
    } // if
  }

  /**
  * Return single PermissionManager instance
  *
  * @access public
  * @param void
  * @return PluginManager 
  */
  static function instance() {
    static $instance;
    if (!($instance instanceof PermissionManager )) {
      $instance = new PermissionManager();
    } // if
    return $instance;
  } // instance
  
  /*
  * Get the localized permission text for displaying to the user
  * @return array mapping the permission string to the localized text for that permission string
  *
  */
  function getPermissionsText() {
    static $instance_permText;
    if (is_array($instance_permText)) {
      return $instance_permText;
    }
    $permText = array();
    $permsBySource = Permissions::getPermissionsBySource();
    foreach ($permsBySource as $source => $permissions) {
      foreach ($permissions as $permission) {
        $text = explode(' ',$permission[0],2);
        if (count($text) == 2) {
          $plang = "can ".$text[0]." ".$source." ".$text[1];
        } else {
          $plang = "can ".$text[0]." ".$source;
        } // if
        // TODO: any 'projects' permission hidden for now
        if ($source != 'projects') {
          $permText[$source."-".preg_replace('/ /','_',$permission[0])] = lang($plang);
        }
      } // foreach
    } // foreach
    $instance_permText = $permText;
    asort($instance_permText);
    return $instance_permText;
  } //getPermissionsText

  /*
  * Add a permission source,name combination to the database
  *
  */
  static function addPermission($source,$name) {
    if (Permissions::findOne(array('conditions' => "`source` = '".$source."' and `permission` = '".$name."'"))) {
      return false; // permission already exists
    }
    $permission = new Permission();
    $permission->setSource($source);
    $permission->setName($name);
    return $permission->save();
  } //addPermission

  /*
  * Remove a permission source,name combination from the database
  *
  */
  static function removePermission($source,$name) {
    $permission = Permissions::findOne(array('conditions' => "`source` = '".$source."' and `permission` = '".$name."'"));
    if (isset($permission) && $permission instanceof Permission) {
      PermissionManager::removeUserPermissions($permission);
      $permission->delete();
      return true; // permission removed
    }
    return false; // permission does not exist
  }

  /*
  * Remove all permissions from the specified source from the database
  *
  */  
  static function removeSource($source) {
    $permissions = Permissions::findAll(array('conditions' => "`source` = '".$source."'"));
    if (is_array($permissions)) {
      foreach ($permissions as $permission) {
        PermissionManager::removeUserPermissions($permission);
        $permission->delete();
      }
      return true; // permission source removed
    }
    return false; // permission source does not exist
  }

  /*
  * Remove all user permissions for the specified permission from the database
  *
  */  
  static function removeUserPermissions($permission) {
    $user_permissions = ProjectUserPermissions::findAll(array('conditions' => "`permission_id` = '".$permission->getId()."'"));
    foreach ($user_permissions as $user_permission) {
      $user_permission->delete();
    }
  }
  
}
?>