<?php 

  // Set page title and set crumbs to index
  set_page_title(lang('user card of', $user->getDisplayName()));
  dashboard_tabbed_navigation();
  dashboard_crumbs($user->getDisplayName());
  if ($user->canUpdateProfile(logged_user())) {
    add_page_action(array(
      lang('update profile')  => $user->getEditProfileUrl(),
      lang('change password') => $user->getEditPasswordUrl()
    ));
  } // if
  
  if ($user->canUpdatePermissions(logged_user())) {
    add_page_action(array(
      lang('permissions')  => $user->getUpdatePermissionsUrl()
    ));
  } // if

?>
<?php 
  $this->includeTemplate(get_template_path('user_card', 'user')) 
?>