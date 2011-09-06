<?php

/**
 * @author ALBATROS INFORMATIQUE SARL - CARQUEFOU FRANCE - Damien HENRY
 * @copyright 2011
 */

Class MmController extends ApplicationController {

  function __construct()
  {
    trace(__FILE__,'__construct()');
    parent::__construct();
    prepare_company_website_controller($this, 'project_website');
  } // __controller
	
  /**
  * Mm index
   * 
   * @return void
   */
  function index()
  {
    trace(__FILE__,'index()');
  }// index
	
	/**
	 * Mn file
	 * 
	 *@return string | die
	 */         	
	function file(){
	   $mm = new Mm();
	   $mm->MakeMm();
  }
}

?>