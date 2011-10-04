<?php
  add_stylesheet_to_page('project/attach_files.css');
?>
<?php if (isset($attached_files) && is_array($attached_files) && count($attached_files)) { ?>
<div class="objectFiles">
  <div class="objectFilesTitle"><span><?php echo lang('attached files') ?>:</span></div>
  <ul>
<?php foreach ($attached_files as $attached_file) { ?>
<?php if ($attached_file->isPrivate() && !logged_user()->isMemberOfOwnerCompany()) continue; ?>
    <li>
<?php
  $attached_file_options = array();
  $attached_file_options[] = '<a href="' . $attached_file->getDetailsUrl() . '">' . lang('file details') . '</a>';
  if ($attached_files_object->canDetachFile(logged_user(), $attached_file)) {
    $attached_file_options[] = '<a href="' . $attached_files_object->getDetachFileUrl($attached_file) . '" onclick="return confirm(\'' . lang('confirm detach file') . '\')">' . lang('detach file') . '</a>';
  }
?>
      <a href="<?php echo $attached_file->getDownloadUrl() ?>"><span><?php echo clean($attached_file->getFilename()) ?></span> (<?php echo format_filesize($attached_file->getFilesize()) ?>)</a> | <?php echo implode(' | ', $attached_file_options) ?>
    </li>
<?php } // foreach ?>
  </ul>
<?php if ($attached_files_object->canAttachFile(logged_user(), $attached_files_object->getProject())) { ?>
  <p><a href="<?php echo $attached_files_object->getAttachFilesUrl() ?>">&raquo; <?php echo lang('attach more files') ?></a></p>
<?php } // if ?>
</div>
<?php } else { ?>
<?php if ($attached_files_object->canAttachFile(logged_user(), $attached_files_object->getProject())) { ?>
<div class="objectFiles">
  <div class="objectFilesTitle"><span><?php echo lang('attached files') ?>:</span> <?php echo lang('no attached files') ?>. <a href="<?php echo $attached_files_object->getAttachFilesUrl() ?>"><?php echo lang('attach files') ?></a>.</div>
</div>
<?php } // if ?>
<?php } // if ?>