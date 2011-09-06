<?php

  /**
  * Let user select where he wants to store uploaded files
  *
  * @http://www.projectpier.org/
  */
  class FileStorageConfigHandler extends ConfigHandler {
  
    /**
    * Render form control
    *
    * @param string $control_name
    * @return string
    */
    function render($control_name) {
      $options = array();
      
      $option_attributes = $this->getValue() == FILE_STORAGE_FILE_SYSTEM ? array('selected' => 'selected') : null;
      $options[] = option_tag(lang('file storage file system'), FILE_STORAGE_FILE_SYSTEM, $option_attributes);
      
      $option_attributes = $this->getValue() == FILE_STORAGE_MYSQL ? array('selected' => 'selected') : null;
      $options[] = option_tag(lang('file storage mysql'), FILE_STORAGE_MYSQL, $option_attributes);
      
      return select_box($control_name, $options);
    } // render
  
  } // FileStorageConfigHandler

?>