<?php
  $page_title = lang('permissions');
  set_page_title($page_title);
  project_crumbs(lang('permissions'));
  add_stylesheet_to_page('project/permissions.css');
?>
<?php 
$source = array();
$names = array();
$source_id=0;
$name_id=0;

$xpermissions = Permissions::findAll(); // findAll
if (is_array($permissions)) {
  foreach ($xpermissions as $permission) {
    $source_id++;  
    $sources[$permission->getSource()] = option_tag($permission->getSource(), $source_id);
    $name_id++;  
    $names[$permission->getName()] = option_tag($permission->getName(), $name_id);
  } // foreach
} // if
?>
<?php $this->includeTemplate(get_template_path('project/pageactions')); ?>
<?php
  $quoted_permissions = array();
  foreach ($permissions as $permission_id => $permission_text) {
    $quoted_permissions[] = "'$permission_id'";
  } // foreach
?>
<?php if (isset($companies) && is_array($companies) && count($companies)) { ?>
<form action="<?php echo get_url('project', 'permissions') ?>" method="post">
<div id="projectCompanies">
<?php foreach ($companies as $company) { ?>
<?php if ($company->countUsers() > 0) { ?>
  <div class="projectCompany">
    <div class="projectCompanyLogo"><img src="<?php echo $company->getLogoUrl() ?>" alt="<?php echo clean($company->getName()) ?>" /></div>
    <div class="projectCompanyMeta block">
      <div class="header">
<?php if ($company->isOwner()) { ?>
        <label><?php echo clean($company->getName()) ?></label>
        <input type="hidden" name="project_company_<?php echo $company->getId() ?>" value="checked" />
<?php } else { ?>
     <?php echo checkbox_field('project_company_' . $company->getId(), $company->isProjectCompany(active_project()), array('id' => 'project_company_' . $company->getId() )) ?> <label for="<?php echo 'project_company_' . $company->getId() ?>" class="checkbox"><?php echo clean($company->getName()) ?></label>
<?php } // if ?>
      </div>
      <div class="projectCompanyUsers content" id="project_company_users_<?php echo $company->getId() ?>">
        <table class="blank">
<?php if ($users = $company->getUsers()) { ?>
<?php foreach ($users as $user) { ?>
          <tr class="user">
            <td>
<?php if ($user->isAdministrator() || ($user->getId() == active_project()->getCreatedById()) ) { ?>
              <img src="<?php echo icon_url('ok.gif') ?>" alt="" /> <label class="checkbox"><a href="<?php echo $user->getUpdatePermissionsUrl() ?>"><?php echo clean($user->getDisplayName()) ?></a></label>
              <input type="hidden" name="<?php echo 'project_user_' . $user->getId() ?>" value="checked" />
<?php } else { ?>
        <?php echo checkbox_field('project_user_' . $user->getId(), $user->isProjectUser(active_project()), array('id' => 'project_user_' . $user->getId()) ) ?> <label class="checkbox" for="<?php echo 'project_user_' . $user->getId() ?>"><a href="<?php echo $user->getUpdatePermissionsUrl() ?>"><?php echo clean($user->getDisplayName()) ?></a></label>
<?php } // if ?>
  
<?php if ($user->isAdministrator()) { ?>
              <span class="desc">(<?php echo lang('administrator') ?>)</span>
<?php } // if ?>
            </td>
            <td>
<?php if ($company->isOwner()) { ?>
              <img src="<?php echo icon_url('ok.gif') ?>" alt="" /> <label class="checkbox"><strong><?php echo lang('all permissions') ?><strong></label>
<?php } else { ?>
              <div class="projectUserPermissions" id="user_<?php echo $user->getId() ?>_permissions">
<?php //echo select_box( 'source', $sources ); ?>
<?php //echo select_box( 'name', $names );  ?>
<?php //echo 'add permission' ?>
     <div><?php echo checkbox_field('project_user_' . $user->getId() . '', $user->hasAllProjectPermissions(active_project()), array('id' => 'project_user_' . $user->getId() . '', 'class' => 'checkbox selectall' )) ?> <label for="<?php echo 'project_user_' . $user->getId() . '_all' ?>" class="checkbox" ><strong><?php echo lang('all permissions') ?><strong></label></div>
<?php foreach ($permissions as $permission_id => $permission_text) { ?>            
                <div><?php echo checkbox_field('project_user_' . $user->getId() . "_$permission_id", $user->getProjectPermission(active_project(), $permission_id), array('id' => 'project_user_' . $user->getId() . "_$permission_id")) ?> <label for="<?php echo 'project_user_' . $user->getId() . "_$permission_id" ?>" class="checkbox normal"><?php echo $permission_text ?></label></div>
<?php } // foreach ?>
              </div>
<?php } // if ?>
            </td>
          </tr>
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
<?php } // if ?>
<?php } // foreach ?>

<?php echo submit_button(lang('update permissions')) ?>
  <input type="hidden" name="process" value="process" />
</div>
</form>
<?php } // if ?>