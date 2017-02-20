<?php
include('db.php');
if($_POST)
{
    $q = mysqli_real_escape_string($connection,$_POST['citysearch']);
    $strSQL_Result = mysqli_query($connection,"select name from city_info where name like '%$q%' order by ID LIMIT 5");
    while($row = mysqli_fetch_array($strSQL_Result))
    {
        $username   = $row['name'];
       
      echo $username; 
    }
}
?>