<div class="sidebarBlock">
  <h2><?php echo lang('message subscribers') ?></h2>
  <div class="blockContent">
    <p><?php echo lang('subscribers desc') ?></p>
<?php if (isset($subscribers) && is_array($subscribers) && count($subscribers)) { ?>
    <ul>
<?php foreach ($subscribers as $user) { ?>
<?php if ($user->getId() == logged_user()->getId()) { ?>
      <li class="<?php echo odd_even_class($subscriber_ln) ?>"><a href="<?php echo $user->getCardUrl() ?>"><?php echo clean($user->getDisplayName()) ?></a> (<a href="<?php echo $message->getUnsubscribeUrl() ?>" onclick="return confirm('<?php echo lang('confirm unsubscribe') ?>')"><?php echo lang('unsubscribe from message') ?></a>)</li>
<?php } else { ?>
      <li class="<?php echo odd_even_class($subscriber_ln) ?>"><a href="<?php echo $user->getCardUrl() ?>"><?php echo clean($user->getDisplayName()) ?></a></li>
<?php } // if ?>
<?php } // foreach ?>
    </ul>
<?php } else { ?>
    <p><?php echo lang('no subscribers') ?></p>
<?php } // if ?>
<?php if (!$message->isSubscriber(logged_user())) { ?>
    <p><a href="<?php echo $message->getSubscribeUrl() ?>" onclick="return confirm('<?php echo lang('confirm subscribe') ?>')"><?php echo lang('subscribe to message') ?></a></p>
<?php } // if ?>
  </div>
</div>

<?php if ($message->canUpdateOptions(logged_user())) { ?>
<div class="sidebarBlock">
  <h2><?php echo lang('options') ?></h2>
  <div class="blockContent">
    <form action="<?php echo $message->getUpdateOptionsUrl() ?>" method="post">
      <div class="formBlock">
        <div class="odd">
          <label><?php echo lang('private message') ?>:</label>
          <?php echo yes_no_widget('message[is_private]', 'messageFormIsPrivate', $message->isPrivate(), lang('yes'), lang('no')) ?>
        </div>
        <div class="even">
          <label><?php echo lang('important message')?>:</label>
          <?php echo yes_no_widget('message[is_important]', 'messageFormIsImportant', $message->getIsImportant(), lang('yes'), lang('no')) ?>
        </div>
        <div class="odd">
          <label><?php echo lang('enable comments')?>:</label>
          <?php echo yes_no_widget('message[comments_enabled]', 'messageFormEnableComments', $message->getCommentsEnabled(), lang('yes'), lang('no')) ?>
        </div>
        <div class="even">
          <label><?php echo lang('enable anonymous comments')?>:</label>
          <?php echo yes_no_widget('message[anonymous_comments_enabled]', 'messageFormEnableAnonymousComments', $message->getAnonymousCommentsEnabled(), lang('yes'), lang('no')) ?>
        </div>
      </div>
      <?php echo submit_button(lang('update message options'), null) ?>
      <div><a href="<?php echo $message->getEditUrl() ?>"><?php echo lang('edit message') ?></a></div>
    </form>
  </div>
</div>
<?php } // if ?>