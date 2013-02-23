<?php
// Emonextras Weather Underground Upload
// Uploads current temperature, humidity, pressure and dewpoint from emoncms database to wunderground.com
// Example: http://www.wunderground.com/weatherstation/WXDailyHistory.asp?ID=ICHESHIR63
// Run via cron with (for example): */10 * * * * php /path/to/wunderground.php >/dev/null 2>&1
// Upload Protocol http://wiki.wunderground.com/index.php/PWS_-_Upload_Protocol
// By Nathan Chantrell http://nathan.chantrell.net

// Connect to DB (change USER, PASSWORD and DATABASE)
  $link = mysql_connect("localhost", "USER", "PASSWORD");
  if (!$link) { die('Could not connect: ' . mysql_error()); }
  mysql_select_db("DATABASE") or die(mysql_error());

// Read feeds table and put into an array
  $result = mysql_query("SELECT * FROM feeds") or die(mysql_error());
  mysql_close($link);

  $arr_table_result=mysql_fetch_full_result_array($result);

function mysql_fetch_full_result_array($result) {
    $table_result=array();
    $r=0;
    while($row = mysql_fetch_assoc($result)){
        $arr_row=array();
        $c=0;
        while ($c < mysql_num_fields($result)) {
            $col = mysql_fetch_field($result, $c);
            $arr_row[$col -> name] = $row[$col -> name];
            $c++;
        }
        $table_result[$r] = $arr_row;
        $r++;
    }
    return $table_result;
}

$id = 'STATIONID'; // Your wunderground station ID
$password = 'PASSWORD'; // Your wunderground password
$date = urlencode(gmdate('y-m-d+H:i:s'));
$tempc = $arr_table_result[14]['value']; // Change 14 to reflect row containing your temperature in C
$tempf = urlencode(32+(1.8*$tempc));
$pressure = urlencode((0.0295301*$arr_table_result[19]['value'])); // Change 19 to reflect row containing your pressure in mb
$humidity = urlencode($arr_table_result[13]['value']); // Change 13 to reflect row containing your humidity in %
$dewptf = round((((round((-430.22+237.7*log($humidity*(6.11*pow(10, (7.5*$tempc/(237.7+$tempc))))/100))/(-log($humidity*(6.11*pow(1$

file_get_contents('http://weatherstation.wunderground.com/weatherstation/updateweatherstation.php?ID=' . $id . '&PASSWORD=' . $password . '&dateutc=' . $date . '&tempf=' . $tempf . '&baromin=' . $pressure . '&humidity=' . $humidity . '&dewptf=' . $dewptf . '&softwaretype=php&action=updateraw');

?>
