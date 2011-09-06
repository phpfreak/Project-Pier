<?php

  set_page_title(lang('update permissions').' '.lc(lang('user')).' "'.$user->getDisplayName().'"' );
  if ($user->getCompany()->isOwner()) {
    administration_tabbed_navigation(ADMINISTRATION_TAB_COMPANY);
    administration_crumbs(array(
      array(lang('company'), $user->getCompany()->getViewUrl()),
      array($user->getDisplayName(), $user->getCardUrl()),
      array(lang('update permissions'))
    ));
  } else {
    administration_tabbed_navigation(ADMINISTRATION_TAB_CLIENTS);
    administration_crumbs(array(
      array(lang('clients'), get_url('administration', 'clients')),
      array($user->getCompany()->getName(), $user->getCompany()->getViewUrl()),
      array($user->getDisplayName(), $user->getCardUrl()),
      array(lang('update permissions'))
    ));
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
  
  add_stylesheet_to_page('admin/user_permissions.css');

?>
<script>
  $(function() {
    $('.selectall').click(function() {
      var checked_status = this.checked;
      var prefix = this.id;
      $('input[id^="'+(prefix)+'"]').each(function() {
        this.checked = checked_status;
      });
    });
  });
</script>
<?php
  $quoted_permissions = array();
  foreach ($permissions as $permission_id => $permission_text) {
    $quoted_permissions[] = "'$permission_id'";
  } // foreach
?>
<?php if (isset($projects) && is_array($projects) && count($projects)) { ?>
<div id="userPermissions">
  <form action="<?php echo $user->getUpdatePermissionsUrl($redirect_to) ?>" method="post">
    <div id="userProjects">
      <table class="blank">
<!-- header -->
        <tr>
          <td class="projectName"><?php echo lang('project') ?></td>
          <td class="projectPermission"><strong><?php echo lang('all') ?></strong></td>
<?php foreach ($permissions as $permission_name => $permission_text) { ?>
          <td class="projectPermission"><?php echo clean($permission_text) ?></td>
<?php } // foreach ?>
        </tr>
<!-- projects -->
<?php foreach ($projects as $project) { ?>
        <tr>
          <td class="projectName">
            <?php echo clean($project->getName()) ?>
<?php if ($project->isCompleted()) { ?>
            <small><?php echo lang('project completed on by', format_date($project->getCompletedOn()), $project->getCompletedByDisplayName()) ?></small>
<?php } // if ?>
          </td>
          <td class="projectPermission center">
          <?php echo checkbox_field('project_permission_' . $project->getId(), false, array('id' => 'projectPermission' . $project->getId(), 'class' => 'checkbox selectall' )) ?>
          </td>
<?php foreach ($permissions as $permission_name => $permission_text) { ?>
          <td class="projectPermission center">
            <?php echo checkbox_field('project_permission_' . $project->getId() . '_' . $permission_name, $user->getProjectPermission($project, $permission_name), array('id' => 'projectPermission' . $project->getId() ."-". $permission_name )) ?>
          </td>
<?php } // foreach ?>
        </tr>
<?php } // foreach ?>
      </table>
    </div>
    <input type="hidden" name="submitted" value="submitted" />
    <?php echo submit_button(lang('update permissions')) ?>  <a href="<?php echo $user->getCardUrl() ?>"><?php echo lang('cancel') ?></a>
  </form>
</div>
<?php } // if ?>
