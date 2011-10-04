<?php 
  add_stylesheet_to_page('project/messages.css'); 
?>
<div class="message">
  <div class="block"><div class="header">
<?php if ($message->isPrivate()) { ?>
    <div class="private" title="<?php echo lang('private message') ?>"><span><?php echo lang('private message') ?></span></div>
<?php } // if ?>
    <a href="<?php echo $message->getViewUrl() ?>"><?php echo clean($message->getTitle()) ?></a></div>
    <div class="content">
<?php if ($message->getCreatedBy() instanceof User) { ?>
      <div class="messageAuthor"><?php echo lang('posted on by', format_datetime($message->getCreatedOn()), $message->getCreatedBy()->getCardUrl(), clean($message->getCreatedBy()->getDisplayName())) ?></div>
<?php } else { ?>
      <div class="messageAuthor"><?php echo lang('posted on', format_datetime($message->getCreatedOn())) ?></div>
<?php } // if ?>
      <div class="messageText">
        <?php echo plugin_manager()->apply_filters('all_messages_message_text', do_textile($message->getText())) ?>
        <p><a href="<?php echo $message->getViewUrl() ?>"><?php echo lang('read more') ?></a></p>
      </div>
    <?php echo render_object_files($message, $message->canEdit(logged_user())) ?>
      <div class="messageCommentCount">
<?php if ($message->countComments()) { ?>
        <span><?php echo lang('comments') ?>:</span> <a href="<?php echo $message->getViewUrl() ?>#objectComments"><?php echo $message->countComments() ?></a>
<?php } else { ?>
        <span><?php echo lang('comments') ?>:</span> <?php echo $message->countComments() ?>
<?php } // if ?>
      </div>
    <?php echo render_object_tags($message); ?>
    </div>
<?php
  $extra_options = array();
  if ($message->canDelete(logged_user())) {
    $extra_options[] = '<a href="' . $message->getMoveUrl() . '">' . lang('move') . '</a>';
  } // if
  echo render_object_options($message, $extra_options);
?>
  </div>
</div>