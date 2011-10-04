<?php

  set_page_title(lang('delete user'));
  administration_tabbed_navigation(ADMINISTRATION_TAB_PROJECTS);
  administration_crumbs(lang('users'));

?>
<form action="<?php echo $user->getDeleteUrl() ?>" method="post">
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

  <?php echo submit_button(lang('delete user')) ?> <a href="<?php echo $user->getCompany()->getViewUrl() ?>"><?php echo lang('cancel') ?></a>
</form>