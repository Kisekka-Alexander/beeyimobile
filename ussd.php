<?php

//Reads Variables sent via POST from AT gateway

$sessionId = $_POST["sessionId"];
$serviceCode = $_POST["serviceCode"];
$phoneNumber = $_POST["phoneNumber"];
$text = $_POST["text"];


if($text==""){
	//This is the first request
	$response = "CON what would you want to check? \n";
	$response .= "1. My Account No \n";
	$response .= "2. Phone Number ";
}
else if ($text =="1"){
	// Business Logic for the first level response
	$response = "CON Choose account information you want to view. \n";
	$response .= "1. Account number \n";
	$response .= "2. Account balance";
}
else if($text=="2"){
	// This is the terminal request
	$response = "END Your phone number is".$phoneNumber;
}
else if($text=="1*1"){
	$accountNumber = "1000";
	$response = "END Your accountnumber is".$accountNumber;
}
else if($text=="1*2"){
	$balance = "UGX 1000";
	$response = "END Your balance is".$balance;
}
   // Echo the response to the API.
   header('content-type; text/plain');
   echo $response;

?>