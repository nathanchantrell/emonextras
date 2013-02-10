<!--
// Emonextras - Feed Summary Table
// I use this to pull the data from the emoncms database and then include it in a dashboard by manually editing
// the dashboard in the database.
// By Nathan Chantrell http://nathan.chantrell.net
-->
<html>
<head>
<title>Power & Temperature</title>
<style type="text/css">
body {color:#686868;font-family:arial, helvetica}
table {border-collapse:collapse;margin:10px 0}
table th {background:#888;color:#fff;font-weight:bold;font-size:12px;padding:4px 8px;border:solid 1px #fff;text-align:left}
table td {padding:4px 8px;background-color:#f4f4f4;border-bottom:1px solid #ddd;text-align:left;font-size:12px}
table td.lowvoltage {padding:4px 8px;background-color:#f4f4f4;border-bottom:1px solid #ddd;text-align:left;color:#E60000}
</style>
<meta http-equiv="refresh" content="60">
</head>
<body>

<?php

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

?>

<table><tbody>
<tr>
 <th>
  Power: 
 </th>
</tr>
<tr>
 <td>
  Now: 
 </td>
 <td>
  <? echo $arr_table_result[0]['value']." W"; ?>
 </td>
</tr>
<tr>
 <td>
  Today: 
 </td>
 <td>
  <? echo number_format($arr_table_result[5]['value'], 1, '.', ' ')." kWh"; ?>
 </td>
</tr>
</tbody></table>

<table><tbody>
<tr>
 <th>
  Temperature: 
 </th>
</tr>
<tr>
 <td>
  Outside Front: 
 </td>
 <td>
  <? echo number_format(($arr_table_result[2]['value']), 1, '.', ' ')." &deg;C"; ?>
 </td>
</tr>
<tr>
 <td>
  Outside Rear: 
 </td>
 <td>
  <? echo number_format(($arr_table_result[15]['value']), 1, '.', ' ')." &deg;C"; ?>
 </td>
</tr>
<tr>
 <td>
  Desk: 
 </td>
 <td>
  <? echo number_format(($arr_table_result[4]['value']), 1, '.', ' ')." &deg;C"; ?>
 </td>
</tr>
<tr>
 <td>
  Lounge: 
 </td>
 <td>
  <? echo number_format(($arr_table_result[3]['value']), 1, '.', ' ')." &deg;C"; ?>
 </td>
</tr>
<tr>
 <td>
  Kitchen: 
 </td>
 <td>
  <? echo number_format(($arr_table_result[9]['value']), 1, '.', ' ')." &deg;C"; ?>
 </td>
</tr>
<tr>
 <td>
  Bathroom: 
 </td>
 <td>
  <? echo number_format(($arr_table_result[6]['value']), 1, '.', ' ')." &deg;C"; ?>
 </td>
</tr>
<tr>
 <td>
  Bedroom: 
 </td>
 <td>
  <? echo number_format(($arr_table_result[7]['value']), 1, '.', ' ')." &deg;C"; ?>
 </td>
</tr>
<tr>
 <td>
  Bedroom 2: 
 </td>
 <td>
  <? echo number_format(($arr_table_result[12]['value']), 1, '.', ' ')." &deg;C"; ?>
 </td>
</tr>
</tbody></table>


<table><tbody>
<tr>
 <th>
  Humidity: 
 </th>
</tr>
<tr>
 <td>
  Inside: 
 </td>
 <td>
  <? echo number_format(($arr_table_result[10]['value']), 1, '.', ' ')." %"; ?>
 </td>
</tr>
<tr>
 <td>
  Outside: 
 </td>
 <td>
  <? echo number_format(($arr_table_result[14]['value']), 1, '.', ' ')." %"; ?>
 </td>
</tr>
</tbody></table>

</body>
</html>
