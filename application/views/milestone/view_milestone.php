<?php
  add_stylesheet_to_page('project/milestones.css');
?>
<?php if ($milestone->isCompleted()) { ?>
<div class="milestone block success">
<?php } elseif ($milestone->isToday()) { ?>
<div class="milestone block important">
<?php } elseif ($milestone->isLate()) { ?>
<div class="milestone block important">
<?php } else { ?>
<div class="milestone block hint">
<?php } // if?>
    <div class="header">
<?php $this->includeTemplate(get_template_path('view_progressbar', 'milestone')); ?>
<?php if ($milestone->isPrivate()) { ?>
    <div class="private" title="<?php echo lang('private milestone') ?>"><span><?php echo lang('private milestone') ?></span></div>
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
<?php if ($milestone->getAssignedTo() instanceof ApplicationDataObject) { ?>
        <div class="assignedTo"><span><?php echo lang('assigned to') ?>:</span> <?php echo clean($milestone->getAssignedTo()->getObjectName()) ?></div>
<?php } // if ?>
<?php if (!is_null($milestone->getDueDate())) { ?>
<?php if ($milestone->getDueDate()->getYear() > DateTimeValueLib::now()->getYear()) { ?>
      <div class="dueDate messageText"><span><?php echo lang('due date') ?>:</span> <?php echo format_date($milestone->getDueDate(), null, 0) ?></div>
<?php } else { ?>
      <div class="dueDate messageText"><span><?php echo lang('due date') ?>:</span> <?php echo format_descriptive_date($milestone->getDueDate(), 0) ?></div>
<?php } // if ?>
<?php } // if ?>

<?php if ($milestone->getGoal()>0) { ?>
      <div class="goal"><span><?php echo lang('goal') ?>:</span> <?php echo $milestone->getGoal() ?></div>
<?php } // if ?>

<?php if ($milestone->getDescription()) { ?>
      <div class="description"><?php echo do_textile($milestone->getDescription()) ?></div>
<?php } // if ?>

<?php if (plugin_active('tags')) { ?>
  <p><span><?php echo lang('tags') ?>:</span> <?php echo project_object_tags($milestone, $milestone->getProject()) ?></p>
<?php } // if ?>
<?php
  $options = array();
  if ($milestone->canEdit(logged_user())) {
    $options[] = '<a href="' . $milestone->getEditUrl() . '">' . lang('edit') . '</a>';
    $options[] = '<a href="' . $milestone->getAddMessageUrl() . '">' . lang('add message') . '</a>';
    $options[] = '<a href="' . $milestone->getAddTaskListUrl() . '">' . lang('add task list') . '</a>';
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
     <div class="options"><?php echo implode(' | ', $options) ?></div>
<?php } // if ?>

<!-- Messages -->
<?php if (!$milestone->hasMessages() && !$milestone->hasTaskLists()) { ?>
      <p><?php echo lang('empty milestone', $milestone->getAddMessageUrl(), $milestone->getAddTaskListUrl()) ?></p>
<?php } else { ?>
<?php $first = true; ?>
<?php if ($milestone->hasMessages()) { ?>
<?php foreach ($milestone->getMessages() as $message) { ?>
<?php if($message->canView(logged_user())) { ?>
<?php if($first) { ?>
<?php $first = false; ?>
      <div class="block">
      <div class="header"><?php echo lang('messages') ?></div>
      <div class="content"><ul>
<?php } // if ?>
        <li><a href="<?php echo $message->getViewUrl() ?>"><?php echo clean($message->getTitle()) ?></a>
<?php if ($message->getCreatedBy() instanceof User) { ?>
        <span class="desc">(<?php echo lang('posted on by', format_date($message->getUpdatedOn()), $message->getCreatedByCardUrl(), clean($message->getCreatedByDisplayName())) ?>)</span>
        </li>
<?php } // if ?>
<?php } // if ?>
<?php } // foreach ?>
<?php if(!$first) { ?>
      </ul></div></div>
<?php } // if ?>
<?php } // if?>

<!-- Task lists -->
<?php if ($milestone->hasTaskLists()) { ?>
<?php $first = true; ?>
<?php foreach ($milestone->getTaskLists() as $task_list) { ?>
<?php if($task_list->canView(logged_user())) { ?>
<?php if($first) { ?>
      <div class="block">
      <div class="header"><?php echo lang('task lists') ?></div>
      <div class="content"><ul>
<?php $first = false; ?>
<?php } // if?>
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
<?php } // if ?>
<?php } // foreach ?>
<?php if(!$first) { ?>
      </ul></div></div>
<?php } // if ?>
<?php } // if ?>
<?php } // if ?>

<!-- Tickets -->
<?php if ($milestone->hasTickets()) { ?>
  <div class="milestone-progress-wrapper">
      <div class="progress clearfix">
        <div style="width:<?php print $milestone->getPercentageByTicketState('resolved'); ?>%;" class="resolved"><img height="14" width="1" src="<?php print image_url('clear.gif'); ?>" alt=""></img></div>
          <div style="width: <?php print $milestone->getPercentageByTicketState('in_progress'); ?>%;" class="in-progress"><img height="14" width="1" src="<?php print image_url('clear.gif'); ?>" alt=""></img></div>
          <div style="width: <?php print $milestone->getPercentageByTicketState('open'); ?>%;" class="open"><img height="14" width="1" src="<?php print image_url('clear.gif'); ?>" alt=""></img></div>
      </div>
    <div class="ticket-details">
      <?php print $milestone->getPercentageByTicketState('resolved'); ?>% completed -
      Tickets: <a href="<?php print get_url('ticket', 'index', array('active_project' => $milestone->getProjectId(), 'order' => 'ASC', 'status' => 'closed')); ?>">Resolved (<?php print $milestone->hasTicketsByState('resolved'); ?>)</a>,
      <a href="<?php print get_url('ticket', 'index', array('active_project' => $milestone->getProjectId(), 'order' => 'ASC', 'status' => 'pending')); ?>">In Progress (<?php print $milestone->hasTicketsByState('in_progress'); ?>)</a>,
      <a href="<?php print get_url('ticket', 'index', array('active_project' => $milestone->getProjectId(), 'order' => 'ASC', 'status' => 'new,open')); ?>">Open (<?php print $milestone->hasTicketsByState('open'); ?>)</a>
    </div>
  </div>
<p><a onclick="var s=document.getElementById('milestone-tickets-list'); s.style.display = (s.style.display=='none'?'block':'none');" href="#"><?php echo lang('tickets') ?> (<?php print $milestone->getTotalTicketCount(); ?>)</a>:</p>
      <ul id="milestone-tickets-list" class="milestone-tickets" style="display: none;">
<?php foreach ($milestone->getTickets() as $ticket) { ?>
        <li><a href="<?php echo $ticket->getViewUrl() ?>"><?php echo clean($ticket->getTitle()) ?></a>
        <span class="ticket-meta-details">(
          <?php if ($ticket->getStatus()) { ?>
          <span class="ticket-status">Status: <?php echo $ticket->getStatus(); ?></span>
          <?php } ?>

          <?php if ($ticket->getAssignedToUserId() > 0) { ?>
          | <span class="ticket-assigned-to">Assigned To: <?php echo clean($ticket->getAssignedToUser()->getContact()->getDisplayName());  ?></span>
          <?php } ?>

          <?php if ($ticket->getDueDate()) { ?>
          | <span class="ticket-due-date">Due: <?php echo format_date($ticket->getDueDate())  ?></span>
          <?php } ?>)
        </span>
        </li>
<?php } // foreach ?>
      </ul>
<?php } // if ?>

    </div>
    
</div>