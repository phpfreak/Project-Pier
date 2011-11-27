<?php
/**
 * @author ALBATROS INFORMATIQUE SARL - CARQUEFOU FRANCE - Damien HENRY
 * @licence Honest Public License
 * @package ProjectPier Gantt
 * @version $Id$
 * @access public
 */
// add project tab
  define('PROJECT_TAB_REPORTS', 'reports');
  add_action('add_project_tab', 'reports_add_project_tab');
  
  function reports_add_project_tab() {
    if (use_permitted(logged_user(), active_project(), 'reports')) {
      add_tabbed_navigation_item(
        PROJECT_TAB_REPORTS,
        'reports',
        get_url('reports', 'index')
      );
    }
  }

  function reports_activate() {
  }
?>