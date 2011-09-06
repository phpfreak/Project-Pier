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
<script type="text/javascript" src="<?php echo get_javascript_url('modules/addFileForm.js') ?>"></script>
<?php if ($file->isNew()) { ?>
<form action="<?php echo get_url('files', 'add_file') ?>" method="post" enctype="multipart/form-data">
<?php } else { ?>
<form action="<?php echo $file->getEditUrl() ?>" method="post" enctype="multipart/form-data">
<?php } // if ?>

<?php tpl_display(get_template_path('form_errors')) ?>

<?php if ($file->isNew()) { ?>
  <div class="hint">
    <div class="content">
      <div id="selectFileControl">
        <?php echo label_tag(lang('file'), 'fileFormFile', true) ?>
        <?php echo file_field('file_file', null, array('id' => 'fileFormFile')) ?>
      </div>
      <div id="selectFolderControl">
        <?php echo label_tag(lang('folder'), 'fileFormFolder') ?>
        <?php echo select_project_folder('file[folder_id]', active_project(), array_var($file_data, 'folder_id'), array('id' => 'fileFormFolder')) ?>
      </div>
      <p><?php echo lang('upload file desc', format_filesize(get_max_upload_size())) ?></p>
    </div>
  </div>
<?php } else { ?>
  <div class="hint">
    <div class="header"><?php echo checkbox_field('file[update_file]', array_var($file_data, 'update_file'), array('class' => 'checkbox', 'id' => 'fileFormUpdateFile', 'onclick' => 'App.modules.addFileForm.updateFileClick()')) ?> <?php echo label_tag(lang('update file'), 'fileFormUpdateFile', false, array('class' => 'checkbox'), '') ?></div>
    <div class="content">
      <div id="updateFileDescription">
        <p><?php echo lang('replace file description') ?></p>
      </div>
      <div id="updateFileForm">
        <p><strong><?php echo lang('existing file') ?>:</strong> <a href="<?php echo $file->getDownloadUrl() ?>"><?php echo clean($file->getFilename()) ?></a> | <?php echo format_filesize($file->getFilesize()) ?></p>
        
        <div>
          <?php echo label_tag(lang('new file'), 'fileFormFile', true) ?>
          <?php echo file_field('file_file', null, array('id' => 'fileFormFile')) ?>
        </div>
        
        <div id="revisionControls">
          <div>
            <?php echo checkbox_field('file[version_file_change]', array_var($file_data, 'version_file_change', true), array('id' => 'fileFormVersionChange', 'class' => 'checkbox', 'onclick' => 'App.modules.addFileForm.versionFileChangeClick()')) ?> <?php echo label_tag(lang('version file change'), 'fileFormVersionChange', false, array('class' => 'checkbox'), '') ?>
          </div>
          <div id="fileFormRevisionCommentBlock">
            <?php echo label_tag(lang('revision comment'), 'fileFormRevisionComment') ?>
            <?php echo textarea_field('file[revision_comment]', array_var($file_data, 'revision_comment'), array('class' => 'short')) ?>
          </div>
        </div>
      </div>
      
      <script type="text/javascript">
        App.modules.addFileForm.updateFileClick();
        App.modules.addFileForm.versionFileChangeClick();
      </script>
      
    </div>
  </div>
<?php } // if ?>

<?php if (!$file->isNew()) { ?>
  <div>
    <?php echo label_tag(lang('folder'), 'fileFormFolder', true) ?>
    <?php echo select_project_folder('file[folder_id]', active_project(), array_var($file_data, 'folder_id'), array('id' => 'fileFormFolder')) ?>
  </div>
<?php } // if ?>

  <fieldset>
    <legend><?php echo lang('description') ?></legend>
    <?php echo textarea_field('file[description]', array_var($file_data, 'description'), array('class' => 'short', 'id' => 'fileFormDescription')) ?>
  </fieldset>

  <!-- <div>
    <?php echo label_tag(lang('description'), 'fileFormDescription') ?>
    <?php echo textarea_field('file[description]', array_var($file_data, 'description'), array('class' => 'short', 'id' => 'fileFormDescription')) ?>
  </div> -->
  
<?php if (logged_user()->isMemberOfOwnerCompany()) { ?>
  <fieldset>
    <legend><?php echo lang('options') ?></legend>
    
    <div class="objectOption">
      <div class="optionLabel"><label><?php echo lang('private file') ?>:</label></div>
      <div class="optionControl"><?php echo yes_no_widget('file[is_private]', 'fileFormIsPrivate', array_var($file_data, 'is_private'), lang('yes'), lang('no')) ?></div>
      <div class="optionDesc"><?php echo lang('private file desc') ?></div>
    </div>
    
    <div class="objectOption">
      <div class="optionLabel"><label><?php echo lang('important file') ?>:</label></div>
      <div class="optionControl"><?php echo yes_no_widget('file[is_important]', 'fileFormIsImportant', array_var($file_data, 'is_important'), lang('yes'), lang('no')) ?></div>
      <div class="optionDesc"><?php echo lang('important file desc') ?></div>
    </div>
    
    <div class="objectOption">
      <div class="optionLabel"><label><?php echo lang('enable comments') ?>:</label></div>
      <div class="optionControl"><?php echo yes_no_widget('file[comments_enabled]', 'fileFormEnableComments', array_var($file_data, 'comments_enabled', true), lang('yes'), lang('no')) ?></div>
      <div class="optionDesc"><?php echo lang('enable comments desc') ?></div>
    </div>
    
    <div class="objectOption">
      <div class="optionLabel"><label><?php echo lang('enable anonymous comments') ?>:</label></div>
      <div class="optionControl"><?php echo yes_no_widget('file[anonymous_comments_enabled]', 'fileFormEnableAnonymousComments', array_var($file_data, 'anonymous_comments_enabled', false), lang('yes'), lang('no')) ?></div>
      <div class="optionDesc"><?php echo lang('enable anonymous comments desc') ?></div>
    </div>
  </fieldset>
<?php } // if ?>

  <fieldset>
    <legend><?php echo lang('tags') ?></legend>
    <?php echo project_object_tags_widget('file[tags]', active_project(), array_var($file_data, 'tags'), array('id' => 'fileFormTags', 'class' => 'long')) ?>
  </fieldset>
  
  <!-- <div class="formBlock">
    <?php echo label_tag(lang('tags'), 'fileFormTags') ?>
    <?php echo project_object_tags_widget('file[tags]', active_project(), array_var($file_data, 'tags'), array('id' => 'fileFormTags', 'class' => 'long')) ?>
  </div> -->
  
  <?php echo submit_button($file->isNew() ? lang('add file') : lang('edit file')) ?>
  
</form>
