<?php
	/*
	$svrname = "localhost";
	$usrnm = "root";
	$psswd = "";
	$dbnm = "patcash";
	*/
	$con = new mysqli("localhost:81", "root", "italia.90", "xenlak");

	if ($con->connect_error) { die("Connection failed: " . $con->connect_error); } 
		
		$con->set_charset("utf8");
		//echo $con->character_set_name();
	 
		date_default_timezone_set('Africa/Nairobi');
		//echo date_default_timezone_get();
	 
		$nwdt=date('Y-m-d H:i:s');
		
	 
		error_reporting(0);

 


?>


