<?php
  set_page_title($file->isNew() ? lang('add file') : lang('edit file'));
  project_tabbed_navigation(PROJECT_TAB_FILES);
  project_crumbs(array(
    array(lang('files'), get_url('files')),
    array($file->isNew() ? lang('add file') : lang('edit file'))
  ));
  if (ProjectFile::canAdd(logged_user(), active_project())) {
    add_page_action(lang('add file'), get_url('files', 'add_file'));
  } // if
  if (ProjectFolder::canAdd(logged_user(), active_project())) {
    add_page_action(lang('add folder'), get_url('files', 'add_folder'));
  } // if
  
  add_stylesheet_to_page('project/files.css');
?>
<?php if ($file->isNew()) { ?>
<form action="<?php echo get_url('files', 'add_file') ?>" method="post" enctype="multipart/form-data">
<?php } else { ?>
<form action="<?php echo $file->getEditUrl() ?>" method="post" enctype="multipart/form-data">
<?php } // if ?>

<?php tpl_display(get_template_path('form_errors')) ?>

  <!-- <fieldset>
    <legend><?php echo lang('description') ?></legend>
    <?php echo textarea_field('file[description]', array_var($file_data, 'description'), array('class' => 'short', 'id' => 'fileFormDescription')) ?>
  </fieldset> -->

  <div>
    <?php echo label_tag(lang('description'), 'fileFormDescription') ?>
    <?php echo textarea_field('file[description]', array_var($file_data, 'description'), array('class' => 'short', 'id' => 'fileFormDescription')) ?>
  </div>

  <div>
    <?php echo label_tag(lang('folder'), 'fileFormFolder', true) ?>
    <?php echo select_project_folder('file[folder_id]', active_project(), array_var($file_data, 'folder_id'), array('id' => 'fileFormFolder')) ?>
  </div>
  
<?php if (logged_user()->isMemberOfOwnerCompany()) { ?>
  <fieldset>
    <legend><?php echo lang('options') ?></legend>
    
    <div class="objectOption odd">
      <div class="optionLabel"><label><?php echo lang('private file') ?>:</label></div>
      <div class="optionControl"><?php echo yes_no_widget('file[is_private]', 'fileFormIsPrivate', array_var($file_data, 'is_private'), lang('yes'), lang('no')) ?></div>
      <div class="optionDesc"><?php echo lang('private file desc') ?></div>
    </div>
    
    <div class="objectOption even">
      <div class="optionLabel"><label><?php echo lang('important file') ?>:</label></div>
      <div class="optionControl"><?php echo yes_no_widget('file[is_important]', 'fileFormIsImportant', array_var($file_data, 'is_important'), lang('yes'), lang('no')) ?></div>
      <div class="optionDesc"><?php echo lang('important file desc') ?></div>
    </div>
    
    <div class="objectOption odd">
      <div class="optionLabel"><label><?php echo lang('enable comments') ?>:</label></div>
      <div class="optionControl"><?php echo yes_no_widget('file[comments_enabled]', 'fileFormEnableComments', array_var($file_data, 'comments_enabled', true), lang('yes'), lang('no')) ?></div>
      <div class="optionDesc"><?php echo lang('enable comments desc') ?></div>
    </div>
    
    <div class="objectOption even">
      <div class="optionLabel"><label><?php echo lang('enable anonymous comments') ?>:</label></div>
      <div class="optionControl"><?php echo yes_no_widget('file[anonymous_comments_enabled]', 'fileFormEnableAnonymousComments', array_var($file_data, 'anonymous_comments_enabled', false), lang('yes'), lang('no')) ?></div>
      <div class="optionDesc"><?php echo lang('enable anonymous comments desc') ?></div>
    </div>
  </fieldset>
<?php } // if ?>

<?php if (plugin_active('tags')) { ?>
  <div class="formBlock">
    <?php echo label_tag(lang('tags'), 'fileFormTags') ?>
    <?php echo project_object_tags_widget('file[tags]', active_project(), array_var($file_data, 'tags'), array('id' => 'fileFormTags', 'class' => 'long')) ?>
  </div>
<?php } // if ?>

<?php if ($file->isNew()) { ?>
  <div class="hint">
    <div class="content">
      <div id="selectFileControl">
        <?php echo label_tag(lang('file'), 'fileFormFile', true) ?>
        <?php echo file_field('file_file', null, array('id' => 'fileFormFile')) ?>
      </div>
      <!-- <div id="selectFolderControl">
        <?php echo label_tag(lang('folder'), 'fileFormFolder') ?>
        <?php echo select_project_folder('file[folder_id]', active_project(), array_var($file_data, 'folder_id'), array('id' => 'fileFormFolder')) ?>
      </div> -->
      <p><?php echo lang('upload file desc', format_filesize(get_max_upload_size())) ?></p>
    </div>
  </div>
<?php 
  $this->assign('project', active_project());
  $this->assign('object', $file);
  $this->assign('post_data_name', 'file');
  $this->assign('post_data', $file_data);
  $this->includeTemplate(get_template_path('select_receivers', 'notifier'));
?>
  <?php echo submit_button(lang('save')) ?> <a href="<?php echo get_url('files') ?>"><?php echo lang('cancel') ?></a>
<?php } else { // if ?>
  <?php echo submit_button(lang('save')) ?> <a href="<?php echo $file->getDetailsUrl() ?>"><?php echo lang('cancel') ?></a>
<?php } // if ?>
</form>