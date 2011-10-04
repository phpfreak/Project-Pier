<?php

  /**
  * Download link of version feed entry
  *
  * @version 1.0
  * @http://www.projectpier.org/
  */
  final class VersionsFeedDownloadLink {
    
    /**
    * True if this download link is loaded from the XML
    *
    * @var boolean
    */
    private $is_loaded = false;
    
    /**
    * Download link URL
    *
    * @var string
    */
    private $url;
    
    /**
    * Format - zip, tgz etc
    *
    * @var string
    */
    private $format;
    
    /**
    * Size in bytes
    *
    * @var integer
    */
    private $size;
  
    /**
    * Construct the VersionsFeedDownloadLink
    *
    * @param SimpleXMLElement $node
    * @return VersionsFeedDownloadLink
    */
    function __construct(SimpleXMLElement $node) {
      $this->setIsLoaded($this->read($node));
    } // __construct
    
    /**
    * Read the data from the XML node
    *
    * @param SimpleXMLNode $node
    * @return boolean
    */
    function read(SimpleXMLElement $node) {
      $this->setUrl($node);
      if (isset($node['format'])) {
        $this->setFormat($node['format']);
      }
      if (isset($node['size'])) {
        $this->setSize($node['size']);
      }
      return true;
    } // read
    
    // ---------------------------------------------------
    //  Getters and setters
    // ---------------------------------------------------
    
    /**
    * Get is_loaded
    *
    * @param null
    * @return boolean
    */
    function isLoaded() {
      return $this->is_loaded;
    } // isLoaded
    
    /**
    * Set is_loaded value
    *
    * @param boolean $value
    * @return null
    */
    private function setIsLoaded($value) {
      $this->is_loaded = $value;
    } // setIsLoaded
    
    /**
    * Get url
    *
    * @param null
    * @return string
    */
    function getUrl() {
      return $this->url;
    } // getUrl
    
    /**
    * Set url value
    *
    * @param string $value
    * @return null
    */
    private function setUrl($value) {
      $this->url = trim($value);
    } // setUrl
    
    /**
    * Get format
    *
    * @param null
    * @return string
    */
    function getFormat() {
      return $this->format;
    } // getFormat
    
    /**
    * Set format value
    *
    * @param string $value
    * @return null
    */
    private function setFormat($value) {
      $this->format = trim($value);
    } // setFormat
    
    /**
    * Get size
    *
    * @param null
    * @return integer
    */
    function getSize() {
      return $this->size;
    } // getSize
    
    /**
    * Set size value
    *
    * @param integer $value
    * @return null
    */
    function setSize($value) {
      $this->size = (integer) $value;
    } // setSize
  
  } // VersionsFeedDownloadLink

?>