<?php
trace(__FILE__,'begin');
/**
 * @author Alex Mayhew
 * @copyright 2008
 */

  set_page_title((!$iscurrev ? lang('viewing revision of', $revision->getRevision(), $revision->getName()) : $revision->getName() . ' [' . $revision->getPageId() . ']' ));
  project_tabbed_navigation(PROJECT_TAB_WIKI);
  project_crumbs( array(
		array(lang('wiki'), get_url('wiki')),
		array($revision->getName()))
  );
  if ($page->canAdd(logged_user(), active_project())) {
    add_page_action(lang('add wiki page'), $page->getAddUrl());
  } // if
  if($page->canEdit(logged_user(), active_project()) && !$page->isNew()){
    add_page_action(lang('edit wiki page'), $page->getEditUrl());	
    add_page_action(lang('view page history'), $page->getViewHistoryUrl());
  } // if
  if($page->canDelete(logged_user(), active_project()) && !$page->isNew() && $iscurrev){
    add_page_action(lang('delete wiki page'), $page->getDeleteUrl());
  }
?>

<div id="wiki-page-content">
<?php echo do_textile(wiki_links($revision->getContent())); ?>
</div>