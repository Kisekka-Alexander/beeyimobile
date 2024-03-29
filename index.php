<?php
//1. Ensure ths code runs only after a POST from AT
///////////////////////////////////if (!empty($_POST) && !empty($_POST['phoneNumber'])) {
    require_once('dbAccess.php');
    ///////////////////////////////////require_once('ATG.php');
    require_once('config.php');

    //2. receive the POST from AT
    $sessionId     = $_POST['sessionId'];
    $serviceCode   = $_POST['serviceCode'];
    $phoneNumber   = $_POST['phoneNumber'];
    $text          = $_POST['text'];

    //3. Explode the text to get the value of the latest interaction - think 1*1
    $textArray = explode('*', $text);
    $userResponse = trim(end($textArray));

    //4. Set the default level of the user
    $level = 0;
    $product="";
   

    //5. Check the level of the user from the DB and retain default level if none is found for this session
    $sql = "select * from ussd_session_levels where session_id ='" . $sessionId . " '";
    $levelQuery = $db->query($sql);
    if ($result = $levelQuery->fetch_assoc())
    {
        $level = $result['level'];
        $action = $result['action'];

    }

    //6. Check the phonenumber whether registered or not

    $sql4n = "select phone_number,active from tbl_subscribers where phone_number ='" . $phoneNumber . " '";
    $phonenumberQuery = $db->query($sql4n);

      if ($result2 = $phonenumberQuery->fetch_assoc())
    {
        $telephone = $result2['phone_number'];
        $active = $result2['active'];

    }
    

    //7. Let user register if not registered

    if ($telephone == "" || $active==0)
{
        if($level==0)
    {
        switch ($userResponse) 
        {
            case "":

                    //Serve our Main Menu
                    $response = ""
                        . "CON Choose a package." . PHP_EOL
                        . "1. Register" . PHP_EOL
                        . "2. Quit" . PHP_EOL;

                    //Print the response onto the page so that our gateway can read it
                    header('Content-type: text/plain');
                    echo $response;
                
                break;

            case "1":
               
                    //Graduate user to next level & Let them enter their name.
                    $sql = "INSERT INTO `ussd_session_levels`(`session_id`,`phone_number`,`level`) VALUES('" . $sessionId . "','" . $phoneNumber . "',1)";
                    $db->query($sql);

                    //Partial Registration
                         $sql = "INSERT INTO tbl_subscribers (`full_name`,`phone_number`,`item`,`market`,`location`,`active`) VALUES('','" . $phoneNumber . "','','','','0')";
                        $db->query($sql);

                    $response = ""
                        . "CON Enter Your Name." . PHP_EOL;

                    //Print the response onto the page so that our gateway can read it.
                    header('Content-type: text/plain');
                    echo $response;
            
                break; 

            case "0":
               
                    //7b. Graduate user to next level & Let them enter their name.
                    $sql7b = "INSERT INTO `ussd_session_levels`(`session_id`,`phone_number`,`level`) VALUES('" . $sessionId . "','" . $phoneNumber . "',1)";
                    $db->query($sql7b);
                    $response = ""
                        . "CON Enter Your Name." . PHP_EOL;

                    // Print the response onto the page so that our gateway can read it
                    header('Content-type: text/plain');
                    echo $response;
            
                break; 
    

            default:
                $response = "END Apologies, something went wrong... \n";
                // Print the response onto the page so that our gateway can read it
                header('Content-type: text/plain');
                echo $response;
                break;    
        }
    }

   elseif($level==1)
    {
          if($userResponse != "" || $userResponse==0)
           {

                $response = ""
                        . "CON Enter Your Location." . PHP_EOL;
                        
                            
                 // Update Name
                $name = $userResponse;
                $sql = "UPDATE `tbl_subscribers` SET `full_name`= '" . $name . "' where `phone_number`='" . $phoneNumber . "'";
                $db->query($sql);

                 // Promote To Next Level

                $sql2 = "UPDATE `ussd_session_levels` SET `level`=2 where `session_id`='" . $sessionId . "'";
                $db->query($sql2);

                // Print the response onto the page so that our gateway can read it
                header('Content-type: text/plain');
                echo $response;
            }
            else 
            {
                $response = "CON You have to enter your Name" . PHP_EOL;
                $response .= "Press 0 to go back." . PHP_EOL;
            
                $sqlLevelDemote = "UPDATE `ussd_session_levels` SET `level`=0 where `session_id`='" . $sessionId . "'";
                $db->query($sqlLevelDemote);

                header('Content-type: text/plain');
                echo $response;
            }
    }


       elseif($level==2)
    {
          if($userResponse != "" || $userResponse ==0)
           {

                $sql = "select * from tbl_markets";
                $marketQuery = $db->query($sql);


                // Print the response onto the page so that our gateway can read it
                
                $response1 = ""
                        . "CON Choose your common Market." . PHP_EOL;

                echo $response1;
                header('Content-type: text/plain');

                while($result = $marketQuery->fetch_assoc())
                {

                   $id = $result['id'];
                   $market = $result['market'];

                   $response = ""
                        . $id . "." . $market . PHP_EOL;

                    header('Content-type: text/plain');
                    echo $response;
                }                        
                  
                  // Update Location
                $location = $userResponse;
                $sql = "UPDATE `tbl_subscribers` SET `location`= '" . $location . "' where `phone_number`='" . $phoneNumber . "'";
                $db->query($sql);
                 
                 // Promote Level 
                $sql3 = "UPDATE `ussd_session_levels` SET `level`=3 where `session_id`='" . $sessionId . "'";
                $db->query($sql3);
              
            }
            else 
            {
                $response = "CON You have to enter your Location" . PHP_EOL;
                $response .= "Press 0 to go back." . PHP_EOL;
            
                $sqlLevelDemote = "UPDATE `ussd_session_levels` SET `level`=1 where `session_id`='" . $sessionId . "'";
                $db->query($sqlLevelDemote);

                header('Content-type: text/plain');
                echo $response;
            }
    }
   
         ////////////////////////// SELECT MAJOR CROP //////////////////////////////////////////

       elseif($level==3)
    {
          if($userResponse == "1" ||$userResponse == "2"||$userResponse == "3" ||$userResponse == "4" 
          ||$userResponse == "5" || $userResponse == "6" ||$userResponse == "7" || 
          $userResponse == "8" || $userResponse == "9" || $userResponse == "10" || $userResponse == "0")
           {

                $sql = "select * from tbl_items";
                $itemQuery = $db->query($sql);


                // Print the response onto the page so that our gateway can read it
                
                $response1 = ""
                        . "CON Choose your Major Item." . PHP_EOL;

                echo $response1;
                header('Content-type: text/plain');

                while($result = $itemQuery->fetch_assoc())
                {

                   $id = $result['id'];
                   $item = $result['item_name'];

                   $response = ""
                        . $id . "." . $item . PHP_EOL;

                    header('Content-type: text/plain');
                    echo $response;
                }     

                // Update Market
                $market = $userResponse;
                $sql = "UPDATE `tbl_subscribers` SET `market`= '" . $market . "' where `phone_number`='" . $phoneNumber . "'";
                $db->query($sql);
                 
                 // Promote Level

                $sql3 = "UPDATE `ussd_session_levels` SET `level`=4 where `session_id`='" . $sessionId . "'";
                $db->query($sql3);
              
            }
            else 
            {
                $response = "CON You have to choose a market" . PHP_EOL;
                $response .= "Press 0 to go back." . PHP_EOL;
            
                $sqlLevelDemote = "UPDATE `ussd_session_levels` SET `level`=2 where `session_id`='" . $sessionId . "'";
                $db->query($sqlLevelDemote);

                header('Content-type: text/plain');
                echo $response;
            }
    }


   

        ////////////////////////// FINISH REGISTERING //////////////////////////////////////////

       elseif($level==4)
    {
          if($userResponse == "1" ||$userResponse == "2"||$userResponse == "3" ||$userResponse == "4" 
          ||$userResponse == "5" || $userResponse == "6" ||$userResponse == "7" || 
          $userResponse == "8" || $userResponse == "9" || $userResponse == "10" || $userResponse == "0" )
           {



                // Print the response onto the page so that our gateway can read it
            
                $response = "END Thank you for registering...\n";
                echo $response;
                header('Content-type: text/plain');                        

               
                 // Update Item
                $item = $userResponse;
                $sql = "UPDATE `tbl_subscribers` SET `item`= '" . $item . "' where `phone_number`='" . $phoneNumber . "'";
                $db->query($sql);
              
                 // Complete Registration By Making User Active
                $sql = "UPDATE `tbl_subscribers` SET `active`= '1' where `phone_number`='" . $phoneNumber . "'";
                $db->query($sql);
            }
            else 
            {
                $response = "CON You have to choose a market" . PHP_EOL;
                $response .= "Press 0 to go back." . PHP_EOL;
            
                $sqlLevelDemote = "UPDATE `ussd_session_levels` SET `level`=3 where `session_id`='" . $sessionId . "'";
                $db->query($sqlLevelDemote);

                header('Content-type: text/plain');
                echo $response;
            }
    }
}




                           ////////////// MAIN MENU AFTER REGISTRATION ////////////////////


else
{
          if($level==0)
    {
        switch ($userResponse) 
        {
            case "":

                    //Serve our Main Menu
                    $response = ""
                        . "CON Choose a package." . PHP_EOL
                        . "1. Prices" . PHP_EOL
                        . "2. Info" . PHP_EOL;

                    //Print the response onto the page so that our gateway can read it
                    header('Content-type: text/plain');
                    echo $response;
                
                break;

            case "1":
               
                    //Graduate user to next level & Let them enter their name.
                    $sql = "INSERT INTO `ussd_session_levels`(`session_id`,`phone_number`,`level`) VALUES('" . $sessionId . "','" . $phoneNumber . "',1)";
                    $db->query($sql);

                    $response = ""
                        . "CON Choose one to proceed." . PHP_EOL
                        . "1. Post" . PHP_EOL
                        . "2. Check" . PHP_EOL;

                    //Print the response onto the page so that our gateway can read it.
                    header('Content-type: text/plain');
                    echo $response;
            
                break;

            default:
                $response = "END Apologies, something went wrong... \n";
                // Print the response onto the page so that our gateway can read it
                header('Content-type: text/plain');
                echo $response;
                break;    
        }
    }

                     ///////////////////SELECT MARKET ///////////////////////////////



      elseif($level==1)
    {
          if($userResponse == "1" || $userResponse == "2" ||$userResponse == "0")
           {
                

               $sql = "INSERT INTO `tbl_prices`(`item`,`market`,`price`,`session_id`,`phone_number`,`is_complete`) VALUES('','','','" . $sessionId . "','" . $phoneNumber . "','0')";
               $db->query($sql);

               
                $sql = "select * from tbl_markets";
                $marketQuery = $db->query($sql);

                // Print the response onto the page so that our gateway can read it
                
                $response1 = ""
                        . "CON Choose Market." . PHP_EOL;

                echo $response1;
                header('Content-type: text/plain');

                while($result = $marketQuery->fetch_assoc())
                {

                   $id = $result['id'];
                   $market = $result['market'];

                   $response = ""
                        . $id . "." . $market . PHP_EOL;

                    header('Content-type: text/plain');
                    echo $response;
                }                        
                  
                 
                 // Promote Level 
                $sql3 = "UPDATE `ussd_session_levels` SET `level`=2 where `session_id`='" . $sessionId . "'";
                $db->query($sql3);


                // Handle checking or Posting
                
                $sql = "UPDATE `ussd_session_levels` SET `action`= '" . $userResponse . "' where `session_id`='" . $sessionId . "'";
                $db->query($sql);
            }
            else 
            {
                $response = "CON Option Invalid" . PHP_EOL;
                $response .= "Press 0 to go back." . PHP_EOL;
            
                $sqlLevelDemote = "UPDATE `ussd_session_levels` SET `level`=0 where `session_id`='" . $sessionId . "'";
                $db->query($sqlLevelDemote);

                header('Content-type: text/plain');
                echo $response;
            }
    }


           ////////////////////////// SELECT PRODUCT TO POST PRICE FOR //////////////////////////////////////////

       elseif($level==2)
    {
          if($userResponse == "1" ||$userResponse == "2"||$userResponse == "3" ||$userResponse == "4" 
          ||$userResponse == "5" || $userResponse == "6" ||$userResponse == "7" || 
          $userResponse == "8" || $userResponse == "9" || $userResponse == "10" || $userResponse == "0")
           {
                
                

                $sql = "select * from tbl_items";
                $itemQuery = $db->query($sql);


                // Print the response onto the page so that our gateway can read it
                
                $response1 = ""
                        . "CON Choose Item." . PHP_EOL;

                echo $response1;
                header('Content-type: text/plain');

                while($result = $itemQuery->fetch_assoc())
                {

                   $id = $result['id'];
                   $item = $result['item_name'];

                   $response = ""
                        . $id . "." . $item . PHP_EOL;

                    header('Content-type: text/plain');
                    echo $response;
                }     

                $sql = "UPDATE `tbl_prices` SET `market`= '" . $userResponse . "' where `session_id`='" . $sessionId . "'";
                $db->query($sql);
                 
                 // Promote Level

                $sql3 = "UPDATE `ussd_session_levels` SET `level`=3 where `session_id`='" . $sessionId . "'";
                $db->query($sql3);
              
            }
            else 
            {
                $response = "CON You have to choose a market" . PHP_EOL;
                $response .= "Press 0 to go back." . PHP_EOL;
            
                $sqlLevelDemote = "UPDATE `ussd_session_levels` SET `level`=1 where `session_id`='" . $sessionId . "'";
                $db->query($sqlLevelDemote);

                header('Content-type: text/plain');
                echo $response;
            }
    }

             ////////////////////////// POST PRICE FOR PRODUCT HERE //////////////////////////////////////////

       elseif($level==3 && $action==1)
    {
          if($userResponse == "1" ||$userResponse == "2"||$userResponse == "3" ||$userResponse == "4" 
          ||$userResponse == "5" || $userResponse == "6" ||$userResponse == "7" || 
          $userResponse == "8" || $userResponse == "9" || $userResponse == "10" || $userResponse == "0" )
           {


                // Print the response onto the page so that our gateway can read it
                
                $response1 = ""
                        . "CON Post Price In UGX." . PHP_EOL;

                echo $response1;   
                 
                 // Promote Level

                $sql3 = "UPDATE `ussd_session_levels` SET `level`=4 where `session_id`='" . $sessionId . "'";
                $db->query($sql3);

                $sql = "UPDATE `tbl_prices` SET `item`= '" . $userResponse . "' where `session_id`='" . $sessionId . "'";
                $db->query($sql);
              
            }
            else 
            {
                $response = "CON You have to choose a product" . PHP_EOL;
                $response .= "Press 0 to go back." . PHP_EOL;
            
                $sqlLevelDemote = "UPDATE `ussd_session_levels` SET `level`=2 where `session_id`='" . $sessionId . "'";
                $db->query($sqlLevelDemote);

                header('Content-type: text/plain');
                echo $response;
            }
    }

             //////////////////////////// CHECK FOR PRICE HERE ///////////////////////////////////

        elseif($level==3 && $action==2)
    {
          if($userResponse == "1" ||$userResponse == "2"||$userResponse == "3" ||$userResponse == "4" 
          ||$userResponse == "5" || $userResponse == "6" ||$userResponse == "7" || 
          $userResponse == "8" || $userResponse == "9" || $userResponse == "10" ||$userResponse == "0" )
           {
                $sql = "select FORMAT(AVG(price),0) as price from `tbl_prices` where DATE(date) = CURRENT_DATE()  and is_complete = '1' and item = '" . $userResponse . "'";
                $priceQuery = $db->query($sql);
                if ($result = $priceQuery->fetch_assoc())
                {
                    $price = $result['price'];
                }

                $sql = "select * from `tbl_items` where ID = '" . $userResponse . "'";
                $itemQuery = $db->query($sql);
                if ($result = $itemQuery->fetch_assoc())
                {
                    $item = $result['item_name'];
                    $unit = $result['unit_of_measure'];
                }

                // Print the response onto the page so that our gateway can read it
                
                $response1 = ""
                        . "END Estimate Price for" . " " . $unit . " of " . $item . " is  " . $price . PHP_EOL;

                echo $response1;   
                 
                 // Promote Level

                $sql3 = "UPDATE `ussd_session_levels` SET `level`=4 where `session_id`='" . $sessionId . "'";
                $db->query($sql3);

                $sql = "UPDATE `tbl_prices` SET `item`= '" . $userResponse . "' where `session_id`='" . $sessionId . "'";
                $db->query($sql);
              
            }
            else 
            {
                $response = "CON You have to choose a product" . PHP_EOL;
                $response .= "Press 0 to go back." . PHP_EOL;
            
                $sqlLevelDemote = "UPDATE `ussd_session_levels` SET `level`=2 where `session_id`='" . $sessionId . "'";
                $db->query($sqlLevelDemote);

                header('Content-type: text/plain');
                echo $response;
            }
    }


            ////////////////////////// FINISH POSTING //////////////////////////////////////////

       elseif($level==4)
    {
          if($userResponse != "")
           {

                // Print the response onto the page so that our gateway can read it
            
                $response = "END Thank you...\n";
                echo $response;
                header('Content-type: text/plain');


                // Update Item
                $sql = "UPDATE `tbl_prices` SET `price`= '" . $userResponse . "' where `session_id`='" . $sessionId . "'";
                $db->query($sql);

                //////////////// COMPLETE TRANSACTION BY CHANGING Iscomplete field to 1  //////////////////

                $sql = "UPDATE `tbl_prices` SET `is_complete`= '1' where `session_id`='" . $sessionId . "'";
                $db->query($sql);                          
            }
            else 
            {
                $response = "CON Enter Valid Price" . PHP_EOL;
                $response .= "Press 0 to go back." . PHP_EOL;
            
                $sqlLevelDemote = "UPDATE `ussd_session_levels` SET `level`=3 where `session_id`='" . $sessionId . "'";
                $db->query($sqlLevelDemote);

                header('Content-type: text/plain');
                echo $response;
            }
    }
   
}
