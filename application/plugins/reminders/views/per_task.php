<hr>
<b><?php echo lang('project')?>:</b> <?php echo $project->getName()."<br>\n"; ?>
<?php
	$milestone = $taskList->getMilestone();
	if ($milestone instanceof Milestone) {
		echo "<b>".lang('milestone')?>:</b> <?php echo $taskList->getMilestone()->getName()."<br>\n";
	} ?>
<b><?php echo lang('task list')?>:</b> <?php echo $taskList->getName()."<br>\n"; ?>
<hr>
<?php
    echo "<a href='".str_replace('&amp;', '&', externalUrl($task->getViewUrl()))."'>";
    echo $task->getText();
    echo "</a> ";
    if ($settings->getIncludeEveryone() && ($task->getAssignedTo()) && ($task->getAssignedTo()->getObjectName() != $user->getObjectName())) {
    	echo " - <i>assigned to ".$task->getAssignedTo()->getObjectName()."</i> - ";
    } else if (!($task->getAssignedTo())) {
    	echo " - <i>assigned to anyone</i> - ";
    }

  if ($task->getDueDate()) {
    if ($task->getDueDate()->isUpcoming()) {
      echo format_days('is future', $task->getDueDate()->getLeftInDays());
    } elseif ($task->getDueDate()->isToday()) { 
      echo "<b>".lang('is today')."</b>";
    } else {
      echo "<font color=red>".format_days('is late', $task->getDueDate()->getLeftInDays())."</font>";
    }
  }
?>
<hr>
<a href='<?php echo externalUrl(ROOT_URL) ?>'><?php echo externalUrl(ROOT_URL) ?></a>