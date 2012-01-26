<?php
  set_page_title($category->getDisplayName());
  administration_tabbed_navigation(ADMINISTRATION_TAB_CONFIGURATION);
  administration_crumbs(array(
    array(lang('configuration'), get_url('administration', 'configuration')),
    array($category->getDisplayName())
  ));
  add_stylesheet_to_page('admin/config.css');
?>
<?php if (isset($options) && is_array($options) && count($options)) { ?>
<form action="<?php echo $category->getUpdateUrl() ?>" method="post" onreset="return confirm('<?php echo lang('confirm reset form') ?>')">
  <div id="configCategoryOptions">
<?php $counter = 0; ?>
<?php foreach ($options as $option) { ?>
<?php $counter++; ?>
    <div class="configCategoryOption <?php echo $counter % 2 ? 'odd' : 'even' ?>" id="configCategoryOption_<?php echo $option->getName() ?>">
      <div class="configOptionLabel"><label><?php echo clean($option->getDisplayName()) ?>:</label></div>
      <div class="configOptionControl"><?php echo $option->render('options[' . $option->getName() . ']') ?></div>
<?php if (trim($option_description = $option->getDisplayDescription())) { ?>
      <div class="configOptionDescription desc"><?php echo do_textile($option_description) ?></div>
<?php } // if ?>
      <div class="clear"></div>
    </div>
<?php } // foreach ?>
  </div>

  <div style="float:right"><button style="margin-top: 10px;" type="reset"><?php echo lang('reset') ?></button>&nbsp;<?php echo submit_button(lang('save')) ?></div>
</form>
<?php } else { ?>
<p><?php echo lang('config category is empty') ?></p>
<?php } // if ?>