<?php
if ( !chdir('../../language') )
	die("Impossible to find the language folder");
function get_blanks($lcode,$file)
{
	global $locales;
	if ( isset($locales[$lcode]) && file_exists('en_us/'.$file) )
	{
		$res = '<h2>'.$file.' ('.$locales[$lcode].')</h2>';
		$fen = function($file){
			return include_once('en_us/'.$file);
		};
		$en = $fen($file);
		if ( file_exists($lcode.'/'.$file) )
		{
			$flang = function($lcode,$file){
				return include_once($lcode.'/'.$file);
			};
			$lang = $flang($lcode,$file);
			$diff = array_diff_key($en,$lang);
		}
		else
		{
			$diff = $en;
			$res .= '<h3>This file in '.$locales[$lcode].' doesn\'t exist</h3>';
		}
		if ( count($diff) > 0 )
		{
			$res .= '<p>';
			foreach ( $diff as $k => $d )
				$res .= "'".$k."' => '".str_replace("'","\'",$d)."',<br>";
			$res .= '</p>';
		}
		else
			$res .= '<h3>Nothing needs to be done here!</h3>';
		return $res;
	}
	return "<h2>The language or the file doesn't exist</h2>";
}
?><!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Untitled Document</title>
</head>

<body>
<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
	<select name="language">
<?php
// Will define $locales
include_once('locales.php');
$langs = array();
$dirs = scandir('.');
foreach ( $dirs as $dir )
{
	if ( $dir !== '.' && $dir !== '..' && $dir !== 'en_us' && is_dir($dir) )
		array_push($langs,$dir);
}
foreach ( $langs as $l )
	echo '<option value="'.$l.'">'.$locales[$l].'</option>';
?>
</select>&nbsp;&nbsp;&nbsp;
<input type="submit" value="Find the blanks!">
</form>
<?php
if ( isset($_POST['language']) && in_array($_POST['language'],$langs) )
{
	$files = scandir('en_us');
	foreach ( $files as $f )
	{
		if ( $f !== 'en_us.php' && is_file('en_us/'.$f) )
			echo get_blanks($_POST['language'],$f).'<hr>';
	}
}
?>
</body>
</html>