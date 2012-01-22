<?php
  set_page_title($folder->isNew() ? lang('add folder') : lang('edit folder'));
  project_tabbed_navigation(PROJECT_TAB_FILES);
  project_crumbs(array(
    array(lang('files'), get_url('files')),
    array($folder->isNew() ? lang('add folder') : lang('edit folder'))
  ));
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

  <div>
    <?php echo label_tag(lang('parent folder'), 'folderFormParentFolder', true) ?>
    <?php echo select_project_folder('folder[parent_id]', active_project(), array_var($folder_data, 'parent_id'), array('parent_id' => 'folderFormParentFolder')) ?>
  </div>
   
  <?php echo submit_button($folder->isNew() ? lang('add folder') : lang('edit folder')) ?> <a href="<?php echo get_url('files') ?>"><?php echo lang('cancel') ?></a>
  
</form>