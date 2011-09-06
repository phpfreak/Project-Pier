<?php
  add_stylesheet_to_page('project/task_list.css');
?>
<script type="text/javascript">
  if (App.modules.addTaskForm) {
    App.modules.addTaskForm.task_lists[<?php echo $task_list->getId() ?>] = {
      id               : <?php echo $task_list->getId() ?>,
      can_add_task     : <?php echo $task_list->canAddTask(logged_user()) ? 'true' : 'false' ?>,
      add_task_link_id : 'addTaskForm<?php echo $task_list->getId() ?>ShowLink',
      task_form_id     : 'addTaskForm<?php echo $task_list->getId() ?>',
      text_id          : 'addTaskText<?php echo $task_list->getId() ?>',
      assign_to_id     : 'addTaskAssignTo<?php echo $task_list->getId() ?>',
      submit_id        : 'addTaskSubmit<?php echo $task_list->getId() ?>'
    };
  } // if
</script>
<div class="taskList">
<div class="block" id="taskList<?php echo $task_list->getId() ?>">
<?php if ($task_list->isPrivate()) { ?>
    <div class="private" title="<?php echo lang('private task list') ?>"><span><?php echo lang('private task list') ?></span></div>
<?php } // if ?>
  <div class="header"><a href="<?php echo $task_list->getViewUrl() ?>"><?php echo clean($task_list->getName()) ?></a></div>
<?php if ($task_list->getDescription()) { ?>
  <div class="desc"><?php echo clean($task_list->getDescription()) ?></div>
<?php } // if ?>
  <div class="openTasks">
<?php if (is_array($task_list->getOpenTasks())) { ?>
    <table class="blank">
<?php foreach ($task_list->getOpenTasks() as $task) { ?>
      <tr>
      
<!-- Checkbox -->
<?php if ($task->canChangeStatus(logged_user())) { ?>
<?php if ($on_list_page) { ?>
        <td class="taskCheckbox"><?php echo checkbox_link($task->getCompleteUrl(), false, lang('mark task as completed')) ?></td>
<?php } else { ?>
        <td class="taskCheckbox"><?php echo checkbox_link($task->getCompleteUrl(undo_htmlspecialchars($task_list->getOverviewUrl())), false, lang('mark task as completed')) ?></td>
<?php } // if ?>
<?php } else { ?>
        <td class="taskCheckbox"><img src="<?php echo icon_url('not-checked.jpg') ?>" alt="<?php echo lang('open task') ?>" /></td>
<?php } // if?>

<!-- Task text and options -->
        <td class="taskText">
<?php if ($task->getAssignedTo()) { ?>
          <span class="assignedTo"><?php echo clean($task->getAssignedTo()->getObjectName()) ?>:</span> 
<?php } // if{ ?>
          <?php echo clean($task->getText()) ?> <?php if ($task->canEdit(logged_user())) { ?><a href="<?php echo $task->getEditUrl() ?>" class="blank" title="<?php echo lang('edit task') ?>"><img src="<?php echo icon_url('edit.gif') ?>" alt="" /></a><?php } // if ?> <?php if ($task->canDelete(logged_user())) { ?><a href="<?php echo $task->getDeleteUrl() ?>" class="blank" title="<?php echo lang('delete task') ?>"><img src="<?php echo icon_url('cancel_gray.gif') ?>" alt="" /></a><?php } // if ?>
        </td>
      </tr>
<?php } // foreach ?>
    </table>
<?php } else { ?>
  <?php echo lang('no open task in task list') ?>
<?php } // if ?>
  </div>
  
  <div class="addTask">
<?php if ($task_list->canAddTask(logged_user())) { ?>
    <div id="addTaskForm<?php echo $task_list->getId() ?>ShowLink"><a href="<?php echo $task_list->getAddTaskUrl($on_list_page) ?>" onclick="App.modules.addTaskForm.showAddTaskForm(<?php echo $task_list->getId() ?>); return false"><?php echo lang('add task') ?></a></div>
  
    <div id="addTaskForm<?php echo $task_list->getId() ?>">
      <form action="<?php echo $task_list->getAddTaskUrl($on_list_page) ?>" method="post">
        <div class="taskListAddTaskText">
          <label for="addTaskText<?php echo $task_list->getId() ?>"><?php echo lang('text') ?>:</label>
          <?php echo textarea_field("task[text]", null, array('class' => 'short', 'id' => 'addTaskText' . $task_list->getId())) ?>
        </div>
        <div class="taskListAddTaskAssignedTo">
          <label for="addTaskAssignTo<?php echo $task_list->getId() ?>"><?php echo lang('assign to') ?>:</label>
          <?php echo assign_to_select_box("task[assigned_to]", active_project(), null, array('id' => 'addTaskAssignTo' . $task_list->getId())) ?>
        </div>
        
        <?php echo submit_button(lang('add task'), 's', array('id' => 'addTaskSubmit' . $task_list->getId())) ?> <?php echo lang('or') ?> <a href="#" onclick="App.modules.addTaskForm.hideAddTaskForm(<?php echo $task_list->getId() ?>); return false;"><?php echo lang('cancel') ?></a>
        
      </form>
    </div>
<?php } else { ?>
<?php if ($on_list_page) { ?>
<?php echo lang('completed tasks') ?>:
<?php } else { ?>
<?php echo lang('recently completed tasks') ?>:
<?php } // if ?>
<?php } // if ?>
  </div>
  
<?php if (is_array($task_list->getCompletedTasks())) { ?>
  <div class="completedTasks">
    <table class="blank">
<?php $counter = 0; ?>
<?php foreach ($task_list->getCompletedTasks() as $task) { ?>
<?php $counter++; ?>
<?php if ($on_list_page || ($counter <= 5)) { ?>
      <tr>
<?php if ($task->canChangeStatus(logged_user())) { ?>
        <td class="taskCheckbox"><?php echo checkbox_link($task->getOpenUrl(), true, lang('mark task as open')) ?></td>
<?php } else { ?>
        <td class="taskCheckbox"><img src="<?php echo icon_url('checked.jpg') ?>" alt="<?php echo lang('completed task') ?>" /></td>
<?php } // if ?>
        <td class="taskText">
          <?php echo clean($task->getText()) ?> <?php if ($task->canEdit(logged_user())) { ?><a href="<?php echo $task->getEditUrl() ?>" class="blank" title="<?php echo lang('edit task') ?>"><img src="<?php echo icon_url('edit.gif') ?>" alt="" /></a><?php } // if ?> <?php if ($task->canDelete(logged_user())) { ?><a href="<?php echo $task->getDeleteUrl() ?>" class="blank" title="<?php echo lang('delete task') ?>"><img src="<?php echo icon_url('cancel_gray.gif') ?>" alt="" /></a><?php } // if ?><br />
          <span class="taskCompletedOnBy">(<?php echo lang('completed on by', format_date($task->getCompletedOn()), $task->getCompletedBy()->getCardUrl(), clean($task->getCompletedBy()->getDisplayName())) ?>)</span>
        </td>
        <td></td>
      </tr>
<?php } // if ?>
<?php } // foreach ?>
<?php if (!$on_list_page && $counter > 5) { ?>
      <tr>
        <td colspan="2"><a href="<?php echo $task_list->getViewUrl() ?>"><?php echo lang('view all completed tasks', $counter) ?></a></td>
      </tr>
<?php } // if ?>
    </table>
  </div>
<?php } // if ?>
  <div class="taskListTags"><span><?php echo lang('tags') ?>:</span> <?php echo project_object_tags($task_list, $task_list->getProject()) ?></div>
<?php
  $options = array();
  if ($task_list->canEdit(logged_user())) {
    $options[] = '<a href="' . $task_list->getEditUrl() . '">' . lang('edit') . '</a>';
  } // if
  if ($task_list->canDelete(logged_user())) {
    $options[] = '<a href="' . $task_list->getDeleteUrl() . '">' . lang('delete') . '</a>';
  } // if
  if ($task_list->canReorderTasks(logged_user())) {
    $options[] = '<a href="' . $task_list->getReorderTasksUrl($on_list_page) . '">' . lang('reorder tasks') . '</a>';
  } // if
?>
<?php if (count($options)) { ?>
  <div class="options">
<?php echo implode(' | ', $options) ?>
  </div>
<?php } // if ?>

</div>
</div>
