<?php
// Emonextras - Get AirQualityEgg values from Cosm.com JSON feed and post to emoncms
// Run via cron with (for example): */5 * * * * php /path/to/aqe.php >/dev/null 2>&1
// By Nathan Chantrell http://nathan.chantrell.net

// Add your Cosm and Emoncms details below
define ("COSMFEEDID", "XXXXXX"); // Cosm feed ID (Air Quality Egg feed)
define ("COSMAPIKEY", "XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX"); // Cosm API Key
define ("EMONCMSAPIKEY", "XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX"); // Emoncms API Key
define ("EMONCMSSERVER", "http://my.server/emoncms"); // Location of Emoncms server

// You shouldn't need to change anything below this point

// Get the JSON from Cosm
$url = "https://api.cosm.com/v2/feeds/" . COSMFEEDID . ".json";

$options = array(
  'http'=>array(
    'method'=>"GET",
    'header'=>"X-ApiKey: " . COSMAPIKEY . ""
  )
);

$context = stream_context_create($options);
$json_string = file_get_contents($url, false, $context);
$parsed_json = json_decode($json_string,true);

$co = $parsed_json[datastreams][0][current_value];
$no2 = $parsed_json[datastreams][3][current_value];
$humidity = $parsed_json[datastreams][2][current_value];
$temperature = $parsed_json[datastreams][5][current_value];

// Update emoncms
file_get_contents(EMONCMSSERVER . '/input/post?json={aqe_co:' . $co . '},{aqe_no2:' . $no2 . '},{aqe_humidity:' . $humidity . '},{aqe_temp:' . $temperature . '}&apikey=' . EMONCMSAPIKEY);

?>
