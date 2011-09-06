<?php

  set_page_title($project_link->isNew() ? lang('add link') : lang('edit link'));
  project_tabbed_navigation(PROJECT_TAB_LINKS);
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
    <?php echo label_tag(lang('title'), 'projectLinkTitle', true) ?>
    <?php echo text_field('project_link[title]', array_var($project_link_data, 'title'), array('id' => 'projectFormTitle', 'class' => 'medium')) ?>
  </div>
  
  <div>
    <?php echo label_tag(lang('url'), 'projectLinkUrl', true) ?>
    <?php echo text_field('project_link[url]', array_var($project_link_data, 'url'), array('id' => 'projectFormUrl', 'class' => 'long')) ?>
  </div>
  
  <?php echo submit_button($project_link->isNew() ? lang('add link') : lang('edit link')) ?>
</form>
