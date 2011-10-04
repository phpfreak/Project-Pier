<?php 
  trace(__FILE__,':begin');
  set_page_title(lang('move message'));
  dashboard_tabbed_navigation('messages');
  trace(__FILE__,':crumbs');
  project_crumbs(lang('move message'));
  trace(__FILE__,':build page');
?>
<form action="<?php echo $message->getMoveUrl(); ?>" method="post">

<?php tpl_display(get_template_path('form_errors')) ?>

  <div><?php echo lang('about to move') ?> <?php echo lc(lang('message')) ?> <b><?php echo clean($message->getTitle()) ?></b></div>

  <div>
    <?php echo label_tag(lang('project to move to', clean($message->getTitle())), 'moveMessageFormTargetProjectId', true) ?>
    <?php echo select_project('move_data[target_project_id]', '', array_var($move_data, 'target_project_id'), array('id' => 'moveMessageFormTargetProjectId')) ?>
  </div>

  <?php echo submit_button(lang('move message')) ?> <span id="cancel"><a href="<?php echo $message->getViewUrl() ?>"><?php echo lang('cancel') ?></a></span>
</form>
<?php trace(__FILE__,':end'); ?>