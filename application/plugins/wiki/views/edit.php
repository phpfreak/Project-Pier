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
  project_tabbed_navigation();
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
<?php echo textarea_field('wiki[content]', $data['content'], array('cols' => 132, 'class' => 'shot', 'id' => 'wikiFormContent')) ?>
<?php echo submit_button(lang('preview'), 'p', array( 'name' => 'wiki[preview]') ) ?>
<?php echo label_tag(lang('preview'), 'wikiFormPreview', false) ?>
<div class="preview"><?php echo do_textile(plugin_manager()->apply_filters('wiki_text', $data['preview_content'])); ?></div>
</div>
<div id="wiki-field-log">
<?php 
  echo label_tag(lang('wiki log message'), 'wikiFormLog');
  echo text_field('wiki[log_message]', ($page->isNew() ? lang('wiki page created') : ''), array('class' => 'long', 'id' => 'wikiFormLog'));
?>
<?php 
  if (plugin_active('tags')) {
    echo label_tag(lang('tags'), 'wikiFormTags');
    echo text_field('wiki[tags]', $tags, array('class' => 'long', 'id' => 'wikiFormTags'));
  }
?>
</div>
  <div>
    <?php echo label_tag(lang('parent page'), 'wikiFormParentId', true) ?>
    <?php echo wiki_select_page('wiki[parent_id]', active_project(), $page->getParentId(), array('id' => 'wikiFormParentId')) ?>
  </div>
<div id="wiki-options">
<?php 
  echo label_tag(lang('wiki set as index page'), 'wikiFormIndexYes');
  echo yes_no_widget('wiki[project_index]', 'wikiFormIndex', $page->getProjectIndex(), lang('yes'), lang('no'));
  echo label_tag(lang('wiki set as sidebar page'), 'wikiFormSidebarYes');
  echo yes_no_widget('wiki[project_sidebar]', 'wikiFormSidebar', $page->getProjectSidebar(), lang('yes'), lang('no'));
  echo label_tag(lang('wiki publish page'), 'wikiFormPublishYes');
  echo yes_no_widget('wiki[publish]', 'wikiFormPublish', $page->getPublish(), lang('yes'), lang('no'));

  if ($page->canLock(logged_user())) { ?>
<div id="wiki-field-lockpage">
<?php 
  echo label_tag(lang('wiki lock page'), 'wikiFormLockPageYes');
  echo yes_no_widget('wiki[locked]', 'wikiFormLockPage', $page->getLocked(), lang('yes'), lang('no'));
?>
<div>
<?php 
  if ($page->getLocked()) { 
    //echo lang('wiki page locked');
    echo lang('wiki page locked by on', $page->getLockedByUser()->getUsername(), format_datetime($page->getLockedOn()));
  } else {
    echo lang('wiki page not locked');
  }
?>
</div>
</div>
<?php } // if ?>
</div>

<?php echo submit_button($page->isNew() ? lang('add wiki page') : lang('edit wiki page')) ?>

</form>