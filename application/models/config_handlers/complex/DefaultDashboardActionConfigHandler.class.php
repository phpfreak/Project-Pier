<?php

/**
* Let user select which page to go to after
* logging in, or when clicking a link to go 
* to the dashboard
*
* @http://www.projectpier.org/
*/
class DefaultDashboardActionConfigHandler extends ConfigHandler {
  /**
  * Render form control
  *
  * @param string $control_name
  * @return string
  */
  function render($control_name) {
    $options = array();
    $actions_of_dashboard_controller = array_diff(get_class_methods('DashboardController'), get_class_methods('ApplicationController'));
    foreach ($actions_of_dashboard_controller as $action_name)
    {
      $option_attributes = $this->getValue() == $action_name ? array('selected' => 'selected') : null;
      $options[] = option_tag(lang("config option name dashboard action $action_name"), $action_name, $option_attributes);
    }
    return select_box($control_name, $options);
  } // render
} // DefaultDashboardActionConfigHandler
?>