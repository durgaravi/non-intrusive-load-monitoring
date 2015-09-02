<?php
	header("Access-Control-Allow-Origin: *");
	extract($_POST);
	
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
	
	$housetype_id = 1;
	$query = "SELECT housetype_id FROM housetypes WHERE housetype_name = '$optionsRadios';";
	$res = mysql_query($query);
	if (!$res) 
	{
		die("Could not execute query8");
	}
	$row = mysql_fetch_row($res);
	if(!$row)
	{
		die("Could not execute query9");
	}
	$housetype_id = $row[0];
	echo $email;
	$query = "INSERT INTO household (first_name,last_name,total_occupancy,no_of_adults,no_of_children,housetype,username) VALUES ('$firstname','$lastname',
				$total_occupancy,$no_of_adults,$no_of_children,$housetype_id,'$email');";
	$res = mysql_query($query);
	if (!$res) 
	{
		die("Could not execute query-first insert");
	}
	else
	{
		echo "Records inserted<br/>";
	}
	
	// get last house id
	$query = "SELECT house FROM household;";
	$res = mysql_query($query);
	if (!$res) 
	{
		die("Could not execute query");
	}
	
	while($row = mysql_fetch_array($res)){ $house_id = $row[0]; }
	
	echo $house_id;
	if(!isset($devices))
	{
		die("Cannot execute further");
	}
	
	foreach($devices as $selected)
	{
		// get device id
		echo "\n".$selected;
		$query = "SELECT device_id FROM devices WHERE device_name = '$selected';";
		$res = mysql_query($query);
		if (!$res) 
		{
			die("Could not execute query7");
		}
		$rows = mysql_fetch_row($res);
		if(!$rows)
		{
			die("Could not execute query6");
		}
		$device_id = end($rows);
		
		//get quantity of selected device
		$device_quantity = $_POST["no_of_".str_replace(" ","",$selected)];
		
		echo $house_id."-".$device_id."-".$selected."-".$device_quantity;
		$query = "INSERT INTO housedevices VALUES ($house_id,$device_id,'$selected',$device_quantity);";
		$res = mysql_query($query);
		if (!$res) 
		{
			die("Could not execute query5");
		}
		else
		{
			echo "Records inserted";
		}
	}
	
	// for tubelights, ceiling fans, laptop and CPL Lamps
	// Tubelight
	if(($device_quantity=$_POST["no_of_Tubelight"]) != 0)
		$query = "INSERT INTO housedevices VALUES ($house_id,11,'Tubelight',$device_quantity);";
		$res = mysql_query($query);
		if (!$res) 
		{
			die("Could not execute query1");
		}
		else
		{
			echo "Tubelight done!";
		}
		
	// Ceiling fans
	if(($device_quantity=$_POST["no_of_CeilingFan"]) != 0)
		$query = "INSERT INTO housedevices VALUES ($house_id,13,'Ceiling Fan',$device_quantity);";
		$res = mysql_query($query);
		if (!$res) 
		{
			die("Could not execute query2");
		}
		else
		{
			echo "Ceiling Fan done!";
		}
	// Laptop
	if(($device_quantity=$_POST["no_of_Laptop"]) != 0)
		$query = "INSERT INTO housedevices VALUES ($house_id,9,'Laptop',$device_quantity);";
		$res = mysql_query($query);
		if (!$res) 
		{
			die("Could not execute query3");
		}
		else
		{
			echo "Laptop done!";
		}
		
	// CPL Lamps
	if(($device_quantity=$_POST["no_of_CPLLamps"]) != 0)
		$query = "INSERT INTO housedevices VALUES ($house_id,14,'CPL Lamps',$device_quantity);";
		$res = mysql_query($query);
		if (!$res) 
		{
			die("Could not execute query4");
		}
		else
		{
			echo "CPL Lamps done!";
		}
		
	mysql_close();
	header("Location: http://localhost:8080/setpwd.html");
?>