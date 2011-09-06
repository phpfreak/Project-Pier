<?php if (!$attach_files_js_included) { ?>
<?php add_stylesheet_to_page('project/attach_files.css'); ?>
<script type="text/javascript" src="<?php echo get_javascript_url('modules/attachFiles.js') ?>"></script>
<?php } // if ?>

<fieldset id="attachFiles_<?php echo $attach_files_id ?>" class="attachFiles">
  <legend><?php echo lang('attach files') ?></legend>
  <div id="attachFilesControls_<?php echo $attach_files_id ?>">
    <div id="attachFiles_<?php echo $attach_files_id ?>_1"><?php echo file_field($attach_files_prefix . '1') ?></div>
  </div>
</fieldset>

<script type="text/javascript">
  App.modules.attachFiles.initialize(<?php echo $attach_files_max_controls ?>, '<?php echo lang('add attach file control') ?>', '<?php echo lang('remove attach file control') ?>', '<?php echo lang('error attach files max controls', $attach_files_max_controls) ?>');
  App.modules.attachFiles.initSet(1, '<?php echo $attach_files_prefix ?>');
</script>
