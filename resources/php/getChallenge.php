<?php
header("Access-Control-Allow-Origin: http://localhost:8080");
require_once __DIR__ . '/db_connect.php';
$db = new DB_CONNECT();
extract($_GET);
$house_id = mysql_query("SELECT house FROM household where username='$username';") or die(mysql_error());
$house_id = mysql_fetch_array($house_id);
//echo $house_id[0];

$result = mysql_query("SELECT month,kilowatts FROM monthwise where house_id='$house_id[0]' and (month='January' or month='February' or month='March');") or die(mysql_error());

if (!empty($result)) 
{
	if (mysql_num_rows($result) > 0) 
	{
		for ($x = 0; $x < mysql_num_rows($result); $x++) 
		{
			$data[]= mysql_fetch_assoc($result); 
		}
		
		// success
		$response["success"] = 1;
		
		$response["data"] = array();
		array_push($response["data"], $data);
		// echoing JSON response
		echo json_encode($response);
	}
	else 
	{
		$response["success"] = 0;
		$response["message"] = "No data found";
		echo json_encode($response);
	}
} 
else 
{
	$response["success"] = 0;
	$response["message"] = "No data found";
	echo json_encode($response);
	//echo $username;
}
?>