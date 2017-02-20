<?php

    $connection = mysqli_connect('localhost','root','','onlinebusticketing');
    if (mysqli_connect_errno())
    {
         echo "Failed to connect to MySQL: " . mysqli_connect_error();
    }
	
 if($_POST) 
  {
      $cityname     = strip_tags($_POST['cityname']);
      
 	  $userData = mysqli_query($connection,"SELECT name FROM city_info WHERE name = '".$cityname."' ");
	  $userDataArray = mysqli_fetch_array($userData);  
      
   if(sizeof($userDataArray)>0)
   {
    echo "<span style='color:yellow;'><b>City exisit in the list !!!<b></span>";
   }
   else
   {
    echo "<span style='color:yellow;'><b>click 'Add City' </b></span>";
   }
  }
?>