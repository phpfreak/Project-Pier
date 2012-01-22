<?php
  trace(__FILE__,'begin');
  set_page_title(lang('project links'));
  project_tabbed_navigation('links');
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
<ul id="links">
<?php if (isset($links) && is_array($links) && count($links)) { ?>
<?php $show_icon = (config_option('files_show_icons', '1') == '1'); ?>
<?php foreach ($links as $link) { ?>
<?php $counter++; ?>
  <li class="item <?php echo $counter % 2 ? 'even' : 'odd' ?>">
  <div class="block">
<?php if ($show_icon) { ?>
  <div class="icon">
    <a rel="gallery" href="<?php echo $link->asUrl() . "?mime=text/html" ?>"><img src="<?php echo $link->getLogoURL(); ?>" alt="<?php echo clean($link->getTitle()) ?> logo"></a>
  </div>
<?php } ?>
  <div class="header"><a href="<?php echo $link->asUrl() ?>" title="<?php echo $link->getTitle() ?>" target="_blank"><?php echo $link->getTitle() ?></a></div>
  <div class="content"><div><?php echo clean($link->getDescription()) ?></div><?php if ($link->getCreatedBy() instanceof User) { ?><span><?php echo lang('created by') ?>:</span> <a href="<?php echo $link->getCreatedBy()->getCardUrl() ?>"><?php echo clean($link->getCreatedBy()->getDisplayName()) ?></a> <?php } ?><?php echo render_object_tags($link); ?>
</div>
<?php
  $options = array();
  if ($link->canEdit(logged_user(),active_project())) {
    $options[] = '<a href="' . $link->getEditUrl() . '">' . lang('edit') . '</a>';
    $options[] = '<a href="' . $link->getEditLogoUrl() . '">' . lang('edit logo') . '</a>';
  }
  if ($link->canDelete(logged_user(),active_project())) {
    $options[] = '<a href="' . $link->getDeleteUrl() . '">' . lang('delete') . '</a>';
  }
?>
<?php if (count($options)) { ?>
  <div class="options"><?php echo implode(' | ', $options) ?></div>
<?php } // if ?>
  </div>
  </li>
<?php } // foreach ?>
<?php } else { ?>
<div class="none"><?php echo lang('no links found') ?></div>
<?php } // if ?>
</div>
<?php trace(__FILE__,'begin'); ?>