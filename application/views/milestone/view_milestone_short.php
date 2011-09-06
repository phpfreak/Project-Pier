<?php
  add_stylesheet_to_page('project/milestones.css');
?>
<tr class="<?php
if ($milestone->isCompleted()) {
  echo "completed ";
}
if ($milestone->isLate()) {
  echo "late ";
}
if ($milestone->isToday()) {
  echo "today ";
}
if ($milestone->isUpcoming()) {
  echo "upcoming ";
}?>">
  <td class="milestoneCompleted"><?php if ($milestone->canChangeStatus(logged_user())) { ?>
  <?php if ($milestone->isCompleted()) { ?>
  <?php echo checkbox_link($milestone->getOpenUrl(), true) ?>
  <?php } else { ?>
  <?php echo checkbox_link($milestone->getCompleteUrl(), false) ?>
  <?php } // if ?>
  <?php } // if?>
  </td>
  <td class="milestoneDueDate"><?php echo format_date($milestone->getDueDate(), null, 0); ?></td>
  <td class="milestoneTitle"><?php if ($milestone->isPrivate()) { ?>
      <div class="private" title="<?php echo lang('private milestone') ?>"><span><?php echo lang('private milestone') ?></span></div><?php } // if ?><?php if ($milestone->getAssignedTo() instanceof ApplicationDataObject) { ?>
          <span class="assignedTo"><?php echo clean($milestone->getAssignedTo()->getObjectName()) ?>:</span>
  <?php } // if ?><a href="<?php echo $milestone->getViewUrl(); ?>"><?php echo clean($milestone->getName()); ?></a></td>
  <td class="milestoneDaysLeft"><?php if ($milestone->isUpcoming()) { ?>
   (<?php echo format_days('days left', $milestone->getLeftInDays()) ?>)
  <?php } elseif ($milestone->isLate()) { ?>
   (<?php echo format_days('days late', $milestone->getLateInDays()) ?>)
  <?php } elseif ($milestone->isToday()) { ?>
   (<?php echo lang('today') ?>)
  <?php } // if ?></td>
  <td class="milestoneCommentsCount"><?php echo count($milestone->getComments()) ?></td>
</tr>