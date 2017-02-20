<?php

    $connection = mysqli_connect('localhost','root','','onlinebusticketing');
    if (mysqli_connect_errno())
    {
         echo "Failed to connect to MySQL: " . mysqli_connect_error();
    }
	
 if($_POST) 
  {
      $cityname     = strip_tags($_POST['cityname']);
      $cityID     = strip_tags($_POST['cityID']);
 	  mysqli_query($connection,"INSERT INTO city_info (ID,name) VALUES ('".$cityID."','".$cityname ."')");	
    echo "<span style='color:green;'>city added</span>";
  
  }
?>