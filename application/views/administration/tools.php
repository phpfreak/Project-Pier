<?php
  set_page_title(lang('administration tools'));
  administration_tabbed_navigation('tools');
  administration_crumbs(lang('administration tools'));
?>
<?php if (isset($tools) && is_array($tools) && count($tools)) { ?>
<div id="administrationTools">
<?php foreach ($tools as $tool) { ?>
  <div class="administrationTool">
    <div class="administrationToolName">
      <h2><a href="<?php echo $tool->getToolUrl() ?>"><?php echo clean($tool->getDisplayName()) ?></a></h2>
    </div>
    <div class="administrationToolDesc"><?php echo clean($tool->getDisplayDescription()) ?></div>
  </div>
<?php } // foreach ?>
</div>
<?php } else { ?>
<p><?php echo lang('no administration tools') ?></p>
<?php } // if ?>