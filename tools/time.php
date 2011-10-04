<?php ?><html>
<body>
<script type="text/javascript">
function formatDate(date, fmt) {
    function pad(value) {
        return (value.toString().length < 2) ? '0' + value : value;
    }
    return fmt.replace(/%([a-zA-Z])/g, function (_, fmtCode) {
        switch (fmtCode) {
        case 'Y':
            return date.getUTCFullYear();
        case 'M':
            return pad(date.getUTCMonth() + 1);
        case 'd':
            return pad(date.getUTCDate());
        case 'H':
            return pad(date.getUTCHours());
        case 'm':
            return pad(date.getUTCMinutes());
        case 's':
            return pad(date.getUTCSeconds());
        default:
            return 'Unsupported format code: ' + fmtCode;
        }
    });
}
function showtime() {
document.getElementById('time').innerHTML = '%Y-%M-%dT%H:%m:%s';
var dd = new Date();
var cc = formatDate(dd, '%Y-%M-%dT%H:%m:%s');
document.getElementById('time').innerHTML = cc;
var cc2 = dd.getHours() + ':' + dd.getMinutes() + ':' + dd.getSeconds();
document.getElementById('time2').innerHTML = cc2;
}
window.onload=showtime;
</script>
<?php
  echo '<xmp>';
  // ntp time servers to contact
  // we try them one at a time if the previous failed (failover)
  // if all fail then wait till tomorrow
  $time_servers = array("nist1.datum.com",
                        "time-a.timefreq.bldrdoc.gov",
                        "utcnist.colorado.edu");

  // a flag and number of servers
  $valid_response = false;
  $ts_count = sizeof($time_servers);

  // time adjustment
  // I'm in California and the clock will be set to -0800 UTC [8 hours] for PST
  // you will need to change this value for your region (seconds)
  $time_adjustment = 0;

  for ($i=0; $i<$ts_count; $i++) {
    $time_server = $time_servers[$i];
    echo "Trying server $time_server\n";
    flush();
    $fp = fsockopen($time_server, 37, $errno, $errstr, 30);
    if (!$fp) {
      echo "$time_server: $errstr ($errno)\n";
      echo "Trying next available server...\n\n";
      flush();
    } else {
      $data = NULL;
      while (!feof($fp)) {
        $data .= fgets($fp, 128);
      }
      fclose($fp);

      // we have a response...is it valid? (4 char string -> 32 bits)
      if (strlen($data) != 4) {
        echo "NTP Server {$time_server} returned an invalid response.\n";
        if ($i != ($ts_count - 1)) {
          echo "Trying next available server...\n\n";
        } else {
          echo "Time server list exhausted\n";
        }
      } else {
        $valid_response = true;
        break;
      }
    }
  }

  if ($valid_response) {
    // time server response is a string - convert to numeric
    $NTPtime = ord($data{0})*pow(256, 3) + ord($data{1})*pow(256, 2) + ord($data{2})*256 + ord($data{3});

    // convert the seconds to the present date & time
    // 2840140800 = Thu, 1 Jan 2060 00:00:00 UTC
    // 631152000  = Mon, 1 Jan 1990 00:00:00 UTC
    $TimeFrom1990 = $NTPtime - 2840140800;
    $TimeNow = $TimeFrom1990 + 631152000;

    $nc = date("c", $TimeNow);
    $sc = date("c");
    $s = time(); 

    echo "Time from $time_server = $nc (seconds $TimeNow)\n";
    echo "Time from server = $sc (seconds $s)\n";
    echo "UTC time from JavaScript</xmp><span id=time></span><xmp>";   
    echo "Local time from JavaScript</xmp><span id=time2></span><xmp>";   
  } else {
    echo "No time servers available.\n";
  }
  echo '</xmp>';
?>
</body>
</html><?php ?>