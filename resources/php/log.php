<?php
header("Access-control-Allow-origin:*");
require_once __DIR__ . '/db_connect.php';
$db = new DB_CONNECT();
extract($_GET);

$q = split("-",$date);
$qu = $q[2]."/".$q[1]."/".$q[0];

$result = mysql_query("SELECT date,hour,min,kilowatts FROM houselogs where house_id='$houseid' and date='$qu' and hour='$hour';") or die(mysql_error());
$q = split("/",$qu);
$qu = $q[2]."-".$q[1]."-".$q[0];
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
}

?>