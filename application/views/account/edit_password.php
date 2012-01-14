<?php 
  
  if ($user->getId() == logged_user()->getId()) {
    set_page_title(lang('change password'));
    account_tabbed_navigation();
    account_crumbs(lang('change password'));
  } else {
    set_page_title(lang('change password'));
    if ($user->getCompany()->isOwner()) {
      administration_tabbed_navigation(ADMINISTRATION_TAB_COMPANY);
      administration_crumbs(array(
        array(lang('company'), $user->getCompany()->getViewUrl()),
        array(lang('change password'))
      ));
    } else {
      administration_tabbed_navigation(ADMINISTRATION_TAB_CLIENTS);
      administration_crumbs(array(
        array(lang('clients'), get_url('administration', 'clients')),
        array($user->getCompany()->getName(), $user->getCompany()->getViewUrl()),
        array($user->getDisplayName(), $user->getCardUrl()),
        array(lang('change password'))
      ));
    } // if
  } // if
?>
<div class="icon"><img src="<?php echo $user->getContact()->getAvatarUrl() ?>" alt="<?php echo clean($user->getDisplayName()) ?> <?php echo lang('avatar') ?>" /></div>
<span class="name"><?php echo lang('user') . ': ' ?><a href="<?php echo $user->getCardUrl() ?>"><?php echo clean($user->getDisplayName()) ?></a></span><?php ?><div class="clear"></div>
<form action="<?php echo $user->getEditPasswordUrl($redirect_to) ?>" method="post">
<?php tpl_display(get_template_path('form_errors')) ?>
<?php if (!logged_user()->isAdministrator()) { ?>
  <div>
    <?php echo label_tag(lang('old password'), 'passwordFormOldPassword', true) ?>
    <?php echo password_field('password[old_password]') ?>
  </div>
<?php } // if ?>
  <div>
    <?php echo label_tag(lang('password'), 'passwordFormNewPassword', true) ?>
    <?php echo password_field('password[new_password]') ?>
  </div>
  <div>
    <?php echo label_tag(lang('password again'), 'passwordFormNewPasswordAgain', true) ?>
    <?php echo password_field('password[new_password_again]') ?>
  </div>
  <?php echo submit_button(lang('change password')) ?>
</form>