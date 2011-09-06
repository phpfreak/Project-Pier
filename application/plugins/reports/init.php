<?php
/**
 * @author ALBATROS INFORMATIQUE SARL - CARQUEFOU FRANCE - Damien HENRY
 * @licence Honest Public License
 * @package ProjectPier Gantt
 * @version $Id$
 * @access public
 */
// add project tab
  define('PROJECT_TAB_REPORTS', 'Reports');
  add_action('add_project_tab', 'reports_add_project_tab');
  
  function reports_add_project_tab() {
    add_tabbed_navigation_item(new TabbedNavigationItem(
      PROJECT_TAB_REPORTS,
      lang('reports'),
      get_url('reports', 'index')
    ));
  }

?>
