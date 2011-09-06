<?php

  /**
  * Just textile the text and return
  *
  * @param string $text Input text
  * @return string
  */
  function do_textile($text) {
    Env::useLibrary('textile');
    $textile = new Textile();
    return $textile->TextileRestricted($text, false, false);
  } // do_textile

?>
