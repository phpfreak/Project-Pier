<?php
  trace(__FILE__,'begin');
  set_page_title(lang('i18n edit locale values'));
  administration_tabbed_navigation('i18n');
  administration_crumbs(lang('i18n'), get_url('i18n'));

  if (I18nLocale::canAdd(logged_user())) {
      add_page_action(lang('add locale'), get_url('i18n', 'add_locale'));
  } // if
  add_stylesheet_to_page('i18n.css');
  $counter = 0;
?>
<?php if (isset($values) && is_array($values) && count($values)) { ?>
<form action=""><?php echo lang('search') ?>: <input type="text" id="filter"> <span id="filter-count"></span></form><br>
<p><?php echo lang('click to edit') ?></p>
<table id="i18n_values" class="filtered">
  <tr>
  <th><?php echo lang('#') ?></th>
  <th><?php echo lang('key') ?></th>
  <th><?php echo lang('text') ?></th>
  <th><?php echo lang('english') ?></th>
  <th><?php echo lang('created by') ?></th>
  <th><?php echo lang('updated by') ?></th>
  </tr>
<?php // DB::addToSQLLog('==edit_values=='); ?>
<?php foreach ($values as $value) { ?>
<?php $vid = $value->getId(); ?>
<?php $counter++; ?>
  <tr class="item <?php echo $counter % 2 ? 'even' : 'odd' ?>">
  <td class="id"><?php echo $counter ?></td>
  <td class="edit" id="<?php echo $vid.'_name' ?>"><?php echo clean($value->getName()) ?></td>
  <td class="edit" id="<?php echo $vid.'_description' ?>"><?php echo clean($value->getDescription()) ?></td>
  <td><?php echo clean($value->getDescriptionIn('en', 'us')) ?></td>
  <td><?php if ($value->getCreatedBy() instanceof User) { ?><a href="<?php echo $value->getCreatedByCardUrl() ?>"><?php echo clean($value->getCreatedByDisplayName()) ?></a> <?php } ?></td>
  <td><?php if ($value->getUpdatedBy() instanceof User) { ?><a href="<?php echo $value->getUpdatedByCardUrl() ?>"><?php echo clean($value->getUpdatedByDisplayName()) ?></a> <?php } ?></td>
  </tr>
<?php } // foreach ?>
</table>
<?php } else { ?>
<div class="none"><?php echo lang('no locale values found') ?></div>
<?php } // if ?>
</div>
<?php // print_r(DB::getSQLLog()); ?>
<?php trace(__FILE__,'end'); ?>