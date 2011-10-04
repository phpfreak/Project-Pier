<?php

  set_page_title(lang('messages'));
  project_tabbed_navigation(PROJECT_TAB_MESSAGES);
  project_crumbs(array(
    array(lang('messages'), get_url('message', 'index')),
    array(lang('index'))
  ));
  if (ProjectMessage::canAdd(logged_user(), active_project())) {
    add_page_action(lang('add message'), get_url('message', 'add'));
  } // if

?>
<?php if (isset($messages) && is_array($messages) && count($messages)) { ?>
<div id="messages">
  <div id="messagesPaginationTop"><?php echo advanced_pagination($messages_pagination, get_url('message', 'index', array('page' => '#PAGE#'))) ?></div>
<?php foreach ($messages as $message) { ?>
<?php 
  $this->assign('message', $message);
  $this->assign('on_message_page', false);
  $this->includeTemplate(get_template_path('view_message', 'message'));
?>
<?php } // foreach ?>
  <div id="messagesPaginationBottom"><?php echo advanced_pagination($messages_pagination, get_url('message', 'index', array('page' => '#PAGE#'))) ?></div>
</div>
<?php } else { ?>
<p><?php echo lang('no messages in project') ?></p>
<?php } // if ?>