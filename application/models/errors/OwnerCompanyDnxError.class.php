<?php

  /**
  * This error is throw when system fails to load owner company
  *
  * @version 1.0
  * @http://www.projectpier.org/
  */
  class OwnerCompanyDnxError extends Error {
  
    /**
    * Construct the OwnerCompanyDnxError
    *
    * @param string $message
    * @return OwnerCompanyDnxError
    */
    function __construct($message = null) {
      if (is_null($message)) {
        $message = 'Owner company is not defined';
      }
      parent::__construct($message);
    } // __construct
  
  } // OwnerCompanyDnxError

?>