<?php

  set_page_title(lang('load values'));
  administration_tabbed_navigation('i18n');
  administration_crumbs(lang('i18n'), get_url('i18n'));

  add_page_action(lang('add locale'), get_url('i18n', 'add_locale', array('status' => '0')));
  add_stylesheet_to_page('i18n.css');
  $locale = $load_data['locale'];
?>
<h2><?php echo lang('locale') . ': ' . $locale->getName() ?></h2>
<form action="<?php echo $locale->getLoadValuesUrl() ?>" method="post">
<?php tpl_display(get_template_path('form_errors')) ?>

  <div>
    <?php echo label_tag(lang('replace'), 'loadFormReplace', false) ?>
    <?php echo yes_no_widget('load[replace]', 'loadFormReplace', array_var($load_data, 'replace'), lang('yes'), lang('no')) ?>
  </div>

  <fieldset>
  <legend><?php echo lang('load from') ?></legend>
  <div>
    <?php echo radio_field('load[what]', true, array('value' => 'locale', 'id'=>'loadFormWhatLocale')); ?>
    <?php echo label_tag(lang('locale'), 'loadFormLocale', false) ?>
    <?php echo select_locale('load[locale]', array_var($load_data, 'locales1'), array('value' => 'existing', 'id' => 'loadFormLocale')) ?>
  </div>

  <div>
    <?php echo radio_field('load[what]', false, array('value' => 'file', 'id'=>'loadFormWhatFile')); ?>
    <?php echo label_tag(lang('files'), 'loadFormFile', false); ?>
    <?php echo select_locale('load[file]', array_var($load_data, 'locales2'), array('id' => 'loadFormFile')) ?>
  </div>
  </fieldset>

  <p><?php echo lang('maximum execution time', $load_data['max_time']) . $load_data['max_time'] ?></p>

  <?php echo submit_button(lang('load')) ?>
</form>