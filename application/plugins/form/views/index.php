<?php

  set_page_title(lang('forms'));
  project_tabbed_navigation(PROJECT_TAB_FORMS);
  project_crumbs(lang('forms'));
  if (ProjectForm::canAdd(logged_user(), active_project())) {
    add_page_action(lang('add form'), get_url('form', 'add'));
  } // if

?>
<?php if (isset($forms) && is_array($forms) && count($forms)) { ?>
<div id="projectForms">
<?php foreach ($forms as $form) { ?>
  <div class="block">
    <div class="header"><?php echo clean($form->getName()) ?></div>
    <div class="content">
<?php if (trim($form->getDescription())) { ?>
      <div class="description"><?php echo do_textile($form->getDescription()) ?></div>
<?php } // if ?>
      <div class="successMessage"><em><?php echo lang('success message') ?>:</em> <?php echo clean($form->getSuccessMessage()) ?></div>

<?php if ($form->getInObject() instanceof ApplicationDataObject) { ?>

<?php if ($form->getAction() == ProjectForm::ADD_COMMENT_ACTION) { ?>
      <div class="action"><em><?php echo lang('project form action') ?></em>: <?php echo lang('add comment to message', $form->getInObjectUrl(), clean($form->getInObjectName())) ?></div>
<?php } else { ?>
      <div class="action"><em><?php echo lang('project form action') ?></em>: <?php echo lang('add task to list', $form->getInObjectUrl(), clean($form->getInObjectName())) ?></div>
<?php } // if ?>

<?php } else { ?>
     <div class="action error"><?php echo lang('related project form object dnx') ?></div>
<?php } // if ?>

      <div class="successMessage"><em><?php echo lang('project form enabled') ?>:</em> <?php echo $form->getIsEnabled() ? lang('yes') : lang('no') ?></div>
      <div class="successMessage"><em><?php echo lang('project form visible') ?>:</em> <?php echo $form->getIsVisible() ? lang('yes') : lang('no') ?></div>    
<?php
  $options = array();
  if ($form->canSubmit(logged_user())) {
    $options[] = '<a href="' . $form->getSubmitUrl() . '">' . lang('submit project form') . '</a>';
  }
  if ($form->canEdit(logged_user())) {
    $options[] = '<a href="' . $form->getEditUrl() . '">' . lang('edit') . '</a>';
  }
  if ($form->canDelete(logged_user())) {
    $options[] = '<a href="' . $form->getDeleteUrl() . '" onclick="return confirm(\'' . lang('confirm delete project form') . '\')">' . lang('delete') . '</a>';
  }
?>
<?php if (count($options)) { ?>
      <div class="options"><?php echo implode(' | ', $options) ?></div>
<?php } // if ?>
    </div>
  </div>
<?php } // forach ?>
</div>
<?php } else { ?>
<p><?php echo lang('no forms in project') ?></p>
<?php } // if ?>