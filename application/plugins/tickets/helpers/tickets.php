<?php

  /**
  * Application helpers. These helpers are injected into the controllers
  * through ApplicationController construction so they are available in
  * whole application
  *
  * @http://www.projectpier.org/
  */
  
  /**
  * Returns possible values for ticket status
  * TODO: remove hardcoded values!
  *
  * @param void
  * @return array
  */
  function get_ticket_statuses() {
    $types = array('opened', 'confirmed', 'not reproducable', 'test and confirm', 'fixed', 'closed');
    return $types;
    // return array('new', 'open', 'pending', 'closed');
    //return get_array('ProjectTicket.status');
  } // get_ticket_statuses
  
  /**
  * Render select ticket status
  *
  * @param string $selected status of ticket
  * @param array $attributes Additional attributes
  * @return string
  */
  function select_ticket_status($name, $selected = null, $attributes = null) {
    $statuses = get_ticket_statuses();
    $options = array();
    foreach($statuses as $status) {
      if ($status != 'closed') {
        $option_attributes = $status == $selected ? array('selected' => 'selected') : null;
        $options[] = option_tag(lang($status), $status, $option_attributes);
      }
    } // foreach
    return select_box($name, $options, $attributes);
  } // select_ticket_type
    
  /**
  * Returns possible values for ticket type
  * TODO: remove hardcoded values!
  *
  * @param void
  * @return array
  */
  function get_ticket_types() {
    return array('defect', 'enhancement', 'feature request');
  } // get_ticket_types    
  /**
  * Render select ticket type
  *
  * @param string $selected type of ticket
  * @param array $attributes Additional attributes
  * @return string
  */
  function select_ticket_type($name, $selected = null, $attributes = null) {
    $types = get_ticket_types();
    $options = array();
    foreach($types as $type) {
      $option_attributes = $type == $selected ? array('selected' => 'selected') : null;
      $options[] = option_tag(lang($type), $type, $option_attributes);
    } // foreach
    return select_box($name, $options, $attributes);
  } // select_ticket_type
  
  /**
  * Returns possible values for ticket priority
  * TODO: remove hardcoded values!
  *
  * @param void
  * @return array
  */
  function get_ticket_priorities() {
    return array('critical', 'major', 'minor', 'trivial');
  } // get_ticket_priorities

  /**
  * Render select ticket priority
  *
  * @param string $selected priority of ticket
  * @param array $attributes Additional attributes
  * @return string
  */
  function select_ticket_priority($name, $selected = null, $attributes = null) {
    if ($selected == null) $selected = 'minor';
    $priorities = get_ticket_priorities();
    $options = array();
    foreach($priorities as $priority) {
      $option_attributes = $priority == $selected ? array('selected' => 'selected') : null;
      $options[] = option_tag(lang($priority), $priority, $option_attributes);
    } // foreach
    return select_box($name, $options, $attributes);
  } // select_ticket_priority
  
  /**
  * Render select ticket priority
  *
  * @param Project $project ticket's project to get the categories
  * @param int $selected category id of ticket
  * @param array $attributes Additional attributes
  * @return string
  */
  function select_ticket_category($name, $project, $selected = null, $attributes = null) {
    $categories = $project->getCategories();
    $option_attributes = $selected ? null: array('selected' => 'selected');
    $options = array(option_tag(lang('none'), 0, $option_attributes));
    if ($categories && count($categories)) {
      foreach($categories as $category) {
        $option_attributes = $category->getId() == $selected ? array('selected' => 'selected') : null;
        $options[] = option_tag($category->getName(), $category->getId(), $option_attributes);
      } // foreach
    } // if
    return select_box($name, $options, $attributes);
  } // select_ticket_priority

  /**
  * Render select ticket state
  *
  * @param string $selected state of ticket
  * @param array $attributes Additional attributes
  * @return string
  */
  function select_ticket_state($name, $selected = null, $attributes = null) {
    if ($selected == null) $selected = 'opened';
    $types = array('opened', 'confirmed', 'not reproducable', 'test and confirm', 'fixed', 'closed');
    $options = array();
    foreach($types as $type) {
      if ($type != 'closed') {
        $option_attributes = $type == $selected ? array('selected' => 'selected') : null;
        $options[] = option_tag(lang($type), $type, $option_attributes);
      }
    } // foreach
    return select_box($name, $options, $attributes);
  } // select_ticket_state
  
?>