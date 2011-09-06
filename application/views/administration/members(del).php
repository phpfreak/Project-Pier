<?php

  set_page_title(lang('members'));
  administration_tabbed_navigation(ADMINISTRATION_TAB_MEMBERS);
  administration_crumbs(lang('members'));
  if (User::canAdd(logged_user(), owner_company())) {
    add_page_action(array(
      lang('add user') => owner_company()->getAddUserUrl()
    ));
  } // if

?>
<?php $this->includeTemplate(get_template_path('list_users', 'administration')) ?>
