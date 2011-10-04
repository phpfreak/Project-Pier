<?php

  set_page_title(lang('delete message'));
  project_tabbed_navigation('messages');
  project_crumbs(lang('delete message'));

?>
<form action="<?php echo $message->getDeleteUrl() ?>" method="post">
  <?php tpl_display(get_template_path('form_errors')) ?>

  <div><?php echo lang('about to delete') ?> <?php echo lc(lang('message')) ?> <b><?php echo clean($message->getTitle()) ?></b></div>

  <div>
    <label><?php echo lang('confirm delete message') ?></label>
    <?php echo yes_no_widget('deleteMessage[really]', 'deleteMessageReallyDelete', false, lang('yes'), lang('no')) ?>
  </div>

  <div>
    <?php echo label_tag(lang('password')) ?>
    <?php echo password_field('deleteMessage[password]', null, array('id' => 'loginPassword', 'class' => 'medium')) ?>
  </div>

  <?php echo submit_button(lang('delete message')) ?> <a href="<?php echo get_url('message') ?>"><?php echo lang('cancel') ?></a>
</form>