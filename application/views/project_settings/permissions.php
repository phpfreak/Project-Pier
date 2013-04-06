<?php

  set_page_title(lang('permissions'));
  project_tabbed_navigation(PROJECT_TAB_SETTINGS);
  project_crumbs(array(
    array(lang('settings'), get_url('project_settings')),
    array(lang('users'), get_url('project_settings', 'users')),
    array(lang('permissions'))
  ));
  add_stylesheet_to_page('project/permissions.css');

?>
<?php
  $quoted_permissions = array();
  foreach ($permissions as $permission_id => $permission_text) {
    $quoted_permissions[] = "'$permission_id'";
  } // foreach
?>

<?php if (isset($companies) && is_array($companies) && count($companies)) { ?>
<form action="<?php echo ($project_init ? active_project()->getPermissionsUrl(array('project_init' => 1)) : active_project()->getPermissionsUrl()); ?>" method="post">
<div id="projectCompanies">
<?php foreach ($companies as $company) { ?>
<?php if ($company->countUsers() > 0) { ?>
  <div class="projectCompany">
    <div class="projectCompanyLogo"><img src="<?php echo $company->getLogoUrl() ?>" alt="<?php echo clean($company->getName()) ?>" /></div>
    <div class="projectCompanyMeta">
      <div class="projectCompanyTitle">
<?php if ($company->isOwner()) { ?>
        <label><?php echo clean($company->getName()) ?></label>
        <input type="hidden" name="project_company_<?php echo $company->getId() ?>" value="checked" />
<?php } else { ?>
        <?php echo checkbox_field('project_company_' . $company->getId(), $company->isProjectCompany(active_project()), array('id' => 'project_company_' . $company->getId())) ?> <label for="<?php echo 'project_company_' . $company->getId() ?>" class="checkbox"><?php echo clean($company->getName()) ?></label>
<?php } // if ?>
      </div>
      <div class="projectCompanyUsers" id="project_company_users_<?php echo $company->getId() ?>">
        <table class="blank">
<?php if ($users = $company->getUsers()) { ?>
<?php foreach ($users as $user) { ?>
          <tr class="user">
            <td>
<?php if ($user->isAccountOwner()) { ?>
              <img src="<?php echo icon_url('ok.gif') ?>" alt="" /> <label class="checkbox"><?php echo clean($user->getDisplayName()) ?></label>
              <input type="hidden" name="<?php echo 'project_user_' . $user->getId() ?>" value="checked" />
<?php } else { ?>
              <?php echo checkbox_field('project_user_' . $user->getId(), $user->isProjectUser(active_project()), array('id' => 'project_user_' . $user->getId())) ?> <label class="checkbox" for="<?php echo 'project_user_' . $user->getId() ?>"><?php echo clean($user->getDisplayName()) ?></label>
<?php } // if ?>
  
<?php if ($user->isAdministrator()) { ?>
              <span class="desc">(<?php echo lang('administrator') ?>)</span>
<?php } // if ?>
            </td>
            <td>
<?php if (!$company->isOwner()) { ?>
              <div class="projectUserPermissions" id="user_<?php echo $user->getId() ?>_permissions">
                <div><?php echo checkbox_field('project_user_' . $user->getId() . '_all', $user->hasAllProjectPermissions(active_project()), array('id' => 'project_user_' . $user->getId() . '_all')) ?> <label for="<?php echo 'project_user_' . $user->getId() . '_all' ?>" class="checkbox" style="font-weight: bolder"><?php echo lang('all permissions') ?></label></div>
<?php foreach ($permissions as $permission_id => $permission_text) { ?>            
                <div><?php echo checkbox_field('project_user_' . $user->getId() . "_$permission_id", $user->hasProjectPermission(active_project(), $permission_id), array('id' => 'project_user_' . $user->getId() . "_$permission_id")) ?> <label for="<?php echo 'project_user_' . $user->getId() . "_$permission_id" ?>" class="checkbox normal"><?php echo $permission_text ?></label></div>
<?php } // foreach ?>
              </div>
<?php } // if ?>
            </td>
          </tr>
<?php if (!$company->isOwner()) { ?>
          <script type="text/javascript">
            if (!document.getElementById('project_user_<?php echo $user->getId() ?>').checked) {
              document.getElementById('user_<?php echo $user->getId() ?>_permissions').style.display = 'none';
            } // if
          </script>
<?php } // if ?>
<?php } // foreach ?>
<?php } else { ?>
          <tr>
            <td colspan="2"><?php echo lang('no users in company') ?></td>
          </tr>
<?php } // if ?>
        </table>
      </div>
      <div class="clear"></div>
    </div>
  </div>
<?php if (!$company->isOwner()) { ?>
  <script type="text/javascript">
    if (!document.getElementById('project_company_<?php echo $company->getId() ?>').checked) {
      document.getElementById('project_company_users_<?php echo $company->getId() ?>').style.display = 'none';
    } // if
  </script>
<?php } // if ?>
<?php } // if ?>
<?php } // foreach ?>

<?php echo submit_button(lang('update permissions')) ?>
  <input type="hidden" name="process" value="process" />
</div>
</form>
<?php } // if ?>