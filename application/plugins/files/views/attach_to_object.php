<?php

  set_page_title(lang('attach files'));
  project_tabbed_navigation(PROJECT_TAB_FILES);
  project_crumbs(array(
    array(lang('files'), get_url('files')),
    array(lang('attach files'))
  ));
  add_stylesheet_to_page('project/attach_files.css');

?>
<form action="<?php echo $attach_to_object->getAttachFilesUrl() ?>" method="post" enctype="multipart/form-data">
<?php tpl_display(get_template_path('form_errors')) ?>
  <div class="hint"><?php echo lang('attach files to object desc', $attach_to_object->getObjectUrl(), clean($attach_to_object->getObjectName())) ?></div>
  <div>
    <?php echo radio_field('attach[what]', array_var($attach_data, 'what') == 'existing_file', array('value' => 'existing_file', 'id' => 'attachFormExistingFile' )) ?> <label for="attachFormExistingFile" class="checkbox"><?php echo lang('attach existing file') ?></label>
  </div>
  
  <div id="attachFormExistingFileControls">
    <fieldset>
      <legend><?php echo lang('select file') ?></legend>
      <?php echo select_project_file('attach[file_id]', active_project(), array_var($attach_data, 'file_id'), $already_attached_file_ids, array('id' => 'attachFormSelectFile', 'style' => 'width: 300px')) ?>
    </fieldset>
  </div>
  
  <div>
    <?php echo radio_field('attach[what]', array_var($attach_data, 'what') <> 'existing_file', array('value' => 'new_file', 'id' => 'attachFormNewFile' )) ?> <label for="attachFormNewFile" class="checkbox"><?php echo lang('upload and attach') ?></label>
  </div>
  
  <div id="attachFormNewFileControls">
    <?php echo render_attach_files() ?>
  </div>

  <?php echo submit_button(lang('attach files')) ?>
  
</form>