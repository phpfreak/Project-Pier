<?php

  if ($user->getId() == logged_user()->getId()) {
    set_page_title(lang('update avatar'));
    account_tabbed_navigation();
    account_crumbs(lang('update avatar'));
  } else {
    set_page_title(lang('update avatar'));
    if ($user->getCompany()->isOwner()) {
      administration_tabbed_navigation(ADMINISTRATION_TAB_COMPANY);
      administration_crumbs(array(
        array(lang('company'), $user->getCompany()->getViewUrl()),
        array(lang('update avatar'))
      ));
    } else {
      administration_tabbed_navigation(ADMINISTRATION_TAB_CLIENTS);
      administration_crumbs(array(
        array(lang('clients'), get_url('administration', 'clients')),
        array($user->getCompany()->getName(), $user->getCompany()->getViewUrl()),
        array($user->getDisplayName(), $user->getCardUrl()),
        array(lang('update avatar'))
      ));
    } // if
  } // if
  
  if ($user->canUpdateProfile(logged_user())) {
    add_page_action(array(
      lang('update profile')  => $user->getEditProfileUrl(),
      lang('change password') => $user->getEditPasswordUrl(),
      lang('update avatar')   => $user->getUpdateAvatarUrl()
    ));
  } // if
  
  if ($user->canUpdatePermissions(logged_user())) {
    add_page_action(array(
      lang('permissions')  => $user->getUpdatePermissionsUrl()
    ));
  } // if

?>
<form action="<?php echo $user->getUpdateAvatarUrl($redirect_to) ?>" method="post" enctype="multipart/form-data">

<?php tpl_display(get_template_path('form_errors')) ?>
  
  <fieldset>
    <legend><?php echo lang('current avatar') ?></legend>
<?php if ($user->hasAvatar()) { ?>
    <img src="<?php echo $user->getAvatarUrl() ?>" alt="<?php echo clean($user->getDisplayName()) ?> avatar" />
<?php } else { ?>
    <?php echo lang('no current avatar') ?>
<?php } // if ?>
<?php if ($user->getUseGravatar()) { ?>
  <div>
    <?php echo lang('avatar from gravatar') ?>
  </div>
<?php } else { ?>
<?php if ($user->hasAvatar()) { ?>
    <p><a href="<?php echo $user->getDeleteAvatarUrl() ?>" onclick="return confirm('<?php echo lang('confirm delete current avatar') ?>')"><?php echo lang('delete current avatar') ?></a></p>
<?php } // if ?>    

  <div>
    <?php echo label_tag(lang('new avatar'), 'avatarFormAvatar', true) ?>
    <?php echo file_field('new avatar', null, array('id' => 'avatarFormAvatar')) ?>
<?php if ($user->hasAvatar()) { ?>
    <p class="desc"><?php echo lang('new avatar notice') ?></p>
<?php } // if ?>
  </div>
  
  <?php echo submit_button(lang('update avatar')) ?>
<?php } // if ?>    
  </fieldset>
  
</form>