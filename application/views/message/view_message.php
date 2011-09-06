<?php 
  add_stylesheet_to_page('project/messages.css'); 
?>
<div class="message">
  <div class="block">
<?php if ($message->isPrivate()) { ?>
    <div class="private" title="<?php echo lang('private message') ?>"><span><?php echo lang('private message') ?></span></div>
<?php } // if ?>
    <div class="header"><a href="<?php echo $message->getViewUrl() ?>"><?php echo clean($message->getTitle()) ?></a></div>
    <div class="content">
<?php if ($message->getCreatedBy() instanceof User) { ?>
      <div class="messageAuthor"><?php echo lang('posted on by', format_datetime($message->getCreatedOn()), $message->getCreatedBy()->getCardUrl(), clean($message->getCreatedBy()->getDisplayName())) ?></div>
<?php } else { ?>
      <div class="messageAuthor"><?php echo lang('posted on', format_datetime($message->getCreatedOn())) ?></div>
<?php } // if ?>
      <div class="messageText">
        <?php echo do_textile($message->getText()) ?>
        <p><a href="<?php echo $message->getViewUrl() ?>"><?php echo lang('read more') ?></a></p>
      </div>
<?php if (plugin_active('files')) { ?>    
    <?php echo render_object_files($message, $message->canEdit(logged_user())) ?>
<?php } // if ?>
      <div class="messageCommentCount">
<?php if ($message->countComments()) { ?>
        <span><?php echo lang('comments') ?>:</span> <a href="<?php echo $message->getViewUrl() ?>#objectComments"><?php echo $message->countComments() ?></a>
<?php } else { ?>
        <span><?php echo lang('comments') ?>:</span> <?php echo $message->countComments() ?>
<?php } // if ?>
      </div>
<?php if (plugin_active('tags')) { ?>
      <div class="messageTags">
        <span><?php echo lang('tags') ?>:</span> <?php echo project_object_tags($message, $message->getProject()) ?>
      </div>    
<?php } // if ?>
<?php
  $options = array();
  if ($message->canEdit(logged_user())) {
    $options[] = '<a href="' . $message->getEditUrl() . '">' . lang('edit') . '</a>';
  } // if
  if ($message->canDelete(logged_user())) {
    $options[] = '<a href="' . $message->getDeleteUrl() . '">' . lang('delete') . '</a>';
  } // if
?>
<?php if (count($options)) { ?>
      <div class="messageOptions"><?php echo implode(' | ', $options) ?></div>
<?php } // if ?>
    </div>
  </div>
</div>
