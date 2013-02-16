<?php
// Emonextras csv feed
// I use this with cosm.com so that cosm can pull data from emoncms
// Just give cosm the url to pull from eg. http://yourserver/csv.php
// By Nathan Chantrell http://nathan.chantrell.net

// Connect to DB  (change USER, PASSWORD and DATABASE)
  $link = mysql_connect("localhost", "USER", "PASSWORD");
  if (!$link) { die('Could not connect: ' . mysql_error()); }
  mysql_select_db("DATABASE") or die(mysql_error());

// Get name and value from feeds table
  $result = mysql_query("SELECT name, value FROM feeds") or die(mysql_error());
  mysql_close($link);

// Set headers for .csv
  header("content-type: text/csv");
  header("Content-Disposition: attachment; filename=emoncms.csv");
  header("Pragma: no-cache");
  header("Expires: 0");

// Output in csv format
  while($row = mysql_fetch_array($result)){
    echo $row['name'] . "," . $row['value'] . "\r\n";
  }

?>
