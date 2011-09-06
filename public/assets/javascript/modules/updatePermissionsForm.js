App.modules.updatePermissionsForm = {
  owner_company_id: 0,
  project_permissions: [],
  
  /**
   * Click on specific company and change its access status
   *
   * @param integer company_id
   */
  companyCheckboxClick: function(company_id) {
    var new_display_value = $('project_company_' + company_id).checked ? 'block' : 'none';
    $('project_company_users_' + company_id).style.display = new_display_value;
  }, // companyCheckboxClick
  
  /**
   * Click on username and change its access status
   *
   * @param integer user_id
   * @param integer company_id
   */
  userCheckboxClick: function(user_id, company_id) {
    if(company_id == App.modules.updatePermissionsForm.owner_company_id) {
      return;
    } // if
    var new_display_value = $('project_user_' + user_id).checked ? 'block' : 'none';
    $('user_' + user_id + '_permissions').style.display = new_display_value;
  }, // userCheckboxClick
  
  /**
   * Click on All checkbox for specific user and check all or no permissions
   *
   * @param integer user_id
   */
  userPermissionAllCheckboxClick: function(user_id) {
    var new_value = $('project_user_' + user_id + '_all').checked;
    
    for(i = 0; i < App.modules.updatePermissionsForm.project_permissions.length; i++) {
      var permission_name = App.modules.updatePermissionsForm.project_permissions[i];
      $('project_user_' + user_id + '_' + permission_name).checked = new_value;
    } // for
  }, // userPermissionAllCheckboxClick
  
  /**
   * Click on single permission for specific user. If all permissions are checked
   * all checkbox should be checked to, unchecked othervise
   *
   * @param integer user_id
   */
  userPermissionCheckboxClick: function(user_id) {
    var all_checked = true;
    
    var len = App.modules.updatePermissionsForm.project_permissions.length;
    for(i = 0; i < len; i++) {
      var permission_name = App.modules.updatePermissionsForm.project_permissions[i];
      if(!$('project_user_' + user_id + '_' + permission_name).checked) all_checked = false;
    } // for
    
    $('project_user_' + user_id + '_all').checked = all_checked;
  } // user_permission_checkbox_click
  
};
