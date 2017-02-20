<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/home', function () {
    return view('welcome');
})->name('home');

Route::post('/checkcity1',  function () {
  echo 'dsds';
    //return response ()->json ($response);
})->name('checkcity1');

Route::post('/SignIn', [
    	'uses' => 'UserController@SignIn',
		'as' => 'SignIn'
		]);

Route::get('/SignOut', [
    	'uses' => 'UserController@SignOut',
		'as' => 'SignOut'
		]);

/////admin routes - test,addroute,viewbusowner,viewroutes

Route::get('/admindashboard', [
    	'uses' => 'UserController@admindashboard',
		'as' => 'admindashboard'
		])->middleware('auth');
		
//////////////// admin Navigation routes

Route::get('/addbusowners', [
    	'uses' => 'UserController@admindashboard',
		'as' => 'addbusowners'
		])->middleware('auth');

Route::get('/addroutes', [
    	'uses' => 'UserController@addroutes',
		'as' => 'addroutes'
		])->middleware('auth');
		
Route::get('/busowners', [
    	'uses' => 'UserController@getbusowners',
		'as' => 'busowners'
		])->middleware('auth');
		
Route::get('/getrouets', [
    	'uses' => 'UserController@getrouets',
		'as' => 'getrouets'
		])->middleware('auth');
		
Route::get('/addtrip', [
    	'uses' => 'UserController@addtrip',
		'as' => 'addtrip'
		])->middleware('auth');

Route::post('/addtripdata',[
		'uses' => 'UserController@getTripsdata',
		'as' => 'addtripdata'
		])->middleware('auth');

Route::post('/busnumpick',[
    'uses' =>'UserController@busnumpick',
    'as' =>'busnumpick']);
		
		
////// Admin dashboard routes	
Route::post('/enterBusOwnerData', [
    	'uses' => 'UserController@enterBusOwnerData',
		'as' => 'enterBusOwnerData'
		]);
		
Route::post('/createRoute', [
    	'uses' => 'UserController@createRoute',
		'as' => 'createRoute'
		]);

Route::post('/owneraddnewbus',[
		'uses' => 'UserController@owneraddnewbus',
		'as' => 'owneraddnewbus'
		])->middleware('auth');


			

////// Conductor routes- pages conductor, ticketCheck
Route::get('/conductordashboard', [
    	'uses' => 'UserController@conductordashboard',
		'as' => 'conductordashboard'
		])->middleware('auth');

/////////// conductor navigation routes

Route::get('/getorderID/{tep}', [
    	'uses' => 'UserController@getOrderID',
		'as' => 'getOrderID'
		])->middleware('auth');
		
 Route::post('/getMID',[
        'uses'=>'UserController@getMID',
        'as'=>'getMID'
    ])->middleware('auth');;

/////// Bus Owner Routes pages busowner,tripresults,bus,owneraddbuss
Route::get('/busownerdashboard', [
    	'uses' => 'UserController@busownerdashboard',
		'as' => 'busownerdashboard'
		])->middleware('auth');
		
/////////////// bus owner navigation routes		
Route::get('/addbus', [
    	'uses' => 'UserController@addbus',
		'as' => 'addbus'
		])->middleware('auth');

Route::get('/getbusorderID/{tep}', [
    	'uses' => 'UserController@getbusOrderID',
		'as' => 'getbusOrderID'
		])->middleware('auth');
		
Route::get('/getTrips/{tep}', [
    	'uses' => 'UserController@getTrips',
		'as' => 'getTrips'
		])->middleware('auth');

Route::get('/addtrip', [
    	'uses' => 'UserController@addtrip',
		'as' => 'addtrip'
		])->middleware('auth');
		

		

/////////////////RedirectBack Home	
Route::get('/homeenter', [
    	'uses' => 'UserController@homeenter',
		'as' => 'homeenter'
		]);


/////////////////////Ajax Routes 


Route::post('/checkCity', [
    	'uses' => 'UserController@checkCity',
		'as' => 'checkcity'
		]);

Route::post('/getCity', [
    	'uses' => 'UserController@getCity',
		'as' => 'getCity'
		]);
		
Route::post('/cityenter', [
    	'uses' => 'UserController@cityenter',
		'as' => 'cityenter'
		]);
		
Route::post('/getseats', [
    	'uses' => 'UserController@getseats',
		'as' => 'getseats'
		]);

Route::post('/cityfinder', [  
		'uses' => 'UserController@cityfinder',
		'as' => 'cityfinder'
		]);
		


//////////////////////////////////////////////////////////////////////////////////	

		//send chosen cities
	Route::post('/senddata', [
    	'uses' => 'UserController@postsenddata',
		'as' => 'senddata'	//route name
		]);		
		
Route::get('/order', function () {
    return view('order');
	})->name('order');	


Route::get('/book/{trip}/{sCity}/{eCity}', [
		'uses' =>'userController@returnView',
		'as' => 'book']);

		
	Route::get('/homesep', [
    	'uses' => 'UserController@gethome',
		'as' => 'homesep'	//route name
		]);	
		
		

		
	
		//send customer data	
Route::post('/customerdata', [
    	'uses' => 'UserController@postCustomerData',
		'as' => 'customerdata'	//route name
		]);	
		
	//start booking 	
	Route::post('/booknow', [
    'uses' => 'UserController@setBook',
	'as' => 'booknow'	//route name
	]);		
		
		
		