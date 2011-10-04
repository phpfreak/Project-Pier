<?php
  add_stylesheet_to_page('project/attach_files.css');
?>
<div class="objectFiles">
<div class="objectFilesBrief">
<?php if (isset($attached_files) && is_array($attached_files) && count($attached_files)) { ?>
  <ul>
<?php foreach ($attached_files as $attached_file) {
      if ($attached_file->isPrivate() && !logged_user()->isMemberOfOwnerCompany()) continue; ?>
    <li><a href="<?php echo $attached_file->getDownloadUrl() ?>">
          <span><?php echo clean($attached_file->getObjectname()) ?></span>
      </a>
    </li>
<?php } // foreach ?>
  </ul>
<?php } else { ?>
<?php if ($attached_files_object->canAttachFile(logged_user(), $attached_files_object->getProject())) { ?>
      <a href="<?php echo $attached_files_object->getAttachFilesUrl() ?>"><?php echo lang('attach') ?></a>
<?php } // if ?>
</div>
</div>
<?php } // if ?>