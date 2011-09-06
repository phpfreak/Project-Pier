<?php
  set_page_title(lang('edit file revisions'));
  project_tabbed_navigation(PROJECT_TAB_FILES);
  project_crumbs(array(
    array(lang('files'), get_url('files')),
    lang('edit file revisions'),
  ));
  
  add_stylesheet_to_page('project/files.css');
?>
<form action="<?php echo $revision->getEditUrl() ?>" method="post">
  <div id="fileRevisionComment">
    <?php echo label_tag(lang('revision comment'), 'fileRevisionComment') ?>
    <?php echo textarea_field('revision[comment]', array_var($revision_data, 'comment'), array('class' => 'short', 'id' => 'fileRevisionComment')) ?>
  </div>
  
  <?php echo submit_button(lang('edit file revisions')) ?>
</form>
