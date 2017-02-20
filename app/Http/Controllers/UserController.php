<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\User;
use App\Database\DataConnection;
use Illuminate\Support\Facades\Auth;
use App\Events\emailVerify;
use Illuminate\Support\Facades\Event;
use App\functions\functions;
use Hash;
use View;
use Session;
Use Input;


class UserController extends Controller{
	
	

public function checkdatabasequery()
{
	
	$testDB = new functions();
	$testDB -> testFunction();
	 return view('welcome');
}

public function SignIn(Request $request)
{	
	$this->validate($request,[
			'username' => 'required',
			'password' => 'required|min:3'
			]);
	
	$checkPassword = new functions();
	$value = $checkPassword -> authenticatedLogin($request['password'],$request['username']);
	if ($value =='true')
	{	$user = Auth::User();
			if ($user->usertype =='admin'){
				
					return redirect()->route('admindashboard');
				}
				else if ($user->usertype =='conductor')
				{
					return redirect()->route('conductordashboard');
				}
				else if ($user->usertype =='busowner')
				{
					return redirect()->route('busownerdashboard');
				}
	}
	else 
	{
		return redirect()->back()->withErrors(['authentication Failed', 'Please re-enter your password']);
		
	}
}

public function SignOut()
{
	$user = Auth::User();
	$updateLogOut = new dataconnection();
	$updateLogOut->updateLogout($user);
	Auth::Logout();
	return redirect()->route('homeenter');
}


public function homeenter()
{
	return view('welcome');
}


////////////////////////   Admin Routes  ////////////////////////////////////////

public function admindashboard()
{
	
	$user = Auth::User();
	$userdata =$user->username ;
	 return view('test')->with('data',$userdata);
}

 public function addroutes()
{
	
	return view('addroute');
	
}

public function getrouets()
{
	$getowners = new dataconnection();
	$result = $getowners->getrouets();
	return view ('viewroutes',compact('result'));
}


public function getbusowners()
{
	$getowners = new dataconnection();
	$result = $getowners->getowners();
	return view ('viewbusowner',compact('result'));
}
public function enterBusOwnerData(Request $request)
{
	$this->validate($request,[
			'ID' => 'required|min:10|max:10',
			'username' => 'required',
			'password' => 'required|min:3',
	
			]);
	$user = Auth::User();
	$adminUser =$user->username;		
	$credentials[0] = $request['ID'];
	$credentials[1] = $request['username'];
	$credentials[2] = $adminUser;
	$credentials[3] = $request['password'];
	$InsertDetails = new DataConnection();
	$result = $InsertDetails->insertBusOwner($credentials);
	if ($result){
	$userVerification = array(
    		'Name'  => 'pasindu',
    		'email' => 'pasinduath@gmail.com'
			);
	//Event::fire(new emailVerify($userVerification));
	return redirect()->back()->with('message', 'A new bus owner has been added.');
	}
	else 
	{
		return redirect()->back()->withErrors(['Process Failed', 'User already there!!!']);
	}
}

public function createRoute(Request $request)
{
	
	$this->validate($request,[
			'routeID' => 'required|max:5',
			'routeName' => 'required',
			'routeNo' => 'required',
			'timeInterval' => 'required',
			'numberofCities'=> 'required',
			'numberofmappings'=> 'required',
			]);
			
			
	$routeCityInfo =array();
	$routeMapInfo =array();
	$numofCities = $request['numberofCities'];
	for ($count = 0; $count < $numofCities; $count++) {
		$counter= 'cityNum_'. $count .'';
		$city =$request[$counter];
		array_push($routeCityInfo,$city);
	}
	$numofmaps = $request['numberofmappings'];
	for ($countmap = 0; $countmap < $numofmaps; $countmap++) {
		$countermap= 'mapNum_'. $countmap .'';
		$map =$request[$countermap];
		array_push($routeMapInfo,$map);
	}
	$routeInfo[0] = $request['routeID'];
	$routeInfo[1] = $request['routeName'];
	$routeInfo[2] = $request['routeNo'];
	$routeInfo[3] = $request['timeInterval'];
	
	//echo implode(" ",$routeInfo);
	//echo implode(" ",$routeMapInfo);
	//echo implode(" ",$routeCityInfo);
	$InsertDetails = new DataConnection();
	$result = $InsertDetails->insertNewRoute($routeCityInfo);
	if ($result!="cityname_error"){
	//return redirect()->back()->with('message', 'A new route has been added.');
	$result2 = $InsertDetails->insertNewRoute2($result,$routeInfo,Auth::User()->id);
		if ($result2)
			{
				$result3 = $InsertDetails->insertNewRoute3($routeMapInfo,$routeInfo);
				if($result2) 
					{return redirect()->back()->with('message', 'A new route has been added.');
						}
				else 
				{return redirect()->back()->withErrors(['Cost map Error']);
					}
				
				}
		else 
			{return redirect()->back()->withErrors(['Route already there']);
				}
		
	}
	else 
	{
		return redirect()->back()->withErrors(['unknown city', 'please add all cities']);
	}
}

/////////// Conductor Routes //////////////////////////

public function conductordashboard()
{
	
	$user = Auth::User();
	$getTrips = new dataconnection();
	$trips = $getTrips->getTrips($user->id);
	return view('conductor',compact('trips'));
	
}

 public function getOrderID($trip_ID){
	 
	$gettickets = new dataconnection();
	$result = $gettickets->gettickets($trip_ID); 
	$seats = $result[1];
	$ticket_ID = $result[2];
	$selected_seats = $result[0];
	return view('ticketCheck',compact('seats','ticket_ID','selected_seats'));
	 
 }
 
  public function getMID(Request $request)
 {
	 $manuID =$request['manuID'];
	 $markticket = new dataconnection();
	 $markticket->getMID($manuID); 
}

 
 
//////////////////////////////// Bus Owner Routes ////////////////////////////

public function busownerdashboard()
{
	
	$user = Auth::User();
	$getTrips = new dataconnection();
	$buses = $getTrips->getBuses($user->id);
	return view('busowner',compact('buses'));
	
}

 
 
 public function getTrips($busID)
{
	

	$getTrips = new dataconnection();
	$trips = $getTrips->getTrips($busID);
	return view('bus',compact('trips'));
	
}

 public function addbus()
{
	
	return view('owneraddbus');
	
}

 public function getbusOrderID($trip_ID){
	 
	$gettickets = new dataconnection();
	$result = $gettickets->gettickets($trip_ID); 
	$result2 = $gettickets->getTripInfo($trip_ID);
	$seats = $result[1];
	$ticket_ID = $result[2];
	$selected_seats = $result[0];
	return view('tripresults',compact('seats','ticket_ID','selected_seats','result2'));
	 
 }
 

 

public function cityfinder(Request $request)
{
	$q= $request['datafile'];
	
	$ajaxCity = new dataconnection();
	$ajaxCity->ajaxCity($q);
	
}
public function getTripsdata(Request $request)
	{	$this->validate($request,[
			'route' => 'required',
			'date' => 'required',
			'start' => 'required',
			'end' => 'required',
			'bus_no'=> 'required',
			'direction'=> 'required',
			]);
		
		$routeData = array();
		array_push($routeData,$request['route']);
		array_push($routeData,$request['date']);
		array_push($routeData,$request['start']);
		array_push($routeData,$request['end']);
		array_push($routeData,$request['bus_no']);
		array_push($routeData,$request['direction']);
		
		$addTrip = new dataconnection();
		$result1 = $addTrip->findBus($request['bus_no'],Auth::User()->id);
		if($result1)
		{
			$result = $addTrip->addTrip($routeData);
			if($result)
			{
				return redirect()->route('addtrip')->with('message', 'A new trip has been added.');;
			}
			else 
			{ 
				return redirect()->back()->withErrors(['Trip is perviously allocated']);
			}
		}
		else
		{
			return redirect()->back()->withErrors(['Bus is not belong to the user']);
		}
	}


 public function addtrip() 
 {
	 
	 $getTripdata = new dataconnection();
	 $result=  $getTripdata->getTripdata();
	 if ($result)
	 {
	 return view('addtrip')->with('routes',$result);
	 }
	 else
	 {
		 return redirect()->back()->withErrors(['Database connection failed']);
	}
}

	public function busnumpick(Request $request)
	{
	
		$q= $request['datafile'];
		$getBus = new dataconnection();
		
		$getBus ->getBus($q,Auth::User()->id);
		
	}
	
	public function owneraddnewBus(Request $request)
	{	
		$this->validate($request,[
			'bus_ID' => 'required',
			'no_ofseats' => 'required',
			'conductorID' => 'required',
			'password1' => 'required',
			'password2' => 'required',
			]);
		$busdata= array();
		array_push($busdata,$request['bus_ID'],$request['no_ofseats'],$request['password1'],Auth::User()->id,$request['conductorID']);
		$addnewBus = new dataconnection();
		$result = $addnewBus->addnewBusfn1($busdata);
		if($result)
		{	$result = $addnewBus->addnewBusfn2($busdata);
			if($result)
			{
				return redirect()->back()->with('message', 'A new bus has been added.');
			}
				else 
			{ 
				return redirect()->back()->withErrors(['Conductor already there']);
			}	
			
		}
		else 
		{ 
		return redirect()->back()->withErrors(['Bus already there']);
		}
	}
/////////////////////////////////////////////Customer routes/////////////////////////////////////////////////////////

	
	public function postsenddata(Request $request)
	{
		$this->validate($request, [	
		'startName' => 'required',
		'endName' => 'required',
		'date'=>'required',
		'time'=>'required'
		
		]);
		
		$startName = $request['startName'];
		$endName =$request['endName'];
		$date =$request['date'];
		$time = $request['time'];
		
		
		$dest[0]=$startName;
		$dest[1]=$endName;
		$getCities = new functions();
		$var = $getCities->getCities($startName,$endName,$date,$time);
		
		
		
		if($var != null)
		{
		
		return view('triproutes') ->with ('ssdsd' , $var)->with ('dest', $dest);
		
	
		}
		
		 else if($var==null){
			return redirect()->route ('home')->with ('message', 'No such Trip found for the given criteria');
		
	}
			
	
	}	
	
	//arrival of customer data
	public function postCustomerData(Request $request){
		
		$this->validate($request, [	
		'nic' => 'required',
		'name' => 'required',
		'email'=>'required',
		'telephone'=>'required',
		'payMethod'=>'required',
		'token'=>'required'
		
		]);

		$nic = $request['nic'];
		$name =$request['name'];
		$email =$request['email'];
		$telephone= $request['telephone'];
		$payment =$request['payMethod'];
		$token =$request['token'];
			
		
		
		$setCustomerData = new functions();
		$expState=$setCustomerData->setCustomerData($nic,$name,$email,$telephone,$payment,$token);
		
		if($expState=="1")
		{
		return redirect()->route ('home')->with ('message', 'Thank you for your booking');
		}
		
		else if($expState=="0")
		{
		return redirect()->route ('home')->with ('messageEXP', 'Booking has expired');
		}
		
		else if($expState=="2")
		{
		return redirect()->route ('home')->with ('message', 'Thank you...You have already booked');
		}

		
		
		}
		
		
					
		function setBook(Request $request){

			//user chooses the bus ID that he is travelling on but as the trip_ID is unique we can deal with tripID
			
			
				$this->validate($request, [	
				'passemail' => 'required',
				]);
			
			
			$email=$request['passemail'];
			$seat_no = $request['seat_no'];
			$tripID=$request['tripID'];
			$start_city=$request['startCity'];
			$end_ccity=$request['endCity'];
			$p_price=$request['price'];
     
	 

		$tempRes= new functions();
		$reqID=$tempRes->reserveTempSeats($tripID,$seat_no,$start_city,$end_ccity,$p_price);
		$userVerification = array(
    		'Name'  => 'Dear Customer',
    		'email' => $email,
			'token'=> $reqID
			);
		Event::fire(new emailVerify($userVerification));
		return view ('order')-> with('requestID',$reqID)-> with('email',$email);
			
		}
		
		
	public function returnView($trip_ID,$start_city,$end_city)
		{
 
		$priceFunc = new dataconnection();
		$price=$priceFunc->priceCalc($trip_ID,$start_city,$end_city);
  		return View ('book')->with('trip_ID',$trip_ID)->with('start_city',$start_city)->with('end_city',$end_city)->with('price',$price);
		}
		
		
		public function checkCity(Request $request)
		
		{	$cityname = $request['datafile'];
			$checkCity = new dataconnection();
			$result = $checkCity->checkCity($cityname);
			echo $result;
		}
		
		public function getCity (Request $request)
		{
			$cityname  = $request['result'];
			$getCity = new dataconnection();
			$result = $getCity->getCity($cityname);
			echo $result;
		}
		
		public function cityenter(Request $request)
		
		{
			$cityId = $request['dataset1'];
			$cityName = $request['dataset2'];
			$addCity = new dataconnection();
			$result = $addCity->addCity($cityName,$cityId );
			echo $result;
			
		}
		
		
		public function getseats(Request $request)
		
		{
			$tripID = $request['tripID'];
			$seatsArrange = new dataconnection();
			$result = $seatsArrange->seatsArrange($tripID);
			echo $result;
			
		}
		



	
}

?>