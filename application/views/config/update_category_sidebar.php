<?php if (isset($config_categories) && is_array($config_categories) && count($config_categories)) { ?>
<div class="sidebarBlock">
  <h2><?php echo lang('configuration categories') ?></h2>
  <div class="blockContent">
    <ul class="listWithDetails">
<?php foreach ($config_categories as $current_config_category) { ?>
      <li><a href="<?php echo $current_config_category->getUpdateUrl() ?>"><?php echo clean($current_config_category->getDisplayName()) ?></a></li>
<?php } // foreach ?>
    </ul>
  </div>
</div>
<?php } // if ?>