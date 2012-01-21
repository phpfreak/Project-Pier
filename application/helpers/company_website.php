<?php

  // ---------------------------------------------------
  //  Dashboard
  // ---------------------------------------------------

  /**
  * Set array of dashboard crumbs
  *
  * @access public
  * @param void
  * @return null
  */
  function dashboard_crumbs() {
    add_bread_crumb(lang('dashboard'), get_url('dashboard'));
    
    $args = func_get_args();
    if (!count($args)) {
      return;
    }
    BreadCrumbs::instance()->addByFunctionArguments($args);
    
  } // dashboard_crumbs
  
  // Tab IDs
  define('DASHBOARD_TAB_OVERVIEW', 'overview');
  define('DASHBOARD_TAB_MY_PROJECTS', 'my_projects');
  define('DASHBOARD_TAB_MY_TASKS', 'my_tasks');
  define('DASHBOARD_TAB_WEEKLY_SCHEDULE', 'weekly_schedule');
  define('DASHBOARD_TAB_CONTACTS', 'contacts');

  /**
  * Prepare dashboard tabbed navigation
  *
  * @access public
  * @param string $selected ID of selected tab
  * @return null
  */
  function dashboard_tabbed_navigation($selected = DASHBOARD_TAB_OVERVIEW) {
    trace(__FILE__,'dashboard_tabbed_navigation');
    add_tabbed_navigation_item(
      DASHBOARD_TAB_OVERVIEW, 
      'overview', 
      get_url('dashboard', 'index')
    );
    add_tabbed_navigation_item(
      DASHBOARD_TAB_MY_PROJECTS,
      'my projects',
      get_url('dashboard', 'my_projects')
    );
    if (use_permitted(logged_user(), active_project(), 'tasks')) {
      add_tabbed_navigation_item(
        DASHBOARD_TAB_MY_TASKS,
        'my tasks',
        get_url('dashboard', 'my_tasks')
      );
    } // if
    add_tabbed_navigation_item(
      DASHBOARD_TAB_WEEKLY_SCHEDULE,
      'weekly schedule',
      get_url('dashboard', 'weekly_schedule')
    );
    if (logged_user()->isMemberOfOwnerCompany()) {
      add_tabbed_navigation_item(
        DASHBOARD_TAB_CONTACTS,
        'contacts',
        get_url('dashboard', 'contacts')
      );
    } // if
    trace(__FILE__,'dashboard_tabbed_navigation:plugin hook');
    // PLUGIN HOOK
    plugin_manager()->do_action('add_dashboard_tab');
    // PLUGIN HOOK
    trace(__FILE__,'dashboard_tabbed_navigation:set_selected');
      
    tabbed_navigation_set_selected($selected);
  } // dashboard_tabbed_navigation
  
  // ---------------------------------------------------
  //  Administration
  // ---------------------------------------------------
  
  /**
  * Set array of administration crumbs
  *
  * @access public
  * @param void
  * @return null
  */
  function administration_crumbs() {
    add_bread_crumb(lang('dashboard'), get_url('dashboard', 'index'));
    add_bread_crumb(lang('administration'), get_url('administration', 'index'));
    
    $args = func_get_args();
    if (!count($args)) {
      return;
    }
    BreadCrumbs::instance()->addByFunctionArguments($args);
    
  } // administration_crumbs
  
  // Tab IDs
  define('ADMINISTRATION_TAB_ADMINISTRATION', 'administration');
  define('ADMINISTRATION_TAB_COMPANY', 'company');
  define('ADMINISTRATION_TAB_PROJECTS', 'projects');
  define('ADMINISTRATION_TAB_CLIENTS', 'clients');
  define('ADMINISTRATION_TAB_CONFIGURATION', 'config');
  define('ADMINISTRATION_TAB_PLUGINS', 'plugins');
  define('ADMINISTRATION_TAB_TOOLS', 'tools');
  //define('ADMINISTRATION_TAB_UPGRADE', 'upgrade');

  /**
  * Prepare administration tabbed navigation
  *
  * @access public
  * @param string $selected ID of selected tab
  * @return null
  */
  function administration_tabbed_navigation($selected = ADMINISTRATION_TAB_ADMINISTRATION) {
    trace(__FILE__,'administration_tabbed_navigation');
    add_tabbed_navigation_item(
      ADMINISTRATION_TAB_ADMINISTRATION, 
      'index', 
      get_url('administration', 'index')
    );
    add_tabbed_navigation_item(
      ADMINISTRATION_TAB_COMPANY, 
      'company', 
      get_url('administration', 'company')
    );
    add_tabbed_navigation_item(
      ADMINISTRATION_TAB_CLIENTS,
      'clients',
      get_url('administration', 'clients')
    );
    add_tabbed_navigation_item(
      ADMINISTRATION_TAB_PROJECTS,
      'projects',
      get_url('administration', 'projects')
    );
    add_tabbed_navigation_item(
      ADMINISTRATION_TAB_CONFIGURATION,
      'configuration',
      get_url('administration', 'configuration')
    );
    add_tabbed_navigation_item(
      ADMINISTRATION_TAB_TOOLS,
      'administration tools',
      get_url('administration', 'tools')
    );
/*
    add_tabbed_navigation_item(
      ADMINISTRATION_TAB_UPGRADE,
      'upgrade',
      get_url('administration', 'upgrade')
    );
*/
    add_tabbed_navigation_item(
      ADMINISTRATION_TAB_PLUGINS,
      'plugins',
      get_url('administration','plugins')
    );
    
    // PLUGIN HOOK
    plugin_manager()->do_action('add_administration_tab');
    // PLUGIN HOOK
    
    tabbed_navigation_set_selected($selected);
  } // administration_tabbed_navigation
  
  // ---------------------------------------------------
  //  Account
  // ---------------------------------------------------
  
  /**
  * Prepare account bread crumbs
  *
  * @access public
  * @param void
  * @return null
  */
  function account_crumbs() {
    add_bread_crumb(lang('dashboard'), get_url('dashboard', 'index'));
    add_bread_crumb(lang('account'), get_url('account', 'index'));
    
    $args = func_get_args();
    if (!count($args)) {
      return;
    }
    BreadCrumbs::instance()->addByFunctionArguments($args);
    
  } // account_crumbs
  
  // Tab IDs
  define('ACCOUNT_TAB_MY_ACCOUNT', 'my_account');

  /**
  * Prepare account tabbed navigation
  *
  * @access public
  * @param string $selected ID of selected tab
  * @return null
  */
  function account_tabbed_navigation($selected = ACCOUNT_TAB_MY_ACCOUNT) {
    add_tabbed_navigation_item(
      ACCOUNT_TAB_MY_ACCOUNT, 
      'my account', 
      get_url('account', 'index')
    );
    
    // PLUGIN HOOK
    plugin_manager()->do_action('add_my_account_tab');
    // PLUGIN HOOK
    tabbed_navigation_set_selected($selected);
  } // account_tabbed_navigation

?>