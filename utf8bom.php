#!/usr/bin/php
<?php
define('STR_BOM', "\xEF\xBB\xBF");
$file = null;
$directory = getcwd();
echo '<xmp>';
$rit = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($directory), RecursiveIteratorIterator::CHILD_FIRST);
try {
$count = 0;
	foreach ($rit as $file) {
		if ($file->isFile()) {
			$path_parts = pathinfo($file->getRealPath());

			if ('php' == $path_parts['extension']) {
				$object = new SplFileObject($file->getRealPath());

				if (false !== strpos($object->getCurrentLine(), STR_BOM)) {
$count++;
					print $file->getRealPath()."\n";
				}
			}
		} else {
			print 'processing ' . $file->getRealPath()."\n";
			flush();
		}

	}
        echo 'done ' . $count . ' files found with BOM mark';
} catch (Exception $e) {
	die ('Exception caught: '. $e->getMessage());
}

?>