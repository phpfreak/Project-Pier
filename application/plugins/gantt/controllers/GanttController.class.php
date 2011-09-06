<?php

/**
 * @author ALBATROS INFORMATIQUE SARL - CARQUEFOU FRANCE - Damien HENRY
 * @copyright 2011
 */

Class GanttController extends ApplicationController {

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
	 * Gantt file img
	 * 
	 *@return string | die
	 */         	
	function file(){
	   $gantt = new Gantt();
	   $gantt->MakeGantt();
  }
}

?>