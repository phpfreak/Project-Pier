<?php
  trace(__FILE__,'begin');
  set_page_title(lang('i18n'));
  administration_tabbed_navigation('i18n');
  administration_crumbs(lang('i18n'), get_url('i18n'));

  if (I18nLocale::canAdd(logged_user())) {
      add_page_action(lang('add locale'), get_url('i18n', 'add_locale'));
  } // if
  add_stylesheet_to_page('i18n.css');
  $counter = 0;
?>
<ul id="i18n_locale">
<?php if (isset($locales) && is_array($locales) && count($locales)) { ?>
<?php $show_icon = (config_option('files_show_icons', '1') == '1'); ?>
<?php foreach ($locales as $locale) { ?>
<?php $counter++; ?>
  <li class="item <?php echo $counter % 2 ? 'even' : 'odd' ?>">
<?php if ($show_icon) { ?>
  <div class="icon"><img src="<?php echo $locale->getLogoURL(); ?>" alt="<?php echo clean($locale->getName()) ?> logo"></div>
<?php } ?>
  <div class="block">
  <div class="header"><?php echo $locale->getName() ?></div>
  <div class="content"><div><?php echo clean($locale->getDescription()) ?></div><?php if ($locale->getCreatedBy() instanceof User) { ?><span><?php echo lang('created by') ?>:</span> <a href="<?php echo $locale->getCreatedBy()->getCardUrl() ?>"><?php echo clean($locale->getCreatedBy()->getDisplayName()) ?></a> <?php } ?><?php // echo render_object_tags($locale); ?>
</div>
<?php
  $options = array();
  if ($locale->canEdit(logged_user())) {
    $options[] = '<a href="' . $locale->getEditUrl() . '">' . lang('edit') . '</a>';
    $options[] = '<a href="' . $locale->getEditLogoUrl() . '">' . lang('edit logo') . '</a>';
  }
  if ($locale->getEditorId() == logged_user()->getId()) {
    $options[] = '<a href="' . $locale->getEditValuesUrl() . '">' . lang('edit values') . '</a>';
    $options[] = '<a href="' . $locale->getLoadValuesUrl() . '">' . lang('load values') . '</a>';
  }
  if ($locale->canDelete(logged_user())) {
    $options[] = '<a href="' . $locale->getDeleteUrl() . '">' . lang('delete') . '</a>';
  }
?>
<?php if (count($options)) { ?>
  <div class="options"><?php echo implode(' | ', $options) ?></div>
<?php } // if ?>
  </div>
  </li>
<?php } // foreach ?>
<?php } else { ?>
<div class="none"><?php echo lang('no locale found') ?></div>
<?php } // if ?>
</div>
<?php trace(__FILE__,'begin'); ?>