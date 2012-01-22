<?php
  add_stylesheet_to_page('project/task_list.css');
  $task_list_options = array();
  if ($task_list->canEdit(logged_user())) {
    $task_list_options[] = '<a href="' . $task_list->getEditUrl() . '">' . lang('edit') . '</a>';
  } // if
  if (ProjectTaskList::canAdd(logged_user(), active_project())) {
    $task_list_options[] = '<a href="' . $task_list->getCopyUrl() . '">' . lang('copy') . '</a>';
    $task_list_options[] = '<a href="' . $task_list->getMoveUrl() . '">' . lang('move') . '</a>';
  } // if
  if ($task_list->canDelete(logged_user())) {
    $task_list_options[] = '<a href="' . $task_list->getDeleteUrl() . '">' . lang('delete') . '</a>';
  } // if
  if ($task_list->canAddTask(logged_user())) {
    $task_list_options[] = '<a href="' . $task_list->getAddTaskUrl() . '">' . lang('add task') . '</a>';
  } // if
  if ($task_list->canReorderTasks(logged_user())) {
    $task_list_options[] = '<a href="' . $task_list->getReorderTasksUrl($on_list_page) . '">' . lang('reorder tasks') . '</a>';
  } // if
  if ($cc = $task_list->countComments()) {
    $task_list_options[] = '<span><a href="'. $task_list->getViewUrl() .'#objectComments">'. lang('comments') .'('. $cc .')</a></span>';
  }
  $task_list_options[] = '<span><a href="'. $task_list->getDownloadUrl() .'">'. lang('download') . '</a></span>';
  $task_list_options[] = '<span><a href="'. $task_list->getDownloadUrl('pdf') .'">'. lang('pdf') . '</a></span>';
?>
<div class="taskList">
<div class="block" id="taskList<?php echo $task_list->getId() ?>">
  <div class="header"><a href="<?php echo $task_list->getViewUrl() ?>"><?php echo clean($task_list->getName()) ?></a>
<?php if ($task_list->isPrivate()) { ?>
    <div class="private" title="<?php echo lang('private task list') ?>"><span><?php echo lang('private task list') ?></span></div>
<?php } // if ?>
<?php $this->includeTemplate(get_template_path('view_progressbar', 'task')); ?>
  </div>
  <div class="content">
<?php if (!is_null($task_list->getDueDate())) { ?>
<?php if ($task_list->getDueDate()->getYear() > DateTimeValueLib::now()->getYear()) { ?>
      <div class="dueDate"><span><?php echo lang('due date') ?>:</span> <?php echo format_date($task_list->getDueDate(), null, 0) ?></div>
<?php } else { ?>
      <div class="dueDate"><span><?php echo lang('due date') ?>:</span> <?php echo format_descriptive_date($task_list->getDueDate(), 0) ?></div>
<?php } // if ?>
<?php } // if ?>
<?php if ($task_list->getScore()>0) { ?>
      <div class="score"><span><?php echo lang('score') ?>:</span> <?php echo $task_list->getScore() ?></div>
<?php } // if ?>
<?php if ($task_list->getDescription()) { ?>
  <div class="desc"><?php echo (do_textile($task_list->getDescription())) ?></div>
<?php } // if ?>
<?php if (plugin_active('tags')) { ?>
  <div class="tags"><span><?php echo lang('tags') ?>:</span> <?php echo project_object_tags($task_list, $task_list->getProject()) ?></div>
<?php } ?>
<?php if (count($task_list_options)) { ?>
  <div class="options"><?php echo implode(' | ', $task_list_options) ?></div>
<?php } // if ?>
<?php if (is_array($task_list->getOpenTasks())) { ?>
  <div class="openTasks">
    <table class="blank">
<?php foreach ($task_list->getOpenTasks() as $task) { ?>
      <tr class="<?php odd_even_class($task_list_ln); ?>">
<!-- Task text and options -->
        <td class="taskText">
          <?php echo (do_textile('[' .$task->getId() . '] ' . $task->getText())) ?>
<?php if (!is_null($task->getStartDate())) { ?>
<?php if ($task->getStartDate()->getYear() > DateTimeValueLib::now()->getYear()) { ?>
      <div class="startDate"><span><?php echo lang('start date') ?>:</span> <?php echo format_date($task->getStartDate(), null, 0) ?></div>
<?php } else { ?>
      <div class="startDate"><span><?php echo lang('start date') ?>:</span> <?php echo format_descriptive_date($task->getStartDate(), 0) ?></div>
<?php } // if ?>
<?php } // if ?>
<?php if (!is_null($task->getDueDate())) { ?>
<?php if ($task->getDueDate()->getYear() > DateTimeValueLib::now()->getYear()) { ?>
      <div class="dueDate"><span><?php echo lang('due date') ?>:</span> <?php echo format_date($task->getDueDate(), null, 0) ?></div>
<?php } else { ?>
      <div class="dueDate"><span><?php echo lang('due date') ?>:</span> <?php echo format_descriptive_date($task->getDueDate(), 0) ?></div>
<?php } // if ?>
<?php } // if ?>
<?php
  $task_options = array();
  if ($task->getAssignedTo()) { 
    $task_options[] = '<span class="assignedTo">' . clean($task->getAssignedTo()->getObjectName()) . '</span>';
  } // if
  if ($task->canEdit(logged_user())) {
    $task_options[] = '<a href="' . $task->getEditUrl() . '">' . lang('edit') . '</a>';
  } // if
  if ($task->canDelete(logged_user())) {
    $task_options[] = '<a href="' . $task->getDeleteUrl() . '">' . lang('delete') . '</a>';
  } // if
  if ($task->canView(logged_user())) {
    $task_options[] = '<a href="' . $task->getViewUrl($on_list_page) . '">' . lang('view') . '</a>';
  } // if
  if ($cc = $task->countComments()) {
    $task_options[] = '<a href="' . $task->getViewUrl() .'#objectComments">'. lang('comments') .'('. $cc .')</a>';
  }
  if ($task->canChangeStatus(logged_user())) {
    if ($task->isOpen()) {
      $task_options[] = '<a href="' . $task->getCompleteUrl() . '">' . lang('mark task as completed') . '</a>';
    } else {
      $task_options[] = '<span>' . lang('open task') . '</span>';
    } // if
  } // if
?>
<?php if (count($task_list_options)) { ?>
  <div class="options"><?php echo implode(' | ', $task_options) ?></div>
<?php } // if ?>
        </td>
      </tr>
<?php } // foreach ?>
    </table>
  </div>
<?php } else { ?>
  <?php //echo lang('no open task in task list') ?>
<?php } // if ?>
<?php if (is_array($task_list->getCompletedTasks())) { ?>
  <div class="completedTasks expand-container-completed">
<?php   if ($on_list_page) { ?>
<?php     echo lang('completed tasks') ?>:
<?php   } else { ?>
<?php     echo lang('recently completed tasks') ?>:
<?php   } // if ?>
    <table class="blank expand-block-completed">
<?php $counter = 0; ?>
<?php foreach ($task_list->getCompletedTasks() as $task) { ?>
<?php $counter++; ?>
<?php if ($on_list_page || ($counter <= 5)) { ?>
      <tr>
        <td class="taskText"><?php echo (do_textile('[' .$task->getId() . '] ' . $task->getText())) ?>
<?php
  $task_options = array();
  if ($task->getCompletedBy()) {
    $task_options[] = '<span class="taskCompletedOnBy">' . lang('completed on by', format_date($task->getCompletedOn()), $task->getCompletedBy()->getCardUrl(), clean($task->getCompletedBy()->getDisplayName())) . '</span>';
  } else {
    $task_options[] = '<span class="taskCompletedOnBy">' . lang('completed on', format_date($task->getCompletedOn())) . '</span>';
  } //if 
  if ($task->canEdit(logged_user())) {
    $task_options[] = '<a href="' . $task->getEditUrl() . '">' . lang('edit') . '</a>';
  } // if
  if ($task->canDelete(logged_user())) {
    $task_options[] = '<a href="' . $task->getDeleteUrl() . '">' . lang('delete') . '</a>';
  } // if
  if ($task->canView(logged_user())) {
    $task_options[] = '<a href="' . $task->getViewUrl($on_list_page) . '">' . lang('view') . '</a>';
  } // if
  if ($cc = $task->countComments()) {
    $task_options[] = '<a href="' . $task->getViewUrl() .'#objectComments">'. lang('comments') .'('. $cc .')</a>';
  }
  if ($task->canChangeStatus(logged_user())) {
      $task_options[] = '<a href="' . $task->getOpenUrl() . '">' . lang('mark task as open') . '</a>';
  } else {
      $task_options[] = '<span>' . lang('completed task') . '</span>';
  } // if
?>
<?php if (count($task_list_options)) { ?>
  <div class="options"><?php echo implode(' | ', $task_options) ?></div>
<?php } // if ?>
        </td>
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
<?php } // if (is_array($task_list->getCompletedTasks())) ?>
</div><?php // div class="taskListExpanded" ?>
</div>
</div>