<?php
  set_page_title($task->isNew() ? lang('add task') : lang('edit task'));
  project_tabbed_navigation('tasks');
  project_crumbs(array(
    array(lang('tasks'), get_url('task')),
    array($task_list->getName(), $task_list->getViewUrl()),
    array($task->isNew() ? lang('add task') : lang('edit task'))
  ));
  add_page_action(lang('add task list'), get_url('task', 'add_list'));

?>
<?php if ($task->isNew()) { ?>
<form action="<?php echo $task_list->getAddTaskUrl($back_to_list) ?>" method="post">
<?php } else { ?>
<form action="<?php echo $task->getEditUrl() ?>" method="post">
<?php } // if ?>

<?php tpl_display(get_template_path('form_errors')) ?>

<?php if (!$task->isNew()) { ?>
  <div>
    <?php echo label_tag(lang('task list'), 'addTaskTaskList', true) ?>
    <?php echo select_task_list('task[task_list_id]', active_project(), array_var($task_data, 'task_list_id'), false, array('id' => 'addTaskTaskList')) ?>
  </div>
<?php } // if ?>

  <div>
    <?php echo label_tag(lang('text'), 'addTaskText', true) ?>
    <?php echo textarea_field("task[text]", array_var($task_data, 'text'), array('id' => 'addTaskText', 'class' => 'short')) ?>
  </div>
  <div>
    <?php echo label_tag(lang('start date'), 'addTaskStartDate', false) ?>
    <?php echo pick_date_widget('task_start_date', array_var($task_data, 'start_date')) ?>
  </div>
  <div>
    <?php echo label_tag(lang('due date'), 'addTaskDueDate', false) ?>
    <?php echo pick_date_widget('task_due_date', array_var($task_data, 'due_date')) ?>
  </div>
  <div>
    <?php echo label_tag(lang('assign to'), 'addTaskAssignedTo', false) ?>
    <?php echo assign_to_select_box("task[assigned_to]", active_project(), array_var($task_data, 'assigned_to')) ?>
  </div>
  <div>
    <?php echo label_tag(lang('send notification'), 'sendNotification', false) ?>
    <?php echo checkbox_field('task[send_notification]', array_var($task_data, 'send_notification'), array_var($task_data, 'send_notification')) ?>
  </div>
  
  <?php echo submit_button($task->isNew() ? lang('add task') : lang('edit task')) ?>
</form>