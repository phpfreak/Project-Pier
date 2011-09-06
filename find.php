#!/usr/bin/php
<?php
$str = 'Container';
$file = null;
$directory = getcwd();
$directory = './';
echo '<xmp>';
$rit = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($directory), RecursiveIteratorIterator::CHILD_FIRST);
try {
  $count = 0;
  foreach ($rit as $file) {
    //print 'processing ' . $file->getRealPath()."\n";
    if ($file->isFile()) {
      $path_parts = pathinfo($file->getRealPath());
      if ('php' == $path_parts['extension']) {
        $object = new SplFileObject($file->getRealPath());
        while (!$object->eof()) {
          $line = $object->getCurrentLine();
          if (false !== ($pos = strpos($line, $str))) {
            $count++;
            print $file->getRealPath()."\n";
            print $line;
            print substr($line, $pos);
            break;
          }
        }
      }
    } else {
      //print 'processing ' . $file->getRealPath()."\n";
      flush();
    }
  }
  echo 'done ' . $count . ' files found with ' . $str;
} catch (Exception $e) {
  die ('Exception caught: '. $e->getMessage());
}
?>