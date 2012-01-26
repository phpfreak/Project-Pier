<h1><?php echo $project->getName()."<br>\n"; ?></h1>
<hr>
<?php 
	foreach ($taskLists as $taskList) {
	$milestone = $taskList->getMilestone();
	if ($milestone instanceof Milestone) {
		echo "<b>".lang('milestone')?>:</b> <?php echo $taskList->getMilestone()->getName()."<br>\n";
	} ?>
<b><?php echo lang('task list')?>:</b> <?php echo $taskList->getName()."<br>\n"; ?>
<ul style="list-style-type:none;">
<?php
$condition = 'task_list_id = '.$taskList->getId();
if (!$settings->getReportsIncludeEveryone()) {
    $condition .= " and assigned_to_user_id = ".$user->getId();
}
$condition .= " and completed_on > Interval -7 day + now()";
$tasks = ProjectTasks::findAll(array('conditions' => $condition));

foreach ($tasks as $task) {
	echo "<li>&#x2713 - ";
	echo "<a href='".str_replace('&amp;', '&', externalUrl($task->getViewUrl()))."'>";
    echo $task->getText();
    echo "</a> ";
    if ($settings->getReportsIncludeEveryone() && ($task->getCompletedBy()->getId() != $user->getId())) {
    	echo " - <i>completed by ".$task->getCompletedBy()->getObjectName()."</i> - ";
	}
   	echo "completed on ";
   	$time = $task->getCompletedOn()->getTimestamp() + $offset;
   	echo gmdate('l, F j Y', $time);
	echo "</li>\n";
}
?>
</ul>
<hr>
<?php } ?>
<?php if (count($logs)) { ?>
<h2>Project Activity Log</h2>
<table border=1 style="border-collapse: collapse;" class="applicationLogs blank">
  <tr>
	<th><?php echo lang('action');?></th>
    <th><?php echo lang('application log date column name') ?></th>
    <th><?php echo lang('application log by column name') ?></th>
  </tr>
<?php foreach ($logs as $log) { ?>
	<tr>
		<td>
		<?php echo $log->getObjectTypeName()." "; ?>
		<?php if ($log_url = $log->getObjectUrl()) { ?>
      			<a href="<?php echo $log_url ?>"><?php echo clean($log->getText()) ?></a>
		<?php } else { ?>
      		<?php echo clean($log->getText()) ?>
		<?php } // if ?>
		</td>	
		<td>
		    <?php if ($log->isToday()) { 
      				echo lang('today') . ' ' . clean(format_time($log->getCreatedOn()));
    			} elseif ($log->isYesterday()) { 
     				echo lang('yesterday') . ' ' . clean(format_time($log->getCreatedOn()));
    			} else { 
      				echo clean(format_date($log->getCreatedOn()));
    			} // if ?>
		</td>
		<td>
		    <?php echo '<a href="' . $log->getTakenBy()->getCardUrl() . '">' . clean($log->getTakenBy()->getDisplayName()) . '</a>'; ?>
		</td>
	</tr>
	<?php  } ?>
</table>
<hr>
<?php } ?>
