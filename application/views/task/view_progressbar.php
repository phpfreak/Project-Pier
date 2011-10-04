<?php 
add_stylesheet_to_page('project/progressbar.css');
if (is_array($task_list->getOpenTasks())) { 
  $openTasks = count($task_list->getOpenTasks());
} else { 
  $openTasks = 0;
} // if
if (is_array($task_list->getOpenTasks())) { 
  $completedTasks = count($task_list->getCompletedTasks());
} else { 
  $completedTasks = 0;
} // if
$totalTasks = $task_list->countAllTasks();
if ($totalTasks>0) {
  $percentTasks = round($completedTasks / $totalTasks * 100);
} else { 
  $percentTasks = 0;
} // if
$completed = $task_list->getCompletedOn();
?>
<?php if (!empty($completed)) { ?>
<div class="progressBar">
  <div class="progressBarCompleted" style="width:100%"></div>
  <div class="progressBarText"><?php echo lang('completed') ?>: <?php echo format_date($completed) ?></div>
</div>
<?php } else if ($totalTasks > 0) { ?>
<div class="progressBar">
  <div class="progressBarCompleted" style="width:<?php echo $percentTasks ?>%"></div>
  <div class="progressBarText"><?php echo lang('completed') ?>: <?php echo $percentTasks ?>% (<?php echo $completedTasks ?> of <?php echo $totalTasks ?>)</div>
</div>
<?php } else { ?>
<!--  <div class="progressBarText"><?php echo lang('no open task in task list') ?></div> -->
<?php } // if ?>