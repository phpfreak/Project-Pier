<?php
  trace(__FILE__,'begin');
  if ($current_folder instanceof Projectfolder) {
    set_page_title(lang('folder') . ': ' . $current_folder->getName());
  } else {
    set_page_title(lang('files'));
  } // if
  
  project_tabbed_navigation(PROJECT_TAB_FILES);
  $files_crumbs = array(
    0 => array(lang('files'), get_url('files'))
  ); // array
  if ($current_folder instanceof ProjectFolder) {
    $files_crumbs[] = array($current_folder->getName(), $current_folder->getBrowseUrl($order));
  } // if
  $files_crumbs[] = array(lang('index'));
  
  trace(__FILE__,'project_crumbs');
  project_crumbs($files_crumbs);
  trace(__FILE__,'ProjectFile::canAdd');
  if (ProjectFile::canAdd(logged_user(), active_project())) {
    if ($current_folder instanceof ProjectFolder) {
      add_page_action(lang('add file'), $current_folder->getAddFileUrl());
    } else {
      add_page_action(lang('add file'), get_url('files', 'add_file'));
    } // if
  } // if
  
  trace(__FILE__,'ProjectFolder::canAdd');
  if (ProjectFolder::canAdd(logged_user(), active_project())) {
    add_page_action(lang('add folder'), get_url('files', 'add_folder'));
  } // if
  
  add_stylesheet_to_page('project/files.css');

?>
<?php if (isset($files) && is_array($files) && count($files)) { ?>
<?php $show_icon = (config_option('files_show_icons', '1') == '1'); ?>
<div id="files">
<?php $this->includeTemplate(get_template_path('order_and_pagination', 'files')) ?>
<?php $counter = 0; ?>
<?php foreach ($files as $group_by => $grouped_files) { ?>
<h2><?php echo clean($group_by) ?></h2>
<div class="filesList">
<?php foreach ($grouped_files as $file) { ?>
<?php $counter++; ?>
  <div class="listedFile <?php echo $counter % 2 ? 'even' : 'odd' ?>">
<?php if ($file->isPrivate()) { ?>
    <div class="private" title="<?php echo lang('private file') ?>"><span><?php echo lang('private file') ?></span></div>
<?php } // if ?>
<?php if ($show_icon) { ?>
    <div class="fileIcon"><img src="<?php echo $file->getTypeIconUrl() ?>" alt="<?php echo $file->getObjectName() ?>" /></div>
<?php } // if ?>
    <div class="fileInfo">
      <div class="fileName"><a href="<?php echo $file->getDetailsUrl() ?>" title="<?php echo lang('view file details') ?>"><?php echo $file->getObjectName() ?></a></div>
<?php if (($file->getDescription())) { ?>
      <div class="fileDescription"><?php echo do_textile($file->getDescription()) ?></div>
<?php } // if ?>
<?php if (($last_revision = $file->getLastRevision()) instanceof ProjectFileRevision) { ?>
      <div class="fileLastRevision">
<?php if ($last_revision->getCreatedBy() instanceof User) { ?>
        <?php echo lang('file revision info long', $last_revision->getRevisionNumber(), $last_revision->getCreatedBy()->getCardUrl(), clean($last_revision->getCreatedBy()->getDisplayName()), format_descriptive_date($last_revision->getCreatedOn())) ?>
<?php } else { ?>
        <?php echo lang('file revision info short', $last_revision->getRevisionNumber(), format_descriptive_date($last_revision->getCreatedOn())) ?>
<?php } // if ?>
      </div>
<?php } // if ?>
      <div class="fileDetails"><?php if ($file->getCreatedBy() instanceof User) { ?><span><?php echo lang('created by') ?>:</span> <a href="<?php echo $file->getCreatedBy()->getCardUrl() ?>"><?php echo clean($file->getCreatedBy()->getDisplayName()) ?></a> | <?php } // if ?><span><a href="<?php echo $file->getCommentsUrl() ?>"><?php echo lang('comments') ?></a>:</span> <?php echo $file->countComments() ?> | <span><a href="<?php echo $file->getRevisionsUrl() ?>"><?php echo lang('revisions') ?></a>:</span> <?php echo $file->countRevisions() ?></div>
<?php if (plugin_active('tags')) { ?>
<?php   if (project_object_tags($file, active_project())!='--') { ?>
      <div class="fileTags"><?php echo lang('tags') ?>: <?php echo project_object_tags($file, active_project()) ?></div>
<?php   } // if ?>
<?php } // if ?>
<?php
  $options = array();
  if ($file->canEdit(logged_user())) {
    $options[] = '<a href="' . $file->getEditUrl() . '">' . lang('edit') . '</a>';
  }
  if ($file->canDelete(logged_user())) {
    $options[] = '<a href="' . $file->getDeleteUrl() . '">' . lang('delete') . '</a>';
  }
  if ($file->canEdit(logged_user())) {
    $options[] = '<a href="' . $file->getAddRevisionUrl() . '">' . lang('files add revision') . '</a>';
  }
  if ($file->canDownload(logged_user())) {
    $options[] = '<a href="' . $file->getDownloadUrl() . '" class="downloadLink">' . lang('download') . ' <span>(' . format_filesize($file->getFilesize()) . ')</span></a>';
  }
?>
<?php if (count($options)) { ?>
      <div class="fileOptions"><?php echo implode(' | ', $options) ?></div>
<?php } // if ?>
    </div>
  </div>
<?php } // foreach ?>
</div>
<?php } // foreach ?>

<?php $this->includeTemplate(get_template_path('order_and_pagination', 'files')) ?>
</div>
<?php } else { ?>
<p><?php echo lang('no files on the page') ?></p>
<?php } // if ?>