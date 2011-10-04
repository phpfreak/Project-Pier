<?php
  set_page_title(lang('configuration'));
  administration_tabbed_navigation(ADMINISTRATION_TAB_CONFIGURATION);
  administration_crumbs(lang('configuration', 'index'));
?>
<div id="configuration">
<?php if (isset($config_categories) && is_array($config_categories) && count($config_categories)) { ?>
<?php foreach ($config_categories as $config_category) { ?>
<?php if (!$config_category->isEmpty()) { ?>

  <div class="configCategory" id="category_<?php echo $config_category->getName() ?>">
    <h2><a href="<?php echo $config_category->getUpdateUrl() ?>"><?php echo clean($config_category->getDisplayName()) ?></a></h2>
<?php if (trim($config_category->getDisplayDescription())) { ?>
    <div class="configCategoryDescription"><?php echo do_textile($config_category->getDisplayDescription()) ?></div>
<?php } // if ?>
  </div>
  
<?php } // if ?>
<?php } // foreach ?>
<?php } // if ?>
</div>