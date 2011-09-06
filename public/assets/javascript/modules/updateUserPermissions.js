App.modules.updateUserPermissions = {
  project_permissions: [],
  
  projectCheckboxClick : function(project_id) {
    var new_value = $('projectPermissions' + project_id).checked ? 'block' : 'none';
    $('projectPermissionsBlock' + project_id).style.display = new_value;
  }, // projectCheckboxClick
  
  projectAllCheckboxClick: function(project_id) {
    // New value for all checkboxes will be the value of all checkbox
    var new_value = $('projectPermissions' + project_id + 'All').checked;
    
    // And apply
    for(i = 0; i < App.modules.updateUserPermissions.project_permissions.length; i++) {
      var permission_name = App.modules.updateUserPermissions.project_permissions[i];
      $('projectPermission' + project_id + permission_name).checked = new_value;
    } // for
  }, // projectAllCheckboxClick
  
  projectPermissionCheckboxClick: function(project_id) {
    var all_checked = true;
    
    var len = App.modules.updateUserPermissions.project_permissions.length;
    for(i = 0; i < len; i++) {
      var permission_name = App.modules.updateUserPermissions.project_permissions[i];
      if(!$('projectPermission' + project_id + permission_name).checked) {
        all_checked = false;
      } // if
    } // for
    
    $('projectPermissions' + project_id + 'All').checked = all_checked;
  } // projectPermissionCheckboxClick
  
};
