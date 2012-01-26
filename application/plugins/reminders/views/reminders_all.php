<h1><?php echo lang('project').": ".$project->getName(); ?></h1>
<hr>
<?php 
	foreach ($taskLists as $taskList) {
	$milestone = $taskList->getMilestone();
	if ($milestone instanceof Milestone) {
		echo "<b>".lang('milestone')?>:</b> <?php echo $taskList->getMilestone()->getName()."<br>\n";
	} ?>
<b><?php echo lang('task list')?>:</b> <?php echo $taskList->getName()."<br>\n"; ?>
<ol>
<?php
	$condition = 'task_list_id = '.$taskList->getId();
	if (!$settings->getIncludeEveryone()) {
    	$condition .= " and assigned_to_user_id = ".$user->getId();
	}
    $condition .= " and completed_on is null";
    $condition .= " and due_date < Interval ".$settings->getRemindersFuture()." day + now()";
 	$tasks = ProjectTasks::findAll(array('conditions' => $condition));

foreach ($tasks as $task) {
	echo "<li>";
	echo "<a href='".str_replace('&amp;', '&', externalUrl($task->getViewUrl()))."'>";
    echo $task->getText();
    echo "</a> ";
    if ($settings->getIncludeEveryone() && ($task->getAssignedTo()) && ($task->getAssignedTo()->getObjectName() != $user->getObjectName())) {
    	echo " - <i>assigned to ".$task->getAssignedTo()->getObjectName()."</i> - ";
    } else if (!($task->getAssignedTo())) {
    	echo " - <i>assigned to anyone</i> - ";
    }
	if ($task->getDueDate()->isUpcoming()) {
            echo format_days('is future', $task->getDueDate()->getLeftInDays());
	} elseif ($task->getDueDate()->isToday()) { 
        echo "<b>".lang('is today')."</b>";
	} else {
    	echo "<font color=red>".format_days('is late', $task->getDueDate()->getLeftInDays())."</font>";
	}
	echo "</li>\n";
}
?>
</ol>
<hr>
<?php } ?>
