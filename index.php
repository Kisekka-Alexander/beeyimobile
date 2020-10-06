<?php

// Reads the variables sent via POST

$sessionId   = $_POST["sessionId"];  
$serviceCode = $_POST["serviceCode"];  
$text = $_POST["text"];

/////require 'db.inc.php';
$con = new mysqli("localhost:81", "root", "italia.90", "xenlak");
$pull = $con->query("SELECT * FROM tblprices WHERE ProductID = '1' and ProductCategory='1'");
$rows = $pull->fetch_assoc();
$Tprice = $rows['Price'];

//This is the first menu screen

if ( $text == "" ) 
	{
		///$response  = "CON Tukwaniliza\n";
		$response  = "CON 1. Nakasero \n";
		$response .= "2. Owino \n";
		$response .= "3. Kaleerwe \n";
	}

// Menu for a user who selects '1' from the first menu
// Will be brought to this second menu screen

else if ($text == "1" ||$text == "2" ||$text == "3")
{
/////$response  = "CON  Pick a table for reservation below \n";
$response  = "CON 1. Ennyanya('$Tprice') \n";
$response .= "2. Emboga \n";
$response .= "3. Ebijanjalo \n";
$response .= "4. Entula \n";
$response .= "5. Bbilinganya \n";
$response .= "6. Muwoogo \n";
$response .= "7. Lumonde \n";
$response .= "8. Obumonde \n";
$response .= "9. Green Paper \n";
$response .= "10.FrenchBeans \n";
$response .= "11.Obutungulu \n";
//////$response .= "4. Table for 8 \n"; 
}

//Menu for a user who selects '1' from the second menu above
// Will be brought to this third menu screen



else if ($text == "1*1") 
	{
		$response = "CON You are about to book a table for 2 \n";
		$response .= "Please Enter 1 to confirm \n";
	}
else if ($text == "1*1*1")
	{
	 	$response = "CON Table for 2 cost -N- 50,000.00 \n";
	 	$response .= "Enter 1 to continue \n";
	 	$response .= "Enter 0 to cancel";
	}
else if ($text == "1*1*1*1") 
	{
	 	$response = "END Your Table reservation for 2 has been booked";
    }
else if ($text == "1*1*1*0") 
    {
      	$response = "END Your Table reservation for 2 has been canceled";
    }


// Menu for a user who selects "2" from the second menu above
// Will be brought to this fourth menu screen


else if ($text == "1*2") 
    {
		$response = "CON You are about to book a table for 4 \n";
		$response .= "Please Enter 1 to confirm \n";
    }


// Menu for a user who selects "1" from the fourth menu screen
else if ($text == "1*2*1") 
	{
		$response = "CON Table for 4 cost -N- 150,000.00 \n";
		$response .= "Enter 1 to continue \n";
		$response .= "Enter 0 to cancel";
	}
else if ($text == "1*2*1*1")
	{
	 	$response = "END Your Table reservation for 4 has been booked";
	}

else if ($text == "1*2*1*0") 
	{
	 	$response = "END Your Table reservation for 4 has been canceled";
	}


// Menu for a user who enters "3" from the second menu above
// Will be brought to this fifth menu screen


else if ($text == "1*3") 
	{
		$response = "CON You are about to book a table for 6 \n";
		$response .= "Please Enter 1 to confirm \n";
	}
// Menu for a user who enters "1" from the fifth menu
else if ($text == "1*3*1") 
	{
		$response = "CON Table for 6 cost -N- 250,000.00 \n";
		$response .= "Enter 1 to continue \n";
		$response .= "Enter 0 to cancel";
	}

else if ($text == "1*3*1*1") 
	{
		$response = "END Your Table reservation for 6 has been booked";
	}


else if ($text == "1*3*1*0") 
	{
		$response = "END Your Table reservation for 6 has been canceled";
	}


// Menu for a user who enters "4" from the second menu above
// Will be brought to this sixth menu screen


else if ($text == "1*4") 
	{
	    $response = "CON You are about to book a table for 8 \n";
	    $response .= "Please Enter 1 to confirm \n";
	}



// Menu for a user who enters "1" from the sixth menu


else if ($text == "1*4*1") 
	{
		$response = "CON Table for 8 cost -N- 250,000.00 \n";
        $response .= "Enter 1 to continue \n";
         $response .= "Enter 0 to cancel";
    }


else if ($text == "1*4*1*1") 
	{
		$response = "END Your Table reservation for 8 has been booked";
	}

else if ($text == "1*4*1*0") 
	{
		$response = "END Your Table reservation for 8 has been canceled";
	}


//echo response
	
header('Content-type: text/plain');
echo $response
?>


