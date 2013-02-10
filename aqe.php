<?php
// Emonextras - Scrape NO2 and CO values from airqualityegg.com and post to emoncms
// Run via cron with (for example): */5 * * * * php /path/to/aqe.php >/dev/null 2>&1
// By Nathan Chantrell http://nathan.chantrell.net

// Replace FEEDNO with feed number of Air Quality Egg
$str = file_get_contents("http://airqualityegg.com/egg/FEEDNO");

// NO2
// Replace SERVER and APIKEY to reflect your emoncms installation
$s = explode('<h3 class="current-id-full">Nitrogen Dioxide</h3>
      <div class="current-value">
        <p class="current-value-measure">
          <span class="current-value-measure-wrap">',$str);
$s = explode('</span>',$s[1]);
if(!($s[0] == NULL)) {
 file_get_contents('http://SERVER/emoncms/input/post?json={no2:' . $s[0] . '}&apikey=APIKEY');
}

// CO
// Replace SERVER and APIKEY to reflect your emoncms installation
$s = explode('<h3 class="current-id-full">Carbon Monoxide</h3>
      <div class="current-value">
        <p class="current-value-measure">
          <span class="current-value-measure-wrap">',$str);
$s = explode('</span>',$s[1]);
if(!($s[0] == NULL)) {
 file_get_contents('http://SERVER/emoncms/input/post?json={co:' . $s[0] . '}&apikey=APIKEY');
}
?>
