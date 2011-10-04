<?php
header("Content-Type: text/plain");
//if ((($_FILES["file"]["type"] == "image/gif")
//|| ($_FILES["file"]["type"] == "image/jpeg")
//|| ($_FILES["file"]["type"] == "image/pjpeg"))
//&& ($_FILES["file"]["size"] < 20000))
//  {
  if ($_FILES["file"]["error"] > 0) {
    echo $_FILES["file"]["error"] . " " . $_FILES["file"]["name"] . " " . $_FILES["file"]["tmp_name"];
  } else {
    //echo "Upload: " . $_FILES["file"]["name"] . "<br />";
    //echo "Type: " . $_FILES["file"]["type"] . "<br />";
    //echo "Size: " . ($_FILES["file"]["size"] / 1024) . " KB<br />";
    //echo "Temp file: " . $_FILES["file"]["tmp_name"] . "<br />";

    $folder = rtrim( './upload/' . $_POST['folder'] , '/');
    @mkdir($folder, 0777, true);

    $seq = str_pad((int) $_POST["part"],4,"0",STR_PAD_LEFT);
    move_uploaded_file($_FILES["file"]["tmp_name"],
    $folder . '/' . $_FILES["file"]["name"] . '-' . $seq );
    echo $_FILES["file"]["error"] . " " . $folder . '/' . $_FILES["file"]["name"] . '-' . $seq;
  }
//  }
//else
//  {
//  echo "Invalid file";
//  }
?>