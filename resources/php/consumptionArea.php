<?php
header("Access-Control-Allow-Origin: *");
$response = array();
extract($_GET);
//echo $date;

$q = split("-",$date);
$qu = $q[2]."/".$q[1]."/".$q[0];
//echo $qu;

require_once __DIR__ . '/db_connect.php';
$db = new DB_CONNECT();
$house_id = mysql_query("SELECT house FROM household where username='$username';") or die(mysql_error());
$house_id = mysql_fetch_array($house_id);

$result = mysql_query("SELECT hour,kilowatts FROM houselogs where date='$qu' and min='0' and house_id='$house_id[0]';") or die(mysql_error());
$q = split("/",$qu);
$qu = $q[2]."-".$q[1]."-".$q[0];

if (!empty($result)) 
{
	if (mysql_num_rows($result) > 0) 
	{
		for ($x = 0; $x < mysql_num_rows($result); $x++) 
		{
			//echo "hello";
			$data[]= mysql_fetch_assoc($result); 
			$data[$x]["hour"] = $qu." ".$data[$x]["hour"].":"."00";
			//echo $data[$x]["hour"];
		}
		
		// success
		$response["success"] = 1;
		
		$response["data"] = array();
		array_push($response["data"], $data);
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