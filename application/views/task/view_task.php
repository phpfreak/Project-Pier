<?php
  trace(__FILE__,'start');
  set_page_title(lang('view task'));
  project_tabbed_navigation('tasks');
  project_crumbs(array(
    array(lang('tasks'), get_url('task')),
    array($task_list->getName(), $task_list->getViewUrl()),
    array(lang('view task'))
  ));

  $options = array();
  if($task->canEdit(logged_user())) $options[] = '<a href="' . $task->getEditUrl() . '">' . lang('edit') . '</a>';
  if($task->canDelete(logged_user())) $options[] = '<a href="' . $task->getDeleteUrl() . '">' . lang('delete') . '</a>';
  if (plugin_active('time')) {
    if(ProjectTime::canAdd(logged_user(), active_project())) {
      $options[] = '<a href="' . get_url('time', 'add', array( 'task' => $task->getId() ) ) . '">' . lang('add time') . '</a>';
    }
  }
  if($task->canChangeStatus(logged_user())) {
    if ($task->isOpen()) {
      $options[] = '<a href="' . $task->getCompleteUrl() . '">' . lang('mark task as completed') . '</a>';
    } else {
      $options[] = '<a href="' . $task->getOpenUrl() . '">' . lang('open task') . '</a>';
    } // if
  } // if
?>

<div id="taskDetails" class="block">
  <div class="header"><?php echo (do_textile('[' .$task->getId() . '] ' . $task->getText())) ?></div>
  <div class="content">
    <div id="taskInfo">
<?php if (!is_null($task->getStartDate())) { ?>
<?php   if ($task->getStartDate()->getYear() > DateTimeValueLib::now()->getYear()) { ?>
      <div class="startDate"><span><?php echo lang('start date') ?>:</span> <?php echo format_date($task->getStartDate(), null, 0) ?></div>
<?php   } else { ?>
      <div class="startDate"><span><?php echo lang('start date') ?>:</span> <?php echo format_descriptive_date($task->getStartDate(), 0) ?></div>
<?php   } // if ?>
<?php } // if ?>
<?php if (!is_null($task->getDueDate())) { ?>
<?php   if ($task->getDueDate()->getYear() > DateTimeValueLib::now()->getYear()) { ?>
      <div class="dueDate"><span><?php echo lang('due date') ?>:</span> <?php echo format_date($task->getDueDate(), null, 0) ?></div>
<?php   } else { ?>
      <div class="dueDate"><span><?php echo lang('due date') ?>:</span> <?php echo format_descriptive_date($task->getDueDate(), 0) ?></div>
<?php   } // if ?>
<?php } // if ?>
	  <?php if($task->getAssignedTo()) { ?>
	    <div id="taskAssigned"><?php echo lang('milestone assigned to', clean($task->getAssignedTo()->getObjectName())) ?></div>
	  <?php } // if ?>
	  <?php if(count($options)) { ?>
        <div id="taskOptions"><?php echo implode(' | ', $options) ?></div>
	   <?php } // if ?>
    </div>
  </div>
  <div class="clear"></div>
</div>

<?php echo render_object_comments($task, $task->getViewUrl()) ?>