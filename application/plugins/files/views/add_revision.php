<?php
  set_page_title(lang('files add revision'));
  project_tabbed_navigation(PROJECT_TAB_FILES);
  project_crumbs(array(
    array(lang('files'), get_url('files')),
    lang('files add revision'),
  ));
  
  add_stylesheet_to_page('project/files.css');
?>
<form action="<?php echo $file->getAddRevisionUrl() ?>" method="post" enctype="multipart/form-data">
  <div id="fileRevisionComment">
    <?php echo label_tag(lang('revision comment'), 'fileRevisionComment') ?>
    <?php echo textarea_field('revision[comment]', array_var($revision_data, 'comment'), array('class' => 'short', 'id' => 'fileRevisionComment')) ?>
  </div>
  <div class="hint">
    <div class="content">
      <div>
        <?php echo label_tag(lang('new file'), 'fileRevisionFile', true) ?>
        <?php echo file_field('file_file', null, array('id' => 'fileRevisionFile')) ?>
      </div>
    </div>
  </div>
  <?php echo submit_button(lang('save')) ?> <a href="<?php echo $file->getDetailsUrl() ?>"><?php echo lang('cancel') ?></a>
</form>

