<?php
header("Access-Control-Allow-Origin: http://localhost:8080");
require_once __DIR__ . '/db_connect.php';
$db = new DB_CONNECT();
extract($_GET);

$house_id = mysql_query("SELECT house FROM household where username='$username';") or die(mysql_error());
$house_id = mysql_fetch_array($house_id);

if($month=="Jan")
	$month = "January";
else if($month=="Feb")
	$month = "February";
else if($month=="Mar")
	$month = "March";
else if($month=="Apr")
	$month = "April";
else if($month=="May")
	$month = "May";
else if($month=="Jun")
	$month = "June";
else if($month=="Jul")
	$month = "July";
else if($month=="Aug")
	$month = "August";
else if($month=="Sep")
	$month = "September";
else if($month=="Oct")
	$month = "October";
else if($month=="Nov")
	$month = "November";
else if($month=="Dec")
	$month = "December";
	
$res = mysql_query("INSERT into challenges values ('$house_id[0]','$target','$month');") or die(mysql_error());

$result = mysql_query("SELECT kilowatts FROM monthwise WHERE (house_id='$house_id[0]' and month='$month');") or die (mysql_error());
$result = mysql_fetch_array($result);
if ($result[0] > $target)
{
	$r = $result[0].";".'0';
	echo $r;
}
else
{
	$r = $result[0].";".'1';
	echo $r;
}


?>