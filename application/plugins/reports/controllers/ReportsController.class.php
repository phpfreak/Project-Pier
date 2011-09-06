<?php
/**
 * @author ALBATROS INFORMATIQUE SARL - CARQUEFOU FRANCE - Damien HENRY
 * @licence Honest Public License
 * @package ProjectPier Gantt
 * @version $Id$
 * @access public
 */
class ReportsController extends ApplicationController {

  function __construct() {
    trace(__FILE__,'__construct()');
    parent::__construct();
    prepare_company_website_controller($this, 'project_website');
  } // __construct
	
  /**
  * Mm index
   * 
   * @return void
   */
  function index() {
    trace(__FILE__,'index()');
  }// index
	
  /**
   * Gantt image
   * 
   * @ return string | die
   */         	
  function gantt_chart() {
    $gantt = new Reports();
    $gantt->MakeGanttChart();
  }
  
  /**
   * Mm file
   * 
   * @return string | die
   */         	
  function mindmap() {
    $mm = new Reports();
    $mm->MakeMindMap();
  }
  
}

?>