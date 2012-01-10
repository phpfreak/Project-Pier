<?php

  set_page_title($file->getObjectName());
  project_tabbed_navigation(PROJECT_TAB_FILES);
  
  $files_crumbs = array(
    0 => array(lang('files'), get_url('files'))
  ); // array
  if ($folder instanceof ProjectFolder) {
    $files_crumbs[] = array($folder->getName(), $folder->getBrowseUrl());
  } // if
  $files_crumbs[] = lang('file details');
  
  project_crumbs($files_crumbs);
  
  if (ProjectFile::canAdd(logged_user(), active_project())) {
    if ($folder instanceof ProjectFolder) {
      add_page_action(lang('add file'), $folder->getAddFileUrl());
    } else {
      add_page_action(lang('add file'), get_url('files', 'add_file'));
    } // if
  } // if
  if (ProjectFolder::canAdd(logged_user(), active_project())) {
    add_page_action(lang('add folder'), get_url('files', 'add_folder'));
  } // if
  
  add_stylesheet_to_page('project/files.css');

?>
<div id="fileDetails" class="block">
<?php if ($file->isPrivate()) { ?>
  <div class="private" title="<?php echo lang('private file') ?>"><span><?php echo lang('private file') ?></span></div>
<?php } // if ?>
  <div class="content">
    <div id="fileIcon"><img src="<?php echo $file->getTypeIconUrl() ?>" alt="<?php echo $file->getObjectName() ?>" /></div>
    <div id="fileInfo">
      <div class="header"><?php echo $file->getObjectName() ?>
<?php if ($folder instanceof ProjectFolder) { ?>
      <div id="fileFolder"><span class="propertyName"><?php echo lang('folder') ?>:</span> <a href="<?php echo $folder->getBrowseUrl() ?>"><?php echo clean($folder->getObjectName(true)) ?></a></div>
<?php } // if ?>
<?php if (($file->getDescription())) { ?>
      <div id="fileDescription"><?php echo do_textile($file->getDescription()) ?></div>
<?php } // if ?>
      </div>
<!--
<?php if ($last_revision instanceof ProjectFileRevision) { ?>
      <div id="fileLastRevision"><span class="propertyName"><?php echo lang('last revision') ?>:</span> 
<?php if ($last_revision->getCreatedBy() instanceof User) { ?>
      <?php echo lang('file revision info long', $last_revision->getRevisionNumber(), $last_revision->getCreatedBy()->getCardUrl(), clean($last_revision->getCreatedBy()->getDisplayName()), format_descriptive_date($last_revision->getCreatedOn())) ?>
<?php } else { ?>
      <?php echo lang('file revision info short', $last_revision->getRevisionNumber(), format_descriptive_date($last_revision->getCreatedOn())) ?>
<?php } // if ?>
      </div>
<?php } // if ?>
-->
<?php if (plugin_active('tags')) { ?>
<?php   if (project_object_tags($file, $file->getProject())!='--') { ?>
      <div id="fileTags"><span class="propertyName"><?php echo lang('tags') ?>:</span> <?php echo project_object_tags($file, $file->getProject()) ?></div>
<?php   } // if ?>
<?php } // if ?>
<?php
$options = array();
if ($file->canEdit(logged_user())) $options[] = '<a href="' . $file->getEditUrl() . '">' . lang('edit') . '</a>';
if ($file->canDelete(logged_user())) $options[] = '<a href="' . $file->getMoveUrl() . '">' . lang('move') . '</a>';
if ($file->canDelete(logged_user())) $options[] = '<a href="' . $file->getDeleteUrl() . '">' . lang('delete') . '</a>';
if ($file->canEdit(logged_user())) $options[] = '<a href="' . $file->getAddRevisionUrl() . '">' . lang('files add revision') . '</a>';
if ($file->canDownload(logged_user())) $options[] = '<a href="' . $file->getDownloadUrl() . '" class="downloadLink">' . lang('download') . ' <span>(' . format_filesize($file->getFilesize()) . ')</span></a>';
?>
<?php if (count($options)) { ?>
        <div class="options"><?php echo implode(' | ', $options) ?></div>
<?php } // if ?>
    </div>
  </div>
  <div class="clear"></div>
</div>

<?php if (isset($revisions) && is_array($revisions) && count($revisions)) { ?>
<div id="revisions">
  <h2><?php echo lang('revisions') ?></h2>
<?php $counter = 0; ?>
<?php foreach ($revisions as $revision) { ?>
<?php $counter++; ?>
  <div class="revision <?php echo $counter % 2 ? 'even' : 'odd' ?> <?php echo $counter == 1 ? 'lastRevision' : '' ?>" id="revision<?php echo $revision->getId() ?>">
    <div class="revisionName">
<?php if ($revision->getCreatedBy() instanceof User) { ?>
    <?php echo lang('file revision title long', $revision->getDownloadUrl(), $revision->getRevisionNumber(), $revision->getCreatedBy()->getCardUrl(), $revision->getCreatedBy()->getDisplayName(), format_datetime($revision->getCreatedOn())) ?>
<?php } else { ?>
    <?php echo lang('file revision title short', $revision->getDownloadUrl(), $revision->getRevisionNumber(), format_datetime($revision->getCreatedOn())) ?>
<?php } // if ?>
    </div>
<?php if (trim($revision->getComment())) { ?>
    <div class="revisionComment"><?php echo do_textile($revision->getComment()) ?></div>
<?php } // if ?>
<?php 
  $options = array();
  if ($revision->canEdit(logged_user())) {
    $options[] = '<a href="' . $revision->getEditUrl() . '">' . lang('edit') . '</a>';
  }
  if ($revision->canDelete(logged_user())) {
    $options[] = '<a href="' . $revision->getDeleteUrl() . '">' . lang('delete') . '</a>';
  }
  if ($revision->canDownload(logged_user())) {
    $options[] = '<a href="' . $revision->getDownloadUrl() . '" class="downloadLink">' . lang('download') . ' <span>(' . format_filesize($revision->getFileSize()) . ')</span></a>';
  }
?>
<?php if (count($options)) { ?>
    <div class="options"><?php echo implode(' | ', $options) ?></div>
<?php } // if ?>
  </div>
<?php } // foreach ?>
</div>
<?php } // if ?>

<?php echo render_object_comments($file, $file->getDetailsUrl()) ?>