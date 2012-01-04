<?php

  set_page_title($locale->isNew() ? lang('add locale') : lang('edit locale'));
  administration_tabbed_navigation('i18n');
  administration_crumbs(lang('i18n'), get_url('i18n'));

  add_page_action(lang('add locale'), get_url('i18n', 'add_locale', array('status' => '0')));
  add_stylesheet_to_page('i18n.css');
?>
<?php if ($locale->isNew()) { ?>
<form action="<?php echo get_url('i18n', 'add_locale') ?>" method="post">
<?php } else { ?>
<form action="<?php echo $locale->getEditUrl() ?>" method="post">
<?php } // if?>

<?php tpl_display(get_template_path('form_errors')) ?>

  <div>
    <?php echo label_tag(lang('name'), 'localeFormName', true) ?>
    <?php echo text_field('locale[name]', array_var($locale_data, 'name'), array('id' => 'localeFormName', 'class' => 'medium')) ?>
  </div>
  
  <div>
    <?php echo label_tag(lang('description'), 'localeFormDescription', true) ?>
    <?php echo textarea_field('locale[description]', array_var($locale_data, 'description'), array('id' => 'localeFormDescription', 'class' => 'long')) ?>
  </div>

  <div>
    <?php echo label_tag(lang('language code'), 'localeFormLanguageCode', true) ?>
    <?php echo text_field('locale[language_code]', array_var($locale_data, 'language_code'), array('id' => 'localeFormLanguageCode', 'class' => 'medium')) ?>
  </div>

  <div>
    <?php echo label_tag(lang('country code'), 'localeFormCountryCode', true) ?>
    <?php echo text_field('locale[country_code]', array_var($locale_data, 'country_code'), array('id' => 'localeFormCountryCode', 'class' => 'medium')) ?>
  </div>

  <div>
    <?php echo label_tag(lang('editor'), 'localeFormEditor', true) ?>
    <?php echo select_user('locale[editor_id]', array_var($locale_data, 'editor_id'), array('id' => 'localeFormEditorId')) ?>
  </div>

<?php if (false) { // if (plugin_active('tags')) {
  echo label_tag(lang('tags'), 'localeFormTags');
  echo text_field('locale_data[tags]', array_var($locale_data, 'tags'), array('class' => 'long', 'id' => 'localeFormTags'));
} // if ?>  

  <?php echo submit_button($locale->isNew() ? lang('add locale') : lang('edit locale')) ?>
</form>