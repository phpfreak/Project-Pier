<?php
  set_page_title($tool->getDisplayName());
  administration_tabbed_navigation(ADMINISTRATION_TAB_TOOLS);
  administration_crumbs(array(
    array(lang('administration tools'), get_url('administration', 'tools')),
    array($tool->getDisplayName())
  ));
?>
<form action="<?php echo $tool->getToolUrl() ?>" method="post">
<?php tpl_display(get_template_path('form_errors')) ?>

  <div>
    <?php echo label_tag(lang('test mail recipient'), 'testMailFormRecipient', true) ?>
    <?php echo text_field('test_mail[recipient]', array_var($test_mail_data, 'recipient'), array('id' => 'testMailFormRecipient', 'class' => 'long')) ?>
  </div>
  
  <div>
    <?php echo label_tag(lang('test mail message'), 'testMailFormMessage', true) ?>
    <?php echo textarea_field('test_mail[message]', array_var($test_mail_data, 'message'), array('id' => 'testMailFormMessage')) ?>
  </div>
  
  <?php echo submit_button(lang('submit')) ?>
</form>

<?php if (extension_loaded('sockets')) { ?>
<div>Socket functions are available so mailing is possible from PHP level</div>
<?php } else { ?>
<div>Socket functions are NOT available. Mailing is not possible from PHP level</div>
<?php } ?>
<?php echo 'Note: allow_url_fopen=' . ini_get('allow_url_fopen') ?>

