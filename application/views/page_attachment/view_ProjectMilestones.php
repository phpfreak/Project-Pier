<?php
$milestone = $attachment->getObject();
if (!$milestone) {
?>
  <div class="milestoneAttachment">
    <div class="milestoneInfo">
      <span class="milestoneDescription"><?php echo $attachment->getText() ?>:</span>
      <span class="milestoneName"><?php echo lang('edit project to select milestone'); ?></span>
    </div>
    <div class="clear"></div>
  </div>
<?php } else {
  if ($milestone->canView(logged_user())) {
?>
  <div class="milestoneAttachment">
<?php if ($milestone->isPrivate()) { ?>
    <div class="private" title="<?php echo lang('private milestone') ?>"><span><?php echo lang('private milestone') ?></span></div>
<?php } // if ?>
    <div class="milestoneInfo">
      <span class="milestoneDescription"><?php echo $attachment->getText() ?>:</span>
      <span class="milestoneName">
<?php if ($milestone->canChangeStatus(logged_user())) { ?>
  <?php if ($milestone->isCompleted()) { ?>
    <?php echo checkbox_link($milestone->getOpenUrl(), true) ?>
  <?php } else { ?>
    <?php echo checkbox_link($milestone->getCompleteUrl(), false) ?>
  <?php } // if ?>
<?php } else { ?>
  <?php if ($milestone->isCompleted()) { ?>
        <img src="<?php echo get_image_url('icons/checked.jpg'); ?>"/>
  <?php } else { ?>
        <img src="<?php echo get_image_url('icons/not-checked.jpg'); ?>"/>
  <?php } // if ?>
<?php } // if ?>
        <a href="<?php echo $milestone->getViewUrl() ?>" title="<?php echo lang('view milestone') ?>"><?php echo clean($milestone->getName()) ?></a>
<?php if ($milestone->isUpcoming()) { ?>
        <span>(<?php echo format_days('days left', $milestone->getLeftInDays()) ?>)</span>
<?php } elseif ($milestone->isLate()) { ?>
        <span class="error">(<?php echo format_days('days late', $milestone->getLateInDays()) ?>)</span>
<?php } elseif ($milestone->isToday()) { ?>
        <span>(<?php echo lang('today') ?>)</span>
<?php } // if ?>
      </span>
      <div class="milestoneContent">
        <?php
        $content = $milestone->getDescription();
        if (strlen($content) > 150) {
          echo do_textile(substr($content, 0, 150)); ?>
        <a href="<?php echo $milestone->getViewUrl(); ?>" title="<?php echo lang('view milestone'); ?>"><?php echo lang('read more'); ?></a>
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
} // if
?>