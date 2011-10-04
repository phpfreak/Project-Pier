<?php

  set_page_title(lang('delete folder'));
  project_tabbed_navigation(PROJECT_TAB_FILES);
  project_crumbs(lang('delete folder'));

?>
<form action="<?php echo $folder->getDeleteUrl() ?>" method="post">
  <?php tpl_display(get_template_path('form_errors')) ?>

  <div><?php echo lang('about to delete') ?> <?php echo lc(lang('folder')) ?> <b><?php echo clean($folder->getName()) ?></b></div>
    
  <div>
    <label><?php echo lang('confirm delete folder') ?></label>
    <?php echo yes_no_widget('deleteFolder[really]', 'deleteFolderReallyDelete', false, lang('yes'), lang('no')) ?>
  </div>
    
  <div>
    <?php echo label_tag(lang('password')) ?>
    <?php echo password_field('deleteFolder[password]', null, array('id' => 'loginPassword', 'class' => 'medium')) ?>
  </div>
    
  <?php echo submit_button(lang('delete folder')) ?> <a href="<?php echo $folder->getBrowseUrl() ?>"><?php echo lang('cancel') ?></a>
</form>