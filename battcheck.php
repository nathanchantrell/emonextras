<?php
// Emonextras - Low Battery Voltage Checker
// Check emoncms database for battery voltages (inputs ending in _v) & sends an email with a list of any that are below $lowbattery
// Run via cron with (for example): 0 0 * * * php /path/to/battcheck.php >/dev/null 2>&1
// By Nathan Chantrell http://nathan.chantrell.net

// Voltage to warn on (in mV)
  $lowbattery = 2600;

// Connect to DB (change USER, PASSWORD and DATABASE)
  $link = mysql_connect("localhost", "USER", "PASSWORD");
  if (!$link) { die('Could not connect: ' . mysql_error()); }
  mysql_select_db("DATABASE") or die(mysql_error());

// Check for low voltages
  $result =  mysql_query("SELECT * FROM input WHERE name LIKE '%_v' ORDER BY name");
  while($row = mysql_fetch_array( $result )) {
    if ($row['value'] < $lowbattery) {
     $message.= str_replace("_v", "", $row['name'])." battery voltage is ".number_format(($row['value']/1000), 2, '.', ' ')."V\n";
    }
  } 

// If there is a low battery send an email
  if(!($message == NULL)) {
    $to      = 'user@domain';
    $subject = 'Sensor low voltage warning';
    $headers = 'From: user@domain' . "\r\n" .
        'Reply-To: user@domain' . "\r\n" .
        'X-Mailer: PHP/' . phpversion();
    $body = "Warning: The following sensor/s have low battery\n\n" . $message;
    mail($to, $subject, $body, $headers);
  }

?>
