<?php
error_reporting(E_ALL);
ini_set('display_errors','On');
require('../../config/config.php');

global $dbtypes_not_translated;
$dbtypes_not_translated = array();

function dbtype_datatype($attributes) {
  global $dbtypes_not_translated;
  $dbname = $attributes['Field'];
  //if ($dbname=='id') return 'ID';
  //if (strpos($dbname,'_id')!==false) {
  //  return 'ID';
  //}
  if ($dbname=='goal') return 'PERCENT';
  if ($dbname=='score') return 'PERCENT';
  $dbtype = $attributes['Type'];
  static $dbdt = array( 
    'xint(11) unsigned' => 'ID',
    'int(10) unsigned' => 'ID',
    'xint(10)' => 'ID',
    'xint(11)' => 'ID',
    'xsmallint(10)' => 'ID',
    'xtinyint(1)' => 'BOOLEAN',
    'tinyint(1) unsigned' => 'BOOLEAN',
    'tinyint(3) unsigned' => 'SEQ',
    'xint(3) unsigned' => 'SEQ',
    'varchar(50)' => 'NAME',
    'datetime' => 'DATETIME',
    'text' => 'TEXT',
    'varchar(255)' => 'LINE',
    'xfloat(3,1)' => 'HOURS',
    'float(4,2)' => 'HOURS',
    'longblob' => 'DATA',
  );
  if (array_key_exists($dbtype, $dbdt)) return $dbdt[$dbtype];
  if (strpos($dbtype,'xvarchar')!==false) {
    $i = strpos($dbtype,'(');
    $len = 0 + substr($dbtype, $i+1);
    if ($len > 50) return 'LINE';
    return 'STRING';
  }
  $dbtypes_not_translated[]=$attributes;;
  return $dbtype;
}

$link = mysql_connect(DB_HOST, DB_USER, DB_PASS) or die('Could not connect to database server ' . DB_HOST);
mysql_select_db(DB_NAME, $link) or die('Could not select database ' . DB_NAME);

$tables = array();
$result = mysql_query('SHOW TABLES LIKE \''.DB_PREFIX .'%\'');
//$result = mysql_query('SHOW TABLES');
while ($row = mysql_fetch_row($result)) {
  $tables[$row[0]] = array();
}
		
foreach ($tables as $table_name => $nothing) {
  $result = mysql_query('SHOW COLUMNS FROM ' . $table_name, $link);
  while ($row = mysql_fetch_assoc($result)) {
    $tables[$table_name][$row['Field']] = $row;
  }
}
//var_dump($tables);
mysql_close($link);
$count=0;
$s = '';
$h = false;
foreach($tables as $table_name => $fields) {  
  foreach($fields as $attributes) {
    $count++;
    $tname = str_replace(DB_PREFIX, '', $table_name );
    $s .= "$count,$tname";
    foreach($attributes as $name => $value) {
      if ($name=='Type') {
        $dt = dbtype_datatype($attributes);
        //$s .= ",$value=$dt";
        $s .= ",$dt";
      } else {
        $s .= ",$value";
      }
    }
    $s .= "\n";
  }
}

$s .= "\nnot translated\n";
foreach($dbtypes_not_translated as $attributes) {
  foreach($attributes as $name => $value) {
    $s .= ",$value";
  }
  $s .= "\n";
}

file_put_contents('export.txt', $s);
echo "<xmp>$s</xmp>";
?>