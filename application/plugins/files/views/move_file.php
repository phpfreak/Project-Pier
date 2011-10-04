<?php 
  trace(__FILE__,':begin');
  set_page_title(lang('move file'));
  dashboard_tabbed_navigation();
  trace(__FILE__,':crumbs');
  project_crumbs(lang('move file'));
  trace(__FILE__,':build page');
?>
<form action="<?php echo $file->getMoveUrl(); ?>" method="post">

<?php tpl_display(get_template_path('form_errors')) ?>

  <div><?php echo lang('about to move') ?> <?php echo lc(lang('file')) ?> <b><?php echo clean($file->getObjectName()) ?></b></div>

  <div>
    <?php echo label_tag(lang('project to move to', clean($file->getObjectName())), 'moveFileFormTargetProjectId', true) ?>
    <?php echo select_project('move_data[target_project_id]', '', array_var($move_data, 'target_project_id'), array('id' => 'moveFileFormTargetProjectId')) ?>
  </div>

  <?php echo submit_button(lang('move file')) ?> <span id="cancel"><a href="<?php echo $file->getViewUrl() ?>"><?php echo lang('cancel') ?></a></span>
</form>
<?php trace(__FILE__,':end'); ?>