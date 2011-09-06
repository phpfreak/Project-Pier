<?php

  /**
  * Set array of dashboard crumbs
  *
  * @param void
  * @return null
  */
  function project_crumbs() {
    
    add_bread_crumb(lang('dashboard'), get_url('dashboard'));
    add_bread_crumb(active_project()->getName(), active_project()->getOverviewUrl());
    
    $args = func_get_args();
    if (!count($args)) {
      return;
    }
    BreadCrumbs::instance()->addByFunctionArguments($args);
    
  } // dashboard_crumbs
  
  // Tab IDs
  define('PROJECT_TAB_OVERVIEW', 'overview');
  define('PROJECT_TAB_MESSAGES', 'messages');
  define('PROJECT_TAB_TASKS', 'tasks');
  define('PROJECT_TAB_MILESTONES', 'milestones');
  define('PROJECT_TAB_FILES', 'files');
  define('PROJECT_TAB_TAGS', 'tags');
  define('PROJECT_TAB_FORMS', 'forms');
  define('PROJECT_TAB_PEOPLE', 'people');

  /**
  * Prepare dashboard tabbed navigation
  *
  * @param string $selected ID of selected tab
  * @return null
  */
  function project_tabbed_navigation($selected = PROJECT_TAB_OVERVIEW) {
    add_tabbed_navigation_item(new TabbedNavigationItem(
      PROJECT_TAB_OVERVIEW, 
      lang('overview'), 
      get_url('project')
    ));
    add_tabbed_navigation_item(new TabbedNavigationItem(
      PROJECT_TAB_MESSAGES, 
      lang('messages'), 
      get_url('message')
    ));
    add_tabbed_navigation_item(new TabbedNavigationItem(
      PROJECT_TAB_TASKS, 
      lang('tasks'), 
      get_url('task')
    ));
    add_tabbed_navigation_item(new TabbedNavigationItem(
      PROJECT_TAB_MILESTONES, 
      lang('milestones'), 
      get_url('milestone')
    ));
    add_tabbed_navigation_item(new TabbedNavigationItem(
      PROJECT_TAB_FILES, 
      lang('files'), 
      get_url('files')
    ));
    add_tabbed_navigation_item(new TabbedNavigationItem(
      PROJECT_TAB_TAGS,
      lang('tags'),
      get_url('project', 'tags')
    ));
    if (logged_user()->isAdministrator()) {
      add_tabbed_navigation_item(new TabbedNavigationItem(
        PROJECT_TAB_FORMS,
        lang('forms'),
        get_url('form')
      ));
    } // if
    add_tabbed_navigation_item(new TabbedNavigationItem(
      PROJECT_TAB_PEOPLE,
      lang('people'),
      get_url('project', 'people')
    ));
    tabbed_navigation_set_selected($selected);
  } // dashboard_tabbed_navigation

?>
