<?php

  set_page_title(lang('company'));
  if ($company->isOwner()) {
    administration_tabbed_navigation(ADMINISTRATION_TAB_COMPANY);
    administration_crumbs(lang('company'));
  } else {
    administration_tabbed_navigation(ADMINISTRATION_TAB_CLIENTS);
    administration_crumbs(array(
      array(lang('clients'), get_url('administration', 'clients')),
      array($company->getName())
    ));
  } // if
  
  if ($company->canEdit(logged_user())) {
    add_page_action(lang('edit company'), $company->getEditUrl());
    add_page_action(lang('edit company logo'), $company->getEditLogoUrl());
    if (!$company->isOwner()) {
      add_page_action(lang('update permissions'), $company->getUpdatePermissionsUrl());
    } // if
  } // if
  if (Contact::canAdd(logged_user(), $company)) {
    add_page_action(lang('add contact'), $company->getAddContactUrl());
  } // if

?>
<?php $this->includeTemplate(get_template_path('company_card', 'company')) ?>

<h1><?php echo lang('contacts') ?></h1>
<?php
  $this->assign('contacts', $company->getContacts());
  $this->includeTemplate(get_template_path('list_contacts', 'administration'));
?>
<h1><?php echo lang('users') ?></h1>
<?php
  $this->assign('users', $company->getUsers());
  $this->includeTemplate(get_template_path('list_users', 'administration'));
?>
<h1><?php echo lang('projects') ?></h1>
<?php
  $this->assign('active_projects', $company->getActiveProjects());
  $this->includeTemplate(get_template_path('list_projects', 'administration'));
?>