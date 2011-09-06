<?php
$task = $attachment->getObject();
if (!$task) {
?>
  <div class="taskAttachment">
    <div class="taskInfo">
      <span class="taskDescription"><?php echo $attachment->getText() ?>:</span>
      <span class="taskName"><?php echo lang('edit project to select task'); ?></span>
    </div>
    <div class="clear"></div>
  </div>
<?php } else {
  if ($task->canView(logged_user())) {
?>
  <div class="taskAttachment">
<?php if ($task->isPrivate()) { ?>
    <div class="private" title="<?php echo lang('private task') ?>"><span><?php echo lang('private task') ?></span></div>
<?php } // if ?>
    <div class="taskInfo">
      <span class="taskDescription"><?php echo $attachment->getText() ?>:</span>
      <span class="taskName">
<?php if ($task->isCompleted()) { ?>
        <img src="<?php echo get_image_url('icons/checked.jpg'); ?>"/>
<?php } else { ?>
        <img src="<?php echo get_image_url('icons/not-checked.jpg'); ?>"/>
<?php } // if ?>
        <a href="<?php echo $task->getTaskList()->getViewUrl() ?>"><?php echo clean($task->getText()) ?></a>
      </span>
    </div>
    <div class="clear"></div>
  </div>
<?php
  } // if
} // if
?>