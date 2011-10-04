<?php add_stylesheet_to_page('project/attach_files.css'); ?>

<fieldset id="attachFiles_<?php echo $attach_files_id ?>" class="attachFiles">
  <legend><?php echo lang('attach files') ?></legend>
  <div id="attachFilesControls_<?php echo $attach_files_id ?>">
    <div id="attachFiles_<?php echo $attach_files_id ?>_1"><?php echo file_field($attach_files_prefix . '1') ?></div>
  </div>
</fieldset>