<?php

  set_page_title(lang('update permissions'));
  administration_tabbed_navigation(ADMINISTRATION_TAB_CLIENTS);
  administration_crumbs(array(
    array(lang('clients'), get_url('administration', 'clients')),
    array($company->getName(), $company->getViewUrl()),
    array(lang('update permissions'))
  ));
  
?>
<?php if (isset($projects) && is_array($projects) && count($projects)) { ?>
<div id="companyPermissions">
  <div class="hint">
    <div class="header"><?php echo lang('hint') ?></div>
    <div class="content"><?php echo lang('update company permissions hint') ?></div>
  </div>
  <form action="<?php echo $company->getUpdatePermissionsUrl() ?>" method="post">
    <table class="blank">
<?php foreach ($projects as $project) { ?>
      <tr>
        <td><?php echo checkbox_field('project_' . $project->getId(), $company->isProjectCompany($project), array('id' => 'projectPermissionsCheckbox' . $project->getId(), 'disabled' => !logged_user()->isProjectUser($project))) ?></td>
        <td>
          <label for="projectPermissionsCheckbox<?php echo $project->getId() ?>" class="checkbox normal">
<?php if ($project->isCompleted()) { ?>
          <del><span title="<?php echo lang('project completed on by', format_datetime($project->getCompletedOn()), $project->getCompletedByDisplayName()) ?>"><?php echo clean($project->getName()) ?></span></del>
<?php } else { ?>
          <?php echo clean($project->getName()) ?>
<?php } // if ?>
          </label>
        </td>
      </tr>
<?php } // foreach ?>
    </table>
    <input type="hidden" name="submitted" value="submitted" />
    <?php echo submit_button(lang('update permissions')) ?>
  </form>
</div>
<?php } // if ?>