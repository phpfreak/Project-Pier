<?php

  /**
  * Set array of dashboard crumbs
  *
  * @param void
  * @return null
  */
  function project_crumbs() {
    
    add_bread_crumb(lang('dashboard'), get_url('dashboard'));
    if (active_project()) {
      add_bread_crumb(active_project()->getName(), active_project()->getOverviewUrl());
    }
    $args = func_get_args();
    if (!count($args)) {
      return;
    }
    BreadCrumbs::instance()->addByFunctionArguments($args);
    
  } // project_crumbs
  
  // Tab IDs
  define('PROJECT_TAB_OVERVIEW', 'overview');
  define('PROJECT_TAB_MESSAGES', 'messages');
  define('PROJECT_TAB_TASKS', 'tasks');
  define('PROJECT_TAB_MILESTONES', 'milestones');

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
      get_url('project', 'index')
    ));
    add_tabbed_navigation_item(new TabbedNavigationItem(
      PROJECT_TAB_MESSAGES, 
      lang('messages'), 
      get_url('message', 'index')
    ));
    add_tabbed_navigation_item(new TabbedNavigationItem(
      PROJECT_TAB_TASKS, 
      lang('tasks'), 
      get_url('task', 'index')
    ));
    add_tabbed_navigation_item(new TabbedNavigationItem(
      PROJECT_TAB_MILESTONES, 
      lang('milestones'), 
      get_url('milestone', 'index')
    ));

    // PLUGIN HOOK
    plugin_manager()->do_action('add_project_tab');
    // PLUGIN HOOK
    
    tabbed_navigation_set_selected($selected);
  } // project_tabbed_navigation

?>
