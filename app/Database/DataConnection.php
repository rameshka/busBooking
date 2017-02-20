<?php
namespace App\Database;
use App\Database\Database;
use Hash;
class dataconnection {


//Authentication functions
	
	function setUser($user)
	{$connection = Database::createConnection();
	 mysqli_query($connection,"INSERT INTO users (userID,username,created_at,logedout_at,usertype) VALUES ('".$user->id."','".$user->username."','".date("Y-m-d H:i:s")."','".$user->logedout_at."','".$user->usertype."')");
		
	}
		
	function getauthData($userID)
	{$connection = Database::createConnection();
	 $userData = mysqli_query($connection,"SELECT * FROM users WHERE userID = '".$userID."' ORDER BY id DESC LIMIT 1");
	 $userDataArray = mysqli_fetch_array($userData);
	 return $userDataArray;	
	}
	
	function updateLogout($userID)
	{$connection = Database::createConnection();
	 $currentTime= date("Y-m-d H:i:s");
	 $userData = mysqli_query($connection," UPDATE users SET logedout_at='".$currentTime."' WHERE userID='".$userID->id."' ORDER BY id DESC LIMIT 1");	
	}
	
	
//Admin Login 	
	
	function getadminData($userID)
	{$connection = Database::createConnection();
	$passwordSave = mysqli_query($connection,"SELECT pass FROM admin WHERE ID = '".$userID."'");
	$passwordSave = mysqli_fetch_array($passwordSave);
	$passwordSaveData = $passwordSave['pass'];
	return $passwordSaveData;
	}
//Bus Owner Login
	function getbusownerData($userID)
	{$connection = Database::createConnection();
	$data = mysqli_query($connection,"SELECT password,name FROM bus_owner WHERE ID = '".$userID."'");
	$data = mysqli_fetch_array($data);
	$SaveData[0] = $data['password'];
	$SaveData[1] = $data['name'];
	return $SaveData;
	}


// Conductor Login
function getconductorData($userID)
	{$connection = Database::createConnection();
	$passwordSave = mysqli_query($connection,"SELECT password,ID FROM conductor WHERE bus_ID = '".$userID."'");
	$passwordSave = mysqli_fetch_array($passwordSave);
	$SaveData[0] = $passwordSave['password'];
	$SaveData[1] = $passwordSave['ID'];
	return $SaveData;
	}
	
	




//Add Bus Owner Details
	function insertBusOwner($credentials)
	{$connection = Database::createConnection();
	$ID = $credentials[0];
	$name = $credentials[1];
	$create = $credentials[2];
	$password = bcrypt($credentials[3]);
	$stmt1 = $connection->prepare("INSERT INTO bus_owner (ID,name,createdBy,password) VALUES (?,?,?,?)");
	$stmt1->bind_param("ssss",$ID,$name,$create,$password);
	$stmt1->execute();
	 $return;
	 if (mysqli_affected_rows ($connection )>0)
	 {$return = true;
		}
		else
		{$return =false;
			}
	return $return;
	}
	
	
//Add new Route 

	function insertNewRoute($routeCityInfo)
	{$connection = Database::createConnection();
	$cityId=array();
	//$stmt = $connection->prepare("INSERT INTO route_info (route_ID,city_ID,city_no) VALUES (?,?,?)");
	//$stmt->bind_param("sss",$a,$b,$c);
	$stmt1 = $connection->prepare("SELECT ID FROM city_info WHERE name=?");
	$stmt1->bind_param("s",$q);
	
		for ($x =0; $x<sizeof($routeCityInfo); $x++)
	{
	$q  = preg_replace('/\s+/', '', $routeCityInfo[$x]);
	
	
	$stmt1->execute();
	//$stmt->execute();
	$stmt1->bind_result($userData);
	$stmt1->fetch();
	if ($userData!="")
	{
		array_push($cityId,$userData);
		$result =$cityId;
	}
	else
	{
		$result = 'cityname_error';
		break;
	}
	
	
	}
	
	return $result;	
	
	}
function insertNewRoute2($result,$routeInfo,$createdBY)
{$connection = Database::createConnection();
	for ($x =0; $x<sizeof($result); $x++)
	{$a = $routeInfo[0];
	$b =$result[$x];
	$c =$x;
	$stmt = $connection->prepare("INSERT INTO route_info (route_ID,city_ID,city_no) VALUES (?,?,?)");
	$stmt->bind_param("sss",$a,$b,$c);
	$stmt->execute();

	
	}
	$a1 = $routeInfo[0];
	$b1 =$routeInfo[1];
	$c1 =$routeInfo[2];
	$d1 = $routeInfo[3];
	$stmt1 = $connection->prepare("INSERT INTO route (ID,name,route_no,timeinterval,createdBY) VALUES (?,?,?,?,?)");
	$stmt1->bind_param("sssss",$a1,$b1,$c1,$d1,$createdBY);
	$stmt1->execute();
	 if (mysqli_affected_rows ($connection )>0)
	 {$return = true;
		}
		else
		{$return =false;
			}
	return $return;
	
}

function insertNewRoute3($routeMapInfo,$routeInfo)
{$connection = Database::createConnection();
	for ($x =0; $x<sizeof($routeMapInfo); $x++)
	{$a = $routeInfo[0];
	$b = preg_replace('/\s+/', '', $routeMapInfo[$x]);
	$c =$x+1;
	$stmt = $connection->prepare("INSERT INTO distancecost (route_ID,costID,cost) VALUES  (?,?,?)");
	$stmt->bind_param("sss",$a,$c,$b);
	$stmt->execute();

	
	}
	
	 if (mysqli_affected_rows ($connection )>0)
	 {$return = true;
		}
		else
		{$return =false;
			}
	return $return;
	
}

function getTripdata()
	{	$connection = Database::createConnection();
			$auth_sql_route = "SELECT ID,route_no,timeinterval,name	FROM route";
			$auth_sql_res_route = mysqli_query($connection, $auth_sql_route);
			$result = array();
			while( $row = mysqli_fetch_array( $auth_sql_res_route)){
				array_push($result,$row);
			}
			
		return $result;
	}
	
function addTrip($routeData)
	{	$connection = Database::createConnection();
		$route_ID = mysqli_real_escape_string($connection, $routeData[0]);
		$day = mysqli_real_escape_string($connection, $routeData[1]);
		$start_time = mysqli_real_escape_string($connection, $routeData[2]);
		$end_time = mysqli_real_escape_string($connection, $routeData[3]);
		$bus_no = mysqli_real_escape_string($connection, $routeData[4]);
		$direction = mysqli_real_escape_string($connection, $routeData[5]);
		$stmt = $connection->prepare("INSERT INTO trip (route_ID,day,start_time,end_time,bus_no,direction) VALUES (?,?,?,?,?,?)");
		$stmt->bind_param("ssssss",$route_ID,$day,$start_time,$end_time,$bus_no,$direction);
		$stmt->execute();
			 if (mysqli_affected_rows ($connection )>0)
	 {$return = true;
		}
		else
		{$return =false;
			}
	return $return;
}
function getBus($q,$ID)
	{
	$connection = Database::createConnection();
	$strSQL_Result = mysqli_query($connection,"select bus_ID from bus where bus_ID like '%$q%' AND owner_ID='".$ID."'");
    while($row = mysqli_fetch_array($strSQL_Result)){
    	
        $username   = $row['bus_ID'];

        
            ?>
            <div class="show" align="left">
               <span class="name"><?php echo  $username; ?></span><br/>
            </div>
        <?php
	}
	}
function findBus($routeData,$userID)
	{	$connection = Database::createConnection();
		$stmt = $connection->prepare("SELECT owner_ID FROM bus WHERE bus_ID=? ");
		$stmt->bind_param("s",$routeData);
		$stmt->execute();
		$stmt->bind_result($userIDGot);
		$stmt->fetch();
			 if ($userIDGot==$userID)
	 {$return = true;
		}
		else
		{$return =false;
			}
	return $return;
}
	
//view bus owner details

function getowners()
{
	$connection = Database::createConnection();
	$busOwners = mysqli_query($connection,"SELECT * FROM bus_owner");
	$owners = array();
	while ($row  = mysqli_fetch_object($busOwners))
	{
	array_push($owners, $row);
	
	}
	return $owners;
}	
function getrouets()
{
	$connection = Database::createConnection();
	$routes = mysqli_query($connection,"SELECT * FROM route");
	$routesData = array();
	while ($row  = mysqli_fetch_object($routes))
	{
	array_push($routesData, $row);
	
	}
	return $routesData;
}

function addnewBusfn1($busData)
	{	$connection = Database::createConnection();
		$bus_ID = mysqli_real_escape_string($connection,$busData[0]);
		$owner_ID = mysqli_real_escape_string($connection,$busData[3]);
		$no_ofseats = mysqli_real_escape_string($connection,$busData[1]);;
		$stmt = $connection->prepare("INSERT INTO bus (bus_ID,owner_ID,no_ofseats) VALUES (?,?,?)");
		$stmt->bind_param("sss",$bus_ID,$owner_ID,$no_ofseats);
		$stmt->execute();
			 if (mysqli_affected_rows ($connection )>0)
	 {$return = true;
		}
		else
		{$return =false;
			}
	return $return;
}


function addnewBusfn2($busData)
	{	$connection = Database::createConnection();
		$bus_ID = mysqli_real_escape_string($connection,$busData[0]);
		$password = bcrypt(mysqli_real_escape_string($connection,$busData[2]));
		$condcutorID = mysqli_real_escape_string($connection,$busData[4]);
		$stmt1 = $connection->prepare("INSERT INTO conductor(ID,password,bus_ID) VALUES (?,?,?)");
		$stmt1->bind_param("sss",$condcutorID,$password,$bus_ID);
		$stmt1->execute();
			 if (mysqli_affected_rows ($connection )>0)
	 {$return = true;
		}
		else
		{$return =false;
			}
	return $return;
	}

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////	
	
//Conductor get all trips

function getTrips($tripData)
{
	$connection = Database::createConnection();
	$tripsvalue = mysqli_query($connection,"SELECT * FROM trip WHERE bus_no = '".$tripData."'");
	$trips = array();
	while ($row  = mysqli_fetch_object($tripsvalue))
	{
	array_push($trips, $row);
	
	}
	return $trips;
	
}	

// Conductor get all tickets of a trip
function gettickets($tripID)
{
	$connection = Database::createConnection();
	
	$strSQL_Result = mysqli_query($connection,"SELECT * from ticket where order_ID in (select order_ID from travel_order where trip_id ='".$tripID."')");
	$selected_seats =array();
	$seats = array();
	$ticket_ID = array();
	$result = array();
	 while($row = mysqli_fetch_object($strSQL_Result))
	 {
    	if ($row->status =="1"){
       array_push($selected_seats, $row->seat_no);
		}
		else
		{
			array_push($seats, $row->seat_no);
		}
	 	array_push($ticket_ID, $row);
	 }
	array_push($result, $selected_seats,$seats,$ticket_ID);
	return $result;
}

//ajax request for ticket book
function getMId($ticketID)

{
 		$manuID=$ticketID;
     $connection = Database::createConnection();
       $sql = "UPDATE ticket SET status=1 WHERE ticket_manID = '".$manuID."'";

        if ($connection->query($sql) === TRUE) {
            echo "Record updated successfully";
			echo $manuID;
        } else {
            echo "Error updating record: " . $connection->error;
        }


        $connection->close();

}//BusOwner get all his buses

function getBuses($ownerdatapass)
{
	$connection = Database::createConnection();
	$ownerdata = $ownerdatapass;
	$datavalues = mysqli_query($connection,"SELECT * FROM bus WHERE owner_ID = '".$ownerdata."'");
	$buses = array();
	while ($row  = mysqli_fetch_object($datavalues))
	{
	array_push($buses , $row);
	
	}
	return $buses ;
	
}
	
//Busowner get trip details

function getTripInfo($trip_ID)
{
	$connection = Database::createConnection();
	$datavalues = mysqli_query($connection,"SELECT * FROM tripsummary where trip_ID = '".$trip_ID."'");
	$row  = mysqli_fetch_array($datavalues);
	
	return $row ;
	
}	
	
	////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	
	
	
	//search bus availability at welcome page
	function ajaxCity($q)
	{	 
	
	$connection = Database::createConnection();
	
	$strSQL_Result = mysqli_query($connection,"select name from city_info where name like '$q%' order by ID LIMIT 5");
    while($row = mysqli_fetch_array($strSQL_Result))
    
        $username   = $row['name'];
        $b_username = '<strong>'.$q.'</strong>';
        $final_username = str_ireplace($q, $b_username, $username);

        
            ?>
            <div class="show" align="left">
                <img src="http://www.thayerauto.com/userfiles/filemanager/243/" style="width:50px; height:50px; float:left; margin-right:6px;" /><span class="name"><?php echo $final_username; ?></span><br/>
            </div>
        <?php
		
		}
		
	
	//return routeID for getCities	
	function returnRouteID($startName,$endName){
		
	$connection = Database::createConnection();

	$startId=$this->preparedID($startName,$connection);
	$endId=$this->preparedID($endName,$connection);
	

		
	$sql2 = "SELECT route_ID FROM route_info WHERE city_ID='".$startId."'";
	$sql3 = "SELECT route_ID FROM route_info WHERE city_ID='".$endId."'";
	
	
	$srouteTemp=mysqli_query($connection,$sql2);
	$sroute=mysqli_fetch_array($srouteTemp);
	$start_routeID=$sroute['route_ID'];
	
	
	$erouteTemp=mysqli_query($connection,$sql3);
	$eroute=mysqli_fetch_array($erouteTemp);
	$end_routeID=$eroute['route_ID'];
	
	$result[0]=$start_routeID;
	//$result[1]=$start_routeID;

	
	if($start_routeID!=null and $end_routeID!=null)
	{
			if($start_routeID==$end_routeID)
				{
					$startNo=$this->returnCityNo($startId,$start_routeID);
					$endNo=$this->returnCityNo($endId,$start_routeID);
					$diff=$endNo-$startNo;
		
					if($diff>0)
					{
					$result[1]="positive";
		
					return $result;
					}
		
					else 
					{
					$result[1]="negative";
		
					return $result;
		
					}
				}
				else
				{
					return null;
				}

	}
	

	else{
		
		return null;
		
		}	
		
	}
		
	
	function returnCityNo($cityID,$route_ID){
		
		$connection =Database::createConnection();
		$sql=mysqli_query($connection,"select city_no from route_info where city_ID='".$cityID."' and $route_ID='".$route_ID."'");
		
		$temp = mysqli_fetch_array($sql);
		
		return $temp['city_no'];
		}
		
		
	function preparedID($cityName,$connection){
			
	$stmt = $connection->prepare("SELECT ID FROM city_info where name=?");
	$stmt->bind_param("s",$cityName);
	$stmt->execute();
	$stmt->bind_result($citytId);
	$stmt->fetch();
	return $citytId;
			
	}
	
	

		
	//function return tripID for getCities
	
	function returnTripID($start_routeID,$date,$time,$diff){
		
		$connection = Database::createConnection();
		$strSQL_Result = mysqli_query($connection,"SELECT trip_ID,start_time,bus_no,end_time from trip where day='".$date."' and start_time>='".$time."' and route_ID='".$start_routeID."' and direction='".$diff."' ");
		
		$result ;
		$i =0;
		while ($row = mysqli_fetch_object($strSQL_Result))
		{ 
			$result[$i] = $row;
			$i++;
		}
   
		$j=0;
		$data=null;
		
		while($j<$i)
		{
		$temp[0]= $result[$j]-> trip_ID;
		$temp[1] =$result[$j]-> start_time;
		$temp[2] =$result[$j]-> end_time;
		$temp[3] =$result[$j]-> bus_no;
		
		$data[$j] = implode("*",$temp);
		$j++;
			}
			
		return $data;
		

		
		}	
		
		
		
		
		
		//insert customer data to database
		function insertCustomerData($nic,$name,$email,$telephone){
			
			$connection = Database::createConnection();
			
			$stmt = $connection->prepare("INSERT INTO customer (NIC, name, phone_no,email) VALUES (?,?,?,?)");
			$stmt->bind_param('ssss', $nic,$name,$telephone,$email);
	
			$stmt->execute();
		
			
			
			}
			
		//insert trave order data to database
		
		function insertTravelOrder($nic,$trip_ID,$due_date,$payment,$price,$seats,$token){
			
			$connection = Database::createConnection();
			$sql2 = "INSERT INTO travel_order (order_ID,cust_NIC, trip_ID,due_date,payment_infoID,price,no_ofseats,reservationID) VALUES (null,'".$nic."','".$trip_ID."','".$due_date."','".$payment."','".$price."','".$seats."','".$token."')";
			mysqli_query($connection, $sql2);
			}
			
			
			
	//calculate price
	
			function priceCalc($trip_ID,$start_city,$end_city){
			
			$connection = Database::createConnection();
			
			$sql5 = 'SELECT city_no FROM routemap WHERE trip_ID="'.$trip_ID.'" and name="'.$start_city.'"';
			$sql6='SELECT city_no FROM routemap WHERE trip_ID="'.$trip_ID.'" and name="'.$end_city.'"';
			
			$var1=mysqli_query($connection, $sql5);
			$var2=mysqli_query($connection, $sql6);
			$tempdata1 = mysqli_fetch_array($var1);	
			$tempdata2 = mysqli_fetch_array($var2);	
			$temp1=$tempdata1['city_no'];
			$temp2=$tempdata2['city_no'];
			
			$diff=abs($temp1-$temp2);
			
			$sql7='SELECT cost FROM tripmap WHERE costID="'.$diff.'" and trip_ID= "'.$trip_ID.'"';
			
			$var3=mysqli_query($connection, $sql7);
			$tempdata3 = mysqli_fetch_array($var3);	
			
			
			return $tempdata3['cost'];			
			
			}	
			
			
			//calculate trip_ID,seatNUms,total_price from token
			
			function calculateFromtoken($token){
			
			$connection = Database::createConnection();
			

			$sql9='select trip_ID,count(seat_no),price_total from tempres_seats,tempres_info where tempres_info.requestID="'.$token.'" and tempres_seats.requestID="'.$token.'"';

			$temp1= mysqli_query($connection,$sql9);
			$array1= mysqli_fetch_array($temp1);
			
			$temp3[0]= $array1['trip_ID'];
			$temp3[1]= $array1['count(seat_no)'];
			$temp3[2]= $array1['price_total'];
			
	
			return $temp3;
		}
		
			
		
		//taking values to create ticket	
		function toCreateTicket($token){

		$connection = Database::createConnection();
		$sql10='select order_ID,seat_no from travel_order,tempres_seats where tempres_seats.requestID="'.$token.'"   and travel_order.reservationID="'.$token.'"';
		$temp1= mysqli_query($connection,$sql10);
			
		$array1= mysqli_fetch_array($temp1);
			
		$temp3[0]= $array1['order_ID'];
		$result[0]=$array1['seat_no'];
			
		$i=1;	
		while ($row = mysqli_fetch_array($temp1))
		{ 
			
			$result[$i] = $row['seat_no'];
	
			$i++;
		
		}
		$temp3[1]=$result;
   
  	 	return $temp3;
				
	}
	
	
	//creating ticket
	function createTicket($order_ID,$i,$seatsN,$priceT,$due_date,$manuID)
	{
		$connection = Database::createConnection();
		$sql3="INSERT INTO ticket (order_ID,ticket_ID, seat_no, price,date_due,status,ticket_manID) VALUES ('".$order_ID."','".$i."','".$seatsN."','".$priceT."','".$due_date."',0,'".$manuID."')";	
		
		
		mysqli_query($connection, $sql3);		

	}
	
	
	//saving in to temporary table
	
	function insertTempres_seats($trip_ID,$seat_Num,$reqID){

			$connection = Database::createConnection();
			$sql4 = 'INSERT INTO tempres_seats (trip_ID, seat_no,requestID,temp_resID) VALUES ("'.$trip_ID.'","'.$seat_Num.'","'.$reqID.'","")';
			mysqli_query($connection, $sql4);
		
		}
		
	
	function insertTempres_info($reqID,$start_city,$end_city,$t_price){
		
		$connection = Database::createConnection();
		$sql8='INSERT INTO tempres_info (requestID,start_city, end_city, price_total,tick_sts,res_time) VALUES ("'.$reqID.'","'.$start_city.'","'.$end_city.'","'.$t_price.'","res",now())';
		mysqli_query($connection, $sql8);
		
		


	}
	
	//get the city is there or not ajax for admin
	function checkCity($cityName)
	{
		$connection = Database::createConnection();
      $cityname     = $cityName;
 	  $userData = mysqli_query($connection,"SELECT name FROM city_info WHERE name = '".$cityname."' ");
	  $userDataArray = mysqli_fetch_array($userData);  
      
   if(sizeof($userDataArray)>0)
   {
   $result = "<span style='color:yellow;'><b>City exisit in the list !!!<b></span>";
   }
   else
   {
    $result =  "<span style='color:yellow;'><b>click 'Add City' </b></span>";
   }
   
   return $result;
  
	}
	
	//getCity for admin to add routes
	function getCity($cityName)
	{
		$connection = Database::createConnection();
        $q = $cityName;
    	$strSQL_Result = mysqli_query($connection,"select name from city_info where name like '%$q%' order by ID LIMIT 5");
    while($row = mysqli_fetch_array($strSQL_Result))
    {
        $username   = $row['name'];
       
      echo $username; 
    }
	}
	
	//Add cities for admin
	function addCity($cityName,$cityId)
	{
		$connection = Database::createConnection();
      $cityname   = $cityName;
      $cityID     = $cityId;
 	  mysqli_query($connection,"INSERT INTO city_info (ID,name) VALUES ('".$cityID."','".$cityname ."')");
	  
	if (mysqli_affected_rows ($connection )>0)
	 {$result = "<span style='color:yellow;'>city added</span>";
		}
		else
		{$result = "<span style='color:yellow;'>city already there</span>";
			}
      
	  return $result;
	}
	
	//get Seasts from booking 
	function seatsArrange($tripID)
	{
	  $connection = Database::createConnection();
       $q =$tripID	;
    $strSQL_Result = mysqli_query($connection,"select seat_no from tempres_seats where requestID In (select requestID from tempres_info where( tick_sts = 'Booked' or tick_sts = 'res')) and trip_ID = '".$q."' ");
	$rowini = mysqli_fetch_array($strSQL_Result);
	$seat_Num1=$rowini['seat_no'];
    while($row = mysqli_fetch_array($strSQL_Result))
    {
        $seat_Num   =$row['seat_no'];
		$seat_Num1 = $seat_Num1.'@'.$seat_Num;
       
    }

	
	 echo $seat_Num1;
	}
	
	function checkExp($token){
		 $connection = Database::createConnection();
		
		$sql=mysqli_query($connection,"select tick_sts from tempres_info where requestID='".$token."'");
		$state =mysqli_fetch_array($sql);
		
		return $state['tick_sts'];
		
		}
	
}

?>