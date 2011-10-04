<?php 
add_stylesheet_to_page('project/progressbar.css');
$open = 0;
$done = 0;
$total = 0; 
$task_lists = $milestone->getTaskLists();
if (is_array($task_lists)) {
  foreach($task_lists as $task_list) {
    $open += count($task_list->getOpenTasks());
    $done += count($task_list->getCompletedTasks());
    $total += $task_list->countAllTasks();
  }
} // if
if ($total>0) {
  $percent = round($done * 100 / $total);
} else { 
  $percent = 0;
} // if
$completed = $milestone->getCompletedOn();
?>

<?php if ($total>0) { ?>
<div class="progressBar">
<?php if (!empty($completed)) { ?>
  <div class="progressBarCompleted" style="width:100%"></div>
  <div class="progressBarText"><?php echo lang('completed') ?>: <?php echo format_date($completed) ?></div>
<?php } else if ($total > 0) { ?>
  <div class="progressBarCompleted" style="width:<?php echo $percent ?>%"></div>
  <div class="progressBarText"><?php echo lang('completed') ?>: <?php echo $percent ?>% (<?php echo $done ?> of <?php echo $total ?>)</div>
<?php } else { ?>
  <div class="progressBarText"><?php echo lang('open tasks') . ': 0' ?></div> 
<?php } // if ?>
</div>
<?php } // if ?>