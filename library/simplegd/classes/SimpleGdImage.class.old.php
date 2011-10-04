<?php

  /**
  * SimpleGdImage wraps arround GD image resource and provides methods to work 
  * with the resource as with a single object
  *
  * @version 1.0
  * @http://www.projectpier.org/
  */
  class SimpleGdImage {
    
    /** Boundaries **/
    const BOUNDARY_INCREASE_ONLY = 'increase';
    const BOUNDARY_DECREASE_ONLY = 'decrease';
    
    /**
    * Is new flag, true if we created this image from resouce, not from file 
    * and we didn't save it to the file
    *
    * @var boolean
    */
    protected $is_new = true;
    
    /**
    * Is loaded flag, true if loaded this file from the file (or saved it to the file)
    *
    * @var string
    */
    protected $is_loaded = false;
    
    /**
    * Image resouce
    *
    * @var resouce
    */
    protected $resource;
    
    /**
    * Original file path
    *
    * @var string
    */
    protected $source;
    
    /**
    * Image type
    *
    * @var integer
    */
    protected $image_type;
    
    /**
    * Image width, cached on request
    *
    * @var integer
    */
    protected $width = null;
    
    /**
    * Image height, cached on request
    *
    * @var integer
    */
    protected $height = null;
    
    /**
    * Construct new SimpleGdImage object
    *
    * @param string $load_from_file Load content from image file
    * @return SimpleGdImage
    */
    function __construct($load_from_file = null) {
      if (!is_null($load_from_file)) {
        $this->loadFromFile($load_from_file);
      }
    } // __construct
    
    /**
    * Destroy this object and free any memory associated with image image
    *
    * @param void
    * @return null
    */
    function __destruct() {
      if (is_resource($this->resource)) {
        imagedestroy($this->resource);
      }
    } // __destruct
    
    // ---------------------------------------------------
    //  Utils
    // ---------------------------------------------------
    
    /**
    * Load this image from file
    *
    * @param string $file_path
    * @return null
    */
    function loadFromFile($file_path) {
      if (!is_readable($file_path)) {
        throw new FileDnxError($file_path);
      }
      $image_type = false;
      if (function_exists('exif_imagetype')) {
        $image_type = exif_imagetype($file_path);
      } else {
        $image_size = getimagesize($file_path);
        if (is_array($image_size) && isset($image_size[2])) {
          $image_type = $image_size[2];
        }
      } // if
      
      if ($image_type === false) {
        throw new FileNotImageError($file_path);
      }
      
      switch ($image_type) {
        case IMAGETYPE_PNG:
          $this->resource = imagecreatefrompng($file_path);
          break;
        case IMAGETYPE_JPEG:
          $this->resource = imagecreatefromjpeg($file_path);
          break;
        case IMAGETYPE_GIF:
          $this->resource = imagecreatefromgif($file_path);
          break;
        default:
          throw new ImageTypeNotSupportedError($file_path, $image_type);
      } // switch
      
      if (!is_resource($this->resource)) {
        $this->resource = null;
        throw new FailedToLoadImageError($file_path);
      } // if
      
      $this->setIsLoaded();
      $this->setSource($file_path);
      $this->setImageType($image_type);
    } // loadFromFile
    
    /**
    * This function is used for saving files that are loaded to file in case 
    * you transformed the resource and want to save it back to the file. If 
    * this file is new or you want to change its type use saveAs() function
    *
    * @param void
    * @return boolean
    * @throws ImageTypeNotSupportedError
    * @throws FileNotWriableError
    */
    function save() {
      if (!$this->isLoaded() || !is_file($this->getSource())) {
        throw new Error('This image was not loaded from the file. Use saveAs() function instead of save() - there you\'ll be able to specify output file and type');
      } // if
      if (!file_is_writable($this->getSource())) {
        throw new FileNotWriableError($this->getSource());
      } // if
      switch ($this->getImageType()) {
        case IMAGETYPE_PNG:
          imagepng($this->resource, $this->getSource());
          break;
        case IMAGETYPE_JPG:
          imagejpeg($this->resource, $this->getSource(), 80);
          break;
        case IMAGETYPE_GIF:
          imagegif($this->resource, $this->getSource());
          break;
        default:
          throw new ImageTypeNotSupportedError(null, $this->getImageType());
      } // switch
      return true;
    } // save
    
    /**
    * Save image into the file
    *
    * @param string $file_path
    * @param integer $as_type Save image as type. Default type is PNG
    * @return null
    * @throws ImageTypeNotSupportedError
    * @throws FailedToWriteFileError
    */
    function saveAs($file_path, $as_type = null) {
      // Use internal value if we called convertType with new object
      if (is_null($as_type)) {
        $as_type = $this->getImageType();
      }
      
      $as_type = (integer) $as_type;
      if (($as_type < IMAGETYPE_GIF) || ($as_type > IMAGETYPE_PNG)) {
        $as_type = IMAGETYPE_PNG;
      }
      
      switch ($as_type) {
        case IMAGETYPE_PNG:
          $write = imagepng($this->resource, $file_path);
          break;
        case IMAGETYPE_JPEG:
          $write = imagejpeg($this->resource, $file_path, 80);
          break;
        case IMAGETYPE_GIF:
          $write = imagegif($this->resource, $file_path);
          break;
        default:
          throw new ImageTypeNotSupportedError(null, $this->getImageType());
      } // switch
      
      if (!$write) {
        throw new FailedToWriteFileError($file_path);
      }
      return true;
    } // saveAs
    
    /**
    * User image resource to populate this object
    *
    * @param resource $resource
    * @return null
    */
    function createFromResource($resource) {
      if (is_resource($resource) && (get_resource_type($resource) == 'gd')) {
        $this->reset();
        $this->resource = $resource;
      } else {
        throw new InvalidInstanceError('resource', $resource, 'resource');
      } // if
    } // createFromResource
    
    /**
    * Reset all fields
    *
    * @param void
    * @return null
    */
    protected function reset() {
      $this->is_new = true;
      $this->is_loaded = false;
      $this->resource = null;
      $this->source = null;
      $this->image_type = null;
      $this->width = null;
      $this->height = null;
    } // reset
    
    /**
    * Return MIME type based on image type
    *
    * @param void
    * @return string
    */
    function getMimeType() {
      return image_type_to_mime_type($this->getImageType());
    } // getMimeType
    
    /**
    * Return extension based on the source file or type if we have new image
    *
    * @param void
    * @return string
    */
    function getExtension() {
      if ($this->isLoaded()) {
        return get_file_extension($this->getSource());
      } else {
        return image_type_to_extension($this->getImageType());
      } // if
    } // getExtension
    
    // ---------------------------------------------------
    //  Transformations
    // ---------------------------------------------------
    
    /**
    * Resize image to given dimensions. This transformation will not keep 
    * the ratio of the image
    *
    * @param integer $width New width
    * @param integer $height
    * @param boolean $mutate If true transofrmation will be done with the internal 
    *   resource. If false new resouce will be created, new SimpleGdImage will be 
    *   created from it and returned
    * @return boolean
    */
    function resize($width, $height, $mutate = true) {
      if (!is_resource($this->resource) || (get_resource_type($this->resource) <> 'gd')) {
        return false;
      }
      
      $width = (integer) $width > 0 ? (integer) $width : 1;
      $height = (integer) $height > 0 ? (integer) $height : 1;
      
      if ($this->getImageType() == IMAGETYPE_GIF) {
        $new_resource = imagecreatetruecolor($new_width, $new_height); 
        $colorcount = imagecolorstotal($this->resource); 
        imagetruecolortopalette($new_resource, true, $colorcount); 
        imagepalettecopy($new_resource, $this->resource); 
        $transparentcolor = imagecolortransparent($this->resource); 
        imagefill($new_resource, 0, 0, $transparentcolor); 
        imagecolortransparent($new_resource, $transparentcolor);
      } else {
        $new_resource = imagecreatetruecolor($width, $height);
      } // if
      
      imagecopyresampled($new_resource, $this->resource, 0, 0, 0, 0, $width, $height, $this->getWidth(), $this->getHeight());
      if ($mutate) {
        // Destroy old resrouce, set new one and reset cached values
        imagedestroy($this->resource); 
        $this->resource = $new_resource;
        $this->width = $width;
        $this->height = $height;
        return true;
      } else {
        // Create new image from the resouce and return
        $new_image = new SimpleGdImage();
        $new_image->createFromResource($new_resource);
        return $new_image;
      } // if
    } // resize
    
    /**
    * Resize to $width x $height but keep the image proportion
    *
    * @param integer $width Max width
    * @param integer $height Max height
    * @param string $boundary Limit the scale action: drecrease or increase 
    *   only. If $boundary is NULL than don't limit
    * @param boolean $mutate Save the transformation in internal resource or
    *   create new image and keep internal as is?
    * @return SimpleGdImage
    */
    function scale($width, $height, $boundary = null, $mutate = true) {
      if (!is_resource($this->resource) || (get_resource_type($this->resource) <> 'gd')) {
        return false;
      }
      
      $width = (integer) $width > 0 ? (integer) $width : 1;
      $height = (integer) $height > 0 ? (integer) $height : 1;
      
      $scale = min($width / $this->getWidth(), $height / $this->getHeight());
      
      if ($boundary == self::BOUNDARY_DECREASE_ONLY) {
        if ($scale > 1) {
          if ($mutate) {
            return;
          } else {
            $new_image = new SimpleGdImage();
            $new_image->createFromResource($this->resource);
            return $new_image;
          } // if
        } // if
      } elseif ($boundary == self::BOUNDARY_INCREASE_ONLY) {
        if ($scale < 1) {
          if ($mutate) {
            return;
          } else {
            $new_image = new SimpleGdImage();
            $new_image->createFromResource($this->resource);
            return $new_image;
          } // if
        } // if
      } // if
      
      $new_width = floor($scale * $this->getWidth());
      $new_height = floor($scale * $this->getHeight());
      
      if ($this->getImageType() == IMAGETYPE_GIF) {
        $new_resource = imagecreatetruecolor($new_width, $new_height); 
        $colorcount = imagecolorstotal($this->resource); 
        imagetruecolortopalette($new_resource, true, $colorcount); 
        imagepalettecopy($new_resource, $this->resource); 
        $transparentcolor = imagecolortransparent($this->resource); 
        imagefill($new_resource, 0, 0, $transparentcolor); 
        imagecolortransparent($new_resource, $transparentcolor);
      } else {
        $new_resource = imagecreatetruecolor($new_width, $new_height);
      } // if
      
      imagecopyresampled($new_resource, $this->resource, 0, 0, 0, 0, $new_width, $new_height, $this->getWidth(), $this->getHeight());
      if ($mutate) {
        imagedestroy($this->resource); 
        $this->resource = $new_resource;
        $this->width = $new_width;
        $this->height = $new_height;
        return true;
      } else {
        $new_image = new SimpleGdImage();
        $new_image->createFromResource($new_resource);
        return $new_image;
      } // if
      
    } // scale
    
    /**
    * Change internat type value
    *
    * @param integer $to_type
    * @return null
    */
    function convertType($to_type) {
      if ($this->getImageType() == $to_type) {
        return;
      }
      if ($to_type == IMAGETYPE_PNG || $to_type == IMAGETYPE_JPEG || $to_type == IMAGETYPE_GIF) {
        $this->setImageType($to_type);
      } else {
        throw new ImageTypeNotSupportedError(null, $to_type);
      } // if
    } // convertType
    
    // ---------------------------------------------------
    //  Flags
    // ---------------------------------------------------
    
    /**
    * Returns true if this image is new (no file, just resource that we can manipulate)
    *
    * @param void
    * @return boolean
    */
    function isNew() {
      return $this->is_new;
    } // isNew
    
    /**
    * Returns true if this image is loaded
    *
    * @param void
    * @return boolean
    */
    function isLoaded() {
      return $this->is_loaded;
    } // isLoaded
    
    // ---------------------------------------------------
    //  Getters and setters
    // ---------------------------------------------------
    
    /**
    * Mark this object as new
    *
    * @param void
    * @return null
    */
    function setIsNew() {
      $this->is_new = true;
      $this->is_loaded = false;
    } // setIsNew
    
    /**
    * Mark this object as loaded
    *
    * @param void
    * @return null
    */
    function setIsLoaded() {
      $this->is_new = false;
      $this->is_loaded = true;
    } // setIsLoaded
    
    /**
    * Get source
    *
    * @param null
    * @return string
    */
    function getSource() {
      return $this->source;
    } // getSource
    
    /**
    * Set source value
    *
    * @param string $value
    * @return null
    */
    private function setSource($value) {
      $this->source = $value;
    } // setSource
    
    /**
    * Get image_type
    *
    * @param null
    * @return integer
    */
    function getImageType() {
      return $this->image_type;
    } // getImageType
    
    /**
    * Set image_type value
    *
    * @param integer $value
    * @return null
    */
    private function setImageType($value) {
      $this->image_type = $value;
    } // setImageType
    
    /**
    * Get width
    *
    * @param null
    * @return integer
    */
    function getWidth() {
      if (is_null($this->width)) {
      	$this->width = imagesx($this->resource);
      }
      return $this->width;
    } // getWidth
    
    /**
    * Set width value
    *
    * @param integer $value
    * @return null
    */
    protected function setWidth($value) {
      $this->width = $value;
    } // setWidth
    
    /**
    * Get height
    *
    * @param null
    * @return integer
    */
    function getHeight() {
      if (is_null($this->height)) {
      	$this->height = imagesy($this->resource);
      }
      return $this->height;
    } // getHeight
    
    /**
    * Set height value
    *
    * @param integer $value
    * @return null
    */
    protected function setHeight($value) {
      $this->height = $value;
    } // setHeight
  
  } // SimpleGdImage

?>