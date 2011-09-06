<?php
$tasklist = $attachment->getObject();
if (!$tasklist) {
?>
  <div class="tasklistAttachment">
    <div class="tasklistInfo">
      <span class="tasklistDescription"><?php echo $attachment->getText() ?>:</span>
      <span class="tasklistName"><?php echo lang('edit project to select task list'); ?></span>
    </div>
    <div class="clear"></div>
  </div>
<?php } else {
  if ($tasklist->canView(logged_user())) {
?>
  <div class="tasklistAttachment">
<?php if ($tasklist->isPrivate()) { ?>
    <div class="private" title="<?php echo lang('private tasklist') ?>"><span><?php echo lang('private tasklist') ?></span></div>
<?php } // if ?>
    <div class="tasklistInfo">
      <span class="tasklistDescription"><?php echo $attachment->getText() ?>:</span>
      <span class="tasklistName">
<?php if ($tasklist->isCompleted()) { ?>
        <img src="<?php echo get_image_url('icons/checked.jpg'); ?>"/>
<?php } else { ?>
        <img src="<?php echo get_image_url('icons/not-checked.jpg'); ?>"/>
<?php } // if ?>
        <a href="<?php echo $tasklist->getViewUrl() ?>"><?php echo clean($tasklist->getName()) ?></a>
        <span>(<?php echo lang('task open of total tasks', $tasklist->countOpenTasks(), $tasklist->countAllTasks()); ?>)</span>
      </span>
      <div class="tasklistContent">
        <?php
        $content = $tasklist->getDescription();
        if (strlen($content) > 150) {
          echo do_textile(substr($content, 0, 150)); ?>
        <a href="<?php echo $tasklist->getViewUrl(); ?>" title="<?php echo lang('view tasklist'); ?>"><?php echo lang('read more'); ?></a>
<?php   } else {
          echo do_textile($content);
        }
        ?>
      </div>
    </div>
    <div class="clear"></div>
  </div>
<?php
  } // if
} // if ?>