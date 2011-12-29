<?php add_stylesheet_to_page('admin/contact_list.css') ?>
<?php if (isset($contacts) && is_array($contacts) && count($contacts)) { ?>
<div id="contactsList">
<?php $counter = 0; ?>
<?php foreach ($contacts as $contact) { ?>
<?php
$counter++;
$user = $contact->getUserAccount();
?>
  <div class="listedContact <?php echo $counter % 2 ? 'even' : 'odd' ?>">
    <div class="icon"><img src="<?php echo $contact->getAvatarUrl() ?>" alt="<?php echo clean($contact->getDisplayName()) ?> <?php echo lang('avatar') ?>" /></div>
    <div class="details">
<?php if (logged_user()->isMemberOfOwnerCompany() && !$contact->isMemberOfOwnerCompany()) { ?>
      <div class="favorite <?php if ($contact->isFavorite()) { echo "on"; } else { echo "off"; }?>">
<?php if (logged_user()->isAdministrator()) { ?>
        <a href="<?php echo $contact->getToggleFavoriteUrl($contact->getCompany()->getViewUrl()); ?>"><img src="<?php echo get_image_url("icons/favorite.png"); ?>" title="<?php echo lang('toggle favorite'); ?>" alt="<?php echo lang('toggle favorite'); ?>"/></a>
<?php } else { ?>
        <img src="<?php echo get_image_url("icons/favorite.png"); ?>" title="<?php echo ($contact->isFavorite() ? lang('favorite') : lang('not favorite')); ?>" alt="<?php echo ($contact->isFavorite() ? lang('favorite') : lang('not favorite')); ?>">
<?php } // if ?>
      </div>
<?php } // if ?>
      <div class="name"><a href="<?php echo $contact->getCardUrl() ?>"><?php echo clean($contact->getDisplayName()) ?></a><?php if ($contact->getTitle() != '') echo " &mdash; ".clean($contact->getTitle()) ?></div>
<?php if ($company->isOwner() && $contact->hasUserAccount()) { ?>
<?php if ($user->isAdministrator()) { ?>
      <span class="userIsAdmin"><?php echo lang('administrator') ?>, </span>
<?php } // if  ?>
<?php if ($user->getAutoAssign()) { ?>
      <span class="userAutoAssign"><?php echo lang('auto assign') ?>, </span>
<?php } // if  ?>
<?php if ($user->getUseLDAP()) { ?>
      <span class="userUseLDAP"><span><?php echo lang('LDAP') ?>, </span>
<?php } // if  ?>
<?php if ($user->canManageProjects()) { ?>
      <span class="userCanManageProjects"><?php echo lang('can manage projects') ?></span>
<?php } // if  ?>
<?php } // if  ?>
<?php
  $options = array();
  if ($contact->canEdit(logged_user())) {
    $options[] = '<a href="' . $contact->getEditUrl() . '">' . lang('edit') . '</a>';
  }
  if ($contact->canDelete(logged_user())) {
    $options[] = '<a href="' . $contact->getDeleteUrl() . '">' . lang('delete') . '</a>';
  } // if
  if ($contact->hasUserAccount()) {
    if ($contact->canEditUserAccount(logged_user())) {
      $options[] = '<a href="' . $contact->getEditUserAccountUrl() . '">' . lang('edit user account') . '</a>';
    }
    if ($contact->canDeleteUserAccount(logged_user())) {
      $options[] = '<a href="' . $contact->getDeleteUserAccountUrl() . '">' . lang('delete user account') . '</a>';
    }
    if ($user->canUpdatePermissions(logged_user())) {
      $options[] = '<a href="' . $user->getUpdatePermissionsUrl() . '">' . lang('update permissions') . '</a>';
    }
  } else {
    if ($contact->canAddUserAccount(logged_user())) {
      $options[] = '<a href="' . $contact->getAddUserAccountUrl() . '">' . lang('add user account') . '</a>';
    }
  }
?>
      <div class="options"><?php echo implode(' | ', $options) ?></div>
      <div class="clear"></div>
    </div>
  </div>  
<?php } // foreach ?>
</div>

<?php } else { ?>
<p><?php echo lang('no contacts in company') ?></p>
<?php } // if ?>