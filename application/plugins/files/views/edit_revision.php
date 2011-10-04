<?php
  $ref = $file->getObjectName() . '#'  . $revision->getRevisionNumber(); 
  set_page_title(lang('files edit revision', $ref ));
  project_tabbed_navigation(PROJECT_TAB_FILES);
  project_crumbs(array(
    array(lang('files'), get_url('files')),
    lang('files edit revision', $ref),
  ));
  
  add_stylesheet_to_page('project/files.css');
?>
<form action="<?php echo $revision->getEditUrl() ?>" method="post">
  <div id="fileRevisionComment">
    <?php echo label_tag(lang('revision comment'), 'fileRevisionComment') ?>
    <?php echo textarea_field('revision[comment]', array_var($revision_data, 'comment'), array('class' => 'short', 'id' => 'fileRevisionComment')) ?>
  </div>
  
  <?php echo submit_button(lang('save')) ?> <a href="<?php echo $file->getDetailsUrl() ?>"><?php echo lang('cancel') ?></a>
</form>