<?php
// Emonextras - Tweet if temperature below 0
// Uses ttytter (http://www.floodgap.com/software/ttytter/) to send a tweet if the temperatire drops below 0
// With a very dirty hack to only send again once the temperature has been above 0 again.
// Run via cron with (for example): */30 * * * * php /path/to/tweet-cold.php >/dev/null 2>&1
// By Nathan Chantrell http://nathan.chantrell.net

// feed to use, change id to your external temperature feed
 $str = file_get_contents("http://yourserver/emoncms/feed/value.json?id=18");

// status file so we can tell if we have already tweeted
 $statusFile = "/home/username/.tweet-cold";

// temperature less than 0 and tweet not already sent
 if (($str < 0) && !file_exists($statusFile)) {

   // create status file
   $statusFileHandle = fopen($statusFile, 'w') or die("can't open file");
   fclose($statusFileHandle);

   // send tweet
   exec('/usr/bin/ttytter.pl -silent -status="Temperature outside is ' . $str . ' degrees C at ' . date('H:i') . ' #Brrrr"');
 } 

// temperature is now 0 or above and tweet was sent, delete status file
 elseif (($str >= 0) && file_exists($statusFile)) {
  unlink($statusFile);
 }

?>
