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
  function select_project_folder($name, $project = null, $selected = null, $exclude = null, $attributes = null) {
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

    $folders = ProjectFolders::getProjectFolders($project);    
    if (is_array($folders)) {
      $sorted = array();
      foreach ($folders as $folder) {
      	$sorted[$folder->getObjectName(true)] = $folder;
      } // foreach
      ksort($sorted);
      foreach ($sorted as $k => $folder) {
      	$option_attributes = $folder->getId() == $selected ? array('selected' => true) : null;
      	$options[] = option_tag($k, $folder->getId(), $option_attributes);
      } // foreach
    } // if
    
    return select_box($name, $options, $attributes);
  } // select_project_folder

  /**
  * Select a single project file
  *
  * @param string $name Control name
  * @param Project $project
  * @param integer $selected ID of selected file
  * @param array $exclude_files Array of IDs of files that need to be excluded (already attached to object etc)
  * @param array $attributes
  * @return string
  */
  function select_project_file($name, $project = null, $selected = null, $exclude_files = null, $attributes = null) {
    if (is_null($project)) {
      $project = active_project();
    } // if
    if (!($project instanceof Project)) {
      throw new InvalidInstanceError('$project', $project, 'Project');
    } // if
    
    $all_options = array(option_tag(lang('none'), 0)); // array of options
    
    $folders = $project->getFolders();
    if (is_array($folders)) {
      foreach ($folders as $folder) {
        $files = $folder->getFiles();
        if (is_array($files)) {
          $options = array();
          foreach ($files as $file) {
            if (is_array($exclude_files) && in_array($file->getId(), $exclude_files)) {
              continue;
            }
            
            $option_attrbutes = $file->getId() == $selected ? array('selected' => true) : null;
            $options[] = option_tag($file->getFilename(), $file->getId(), $option_attrbutes);
          } // if
          
          if (count($options)) {
            $all_options[] = option_tag('', 0); // separator
            $all_options[] = option_group_tag($folder->getName(), $options);
          } // if
        } // if
      } // foreach
    } // if
    
    $orphaned_files = $project->getOrphanedFiles();
    if (is_array($orphaned_files)) {
      $all_options[] = option_tag('', 0); // separator
      foreach ($orphaned_files as $file) {
        if (is_array($exclude_files) && in_array($file->getId(), $exclude_files)) {
          continue;
        }
        
        $option_attrbutes = $file->getId() == $selected ? array('selected' => true) : null;
        $all_options[] = option_tag($file->getFilename(), $file->getId(), $option_attrbutes);
      } // foreach
    } // if
    
    return select_box($name, $all_options, $attributes);
  } // select_project_file


  /**
  * Render folder tree
  *
  * @param string $name Control name
  * @param Project $project
  * @param integer $selected ID of selected folder
  * @param array $attributes Select box attributes
  * @return string
  */
  function render_folder_tree($folder, $depth = 0, $project = null, $selected = null, $attributes = null) {
    if ($depth>5) return;
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
    
    $html = '';
    if ($folder instanceof ProjectFolder) {
      $folders = ProjectFolders::getProjectFolderTree( $project, $folder->getId() );
    } else {
      $folders = ProjectFolders::getProjectFolderTree( $project );
    }
    if (is_array($folders)) {
      $html .= '<ul>';
      foreach ($folders as $folder) {
        $class = $folder->getId() == $selected ? $class = 'class="selected"' : '';
        //$html .= '<li>' . $folder->getName() . render_folder_tree( $folder, $depth, $project, $selected, $attributes ) . '</li>';
        $html .= '<li><a href="' . $folder->getBrowseUrl() . '" ' . $class . '>' . clean($folder->getName()) . '</a>';
        if ($folder->canEdit(logged_user())) { 
          $html .= ' <a href="' . $folder->getEditUrl() . '" class="blank" title="' . lang('edit folder') . '"><img src="' . icon_url('edit.gif') . '" alt="" /></a>';
        } // if 
        if ($folder->canDelete(logged_user())) { 
          $html .= ' <a href="' . $folder->getDeleteUrl() . '" class="blank" title="' . lang('delete folder') . '"><img src="' . icon_url('cancel_gray.gif') . '" alt="" /></a>';
        } // if 
        $html .= render_folder_tree( $folder, $depth + 1, $project, $selected, $attributes ); 
        $html .= '</li>';
      } // foreach
      $html .= '</ul>';
    } // if
    
    return $html;
  } // render_folder_tree

?>