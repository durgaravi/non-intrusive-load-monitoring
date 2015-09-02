<?php
	header("Access-Control-Allow-Origin: http://localhost:8080");
	$conn = mysql_connect("localhost", "root", "");
	if (!$conn) 
	{
		die("Could not connect to the database server");
	} 
	
	$db = mysql_select_db("nilmdb");
	if (!$conn) 
	{
		die("Could not connect to the database");
	}
	$query = "SELECT  house,username FROM household;";
	$res = mysql_query($query);
	if (!$res) 
	{
		die("Could not execute query");
	}
	
	while($row = mysql_fetch_array($res)){ $house_id = $row[0]; $username=$row[1];}
	echo $username;
	header("Location:http://localhost:8080/index.html")
?>