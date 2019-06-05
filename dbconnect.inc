<?php
	$hostName = "localhost";
   	$databaseName = "iMusic";
   	$username = "root";
   	$password = "";
	
	if(!($connection = @mysql_connect($hostname, $username, $password)))
	{
		die("Error: Cannot connect to database !!!");
	}		
	if (!(mysql_select_db($databaseName, $connection))) 
	{
		die("Error: Cannot select database name: $databaseName");
	}
?>