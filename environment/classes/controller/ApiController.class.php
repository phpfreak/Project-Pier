<?php

  /**
  * API controller is used for handling API requests
  *
  * @version 1.0
  * @http://www.projectpier.org/
  */
  abstract class ApiController extends Controller {
    
    /** Response types **/
    const RESPONSE_XML  = 'application/xml';
    const RESPONSE_JSON = 'application/json';
  
    /**
    * Construct the ApiController
    *
    * @access public
    * @param void
    * @return ApiController
    */
    function __construct() {
      parent::__construct();
      $this->setSystemControllerClass('ApiController');;
    } // __construct
    
    /**
    * Return response if specified format.
    * 
    * $objects can be:
    * 
    * - single DataObject. Sample response for ProjectTask object:
    * 
    * <response status="ok" format="text/xml">
    *   <object class="ProjectTask">
    *     <id type="integer">12</id>
    *     <text type="string">...</id>
    *     ...
    *   </object>
    * </response>
    * 
    *  - array of DataObjects. Sample response for array of ProjectTask objects:
    * 
    * <response status="ok" format="text/xml">
    *   <objects class="ProjectTask">
    *     <object>
    *       <id type="integer">12</id>
    *       <text type="string">...</id>
    *       ...
    *     </object>
    *   </objects>
    * </response>
    * 
    *  - NULL - Sample response
    * 
    * <response status="ok" format="text/xml">
    * </response>
    *
    * @param mixed $objects
    * @param string $format If this value is NULL requested format is used. If NULL and
    *   format is not specified default format is used (self::RESPONSE_XML)
    * @return null
    */
    function response($objects = null, $format = null) {
      
    } // response
    
    /**
    * Return HTTP error
    *
    * @param integer $code Error code
    * @return null
    */
    function error($code) {
      
    } // error
  
  } // ApiController

?>