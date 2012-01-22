<?php
  trace(__FILE__,'begin');
  if ($current_folder instanceof Projectfolder) {
    set_page_title($current_folder->getObjectName(true) . ' '. lang('files'));
  } else {
    set_page_title(lang('all files'));
  } // if
  
  project_tabbed_navigation(PROJECT_TAB_FILES);
  $files_crumbs = array(
    0 => array(lang('files'), get_url('files'))
  ); // array
  if ($current_folder instanceof ProjectFolder) {
    $files_crumbs[] = array($current_folder->getName(), $current_folder->getBrowseUrl($order));
  } // if
  $files_crumbs[] = array(lang('index'));
  
  trace(__FILE__,'project_crumbs');
  project_crumbs($files_crumbs);
  trace(__FILE__,'ProjectFile::canAdd');
  if (ProjectFile::canAdd(logged_user(), active_project())) {
    if ($current_folder instanceof ProjectFolder) {
      add_page_action(lang('add file'), $current_folder->getAddFileUrl());
    } else {
      add_page_action(lang('add file'), get_url('files', 'add_file'));
    } // if
  } // if
  
  trace(__FILE__,'ProjectFolder::canAdd');
  if (ProjectFolder::canAdd(logged_user(), active_project())) {
    if ($current_folder instanceof ProjectFolder) {
      add_page_action(lang('add folder'), $current_folder->getAddUrl());
    } else {
      add_page_action(lang('add folder'), get_url('files', 'add_folder'));
    } // if
    //add_page_action(lang('add folder'), get_url('files', 'add_folder'));
  } // if
  if ($current_folder instanceof ProjectFolder) {
    if ($current_folder->canEdit(logged_user())) {
      add_page_action(lang('edit folder'), $current_folder->getEditUrl());
    }
    if ($current_folder->canDelete(logged_user())) {
      add_page_action(lang('delete folder'), $current_folder->getDeleteUrl());
    }
  }
  
  add_stylesheet_to_page('project/files.css');

?>
<?php $this->assign('files', $files) ?>
<?php $this->includeTemplate(get_template_path('list_files', 'files')) ?>