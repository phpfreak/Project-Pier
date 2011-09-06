<?php
  set_page_title($folder->isNew() ? lang('add folder') : lang('edit folder'));
  project_tabbed_navigation(PROJECT_TAB_FILES);
  project_crumbs(array(
    array(lang('files'), get_url('files')),
    array($folder->isNew() ? lang('add folder') : lang('edit folder'))
  ));
  
  if (ProjectFile::canAdd(logged_user(), active_project())) {
    add_page_action(lang('add file'), get_url('files', 'add_file'));
  } // if
  if (ProjectFolder::canAdd(logged_user(), active_project())) {
    add_page_action(lang('add folder'), get_url('files', 'add_folder'));
  } // if
  
?>
<?php if ($folder->isNew()) { ?>
<form action="<?php echo get_url('files', 'add_folder') ?>" method="post">
<?php } else { ?>
<form action="<?php echo $folder->getEditUrl() ?>" method="post">
<?php } // if ?>

<?php tpl_display(get_template_path('form_errors')) ?>
  
  <div>
    <?php echo label_tag(lang('name'), 'folderFormName') ?>
    <?php echo text_field('folder[name]', array_var($folder_data, 'name'), array('id' => 'folderFormName')) ?>
  </div>
  
  <?php echo submit_button($folder->isNew() ? lang('add folder') : lang('edit folder')) ?> <a href="<?php echo get_url('files') ?>"><?php echo lang('cancel') ?></a>
  
</form>
