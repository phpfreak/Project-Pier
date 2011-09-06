<?php
  add_stylesheet_to_page('project/milestones.css');
?>
<?php if ($milestone->isCompleted()) { ?>
<div class="milestone success">
<?php } elseif ($milestone->isToday()) { ?>
<div class="milestone important">
<?php } elseif ($milestone->isLate()) { ?>
<div class="milestone important">
<?php } else { ?>
<div class="milestone hint">
<?php } // if?>

<?php if ($milestone->isPrivate()) { ?>
    <div class="private" title="<?php echo lang('private milestone') ?>"><span><?php echo lang('private milestone') ?></span></div>
<?php } // if ?>

    <div class="header">
<?php if ($milestone->getAssignedTo() instanceof ApplicationDataObject) { ?>
        <span class="assignedTo"><?php echo clean($milestone->getAssignedTo()->getObjectName()) ?>:</span>
<?php } // if ?>
      <a href="<?php echo $milestone->getViewUrl() ?>"><?php echo clean($milestone->getName()) ?></a>
<?php if ($milestone->isUpcoming()) { ?>
 (<?php echo format_days('days left', $milestone->getLeftInDays()) ?>)
<?php } elseif ($milestone->isLate()) { ?>
 (<?php echo format_days('days late', $milestone->getLateInDays()) ?>)
<?php } elseif ($milestone->isToday()) { ?>
 (<?php echo lang('today') ?>)
<?php } // if ?>
    </div>
    <div class="content">
<?php if (!is_null($milestone->getDueDate())) { ?>
<?php if ($milestone->getDueDate()->getYear() > DateTimeValueLib::now()->getYear()) { ?>
      <div class="dueDate"><span><?php echo lang('due date') ?>:</span> <?php echo format_date($milestone->getDueDate(), null, 0) ?></div>
<?php } else { ?>
      <div class="dueDate"><span><?php echo lang('due date') ?>:</span> <?php echo format_descriptive_date($milestone->getDueDate(), 0) ?></div>
<?php } // if ?>
<?php } // if ?>
      
<?php if ($milestone->getDescription()) { ?>
      <div class="description"><?php echo do_textile($milestone->getDescription()) ?></div>
<?php } // if ?>

<!-- Milestones -->
<?php if (!$milestone->hasMessages() && !$milestone->hasTaskLists()) { ?>
      <p><?php echo lang('empty milestone', $milestone->getAddMessageUrl(), $milestone->getAddTaskListUrl()) ?></p>
<?php } else { ?>
<?php if ($milestone->hasMessages()) { ?>
      <p><?php echo lang('messages') ?>:</p>
      <ul>
<?php foreach ($milestone->getMessages() as $message) { ?>
        <li><a href="<?php echo $message->getViewUrl() ?>"><?php echo clean($message->getTitle()) ?></a>
<?php if ($message->getCreatedBy() instanceof User) { ?>
        <span class="desc">(<?php echo lang('posted on by', format_date($message->getUpdatedOn()), $message->getCreatedByCardUrl(), clean($message->getCreatedByDisplayName())) ?>)</span>
<?php } // if ?>
<?php } // foreach ?>
      </ul>
<?php } // if?>

<!-- Task lists -->
<?php if ($milestone->hasTaskLists()) { ?>
      <p><?php echo lang('task lists') ?>:</p>
      <ul>
<?php foreach ($milestone->getTaskLists() as $task_list) { ?>
<?php if ($task_list->isCompleted()) { ?>
        <li><del datetime="<?php echo $task_list->getCompletedOn()->toISO8601() ?>"><a href="<?php echo $task_list->getViewUrl() ?>" title="<?php echo lang('completed task list') ?>"><?php echo clean($task_list->getName()) ?></a></del></li>
<?php } else { ?>
        <li><a href="<?php echo $task_list->getViewUrl() ?>"><?php echo clean($task_list->getName()) ?></a>
<?php
        $this->assign('task_list', $task_list); 
        $this->includeTemplate(get_template_path('view_progressbar', 'task')); 
?>
        </li>
<?php } // if ?>
<?php } // foreach ?>
      </ul>
<?php } // if ?>
<?php } // if ?>
<?php if (plugin_active('tags')) { ?>
  <p><span><?php echo lang('tags') ?>:</span> <?php echo project_object_tags($milestone, $milestone->getProject()) ?></p>
<?php } // if ?>
<?php
  $options = array();
  if ($milestone->canEdit(logged_user())) {
    $options[] = '<a href="' . $milestone->getEditUrl() . '">' . lang('edit') . '</a>';
  }
  if ($milestone->canDelete(logged_user())) {
    $options[] = '<a href="' . $milestone->getDeleteUrl() . '">' . lang('delete') . '</a>';
  }
  if ($milestone->canChangeStatus(logged_user())) {
    if ($milestone->isCompleted()) {
      $options[] = '<a href="' . $milestone->getOpenUrl() . '">' . lang('mark milestone as open') . '</a>';
    } else {
      $options[] = '<a href="' . $milestone->getCompleteUrl() . '">' . lang('mark milestone as completed') . '</a>';
    } // if
  } // if
?>
<?php if (count($options)) { ?>
      <div class="milestoneOptions"><?php echo implode(' | ', $options) ?></div>
<?php } // if ?>
    </div>
    
</div>
