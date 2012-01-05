<?php

  /**
  * BaseI18nLocale class
  *
  */
  abstract class BaseI18nLocale extends ApplicationDataObject {
  
    /**
    * Return manager instance
    *
    * @access protected
    * @param void
    * @return I18nLocales
    */
    function manager() {
      if (!($this->manager instanceof I18nLocales)) {
        $this->manager = I18nLocales::instance();
      }
      return $this->manager;
    } // manager
  
  } // BaseI18nLocale

?>