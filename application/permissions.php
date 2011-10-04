<?php

  /* Permissions loader
   * @author Brett Edgar (TheWalrus) True Digital Security, Inc. www.truedigitalsecurity.com
   * @version 1.0
   * @http://www.projectpier.org/
   */
  trace(__FILE__,'begin');
  include 'models/PermissionManager.class.php';
// init the permission manager
  trace(__FILE__,'initialize permission manager');
  PermissionManager::instance()->init();
  /*
   * Convenience function for instance of PermissionManager used by hooks throughout
   */
  function permission_manager() {
    return PermissionManager::instance();
  }
  
  function add_permission($source, $permission_to_add) {
    permission_manager()->addPermission($source,$permission_to_add);
  }

  function remove_permission($source, $permission_to_remove) {
    permission_manager()->removePermission($source,$permission_to_add);
  }

  function remove_permission_source($source) {
    permission_manager()->removeSource($source);
  }

  function use_permitted($user, $project, $source) {
    if (!($project instanceof Project)) return false;
    if ($user->isAdministrator()) return true;
    if ($user->getProjectPermission($project, $source . '-access')) {
      return true;
    }
    return $user->getProjectPermission($project, $source . '-manage');
  }
  trace(__FILE__,'end');
?>