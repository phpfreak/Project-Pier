<?php

  set_page_title(lang('delete user account'));
  if ($company->isOwner()) {
    administration_tabbed_navigation(ADMINISTRATION_TAB_COMPANY);
    administration_crumbs(array(
      array(lang('company'), $company->getViewUrl()),
      array($contact->getDisplayName(), $contact->getCardUrl()),
      array(lang('delete user account'))
    ));
  } else {
    administration_tabbed_navigation(ADMINISTRATION_TAB_CLIENTS);
    administration_crumbs(array(
      array(lang('clients'), get_url('administration', 'clients')),
      array($company->getName(), $company->getViewUrl()),
      array($contact->getDisplayName(), $contact->getCardUrl()),
      array(lang('delete user account'))
    ));
  } // if

?>
<form action="<?php echo $contact->getDeleteUserAccountUrl() ?>" method="post">
  <?php tpl_display(get_template_path('form_errors')) ?>

  <div><?php echo lang('about to delete') ?> <b><?php echo clean($user->getDisplayName()) ?></b></div>

  <div>
    <label><?php echo lang('confirm delete user') ?></label>
    <?php echo yes_no_widget('deleteUser[really]', 'deleteUserReallyDelete', false, lang('yes'), lang('no')) ?>
  </div>

  <div>
    <?php echo label_tag(lang('password')) ?>
    <?php echo password_field('deleteUser[password]', null, array('id' => 'loginPassword', 'class' => 'medium')) ?>
  </div>

  <?php echo submit_button(lang('delete user')) ?> <a href="<?php echo $company->getViewUrl() ?>"><?php echo lang('cancel') ?></a>
</form>