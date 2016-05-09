<?php
//header('Content-Type: application/json; charset=utf-8');

//print_r($_GET);

$start_date = $_GET['start_date'];

//$start_date = "2016-01-01";
//$end_date = "2016-06-30";

include_once('parameters.php');
$conn = mysql_connect($database_server, $database_user, $database_password);
if (!$conn ) {
   die('Not connected : ' . mysql_error());
}
// select db
$dbconn = mysql_select_db($dbase,$conn);
if (!$dbconn ) {
   die ('Can\'t select db : ' . mysql_error());
}

$right_rail = "";

// start right rail

$right_rail = $right_rail . "<table>";
$right_rail = $right_rail . "<tr><th>Start</th><th>End</th><th>Title</th></tr>";

//$q = 'SELECT start, end, title FROM event WHERE start >= "' . $start_date . '" and start <= "' . $end_date . '" order by start asc';
$q = 'SELECT start, end, title FROM event WHERE start >= "' . $start_date . '" and start <= DATE_ADD("' . $start_date . '",INTERVAL 1 DAY) order by start asc';
echo $q;

// generating right rail rows
$eventQuery=mysql_query($q)  or die (mysql_error());

while ($row = mysql_fetch_array($eventQuery)) {
   if ($row['end']== NULL || $row['end'] == '0000-00-00') {
	   $durationEvent = FALSE; 
   }
   else {
	   $durationEvent = TRUE;
   }

   $line = "<tr><td>" . $row['start'] . "</td><td>" . $row['end'] . "</td><td>" . substr($row['title'],0,100) . "</td></tr>";
   $right_rail = $right_rail . $line;

}
mysql_free_result($eventQuery);

//end right_rail

$right_rail = $right_rail . "</table>";
   
echo $right_rail;

?>