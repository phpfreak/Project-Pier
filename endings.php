#!/usr/bin/php
<?php
$file = null;
$directory = getcwd();
echo '<xmp>';
$rit = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($directory), RecursiveIteratorIterator::CHILD_FIRST);
try {
  $count = 0;
  foreach ($rit as $file) {
    if ($file->isFile()) {
      $path_parts = pathinfo($file->getRealPath());
      if (('php' == $path_parts['extension']) && (0 == preg_match('/views|templates|layouts/',$file->getRealPath()))) {
        $contents = file_get_contents($file->getRealPath());
        $reversed = strrev($contents);
        if (substr($reversed, 0, 2) != '>?') {
          $count++;
          print strpos($reversed, '>?') . '|' . substr($reversed, 0, 3) . '|' . $file->getRealPath();
          $contents = trim($contents);
          if (file_put_contents( $file->getRealPath(), $contents )) {
            print '|fixed';
          }
          print "\n";
//if ($count>2) die();
        }
      }
    } else {
      //print 'processing ' . $file->getRealPath()."\n";
      flush();
    }
  }
  echo 'done ' . $count . ' files found with text after last ?>';
} catch (Exception $e) {
  die ('Exception caught: '. $e->getMessage());
}

?>