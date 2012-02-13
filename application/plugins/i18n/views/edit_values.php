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
<?php $trx_url = trim($locale->getTranslationUrl()); ?>
<?php if ($trx_url) { ?>
<iframe src="<?php echo $trx_url ?>" style="border: 1px solid black; width: 100%; height: 12em;"></iframe>
<?php } ?>
<p><?php echo lang('click to edit') ?></p>
<table id="i18n_values" class="filtered">
  <tr>
  <th><?php echo lang('#') ?></th>
  <th><?php echo lang('key') ?></th>
  <th><?php echo lang('mark') ?></th>
  <th><?php echo lang('text') ?></th>
  <th><?php echo lang('english') ?></th>
  <th><?php echo lang('created by') ?></th>
  <th><?php echo lang('updated by') ?></th>
  </tr>
<?php // DB::addToSQLLog('==edit_values=='); ?>
<?php foreach ($values as $value) { ?>
<?php $vid = $value->getId(); ?>
<?php $counter++; ?>
<?php $en_us = trim($value->getDescriptionIn('en', 'us'));
      $desc = trim($value->getDescription());
      $mark = '';
      if (strlen($desc)>0) { 
        if ($desc == $en_us) {
          $mark = '==';
        }
        $desc1 = $desc[0]; 
        if ($desc1 == '~') {
          $mark = '~';
          if (extension_loaded('mbstring')) {
            $desc = mb_substr($desc, 1);
          } else {
            $desc = substr($desc, 1);
          }
        }
      } else {
        $mark = '=0';
      }
?>
  <tr class="item <?php echo $counter % 2 ? 'even' : 'odd' ?>">
  <td class="id"><?php echo $counter ?></td>
  <td class="edit" id="<?php echo $vid.'_name' ?>"><?php echo clean($value->getName()) ?></td>
  <td class="mark"><?php echo $mark ?></td>
  <td class="edit" id="<?php echo $vid.'_description' ?>"><?php echo clean($desc) ?></td>
  <td><?php echo $en_us ?></td>
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