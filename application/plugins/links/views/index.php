<?php
  trace(__FILE__,'begin');
  set_page_title(lang('project links'));
  project_tabbed_navigation(PROJECT_TAB_LINKS);
  project_crumbs(array(
    array(lang('links'), get_url('links', 'index')),
    array(lang('index'))
  ));
  if (ProjectLink::canAdd(logged_user(), active_project())) {
      add_page_action(lang('add link'), get_url('links', 'add_link'));
  } // if
  add_stylesheet_to_page('project/files.css');
  $counter = 0;
?>
<div id="files">
<?php if (isset($links) && is_array($links) && count($links)) { ?>
<div class="filesList">
<?php foreach ($links as $link) { ?>
<?php $counter++; ?>
  <div class="listedFile <?php echo $counter % 2 ? 'even' : 'odd' ?>">
  <div class="fileInfo">
      <div class="fileName"><a href="<?php echo $link->asUrl() ?>" title="<?php echo $link->getTitle() ?>" target="_blank"><?php echo $link->getTitle() ?></a></div>
      <div class="fileDetails"><?php if ($link->getCreatedBy() instanceof User) { ?><span><?php echo lang('created by') ?>:</span> <a href="<?php echo $link->getCreatedBy()->getCardUrl() ?>"><?php echo clean($link->getCreatedBy()->getDisplayName()) ?></a> <?php } ?></div>
    <?php
      $options = array();
      if ($link->canEdit(logged_user(),active_project())) {
        $options[] = '<a href="' . $link->getEditUrl() . '">' . lang('edit') . '</a>';
      }
      if ($link->canDelete(logged_user(),active_project())) {
        $options[] = '<a href="' . $link->getDeleteUrl() . '">' . lang('delete') . '</a>';
      }
    ?>
<?php if (count($options)) { ?>
      <div class="fileOptions"><?php echo implode(' | ', $options) ?></div>
<?php } // if ?>
  </div>
  </div>
<?php } // foreach ?>
</div>
<?php } else { ?>
<p><?php echo lang('no links found') ?></p>
<?php } // if ?>
</div>
<?php trace(__FILE__,'begin'); ?>
