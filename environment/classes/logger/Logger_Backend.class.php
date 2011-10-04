<?php

  /**
  * Logger backend interface need to be implemented by every logger backend in order to 
  * be pluggined into the Logger
  *
  * @package Logger
  * @http://www.projectpier.org/
  */
  interface Logger_Backend {
    
    /**
    * Save array of sessions into a single session set
    *
    * @param array $sessions
    * @return boolean
    */
    public function saveSessionSet($sessions);
    
    /**
    * This function will write logger session into the persistant storage (file, database, 
    * send an email etc)
    *
    * @param Logger_Session $session
    * @return boolean
    */
    public function saveSession(Logger_Session $session);
    
  } // Logger_Backend

?>