<?php if (isset($files) && is_array($files) && count($files)) { ?>
<?php $show_icon = (config_option('files_show_icons', '1') == '1'); ?>
<div id="files">
<?php $this->includeTemplate(get_template_path('order_and_pagination', 'files')) ?>
<?php $counter = 0; ?>
<?php $player_counter = 0; ?>
<?php foreach ($files as $group_by => $grouped_files) { ?>
<div class="block"><div class="header"><h2><?php echo clean($group_by) ?></h2></div>
<div class="content filesList" style="display:none">
<?php foreach ($grouped_files as $file) { ?>
<?php $counter++; ?>
  <div class="listedFile <?php echo $counter % 2 ? 'even' : 'odd' ?>">
<?php if ($show_icon) { ?>
<?php $mime = '&mime='.($file->getTypeString()).''; ?>
<?php } // if ?>
  <div class="block">
    <div class="header fileName">
<?php $last_revision = $file->getLastRevision(); ?>
<?php $rev = ''; ?>
<?php if ($last_revision instanceof ProjectFileRevision) { ?>
<?php   $rev = '#'.$last_revision->getRevisionNumber(); ?>
<?php } ?>
<?php if ($file->isPrivate()) { ?>
    <div class="private" title="<?php echo lang('private file') ?>"><span><?php echo lang('private file') ?></span></div>
<?php } // if ?>
<?php $description = trim(strip_tags(do_textile($file->getDescription()))); ?>
<?php $mouse_over = lang('view file details') . "\n$description"; ?>
    <a href="<?php echo $file->getDetailsUrl() ?>" title="<?php echo $mouse_over ?>"><?php echo $file->getObjectName() . ' <span>(' . format_filesize($file->getFilesize()) . ")</span> $rev"; ?></a></div>
    <div class="content" style="display:none">
      <div class="fileIcon"><a rel="gallery" href="<?php echo $file->getDownloadUrl() . $mime ?>&inline=1"><img src="<?php echo $file->getTypeIconUrl() ?>" title="<?php echo $file->getObjectName() ?>" alt="<?php echo $file->getTypeString() ?>" /></a></div>
      <div class="fileInfo">
<?php if (($file->getDescription())) { ?>
        <div class="fileDescription"><?php echo $description ?></div>
<?php } // if ?>
<?php if ($last_revision instanceof ProjectFileRevision) { ?>
<?php if ($last_revision->getCreatedBy() instanceof User) { ?>
        <div class="fileLastRevision"><?php echo lang('file revision info long', $last_revision->getRevisionNumber(), $last_revision->getCreatedBy()->getCardUrl(), clean($last_revision->getCreatedBy()->getDisplayName()), format_descriptive_date($last_revision->getCreatedOn())) ?></div>
<?php } else { ?>
        <div class="fileLastRevision"><?php echo lang('file revision info short', $last_revision->getRevisionNumber(), format_descriptive_date($last_revision->getCreatedOn())) ?></div>
<?php } // if ?>
<?php } // if ?>
        <div class="fileDetails"><?php if ($file->getCreatedBy() instanceof User) { ?><span><?php echo lang('created by') ?>:</span> <a href="<?php echo $file->getCreatedBy()->getCardUrl() ?>"><?php echo clean($file->getCreatedBy()->getDisplayName()) ?></a> | <?php } // if ?><span><a href="<?php echo $file->getCommentsUrl() ?>"><?php echo lang('comments') ?></a>:</span> <?php echo $file->countComments() ?> | <span><a href="<?php echo $file->getRevisionsUrl() ?>"><?php echo lang('revisions') ?></a>:</span> <?php echo $file->countRevisions() ?></div>
<?php if (plugin_active('tags')) { ?>
<?php if (project_object_tags($file, active_project())!='--') { ?>
        <div class="fileTags"><?php echo lang('tags') ?>: <?php echo project_object_tags($file, active_project()) ?></div>
<?php } // if ?>
<?php } // if ?>
      </div>

<?php
  $options = array();
  if ($file->canEdit(logged_user())) {
    $options[] = '<a href="' . $file->getEditUrl() . '">' . lang('edit') . '</a>';
  }
  if ($file->canDelete(logged_user())) {
    $options[] = '<a href="' . $file->getMoveUrl() . '">' . lang('move') . '</a>';
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
      <div class="options"><?php echo implode(' | ', $options) ?></div>
<?php } // if ?>
    </div>
  </div>
  </div>

<?php } // foreach ?>
</div></div>
<?php } // foreach ?>
<?php $this->includeTemplate(get_template_path('order_and_pagination', 'files')) ?>
</div>
<?php } else { ?>
<p><?php echo lang('no files on the page') ?></p>
<?php } // if ?>