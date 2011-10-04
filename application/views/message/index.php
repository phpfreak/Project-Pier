<?php

  set_page_title(lang('messages'));
  project_tabbed_navigation('messages');
  project_crumbs(array(
    array(lang('messages'), get_url('message', 'index')),
    array(lang('index'))
  ));
  if (ProjectMessage::canAdd(logged_user(), active_project())) {
    add_page_action(lang('add message'), get_url('message', 'add'));
  } // if
  $view_image = ($view_type=="list") ?  "list_on.png" : "list_off.png";
  add_view_option(lang('list'), get_image_url("icons/$view_image"), get_url('message', 'index', array('view'=>'list', 'page' => $messages_pagination->getCurrentPage())) );
  $view_image = ($view_type=="card") ?  "excerpt_on.png" : "excerpt_off.png";
  add_view_option(lang('card'), get_image_url("icons/$view_image"), get_url('message', 'index', array('view'=>'card', 'page' => $messages_pagination->getCurrentPage())) );
  $period_image = ($period_type=="fresh") ?  "till7_on.png" : "till7_off.png";
  add_view_option(lang('period'), get_image_url("icons/$period_image"), get_url('message', 'index', array('period'=>'fresh', 'page' => $messages_pagination->getCurrentPage())) );
  $period_image = ($period_type=="archive") ?  "after7_on.png" : "after7_off.png";
  add_view_option(lang('period'), get_image_url("icons/$period_image"), get_url('message', 'index', array('period'=>'archive', 'page' => $messages_pagination->getCurrentPage())) );
?>
<?php if (isset($messages) && is_array($messages) && count($messages)) { ?>
<div id="messages">
<div id="messagesPaginationTop"><?php echo advanced_pagination($messages_pagination, get_url('message', 'index', array('page' => '#PAGE#'))) ?></div>
<?php if ($view_type == 'list') { ?>
<table id="short_messages">
<tr class="message short header"><th></th><th><?php echo lang('date') ?></th><th><?php echo lang('title') ?></th><th><?php echo lang('author'); ?></th><th class="center"><img src="<?php echo get_image_url("icons/comments.png"); ?>" title="<?php echo lang('comments'); ?>" alt="<?php echo lang('comments'); ?>"/></th><th class="center"><img src="<?php echo get_image_url("icons/attach.png"); ?>" title="<?php echo lang('attachments'); ?>" alt="<?php echo lang('attachments'); ?>"/></th></tr>
<?php $odd_or_even = "even"; ?>
<?php foreach ($messages as $message) { ?>
<?php
  $this->assign('message', $message);
  $this->assign('on_message_page', false);
  $this->assign('odd_or_even', $odd_or_even);
  $this->includeTemplate(get_template_path('view_message_short', 'message'));
  $odd_or_even = ($odd_or_even == "odd" ? "even" : "odd");
?>
<?php } // foreach ?>
  </table>
  <?php } else { ?>
<?php foreach ($messages as $message) { ?>
<?php
      $this->assign('message', $message);
      $this->assign('on_message_page', false);
      $this->includeTemplate(get_template_path('view_message', 'message'));
    ?>
<?php } // foreach ?>
  <?php } // if ?>
  <div id="messagesPaginationBottom"><?php echo advanced_pagination($messages_pagination, get_url('message', 'index', array('page' => '#PAGE#'))) ?></div>
</div>
<?php } else { ?>
<p><?php echo lang('no messages in project') ?></p>
<?php } // if ?>