<?php
error_reporting(E_ALL);
ini_set('display_errors','On');
require('../config/config.php');

$link = mysql_connect(DB_HOST, DB_USER, DB_PASS) or die('Could not connect to database server ' . DB_HOST);
mysql_select_db(DB_NAME, $link) or die('Could not select database ' . DB_NAME);

echo '<table>';
$result = mysql_query('SHOW VARIABLES');
while ($row = mysql_fetch_row($result)) {
  echo '<tr><td>';
  echo $row[0];
  echo '</td><td>';
  echo $row[1];
  echo '</td></tr>';
}
echo '</table>';

mysql_close($link);
?>