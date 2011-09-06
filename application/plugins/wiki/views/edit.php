<?php
trace(__FILE__,'begin');
/**
 * @author Alex Mayhew
 * @copyright 2008
 */

  $project_crumbs = array(array(lang('wiki'), get_url('wiki', 'index')));
  if(!$page->isNew()){
    $project_crumbs[] = array($revision->getName(), $page->getViewUrl());
    $project_crumbs[] = array(lang('edit wiki page'));
  } else {
    $project_crumbs[] = array(lang('add wiki page'));
  }

  set_page_title(lang('wiki'));
  project_tabbed_navigation(PROJECT_TAB_WIKI);
  project_crumbs($project_crumbs);
 
?>

<?php if($page->isNew()): ?>
<form action="<?php echo $page->getAddUrl() ?>" method="POST">
<?php else: ?>
<form action="<?php echo $page->getEditUrl() ?>" method="POST">
<?php endif;?>
<?php tpl_display(get_template_path('form_errors')) ?>

<div id="wiki-field-name">
<?php echo label_tag(lang('name'), 'wikiFormName', true) ?>
<?php echo text_field('wiki[name]', $revision->getName(), array('class' => 'long', 'id' => 'wikiFormName')) ?>
</div>
<div id="wiki-field-content">
<?php echo label_tag(lang('wiki page content'), 'wikiFormContent', true) ?>
<?php echo textarea_field('wiki[content]', $revision->getContent(), array('cols' => 400, 'class' => 'shot', 'id' => 'wikiFormContent')) ?>
</div>
<div id-"wiki-field-log">
<?php 
  echo label_tag(lang('wiki log message'), 'wikiFormLog');
  echo text_field('wiki[log_message]', ($page->isNew() ? lang('wiki page created') : ''), array('class' => 'long', 'id' => 'wikiFormLog'));
  if (plugin_active('tags')) {
    echo label_tag(lang('tags'), 'wikiFormTags');
    echo text_field('wiki[tags]', '', array('class' => 'long', 'id' => 'wikiFormLog'));
  }
  echo label_tag(lang('wiki set as index page'), 'wikiFormIndexYes');
  echo yes_no_widget('wiki[project_index]', 'wikiFormIndex', $page->getProjectIndex(), lang('yes'), lang('no'));
  echo label_tag(lang('wiki set as sidebar page'), 'wikiFormSidebarYes');
  echo yes_no_widget('wiki[project_sidebar]', 'wikiFormSidebar', $page->getProjectSidebar(), lang('yes'), lang('no'));
?>
</div>

<?php echo submit_button($page->isNew() ? lang('add wiki page') : lang('edit wiki page')) ?>

</form>