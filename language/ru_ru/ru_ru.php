<?php

  // Are we in Localization class? If not break!
  if(!isset($this) || !($this instanceof Localization)) {
    throw new InvalidInstanceError('$this', $this, 'Localization', "File '" . __FILE__ . "' can be included only from Localization class");
  } // if

?>