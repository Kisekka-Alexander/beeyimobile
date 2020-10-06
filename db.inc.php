<?php
	/*
	$svrname = "localhost";
	$usrnm = "root";
	$psswd = "";
	$dbnm = "patcash";
	*/
	$con = new mysqli_connect("localhost", "alex", "italia.90", "xenlak",3308);

	if ($con->mysqli_connect_error) 
		{ 
			die("Connection failed: " . $con->mysqli_connect_error); 
		} 
		
		$con->set_charset("utf8");
		//echo $con->character_set_name();
	 
		date_default_timezone_set('Africa/Nairobi');
		//echo date_default_timezone_get();
	 
		$nwdt=date('Y-m-d H:i:s');
		
	 
		error_reporting(0);

 


?>


