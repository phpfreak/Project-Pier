<?php

  /**
  * Render select folder box
  *
  * @param string $name Control name
  * @param Project $project
  * @param integer $selected ID of selected folder
  * @param array $attributes Select box attributes
  * @return string
  */
  function select_project_folder($name, $project = null, $selected = null, $attributes = null) {
    if (is_null($project)) {
      $project = active_project();
    } // if
    if (!($project instanceof Project)) {
      throw new InvalidInstanceError('$project', $project, 'Project');
    } // if
    
    if (is_array($attributes)) {
      if (!isset($attributes['class'])) {
        $attributes['class'] = 'select_folder';
      }
    } else {
      $attributes = array('class' => 'select_folder');
    } // if
    
    $options = array(option_tag(lang('none'), 0));
    
    $folders = $project->getFolders();
    if (is_array($folders)) {
      foreach ($folders as $folder) {
      	$option_attributes = $folder->getId() == $selected ? array('selected' => true) : null;
      	$options[] = option_tag($folder->getName(), $folder->getId(), $option_attributes);
      } // foreach
    } // if
    
    return select_box($name, $options, $attributes);
  } // select_project_folder
?>