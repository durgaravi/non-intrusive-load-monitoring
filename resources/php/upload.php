<?php
header("Access-Control-Allow-Origin: http://localhost:8080");

$ret = move_uploaded_file($_FILES['cv']['tmp_name'], "/home/user" . $_FILES['cv']['name']);

if($ret != 0)
{
	echo $_FILES['cv']['name'];
}
else
{
	echo "0";
}
?>
