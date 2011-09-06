<?php
  echo '<xmp>';

  function check_directory($d) {
    echo "\nDirectory $d\n";
    echo '1.' . ( file_exists($d) ? ' exists' : ' does NOT exist' ) . " \n";
    echo '2. is' . ( is_dir($d) ? '' : ' NOT' ) . " a directory\n";
    echo '3. is' . ( is_readable($d) ? '' : ' NOT' ) . " readable\n";
    echo '4. is' . ( is_writable($d) ? '' : ' NOT' ) . " writable\n";
    echo '5. has permissions ' . substr(sprintf('%o', fileperms($d)), -4) . "\n";
    echo '6. owner id ' . fileowner($d) . " (0 on Windows, blank if not permitted)\n";
    if (function_exists('posix_geteuid')) {
      $details = posix_getpwuid( posix_geteuid() );
      echo '6. owner name ' . $details['name'] . " \n";
      echo '6. owner gid ' . $details['gid'] . " \n";
      $details = posix_getgrgid( $details['gid'] );
      echo '6. group name ' . $details['name'] . " \n";
    }
    echo '7. group id ' . filegroup($f) . " (0 on Windows, blank if not permitted)\n";
    if (function_exists('posix_getegid')) {
      $details = posix_getgrgid( posix_getegid() );
      echo '7. group name ' . $details['name'] . " \n";
    }
  }

  function check_file($f) {
    echo "\nFile $f\n";
    echo '1.' . ( file_exists($f) ? ' exists' : ' does NOT exist' ) . " \n";
    echo '2. is' . ( is_file($f) ? '' : ' NOT' ) . " a file\n";
    echo '3. is' . ( is_readable($f) ? '' : ' NOT' ) . " readable\n";
    echo '4. is' . ( is_writable($f) ? '' : ' NOT' ) . " writable\n";
    echo '5. has permissions ' . substr(sprintf('%o', fileperms($f)), -4) . "\n";
    echo '6. owner id ' . fileowner($d) . " (0 on Windows, blank if not permitted)\n";
    if (function_exists('posix_geteuid')) {
      $details = posix_getpwuid( posix_geteuid() );
      echo '6. owner name ' . $details['name'] . " \n";
      echo '6. owner gid ' . $details['gid'] . " \n";
      $details = posix_getgrgid( $details['gid'] );
      echo '6. group name ' . $details['name'] . " \n";
    }
    echo '7. group id ' . filegroup($f) . " (0 on Windows, blank if not permitted)\n";
    if (function_exists('posix_getegid')) {
      $details = posix_getgrgid( posix_getegid() );
      echo '7. group name ' . $details['name'] . " \n";
    }
  }

  if (function_exists('posix_getuid')) {
    echo 'A. user id ' . posix_getuid() . " \n";
  } else {
    echo 'A. user id ' . 'NOT available' . " \n";
  }
  if (function_exists('get_current_user')) {
    echo 'B. running user ' . get_current_user() . " \n";
  } else {
    echo 'B. running user ' . 'NOT available' . " \n";
  }
  if (function_exists('getmyuid')) {
    echo 'C. script owner ' . getmyuid() . " \n";
  } else {
    echo 'C. script owner ' . 'NOT available' . " \n";
  }


  define('ROOT', dirname(__FILE__));
  define('APPLICATION_PATH', ROOT . '/application');
  define('LIBRARY_PATH',     ROOT . '/library');
  define('FILES_DIR',        ROOT . '/upload'); // place where we will upload project files
  define('CACHE_DIR',        ROOT . '/cache');
  define('THEMES_DIR',       ROOT . '/public/assets/themes');
  define('PLUGINS_DIR',      APPLICATION_PATH . '/plugins');

  check_directory( ROOT );
  check_directory( APPLICATION_PATH );
  check_directory( LIBRARY_PATH );
  check_directory( FILES_DIR );
  check_directory( CACHE_DIR );
  check_directory( PLUGINS_DIR );
  check_directory( ROOT . '/config' );
  check_directory( ROOT . '/public' );

  check_file( ROOT . '/config/config.php' );
  check_file( ROOT . '/cache/autoloader.php' );
  check_file( ROOT . '/cache/trace.txt' );
  check_file( ROOT . '/cache/log.php' );

?>