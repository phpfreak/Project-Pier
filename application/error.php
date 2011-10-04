<?php
if (ob_get_level()) while(@ob_end_clean()); 
ob_start(); phpinfo(); $info = ob_get_contents(); ob_end_clean();
$info = str_replace('class="v">', 'class="v">;', $info);
$info = str_replace('<th>', '<th>;', $info);
$info = str_replace('&nbsp;', ' ', $info);
$info = str_replace('&amp;', '&', $info);
$i = strpos($info,'phpinfo()');
if ($i !== false) $info = substr($info, $i);
$info=strip_tags($info);
?>
<style>body { font-family: Arial; font-size:12pt; margin: 0 5px; padding: 1px; }</style>
<em>Sorry, fatal error happened</em>
<form method="post" target=_blank>
Please explain what you were doing:<br /><textarea cols=50 rows=10 name=explain></textarea><br />
<input type=submit action="" value="Send to development and check for fix"><br />
<hr>Error and environment details<hr>
Error:<br /><input size=70 type=text name=message value="<?php echo $last_error['message']; ?>"><br />
File:<br /><input size=70 type=text name=file value="<?php echo $last_error['file']; ?>"><br />
Line:<br /><input size=70 type=text name=line value="<?php echo $last_error['line']; ?>"><br />
Release:<br /><input type=text name=release value="pp088"><br />
PHP version:<br /><input type=text size=70 name=phpversion value="<?php echo phpversion(); ?>"><br />
Table prefix:<br /><input type=text size=70 name=table_prefix value="<?php echo TABLE_PREFIX; ?>"><br />
Request:<br /><input type=text size=70 name=request value="<?php echo $_SERVER["REQUEST_URI"]; ?>"><br />
Browser:<br /><input type=text size=70 name=browser value="<?php echo $_SERVER["HTTP_USER_AGENT"]; ?>"><br />
PHP Info:<br /><textarea cols=50 rows=50 name=phpinfo nowrap><?php echo $info; ?></textarea><br />
</form>
<script type="text/javascript">
  var f = document.getElementsByTagName("form");
  for(var i = 0; i < f.length; i++) f[i].action="http://www.phalanx.nl/pperror.php";
  var e = document.getElementsByTagName("*");
  for(var i = 0; i < e.length; i++) e[i].style.display="block";
</script>
<?php ?>