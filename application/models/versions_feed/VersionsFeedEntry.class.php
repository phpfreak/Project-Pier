<?php

  /**
  * Single (version) entry of www.ProjectPier version feed
  *
  * @version 1.0
  * @http://www.projectpier.org/
  */
  final class VersionsFeedEntry {
    
    /**
    * Is this version loaded from the SimpleXMLNode
    *
    * @var boolean
    */
    private $is_loaded = false;
  
    /**
    * Version number
    *
    * @var string
    */
    private $version_number;
    
    /**
    * Is this version stable
    *
    * @var boolean
    */
    private $is_stable;
    
    /**
    * Details page URL
    *
    * @var string
    */
    private $details_url;
    
    /**
    * Product signaturre, usualy product name + version number
    *
    * @var string
    */
    private $signature;
    
    /**
    * Release notes - short info about this version
    *
    * @var string
    */
    private $release_notes;
    
    /**
    * Release date - time when this version become available
    *
    * @var DateTimeValue
    */
    private $release_date;
    
    /**
    * URL to change log
    *
    * @var string
    */
    private $change_log_url;
    
    /**
    * Array of download links
    *
    * @var array
    */
    private $download_links;
    
    /**
    * Construct the VersionsFeedEntry
    *
    * @param SimpleXMLElement $node
    * @return VersionsFeedEntry
    */
    function __construct(SimpleXMLElement $node) {
      $this->setIsLoaded($this->read($node));
    } // __construct
    
    // ---------------------------------------------------
    //  Utils
    // ---------------------------------------------------
    
    /**
    * Returns true if this version is newer than input version
    *
    * @param string $version Input version
    * @return boolean
    */
    function isNewerThan($version) {
      return version_compare($this->getVersionNumber(), $version) > 0;
    } // isNewerThan
    
    /**
    * Read the values from XML node
    *
    * @param SimpleXMLElement $node
    * @return boolean
    */
    function read(SimpleXMLElement $node) {
      $this->setVersionNumber($node['number']);
      $this->setIsStable(isset($node['stable']) && ($node['stable'] == 'stable'));
      $this->setDetailsUrl($node->details_url);
      $this->setSignature($node->signature);
      $this->setReleaseNotes($node->release_notes);
      $this->setReleaseDate(DateTimeValueLib::makeFromString((string) $node->release_date));
      $this->setChangeLogUrl($node->change_log);
      
      if ($node->download_links->children() instanceof SimpleXMLElement) {
        $download_links = array();
        foreach ($node->download_links->children() as $link_node) {
          $download_link = new VersionsFeedDownloadLink($link_node);
          if ($download_link->isLoaded()) {
            $download_links[] = $download_link;
          }
        } // foreach
        $this->download_links = count($download_links) ? $download_links : null;
      } // if
      
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
    * Get version_number
    *
    * @param null
    * @return string
    */
    function getVersionNumber() {
      return $this->version_number;
    } // getVersionNumber
    
    /**
    * Set version_number value
    *
    * @param string $value
    * @return null
    */
    private function setVersionNumber($value) {
      $this->version_number = (string) $value;
    } // setVersionNumber
    
    /**
    * Get is_stable
    *
    * @param null
    * @return boolean
    */
    function getIsStable() {
      return $this->is_stable;
    } // getIsStable
    
    /**
    * Set is_stable value
    *
    * @param boolean $value
    * @return null
    */
    private function setIsStable($value) {
      $this->is_stable = (boolean) $value;
    } // setIsStable
    
    /**
    * Get details_url
    *
    * @param null
    * @return string
    */
    function getDetailsUrl() {
      return $this->details_url;
    } // getDetailsUrl
    
    /**
    * Set details_url value
    *
    * @param string $value
    * @return null
    */
    private function setDetailsUrl($value) {
      $this->details_url = (string) $value;
    } // setDetailsUrl
    
    /**
    * Get signature
    *
    * @param null
    * @return string
    */
    function getSignature() {
      return $this->signature;
    } // getSignature
    
    /**
    * Set signature value
    *
    * @param string $value
    * @return null
    */
    private function setSignature($value) {
      $this->signature = (string) $value;
    } // setSignature
    
    /**
    * Get release_notes
    *
    * @param null
    * @return string
    */
    function getReleaseNotes() {
      return $this->release_notes;
    } // getReleaseNotes
    
    /**
    * Set release_notes value
    *
    * @param string $value
    * @return null
    */
    private function setReleaseNotes($value) {
      $this->release_notes = (string) $value;
    } // setReleaseNotes
    
    /**
    * Get release_date
    *
    * @param null
    * @return DateTimeValue
    */
    function getReleaseDate() {
      return $this->release_date;
    } // getReleaseDate
    
    /**
    * Set release_date value
    *
    * @param DateTimeValue $value
    * @return null
    */
    private function setReleaseDate($value) {
      if ($value instanceof DateTimeValue) {
        $this->release_date = $value;
      }
    } // setReleaseDate
    
    /**
    * Get change_log_url
    *
    * @param null
    * @return string
    */
    function getChangeLogUrl() {
      return $this->change_log_url;
    } // getChangeLogUrl
    
    /**
    * Set change_log_url value
    *
    * @param string $value
    * @return null
    */
    private function setChangeLogUrl($value) {
      $this->change_log_url = (string) $value;
    } // setChangeLogUrl
    
    /**
    * Return array of download links extracted from this version
    *
    * @param void
    * @return array
    */
    function getDownloadLinks() {
      return $this->download_links;
    } // getDownloadLinks
    
    /**
    * Return specific download link by format
    *
    * @param string $format
    * @return VersionsFeedDownloadLink
    */
    function getDownloadLinkByFormat($format) {
      $search_for = trim(strtolower($format));
      $download_links = $this->getDownloadLinks();
      if (is_array($download_links)) {
        foreach ($download_links as $download_link) {
          if ($download_link->getFormat() == $search_for) {
            return $download_link;
          }
        } // if
      } // if
      return null;
    } // getDownloadLinkByFormat
  
  } // VersionsFeedEntry

?>