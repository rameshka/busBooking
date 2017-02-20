<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name = "_token" content= "{{csrf_token()}}">
<title>Online Bus Ticketing System</title>


<link href='https://fonts.googleapis.com/css?family=Cookie' rel='stylesheet' type='text/css'>
<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css">
<link rel="stylesheet" href="{{URL::asset('main_window/css/style.css')}}">
<link rel="stylesheet" href="{{URL::asset('main_window/css/jquery-ui.css')}}" />
<link rel="stylesheet" href="{{URL::asset('main_window/css/sidebar-left.css')}}">
<link rel="stylesheet" href="{{URL::asset('main_window/css/cityfinder.css')}}">


<script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/1.8.0/jquery.min.js'></script>
<script src="{{URL::asset('main_window/js/jquery.min.js')}}"></script>
<script src="{{URL::asset('main_window/js/jquery-ui.js')}}"></script>

<script src="{{URL::asset('main_window/js/sidebar.js')}}"></script>


<style>
    #result1
    {
        position:absolute;
        width:250px;
        padding:10px;
        display:none;
        margin-top:30px;
        border-top:0px;
        overflow:hidden;
        border:1px #CCC solid;
        background-color: white;
    }

</style>


</head>

<body>


<div class="wrapper">
  <div class="nav" id="iid"> <i class="fa fa-info-circle" id="outi" aria-hidden="true"></i> </div>
  	<aside class="sidebar-left" >
    	<div class="sidebar-links"> 
        	<a class="link-blue selected" id="searchBt"><i class="fa fa-search"></i>Search</a> 
            <a class="link-red" id="SignInBt"><i class="fa fa-envelope-o"></i>SignIn</a> 
            <a class="link-yellow" id="SignUpBt"><i class="fa fa-sign-in"></i>SignUp</a> 
            <a class="link-green" id="Pre-Reservation"><i class="fa fa-ticket"></i>Pre-Reservation</a> 
         </div>
  </aside>
</div>

	
<h1>Online Bus Booking</h1>
<div style=" margin-left:500px; margin-top:30px; margin-bottom:60px; background-color:rgba(0, 0, 0, 0.8); width:400px;">	
		@if(Session::has('messageEXP'))
				<div class ="row">
					<div class="col-md-6">
						<ul>
                        			<div class="my-notify-error" style="text-align:center; color:#FF0004;"></div>
						
                                <div class="my-notify-error" style="text-align:center; color:#FF0004;">{{ Session::get('messageEXP') }}</div>
					
                         
						</ul>
					</div>
				</div>
			@endif
</div>
<div style=" margin-left:500px; margin-top:30px; margin-bottom:60px; background-color:rgba(0, 0, 0, 0.8); width:400px;">	
		@if(Session::has('message'))
				<div class ="row">
					<div class="col-md-6">
						<ul>
                        			<div class="my-notify-error" style="text-align:center; color:#00FB2C;"></div>
						
                                <div class="my-notify-error" style="text-align:center; color:#00FB2C;">{{ Session::get('message') }}</div>
					
                         
						</ul>
					</div>
				</div>
			@endif
</div>
  <div style=" margin-left:500px; margin-top:30px; margin-bottom:60px; background-color:rgba(0, 0, 0, 0.8); width:400px;">	
		@if(count($errors) >0)
				<div class ="row">
					<div class="col-md-6">
						<ul>
							@foreach($errors->all() as $error)
							
                                <div class="my-notify-error" style="text-align:center; color:#FF0004">{{$error}}</div>
							@endforeach
                         
						</ul>
					</div>
				</div>
			@endif
</div>
<div class="main-agileinfo" id="search">
  <ul class="resp-tabs-list">
    <li class="resp-tab-item"><span style="color:#000000">Search Bus</span></li>
  </ul>
  <div class="clearfix"> </div>
  	<div class="resp-tabs-container">
    	<form action='{{route('senddata')}}' method="post">
      		<div class="from">
        		<h3>From</h3>
        			<div id="result"></div>
        				<input type="text" name="startName" id="searchid" class="city1 search" placeholder="Departure City" required="" autocomplete="off">
      				</div>
      		<div class="to">
        		<h3>To</h3>
        				<input type="text" id="searchid1" class="city1 search1" placeholder="Destination City" name="endName" required="" autocomplete="off">
        			<div id="result1"></div>
      		</div>
      		<div class="clear"></div>
      		<div class="date">
        			<h3>Date</h3>
        				<input  name="date" type="date" value="dd-mm-yyyy"  min="<?php echo date("Y-m-d"); ?>">
                        
      		</div>
      		<div class="clear"></div>
      			<div>
        			<h3>Time</h3>
        				<input type="time" name="time">
      			</div>
      		<div class="clear"></div>
      			<input type="submit" value="Search Bus">
      			<input type="hidden" name="_token" value = "{{Session::token()}}">
    	</form>
  </div>
</div>





<div class="main-agileinfo" style="width:400px" id ="signIn" hidden="">
  <ul class="resp-tabs-list">
    <li class="resp-tab-item"><span style="color:#000000">SignIn</span></li>
  </ul>
  <div class="clearfix"> </div>
  <div class="resp-tabs-container">
    <form action='{{route('SignIn')}}' method="post">
      <div class="clear">
        <h3>Username </h3>
        <input id="user"  name = "username" type="text" class="username" required="" autocomplete="off">
      </div>
      <div class="clear"> <br>
        <h3>Password</h3>
        <input id="pass" name = "password" type="password" class="pass"  required="" autocomplete="off" style="height:30px; width:345px;">
      </div>
      <div style="text-align: center;">
        <input type="submit" value="SignIn">
      </div>
      <input type="hidden" name="_token" value = "{{Session::token()}}">
    
    </form>
  </div>
</div>




<div class="main-agileinfo" style="width:400px" id="signUp" hidden="">
  <ul class="resp-tabs-list">
    <li class="resp-tab-item"><span style="color:#000000">SignUP</span></li>
  </ul>
  <div class="clearfix"> </div>
  <div class="resp-tabs-container">
    <form action='' method="post">
      <div class="clear">
        <h3>Username </h3>
        <input id="user"  name = "username" type="text" class="username" required="" autocomplete="off">
      </div>
      <div class="clear"> <br>
        <h3>Password</h3>
        <input id="pass" name = "password" type="password" class="pass"  required="" autocomplete="off" style="height:30px; width:345px;">
      </div>
      <div style="text-align: center;">
        <input type="submit" value="SignUp">
      </div>
      <input type="hidden" name="_token" value = "{{Session::token()}}">
    </form>
  </div>
</div>


<div class="main-agileinfo" id="Reservation" hidden="">
  <ul class="resp-tabs-list">
    <li class="resp-tab-item"><span style="color:#000000">Continue Reservation</span></li>
  </ul>
  <div class="clearfix"> </div>
  	<div class="resp-tabs-container">
    	<form action='{{route('customerdata')}}' method="post" id="form3">
          
       
      		<div class="from">
             <h3>Name</h3>
        				<input type="text"id="inputName" name="name" placeholder="Name" required="">
      				</div>
                    
      		<div class="to">
            <h3>NIC</h3> 
        		<input type="text"  id="nic"   name="nic" placeholder="NIC number" required="">
      		</div>
 	 	<div class="from">
         <h3>Email</h3>
    	<input type="text"  name="email" placeholder="Email" id="email" value=""  required="">
 		 </div>
    <div class="to">
     <h3>Telelphone</h3>
    <input type="text"  name="telephone" placeholder="Telephone" required="">
     </div>
	  <div class="from">
      <h3 style="color:#FFFFFF">Find your Token from Reservation Email </h3>
       <h3>Token</h3>
    <input name="token" id="token" placeholder="Token" type="text"  value="" required="">
  </div>
  
  <div class="from">
  <h3> Payment Method</h3>
      <div class="radio">
      <label style="color:#FFFFFF; font-style:oblique">
        <input type="radio" name="payMethod" value="Visa">
        Visa </label>
    <label style="color:#FFFFFF; font-style:oblique">
        <input type="radio" name="payMethod" value="Visa">
       Paypal </label>
    </div>
    <div class="radio">
     
    </div>
  </div>
			
            <div class="clear" style="text-align:center">
     
      			<input type="submit" value="Contibue Booking">
                
      			<input type="hidden" name="_token" value = "{{Session::token()}}">
                </div>
    	</form>
  </div>
</div>



<script src="{{URL::asset('main_window/js/datepicker.js')}}"></script>
<script src="{{URL::asset('main_window/js/nav.js')}}"></script>
<script>
$(function(){
$(".search").keyup(function() 
{ 
var searchid = $(this).val();
var dataString = searchid;
var token = $('meta[name="_token"]').attr('content');
var url1='{{route("cityfinder")}}';
if(searchid!='')
{
    $.ajax({
    type: "POST",
    url: url1 ,
    data: { _token:token , 'datafile':dataString },
    cache: false,
    success: function(html)
    {
    $("#result").html(html).show();
    }
    });
}return false;    
});

jQuery("#result").on("click",function(e){ 
    var $clicked = $(e.target);
    var $name = $clicked.find('.name').html();
    var decoded = $("<div/>").html($name).text();
    $('#searchid').val(decoded);
});
jQuery(document).on('click',  function(e) { 
    var $clicked = $(e.target);
    if (! $clicked.hasClass("search")){
    jQuery("#result").fadeOut(); 
    }
});

});


///////////////////////////////////
$(function(){
$(".search1").keyup(function() 
{ 
var searchid = $(this).val();
var dataString =searchid;
var token = $('meta[name="_token"]').attr('content');
var url1='{{route("cityfinder")}}';

if(searchid!='')
{
    $.ajax({
    type: "POST",
    url: url1,
    data:  { _token:token , 'datafile':dataString },
    cache: false,
    success: function(html)
    {
		$("#result1").show();
    $("#result1").html(html).show();
    }
    });
}
else {$("#result1").hide();
	}return false;    
});

jQuery("#result1").on("click",function(e){ 
    var $clicked = $(e.target);
    var $name = $clicked.find('.name').html();
    var decoded = $("<div/>").html($name).text();
    $('#searchid1').val(decoded);
});
jQuery(document).on('click',  function(e) { 
    var $clicked = $(e.target);
    if (! $clicked.hasClass("search1")){
    jQuery("#result1").fadeOut(); 
    }
});

});
</script>



</body>
</html>
