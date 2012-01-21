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


  function project_tabbed_navigation_filter($items) {
    $pass = array();
    foreach ($items as &$item) {
      if (use_permitted(logged_user(), active_project(), $item->getID())) {
        $pass[]=$item;
      } else {
        if ($item->getId() == 'overview') {
          $pass[]=$item;
        }
        if ($item->getId() == 'links') {   // links are outside of permissions setup currently
          $pass[]=$item;
        }
      }
    }
    return $pass;
  }
  
  /**
  * Prepare dashboard tabbed navigation
  *
  * @param string $selected ID of selected tab
  * @return null
  */
  function project_tabbed_navigation($selected = 'overview') {
    add_filter('tabbed_navigation_items', 'project_tabbed_navigation_filter');

    add_tabbed_navigation_item('overview', 'overview', get_url('project', 'index'));
    add_tabbed_navigation_item('milestones', 'milestones', get_url('milestone', 'index'));
    add_tabbed_navigation_item('tasks', 'tasks', get_url('task', 'index'));
    add_tabbed_navigation_item('messages', 'messages', get_url('message', 'index'));

    // PLUGIN HOOK
    plugin_manager()->do_action('add_project_tab');
    // PLUGIN HOOK
    
    tabbed_navigation_set_selected($selected);
  } // project_tabbed_navigation

?>