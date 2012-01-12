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
    //$text = $textile->TextileRestricted($text, false, false); 
    $text = $textile->TextileThis($text, false, false); 
    return add_links($text);
  } // do_textile

?>