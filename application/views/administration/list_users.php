<?php add_stylesheet_to_page('admin/user_list.css') ?>
<?php if (isset($users) && is_array($users) && count($users)) { ?>
<div id="usersList">
<?php $counter = 0; ?>
<?php foreach ($users as $user) { ?>
<?php $counter++; ?>
  <div class="listedUser <?php echo $counter % 2 ? 'even' : 'odd' ?>">
    <div class="icon"><img src="<?php echo $user->getContact()->getAvatarUrl() ?>" alt="<?php echo clean($user->getDisplayName()) ?> <?php echo lang('avatar') ?>" /></div>
    <div class="details">
      <span class="name"><a href="<?php echo $user->getCardUrl() ?>"><?php echo clean($user->getDisplayName()) ?></a></span><?php ?>
<?php if ($company->isOwner()) { ?><?php ?>
<?php if ($user->isAdministrator()) { ?>, <span class="userIsAdmin"><?php echo lang('administrator') ?></span><?php } // if  ?>
<?php if ($user->getAutoAssign()) { ?>, <span class="userAutoAssign"><?php echo lang('auto assign') ?></span><?php } // if  ?>
<?php if ($user->getUseLDAP()) { ?>, <span class="userUseLDAP"><?php echo lang('LDAP') ?></span><?php } // if  ?>
<?php if ($user->canManageProjects()) { ?>, <span class="userCanManageProjects"><?php echo lang('can manage projects') ?></span><?php } // if  ?>
<?php } // if  ?>
<?php
  $options = array();
  if ($user->canEdit(logged_user())) { 
    $options[] = '<a href="' . $user->getEditUrl() . '">' . lang('edit') . '</a>';
    $options[] = '<a href="' . $user->getEditPasswordUrl($company->getViewUrl()) . '">' . lang('change password') . '</a>';
  }
  if ($user->canUpdatePermissions(logged_user())) {
    $options[] = '<a href="' . $user->getUpdatePermissionsUrl($company->getViewUrl()) . '">' . lang('permissions') . '</a>';
  } // if
  if ($user->canDelete(logged_user())) {
    $options[] = '<a href="' . $user->getDeleteUrl() . '">' . lang('delete') . '</a>';
  } // if
?>
      <div class="options"><?php echo implode(' | ', $options) ?></div>
      <div class="clear"></div>
    </div>
  </div>  
<?php } // foreach ?>
</div>

<?php } else { ?>
<p><?php echo lang('no users in company') ?></p>
<?php } // if ?>