<?php 

  set_page_title($milestone->isNew() ? lang('add milestone') : lang('edit milestone'));
  project_tabbed_navigation('milestones');
  project_crumbs(array(
    array(lang('milestones'), get_url('milestone')),
    array($milestone->isNew() ? lang('add milestone') : lang('edit milestone'))
  ));
  
?>
<?php if ($milestone->isNew()) { ?>
<form action="<?php echo get_url('milestone', 'add') ?>" method="post">
<?php } else { ?>
<form action="<?php echo $milestone->getEditUrl() ?>" method="post">
<?php } // if ?>

<?php tpl_display(get_template_path('form_errors')) ?>

  <div>
    <?php echo label_tag(lang('name'), 'milestoneFormName', true) ?>
    <?php echo text_field('milestone[name]', array_var($milestone_data, 'name'), array('class' => 'long', 'id' => 'milestoneFormName')) ?>
  </div>
  
  <div>
    <?php echo label_tag(lang('description'), 'milestoneFormDesc') ?>
    <?php echo textarea_field('milestone[description]', array_var($milestone_data, 'description'), array('class' => 'short', 'id' => 'milestoneFormDesc')) ?>
  </div>
  
  <div>
    <?php echo label_tag(lang('due date'), null, true) ?>
    <?php echo pick_date_widget('milestone_due_date', array_var($milestone_data, 'due_date')) ?>
  </div>

<?php if (logged_user()->getProjectPermission($milestone->getProject(), 'milestones-edit_goal')) { ?>
  <div>
    <?php echo label_tag(lang('goal'), 'milestoneFormGoal') ?>
    <?php echo input_field('milestone[goal]', array_var($milestone_data, 'goal'), array('class' => 'short', 'id' => 'milestoneFormGoal')) ?>
  </div>
<?php } // if ?>
  
<?php if (logged_user()->isMemberOfOwnerCompany()) { ?>
  <div class="formBlock">
    <label><?php echo lang('private milestone') ?>: <span class="desc">(<?php echo lang('private milestone desc') ?>)</span></label>
    <?php echo yes_no_widget('milestone[is_private]', 'milestoneFormIsPrivate', array_var($milestone_data, 'is_private'), lang('yes'), lang('no')) ?>
  </div>
<?php } // if ?>
  
  <div class="formBlock">
    <div>
      <?php echo label_tag(lang('assign to'), 'milestoneFormAssignedTo') ?>
      <?php echo assign_to_select_box('milestone[assigned_to]', active_project(), array_var($milestone_data, 'assigned_to'), array('id' => 'milestoneFormAssignedTo')) ?>
    </div>
    <div><?php echo checkbox_field('milestone[send_notification]', array_var($milestone_data, 'send_notification', true), array('id' => 'milestoneFormSendNotification')) ?> <label for="milestoneFormSendNotification" class="checkbox"><?php echo lang('send milestone assigned to notification') ?></label></div>
  </div>

<?php if (plugin_active('tags')) { ?>
  <div class="formBlock">
    <?php echo label_tag(lang('tags'), 'milestoneFormTags') ?>
    <?php echo project_object_tags_widget('milestone[tags]', active_project(), array_var($milestone_data, 'tags'), array('id' => 'milestoneFormTags', 'class' => 'long')) ?>
  </div>
<?php } // if ?>

  <?php echo submit_button($milestone->isNew() ? lang('add milestone') : lang('edit milestone')) ?>
</form>