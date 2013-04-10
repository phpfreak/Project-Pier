<?php

  set_page_title($task_list->isNew() ? lang('add task list') : lang('edit task list'));
  project_tabbed_navigation('tasks');
  project_crumbs(array(
    array(lang('tasks'), get_url('task')),
    array($task_list->isNew() ? lang('add task list') : lang('edit task list'))
  ));
  if ( !$task_list->isNew() ) add_page_action(lang('add task list'), get_url('task', 'add_list'));

?>
<?php if ($task_list->isNew()) { ?>
<form action="<?php echo get_url('task', 'add_list') ?>" method="post">
<?php } else { ?>
<form action="<?php echo $task_list->getEditUrl() ?>" method="post">
<?php } // if ?>

  <?php tpl_display(get_template_path('form_errors')) ?>

  <div>
    <?php echo label_tag(lang('name'), 'taskListFormName', true) ?>
    <?php echo text_field('task_list[name]', array_var($task_list_data, 'name'), array('class' => 'long', 'id' => 'taskListFormName')) ?>
  </div>

  <div>
    <?php echo label_tag(lang('description'), 'taskListFormDescription') ?>
    <?php echo textarea_field('task_list[description]', array_var($task_list_data, 'description'), array('class' => 'short', 'id' => 'taskListFormDescription')) ?>
  </div>
  
  <div class="formBlock">
    <?php echo label_tag(lang('milestone'), 'taskListFormMilestone') ?>
    <?php echo select_milestone('task_list[milestone_id]', active_project(), array_var($task_list_data, 'milestone_id'), array('id' => 'taskListFormMilestone')) ?>
  </div>
  
  <?php if (logged_user()->isMemberOfOwnerCompany()) { ?>
  <div class="formBlock">
    <label><?php echo lang('private task list') ?>: <span class="desc">(<?php echo lang('private task list desc') ?>)</span></label>
    <?php echo yes_no_widget('task_list[is_private]', 'taskListFormIsPrivate', array_var($task_list_data, 'is_private'), lang('yes'), lang('no')) ?>
  </div>
  <?php } // if ?>

<?php if (plugin_active('tags')) { ?>
  <div class="formBlock">
    <?php echo label_tag(lang('tags'), 'taskListFormTags') ?>
    <?php echo project_object_tags_widget('task_list[tags]', active_project(), array_var($task_list_data, 'tags'), array('id' => 'taskListFormTags', 'class' => 'long')) ?>
  </div>
 <?php } // if ?>
  
<?php if ($task_list->isNew()) { ?>
  <h2><?php echo lang('tasks') ?></h2>
  <table class="blank">
    <tr>
      <th>&nbsp;</th>
      <th>&nbsp;</th>
      <th>&nbsp;</th>
    </tr>
<?php for ($i = 0; $i < 6; $i++) { ?>
    <tr class="<?php echo $i % 2 ? 'odd' : 'even' ?>">
      <td><?php echo label_tag(lang('description'), null, false); ?>
        <?php echo textarea_field("task_list[task$i][text]", array_var($task_list_data["task$i"], 'text'), array('class' => 'short')) ?>
      </td>
      <td>
       <?php echo label_tag(lang('due date'), null, false) ?>
       <?php echo pick_date_widget("task_list_task{$i}_due_date", array_var($task_list_data["task$i"], 'due_date')) ?>
      </td>
      <td><?php echo label_tag(lang('assign to'), null, false) ?>
        <?php echo assign_to_select_box("task_list[task$i][assigned_to]", active_project(), array_var($task_list_data["task$i"], 'assigned_to')) ?>
        <?php echo label_tag(lang('send notification'), null, false) ?>
        <?php echo checkbox_field("task_list[task$i][send_notification]", array_var($task_list_data["task$i"], 'send_notification'), array_var($task_list_data["task$i"], 'send_notification')) ?>
      </td>
    </tr>
<?php } // for ?>
  </table>
<?php } // if ?>
  
  <?php echo submit_button($task_list->isNew() ? lang('add task list') : lang('edit task list')) ?>

</form>
