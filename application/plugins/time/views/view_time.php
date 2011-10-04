<?php
  add_stylesheet_to_page('project/time.css');
?>
<div class="time block">

<?php if($time->isPrivate()) { ?>
    <div class="private" title="<?php echo lang('private time') ?>"><span><?php echo lang('private time') ?></span></div>
<?php } // if ?>

    <div class="header">
<?php if($time->canChangeStatus(logged_user())) { ?>
<?php } // if?>

<?php if($time->getAssignedTo() instanceof ApplicationDataObject) { ?>
        <span class="assignedTo"><?php echo clean($time->getAssignedTo()->getObjectName()) ?>:</span>
<?php } // if ?>
      <a href="<?php echo $time->getViewUrl() ?>"><?php echo clean($time->getName()) ?></a>
    </div>
    <div class="content">
<?php if($time->getDoneDate()->getYear() > DateTimeValueLib::now()->getYear()) { ?>
      <div class="doneDate"><span><?php echo lang('done date') ?>:</span> <?php echo format_date($time->getDoneDate(), null, 0) ?></div>
<?php } else { ?>
      <div class="doneDate"><span><?php echo lang('done date') ?>:</span> <?php echo format_descriptive_date($time->getDoneDate(), 0) ?></div>
<?php } // if ?>
      <div class="hours"><span><?php echo lang('hours') ?>:</span> <?php echo $time->getHours() ?></div>
      
<?php if($time->getDescription()) { ?>
      <div class="description"><?php echo do_textile($time->getDescription()) ?></div>
<?php } // if ?>

<?php
  $options = array();
  if($time->canEdit(logged_user())) $options[] = '<a href="' . $time->getEditUrl() . '">' . lang('edit') . '</a>';
  if($time->canDelete(logged_user())) $options[] = '<a href="' . $time->getDeleteUrl() . '" onclick="return confirm(\'' . lang('confirm delete time') . '\')">' . lang('delete') . '</a>';
?>
<?php if(count($options)) { ?>
      <div class="timeOptions"><?php echo implode(' | ', $options) ?></div>
<?php } // if ?>
    </div>
    
</div>