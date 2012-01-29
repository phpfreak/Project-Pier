<?php
  set_page_title(lang('wiki all pages'));
  project_tabbed_navigation();
  project_crumbs(array(
    array(lang('wiki'), get_url('wiki')),
    array(lang('wiki all pages'), $page->getAllPagesUrl()))
  );
  if ($page->canAdd(logged_user(), active_project())) {
    add_page_action(lang('add wiki page'), $page->getAddUrl());
  } // if

  add_inline_css_to_page('.wikiPageLocked{float:right; font-weight:bolder; border: 2px solid #D15151; padding: 2px; color: #fff; background-color: #ED6E6E}');
  add_page_action(lang('wiki public wiki'), externalUrl(ROOT_URL . '/' . PUBLIC_FOLDER . '/wiki'));
?>

<div id="wiki-page-content">
  <ul>
    <?php foreach ($all_pages as $spage) { ?>
    <?php   $parent = $spage->getParent(); ?>
    <?php   if ($parent instanceof WikiPage) { ?>
      <li><a href="<?php echo $spage->getViewUrl() ?>"><?php echo $spage->getObjectName() ?></a> (<a href="<?php echo $parent->getViewUrl() ?>"><?php echo $parent->getObjectName() ?></a>)</li>
    <?php   } else { ?>
      <li><a href="<?php echo $spage->getViewUrl() ?>"><?php echo $spage->getObjectName() ?></a></li>
    <?php   } // if  ?>
    <?php } // foreach ?>
  </ul>
</div>