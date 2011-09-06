<?php
ob_start();
$themes = array();
$files = array();
$directory = './public/assets/themes';
echo "<html><a href='?download'>Download</a>";
echo '<xmp>';
foreach (new DirectoryIterator($directory) as $fileInfo) {
    if($fileInfo->isDot()) continue;
    if($fileInfo->isFile()) continue;
    //echo $fileInfo->getFilename() . "\n";
    //echo $fileInfo->getPathname() . "\n";
    process_theme( $fileInfo->getFilename(), $fileInfo->getPathname() );
}
if (isset($_GET['download'])) {
  ob_end_clean();
  header('Content-Type: application/octet-stream');
  header('Content-Disposition: attachment; filename=themesdiff.txt;');
  foreach( $files as $k1 => $v1 ) {
    foreach( $v1 as $k2 => $v2 ) {
      foreach( $v2 as $k3 => $v3 ) {
        print "$k1;$k2;$k3;$v3\n";
      }
    }
  }
  die();
}
print_r($themes);
print_r($files);
ob_end_flush();

function process_theme($theme, $theme_path) {
  global $themes;
  global $files;
  $rit = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($theme_path), RecursiveIteratorIterator::CHILD_FIRST);
  try {
    $count = 0;
    foreach ($rit as $file) {
      if ($file->isDir()) continue;
      $count++;
      $path =  $file->getPath();
      $path = str_replace( $theme_path, '', $path );
      $path = str_replace( $theme, '', $path );
      $name =  $file->getBasename();
      //print 'processing ' . $path ."\n";
      //print 'processing ' . $name ."\n";
      $themes[$theme][$path][$name]=$file->getSize();
      $files[$name][$path][$theme]=$file->getSize();;
      flush();
    }
    echo 'done ' . $count . ' files found with ' . $theme . "\n";
  } catch (Exception $e) {
    die ('Exception caught: '. $e->getMessage());
  }
}
?>