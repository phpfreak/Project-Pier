<?php

  /**
  * Application helpers. This helpers are injected into the controllers
  * through ApplicationController construction so they are available in
  * whole application
  *
  * @http://www.projectpier.org/
  */
  
  /**
  * Render select ticket type
  *
  * @param string $selected type of ticket
  * @param array $attributes Additional attributes
  * @return string
  */
  function select_ticket_type($name, $selected = null, $attributes = null) {
    $types = array('defect', 'enhancement', 'feature request');
    $options = array();
    foreach($types as $type) {
      $option_attributes = $type == $selected ? array('selected' => 'selected') : null;
      $options[] = option_tag(lang($type), $type, $option_attributes);
    } // foreach
    return select_box($name, $options, $attributes);
  } // select_ticket_type
  
  /**
  * Render select ticket priority
  *
  * @param string $selected priority of ticket
  * @param array $attributes Additional attributes
  * @return string
  */
  function select_ticket_priority($name, $selected = null, $attributes = null) {
    if ($selected == null) $selected = 'minor';
    $types = array('critical', 'major', 'minor', 'trivial');
    $options = array();
    foreach($types as $type) {
      $option_attributes = $type == $selected ? array('selected' => 'selected') : null;
      $options[] = option_tag(lang($type), $type, $option_attributes);
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
      $option_attributes = $type == $selected ? array('selected' => 'selected') : null;
      $options[] = option_tag(lang($type), $type, $option_attributes);
    } // foreach
    return select_box($name, $options, $attributes);
  } // select_ticket_state
  
?>