<?php
if (isset($_COOKIE['pp088pp_']))
{
echo "<html>
<body>
<form action=\"upload_file.php\" method=\"post\"
enctype=\"multipart/form-data\">
<label for=\"folder\">Folder:</label>
<input type=\"text\" name=\"folder\" id=\"folder\" />
<br />
<label for=\"file\">Filename:</label>
<input type=\"file\" name=\"file\" id=\"file\" />
<br />
<label for=\"part\">Part:</label>
<input type=\"text\" name=\"part\" id=\"part\" />
<br />
<input type=\"submit\" name=\"submit\" value=\"Submit\" />
</form>
</body>
</html>";
}
else
{
header("Location: /index.php");
}
?>