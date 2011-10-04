<?php

  set_page_title(lang('delete file'));
  project_tabbed_navigation(PROJECT_TAB_FILES);
  project_crumbs(lang('delete file'));
?>
<form action="<?php echo $file->getDeleteUrl() ?>" method="post">
  <?php tpl_display(get_template_path('form_errors')) ?>

  <div><?php echo lang('about to delete') ?> <?php echo lc(lang('file')); ?> <b><?php echo clean($file->getFilename()) ?></b></div>
    
  <div>
    <label><?php echo lang('confirm delete file') ?></label>
    <?php echo yes_no_widget('deleteFile[really]', 'deleteFileReallyDelete', false, lang('yes'), lang('no')) ?>
  </div>
    
  <div>
    <?php echo label_tag(lang('password')) ?>
    <?php echo password_field('deleteFile[password]', null, array('id' => 'loginPassword', 'class' => 'medium')) ?>
  </div>
    
  <?php echo submit_button(lang('delete file')) ?> <a href="<?php echo $file->getDetailsUrl() ?>"><?php echo lang('cancel') ?></a>
</form>