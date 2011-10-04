<?php

  /**
  * Abstract feed renderer
  *
  * @package Angie.toys
  * @subpackage feed
  * @http://www.projectpier.org/
  */
  abstract class Angie_Feed_Renderer {
  
    /**
    * Render feed
    * 
    * This function will take input feed and return XML code that can be printed to the client based on it
    *
    * @param Angie_Feed $feed
    * @return string
    */
    abstract function render(Angie_Feed $feed);
  
  } // Angie_Feed_Renderer

?>