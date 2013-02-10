<?php
// Emonextras - Daily tweet of kWh usage for electricity and gas
// Uses ttytter (http://www.floodgap.com/software/ttytter/) to send a tweet with the days kWh usage.
// Run via cron with (for example): 0 0 * * * php /path/to/tweet-kwh.php >/dev/null 2>&1
// By Nathan Chantrell http://nathan.chantrell.net

$power = file_get_contents("http://yourserver/emoncms/feed/value.json?id=6"); // change id to your power kwh feed
$power = number_format($power, 1, '.', ''); // format power kWh

$gas = file_get_contents("http://yourserver/emoncms/feed/value.json?id=28"); // change id to your gas m3 feed
$gas = number_format(($gas * 1.02264 * 39 / 3.6), 1, '.', ''); // convert m3 to kWh and format

exec('/usr/bin/ttytter.pl -silent -status="Power used today was ' . $power . ' kWh and gas usage was ' . $gas . ' kWh"');
?>



