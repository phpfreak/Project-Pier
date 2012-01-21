<?php
if (plugin_active('files')) { 
$file = $attachment->getObject();
if (!$file) {
?>
  <div class="fileAttachment">
    <div class="fileIcon"><img src="<?php echo get_image_url('filetypes/unknown.png'); ?>" /></div>
    <div class="fileInfo">
      <span class="fileDescription"><?php echo $attachment->getText() ?>:</span>
      <span class="fileName"><?php echo lang('edit project to select file'); ?></span>
    </div>
    <div class="clear"></div>
  </div>

<?php 
} else {
  if ($file->canView(logged_user())) {
?>
  <div class="fileAttachment">
<?php if ($file->isPrivate()) { ?>
    <div class="private" title="<?php echo lang('private file') ?>"><span><?php echo lang('private file') ?></span></div>
<?php } // if ?>
<?php if ($file->getFileType()->getIsImage()) { ?>
  <img src="<?php echo $file->getDownloadUrl() ?>" style="max-height:100%; max-width:100%;">
<?php } else { ?>
    <!--- <div class="fileIcon"><img src="<?php echo $file->getTypeIconUrl() ?>" alt="<?php echo $file->getFilename() ?>" /></div> --->
    <div class="fileInfo">
      <span class="fileDescription"><?php echo $attachment->getText() ?>:</span>
      <span class="fileName"><a href="<?php echo $file->getDetailsUrl() ?>" title="<?php echo lang('view file details') ?>"><?php echo clean($file->getFilename()) ?></a></span>
    </div>
<?php } // if ?>
    <div class="clear"></div>
  </div>
<?php
  } // if
} // if
} // if
?>