<?php 

  // Set page title and set crumbs to index
  set_page_title(logged_user()->getDisplayName());
  account_tabbed_navigation();
  account_crumbs(lang('index'));
  add_page_action(array(
    lang('update profile')  => logged_user()->getEditProfileUrl(),
    lang('change password') => logged_user()->getEditPasswordUrl()
  ));
  
  if ($user->canUpdatePermissions(logged_user())) {
    add_page_action(array(
      lang('permissions')  => $user->getUpdatePermissionsUrl()
    ));
  } // if

?>
<?php
  $this->assign('user', logged_user());
  $this->includeTemplate(get_template_path('contact_card', 'contacts'));
?>