<?php

  set_page_title(lang('delete file revision'));
  project_tabbed_navigation(PROJECT_TAB_FILES);
  project_crumbs(lang('delete file revision'));

?>
<form action="<?php echo $revision->getDeleteUrl() ?>" method="post">
  <?php tpl_display(get_template_path('form_errors')) ?>

  <div><?php echo lang('about to delete') ?> <?php echo strtolower(lang('revision')) ?> <b><?php echo clean($revision->getObjectName()) ?></b></div>
    
  <div>
    <label><?php echo lang('confirm delete revision') ?></label>
    <?php echo yes_no_widget('deleteFileRevision[really]', 'deleteFileRevisionReallyDelete', false, lang('yes'), lang('no')) ?>
  </div>
    
  <div>
    <?php echo label_tag(lang('password')) ?>
    <?php echo password_field('deleteFileRevision[password]', null, array('id' => 'loginPassword', 'class' => 'medium')) ?>
  </div>
    
  <?php echo submit_button(lang('delete file revision')) ?> <a href="<?php echo $revision->getDetailsUrl() ?>"><?php echo lang('cancel') ?></a>
</form>
