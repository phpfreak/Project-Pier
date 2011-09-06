<?php
$message = $attachment->getObject();
if (!$message) {
?>
  <div class="messageAttachment">
    <div class="messageInfo">
      <span class="messageDescription"><?php echo $attachment->getText() ?>:</span>
      <span class="messageName"><?php echo lang('edit project to select message'); ?></span>
    </div>
    <div class="clear"></div>
  </div>
<?php } else {
  if ($message->canView(logged_user())) {
?>
  <div class="messageAttachment">
<?php if ($message->isPrivate()) { ?>
    <div class="private" title="<?php echo lang('private message') ?>"><span><?php echo lang('private message') ?></span></div>
<?php } // if ?>
    <div class="messageInfo">
      <span class="messageDescription"><?php echo $attachment->getText() ?>:</span>
      <span class="messageName"><a href="<?php echo $message->getViewUrl() ?>" title="<?php echo lang('view message') ?>"><?php echo clean($message->getTitle()) ?></a></span>
      <div class="messageContent">
        <?php
        $content = $message->getText();
        if (strlen($content) > 150) {
          echo do_textile(substr($content, 0, 150)); ?>
        <a href="<?php echo $message->getViewUrl(); ?>" title="<?php echo lang('view message'); ?>"><?php echo lang('read more'); ?></a>
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