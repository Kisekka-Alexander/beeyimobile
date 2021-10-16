<?php
include_once "config.php";
// Create connection
$db =  mysqli_connect(DB_SVR, DB_USER, DB_PW, DB_NAME);

// Check connection
if ($db->connect_error) {
    header('Content-type: text/plain');
    //log error to file/db $e-getMessage()
    die("END An error was encountered. Please try again later");
}
