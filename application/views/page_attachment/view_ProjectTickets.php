<?php
if (plugin_active('tickets')) {
$ticket = $attachment->getObject();
if (!$ticket) {
?>
  <div class="ticketAttachment">
    <div class="ticketInfo">
      <span class="ticketDescription"><?php echo $attachment->getText() ?>:</span>
      <span class="ticketName"><?php echo lang('edit project to select ticket'); ?></span>
    </div>
    <div class="clear"></div>
  </div>
<?php } else {
  if ($ticket->canView(logged_user())) {
?>
  <div class="ticketAttachment">
<?php if ($ticket->isPrivate()) { ?>
    <div class="private" title="<?php echo lang('private ticket') ?>"><span><?php echo lang('private ticket') ?></span></div>
<?php } // if ?>
    <div class="ticketInfo">
      <span class="ticketDescription"><?php echo $attachment->getText() ?>:</span>
      <span class="ticketName">
<?php if ($ticket->isClosed()) { ?>
        <img src="<?php echo get_image_url('icons/checked.jpg'); ?>"/>
<?php } else { ?>
        <img src="<?php echo get_image_url('icons/not-checked.jpg'); ?>"/>
<?php } // if ?>
        <a href="<?php echo $ticket->getViewUrl() ?>"><?php echo clean($ticket->getSummary()) ?></a>
      </span>
    </div>
    <div class="clear"></div>
  </div>
<?php
  } // if
} // if
} // if
?>