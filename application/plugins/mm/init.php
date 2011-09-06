<?php
  // add project tab
  define('PROJECT_TAB_MM', 'freemind');
  add_action('add_project_tab', 'mm_add_project_tab');
  
  function mm_add_project_tab() {
    add_tabbed_navigation_item(new TabbedNavigationItem(
      PROJECT_TAB_MM,
      lang('mm'),
      get_url('mm', 'index')
    ));
  }

?>
