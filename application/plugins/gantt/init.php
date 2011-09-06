<?php
  // add project tab
  define('PROJECT_TAB_GANTT', 'Gantt');
  add_action('add_project_tab', 'gantt_add_project_tab');
  
  function gantt_add_project_tab() {
    add_tabbed_navigation_item(new TabbedNavigationItem(
      PROJECT_TAB_GANTT,
      lang('gantt'),
      get_url('gantt', 'index')
    ));
  }

?>
