<?php

  define('SWIFTMAILER_LIBRARY_PATH', dirname(__FILE__));
  require SWIFTMAILER_LIBRARY_PATH . '/lib/Swift.php';
  require SWIFTMAILER_LIBRARY_PATH . '/lib/Swift/Connection/SMTP.php';
  require SWIFTMAILER_LIBRARY_PATH . '/lib/Swift/Connection/NativeMail.php';

?>