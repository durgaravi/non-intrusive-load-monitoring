<?php
	header("Access-Control-Allow-Origin: *");
	$conn = mysql_connect("localhost", "root", "");
	if (!$conn) 
	{
		die("Could not connect to the database server");
	} 
	
	$db = mysql_select_db("your db name");
	if (!$conn) 
	{
		die("Could not connect to the database");
	}
	extract($_GET);
	$query = "SELECT  house,first_name,last_name,password FROM household WHERE username='$username';";
	$res = mysql_query($query);
	if (!$res) 
	{
		die("Could not execute query");
	}
	$a = array();
	$row = mysql_fetch_array($res);
	echo json_encode($row);
?>
