<?php

  set_page_title($project_link->isNew() ? lang('add link') : lang('edit link'));
  project_tabbed_navigation();
  project_crumbs(array(
    array(lang('links'), get_url('links')),
    array($project_link->isNew() ? lang('add link') : lang('edit link'))
  ));
  add_stylesheet_to_page('project/files.css');
  
?>
<?php if ($project_link->isNew()) { ?>
<form action="<?php echo get_url('links', 'add_link') ?>" method="post">
<?php } else { ?>
<form action="<?php echo $project_link->getEditUrl() ?>" method="post">
<?php } // if?>

<?php tpl_display(get_template_path('form_errors')) ?>

  <div>
    <?php echo label_tag(lang('title'), 'linkFormTitle', true) ?>
    <?php echo text_field('project_link[title]', array_var($project_link_data, 'title'), array('id' => 'linkFormTitle', 'class' => 'medium')) ?>
  </div>
  
  <div>
    <?php echo label_tag(lang('url'), 'linkFormUrl', true) ?>
    <?php echo text_field('project_link[url]', array_var($project_link_data, 'url'), array('id' => 'linkFormUrl', 'class' => 'long')) ?>
  </div>

  <div>
    <?php echo label_tag(lang('description'), 'linkFormDescription', true) ?>
    <?php echo textarea_field('project_link[description]', array_var($project_link_data, 'description'), array('id' => 'linkFormDescription', 'class' => 'long')) ?>
  </div>

  <div>
    <?php echo label_tag(lang('folder'), 'linkFormFolder', true) ?>
    <?php echo select_project_folder('project_link[folder_id]', active_project(), array_var($project_link_data, 'folder_id'), array('id' => 'linkFormFolder')) ?>
  </div>

<?php if (plugin_active('tags')) { ?>  
  <fieldset>
    <legend><?php echo lang('tags') ?></legend>
    <?php echo project_object_tags_widget('project_link[tags]', active_project(), array_var($project_link_data, 'tags'), array('id' => 'linkFormTags', 'class' => 'long')) ?>
  </fieldset>
<?php } // if ?>  

  <?php echo submit_button($project_link->isNew() ? lang('add link') : lang('edit link')) ?>
</form>