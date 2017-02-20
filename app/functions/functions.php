<?php
namespace App\functions;
use View, Input, Redirect;
use App\Database\DataConnection;
use Hash;
use DB;
use App\User;
use Illuminate\Support\Facades\Auth;
use App\Events\emailVerifypay;
use Illuminate\Support\Facades\Event;

class functions {


	
	
	function testFunction(){
	$password = bcrypt('Check');
	DB::table('admin')->insert(
    ['ID' => '943062617V', 'name' => 'pasindu' , 'pass' => $password ]);
	}
	
	
	function authenticatedLogin($passwordEnter,$userID)
	{	$dataConnection = new DataConnection();
		$password="";
		if (strlen($userID) == 15){
		
		$userData = $dataConnection->getadminData($userID);
		$id = $userID;
		$username = $userID;
		$password = $userData;
		$usertype = 'admin';
		}
		else if (strlen($userID) == 10){
		$userData = $dataConnection->getbusownerData($userID);
		$id = $userID; 
		$username = $userData[1];
		$password = $userData[0];
		$usertype = 'busowner';
		}
		else if (strlen($userID) == 8){
		$userData = $dataConnection->getconductorData($userID);
		$id = $userID; 
		$username = $userData[1];
		$password = $userData[0];
		$usertype = 'conductor';
		}
		if(Hash::check($passwordEnter,$password)) {
			$result = 'true';
			$user = new User(['id'=>$id,'username'=>$username, 'usertype'=>$usertype]);
			Auth::Login($user);
			$dataConnection->setUser($user);
			} 
			else 
			{
     		$result = 'false';
			}
		return $result;
		
	}	
	
	
	//////////////////////////////////////////////////////////////////////
	

	//search for buses	
	function getCities($startName,$endName,$date,$time)
	{
		
		
	$dataConnection = new DataConnection();
	$result=$dataConnection->returnRouteID($startName,$endName);
	
	if($result!=null){
		$diff=$result[1];
		$start_routeID=$result[0];

		//route find
		$data=$dataConnection->returnTripID($start_routeID,$date,$time,$diff);	
		
		if($data!= null)
		{
		$sentData=	implode("+",$data);
		return $sentData;
		}
		else{
			return null;
			}
	
  		
		
	}	
	else
	{
	//"not found a route";
		
		return null;
	}
	
	
	}	
		
	function setCustomerData($nic,$name,$email,$telephone,$payment,$token)
		{
			
			$dataConnection = new DataConnection();
			
			$expState=$dataConnection->checkExp($token);
			
			if($expState=="res"){
			
			$dataConnection->insertCustomerData($nic,$name,$email,$telephone);
			
			$var=$dataConnection->calculateFromtoken($token);
			
			$trip_ID=$var[0];
			$price=$var[2];
			$seats=$var[1];
			$due_date="2016-12-31";
			
			
			$dataConnection->insertTravelOrder($nic,$trip_ID,$due_date,$payment,$price,$seats,$token);
			
			$var1=$dataConnection->toCreateTicket($token); 
			
			$order_ID=$var1[0];
			$priceT=$price/$seats;
			$seatsN=$var1[1];
			
			$out="";
			$manuIDArray=array();
			
			for ($j=0;$j<$seats;$j++){
			$temp1=rand(10000,1);
			$temp2=rand(10000,1);
			$manuID=$temp1.$temp2;
			
			array_push($manuIDArray,$manuID);
			
			$outT=$manuID."-".$seatsN[$j];
			$out=$outT.",".$out;
			
			}

			$userVerification = array(
    		'Name'  => $name,
    		'email' => $email,
			'ticketnum'=> $out
			);
			
			$i=0;
			for($i=0;$i<$seats;$i++){
				
				$dataConnection->createTicket($order_ID,$i,$seatsN[$i],$priceT,$due_date,$manuIDArray[$i]);
				}
				
		
				Event::fire(new emailVerifypay($userVerification));
				
				return "1";
				
			}
			
			else if($expState=="exp")
			{
				
				
				return "0";
			}
			
			else if($expState=="Booked"){
				
				return "2";
				}
			

		}
		
		
		
		
	/*****saving data to the tempory seat table****/		
	function reserveTempSeats($trip_ID,$seat_no,$start_city,$end_city,$p_price)
	{
		
		
		$dataConnection = new DataConnection();
		
		$seat_Num = explode(",", $seat_no);
		
		//loop through seats and save in the database
		
			$temp1=rand(10000,1);
			$temp2=rand(10000,1);
			
			$reqID=$temp1.$temp2;
			
			
			
		for ($i = 0; $i < count($seat_Num); $i++) 
		{

			$dataConnection->insertTempres_seats($trip_ID,$seat_Num[$i],$reqID);
	
		
		}
		
		
		$t_price=$p_price*count($seat_Num);
		$dataConnection->insertTempres_info($reqID,$start_city,$end_city,$t_price);
		return $reqID;
	
	}		
		
}































			//trigger code
			
	/*		$sql3= 'CREATE TRIGGER `ticket` AFTER INSERT ON `travel_order` FOR EACH ROW
					
					BEGIN
					DECLARE x INT;
					DECLARE y INT;
					DECLARE z VARCHAR(15);
					SET x=0;
					
    				SET y=(NEW.price)/NEW.no_ofseats;
    				SET z= "2016-12-31";
  					IF (NEW.no_ofseats > 0) THEN
 					WHILE x< NEW.no_ofseats DO
					INSERT INTO ticket (order_ID,ticket_ID, seat_no, price,date_created,date_due,status,ticket_manID) VALUES (NEW.order_ID,"",x+1,y," ",z,0,"aaaaaa");
 					SET x = x + 1; 
 					END WHILE;
					END IF;


					END;';
					
					
					
								
					if($connection->query($sql3)){
						
						echo "triggers saved successfully";
						
					}
					
					else {
						echo "ERROR: Could not able to execute $sql2. " . mysqli_error($connection);
					}
					
					
					*/
	
		/*$sql8= 'CREATE TRIGGER `tempRes` AFTER INSERT ON `tempres_seats` FOR EACH ROW
					
				BEGIN
				INSERT INTO tempres_info (requestID,start_city, end_city, price_P) VALUES ("'.$reqID.'","'.$start_city.'","'.$end_city.'","'.$p_price.'");
				END;';
		
		*/
	
		
			/*	if(mysqli_query($connection, $sql8))
				{
					
   				echo "Records added successfully.";
				
				}
				
				else {
						echo "ERROR: Could not able to execute $sql8. " . mysqli_error($connection);
					}*/
		







?>