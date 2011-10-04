<?php

  /**
  * Interface that all file repository backend adapters need to implement
  *
  * @package FileRepository.backend
  * @http://www.projectpier.org/
  */
  interface FileRepository_Backend {
    function listFiles();
    function countFiles();
    function getFileContent($file_id);
    function getFileAttributes($file_id);
    function getFileAttribute($file_id, $attribute_name, $default = null);
    function setFileAttribute($file_id, $attribute_name, $attribute_value);
    function addFile($source, $attributes = null);
    function updateFileContent($file_id, $source);
    function deleteFile($file_id);
    function cleanUp();
    function isInRepository($file_id);
  } // FileRepository_Backend

?>