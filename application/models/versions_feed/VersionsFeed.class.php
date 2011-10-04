<?php

  /**
  * Model class that provides interface to ProjectPier update feed:
  * 
  * http://upgrade.projectpier.org/upgrade.xml
  *
  */
  final class VersionsFeed {
    
    /**
    * Simple xml object
    *
    * @var SimpleXMLElement
    */
    private $xml_object;
    
    /**
    * True if we have loaded feed
    *
    * @var boolean
    */
    private $is_loaded = false;
    
    /**
    * URL of XML file
    *
    * @var string
    */
    private $feed_url = 'http://upgrade.projectpier.org/beta.xml';
    
    /**
    * Feed format - version
    *
    * @var string
    */
    private $feed_format = null;
    
    /**
    * Array of versions extracted from the XML file
    *
    * @var array
    */
    private $versions;
  
    /**
    * Construct the VersionsFeed
    *
    * @param void
    * @return VersionsFeed
    */
    function __construct($feed_url = null) {
      if (!is_null($feed_url)) {
        $this->setFeedUrl($feed_url);
      } // if
      $this->setIsLoaded($this->read());
    } // __construct
    
    // ---------------------------------------------------
    //  Utils
    // ---------------------------------------------------
    
    /**
    * This function will return true if there is a new version compared to the input version
    *
    * @param string $current_version
    * @return boolean
    */
    function hasNewVersions($current_version) {
      $versions = $this->getVersions();
      if (is_array($versions)) {
        foreach ($versions as $version) {
          if ($version->isNewerThan($current_version)) {
            return true;
          }
        } // foreach
      } // if
      return false;
    } // hasNewVersions
    
    /**
    * It will return new versions compared to the input version
    *
    * @param string $current_version
    * @return array
    */
    function getNewVersions($current_version) {
      $new_versions = null;
      $all_versions = $this->getVersions();
      if (is_array($all_versions)) {
        $new_versions = array();
        foreach ($all_versions as $version) {
          if ($version->isNewerThan($current_version)) {
            $new_versions[] = $version;
          }
        } // foreach
        if (!count($new_versions)) {
          $new_versions = null;
        } // if
      } // if
      return $new_versions;
    } // getNewVersions
    
    /**
    * Read the data from the XML file and prepare it
    *
    * @param void
    * @return null
    */
    private function read() {
      if (!function_exists('simplexml_load_file')) {
        return false;
      } // if
      
      $this->xml_object = simplexml_load_file($this->getFeedUrl());
      if (!($this->xml_object instanceof SimpleXMLElement)) {
        $this->xml_object = null;
        return false;
      } // if
      
      return $this->processXml();
    } // read
    
    /**
    * Extract data from the XML file
    *
    * @param void
    * @return boolean
    */
    private function processXml() {
      $feed_format = $this->xml_object['format'];
      if (trim($feed_format)) {
        $this->setFeedFormat($feed_format);
      } // if
      
      $versions = array();
      foreach ($this->xml_object->children() as $version_node) {
        $version = new VersionsFeedEntry($version_node);
        if ($version->isLoaded()) {
          $versions[] = $version;
        }
        if (count($versions)) {
          usort($versions, array('VersionsFeed', 'compareByVersion'));
        } // if
      } // foreach
      
      $this->versions = count($versions) ? $versions : null;
      return true;
    } // processXml
    
    /**
    * Compare two feed entries by version
    *
    * @param void
    * @return integer
    */
    static function compareByVersion(VersionsFeedEntry $object1, VersionsFeedEntry $object2) {
      return version_compare($object1->getVersionNumber(), $object2->getVersionNumber());
    } // compareByVersion
    
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
    * Get feed_url
    *
    * @param null
    * @return string
    */
    function getFeedUrl() {
      return $this->feed_url;
    } // getFeedUrl
    
    /**
    * Set feed_url value
    *
    * @param string $value
    * @return null
    */
    function setFeedUrl($value) {
      $this->feed_url = $value;
    } // setFeedUrl
    
    /**
    * Get feed_format
    *
    * @param null
    * @return string
    */
    function getFeedFormat() {
      return $this->feed_format;
    } // getFeedFormat
    
    /**
    * Set feed_format value
    *
    * @param string $value
    * @return null
    */
    function setFeedFormat($value) {
      $this->feed_format = $value;
    } // setFeedFormat
    
    /**
    * Return array of versions that we extracted from the XML file
    *
    * @param void
    * @return array
    */
    function getVersions() {
      return $this->versions;
    } // getVersions
    
    /**
    * Return specific version entry, if found
    *
    * @param string $number Version number
    * @return VersionsFeedEntry
    */
    function getVersion($number) {
      $versions = $this->getVersions();
      if (is_array($versions)) {
        foreach ($versions as $version) {
          if ($version->getVersionNumber() == $number) {
            return $version;
          }
        } // foerach
      } // if
      return null;
    } // getVersion
  
  } // VersionsFeed

?>