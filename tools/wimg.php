<?php
//ini_set ('user_agent', $_SERVER['HTTP_USER_AGENT']); 

function unchunkHttp11($data) {
    $fp = 0;
    $outData = "";
    while ($fp < strlen($data)) {
        $rawnum = substr($data, $fp, strpos(substr($data, $fp), "\r\n") + 2);
        $num = hexdec(trim($rawnum));
        $fp += strlen($rawnum);
        $chunk = substr($data, $fp, $num);
        $outData .= $chunk;
        $fp += strlen($chunk);
    }
    return $outData;
}

//echo "<xmp>";
$fp = fsockopen("wimg.ca", 80, $errno, $errstr, 30);
if (!$fp) {
    echo "$errstr ($errno)<br />\n";
} else {
    $out = "GET /http://www.nu.nl HTTP/1.0\r\n";
    $out .= "Host: wimg.ca\r\n";
    $out .= "Connection: Close\r\n\r\n";
    fwrite($fp, $out);
    while (!feof($fp)) {
        $reply .= fgets($fp, 1024);
    }
    fclose($fp);
}

$data = substr($reply, (strpos($reply, "\r\n\r\n")+4));
if (strpos(strtolower($reply), "transfer-encoding: chunked") !== FALSE) {
    $data = unchunkHttp11($data);
}

header('Content-Type: image/png');
echo $data;
die();






// standard routines cannot handle chunked data...
// the below does not work




$url='http://wimg.ca/http://www.nu.nl';
$img_with_headers=file_get_contents($url);
$i=strpos($img_with_headers, "PNG");
header('Content-Type: image/png');
echo substr($img_with_headers,$i-1);
die();
$i=strpos($img_with_headers, "\r\n\r\n");
die(substring($img_with_headers,0,$i+7));
$img = substr($img_with_headers, $i+4);
$src_img = imagecreatefromstring($img);
//file_put_contents('wimg.png', $src_img);
//$dst_img = imagecreatetruecolor(50, 50);
//imagecopyresized($dst_img, $src_img, 0, 0, $x1, $y1, 50, 50, abs($x2-$x1), abs($y2-$y1) );

// Output and free from memory
header('Content-Type: image/gif');
imagegif($src_img);
//echo $src_img;
?>