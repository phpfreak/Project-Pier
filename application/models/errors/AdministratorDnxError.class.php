<?php

  /**
  * This error is thrown when system fails to load administrator user
  *
  * @version 1.0
  * @http://www.projectpier.org/
  */
  class AdministratorDnxError extends Error {
  
    /**
    * Construct the AdministratorDnxError
    *
    * @param string $message
    * @return AdministratorDnxError
    */
    function __construct($message = null) {
      if (is_null($message)) {
        $message = 'Administrator account is not defined';
      }
      parent::__construct($message);
    } // __construct
  
  } // AdministratorDnxError

?>