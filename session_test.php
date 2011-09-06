<?php
// Source: http://wiki.phpmyadmin.net/pma/session.save_path
// save as "session_test.php" inside your webspace  
ini_set('display_errors', 'On');
error_reporting(6143);
session_start();
echo '<xmp>';
echo 'upload_limit = ' . ini_get('upload_limit') . "\n";
echo 'file_uploads = ' . ini_get('file_uploads') . "\n";
echo 'upload_max_filesize = ' . ini_get('upload_max_filesize') . "\n";
echo 'max_input_time = ' . ini_get('max_input_time') . "\n";
echo 'memory_limit = ' . ini_get('memory_limit') . "\n";
echo 'max_execution_time = ' . ini_get('max_execution_time') . "\n";
echo 'post_max_size = ' . ini_get('post_max_size') . "\n";
echo 'upload_tmp_dir = ' . ini_get('upload_tmp_dir') . "\n";
echo '</xmp>';

$sessionSavePath = ini_get('session.save_path');

echo '<br><div style="background:#def;padding:6px">'
   , 'If a session could be started successfully <b>you should'
   , ' not see any Warning(s)</b>, otherwise check the path/folder'
   , ' mentioned in the warning(s) for proper access rights.<hr>';
   
if (empty($sessionSavePath)) {
    echo 'Warning "<b>session.save_path</b>" is currently',
         ' <b>not</b> set.<br>Normally "<b>';
    if (isset($_ENV['TMP'])) {
        echo  $_ENV['TMP'], '</b>" ($_ENV["TMP"]) ';
    } else {
        echo '/tmp</b>" or "<b>C:\tmp</b>" (or whatever',
             ' the OS default "TMP" folder is set to)';
    }    
    echo ' is used in this case.';
} else {
    echo 'The current "session.save_path" is "<b>',
         $sessionSavePath, '</b>".';
}

echo '<br>Session file name: "<b>sess_', session_id()
   , '</b>".</div><br>';
?>