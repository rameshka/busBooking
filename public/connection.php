<?php
header("Access-Control-Allow-Origin: *");
include('db.php');
if($_POST)
{
    $q = mysqli_real_escape_string($connection,$_POST['tripId']);
    $strSQL_Result = mysqli_query($connection,"select seat_no from ticket where ticket.order_ID=(select order_ID from travel_order where travel_order.trip_ID='".$q."') ");
	$rowini = mysqli_fetch_array($strSQL_Result);
	$seat_Num1=$rowini['seat_no'];
    while($row = mysqli_fetch_array($strSQL_Result))
    {
        $seat_Num   =$row['seat_no'];
		$seat_Num1 = $seat_Num1.'@'.$seat_Num;
       
    }
	$strSQL_Result1 = mysqli_query($connection,"select seat_no from  tempres_seats where trip_ID='".$q."' ");
	
	 while($row2 = mysqli_fetch_array($strSQL_Result1))
    {
        $seat_Num   =$row2['seat_no'];
		$seat_Num1 = $seat_Num1.'@'.$seat_Num;
       
    }
	
	 echo $seat_Num1;
		
}
?>