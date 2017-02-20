<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="_token" content="{{ csrf_token() }}">
<title>Admin view</title>
<link rel="stylesheet" href="{{URL::asset('admin_window/css/style.css')}}">
<link rel="stylesheet" href="{{URL::asset('main_window/css/jquery-ui.css')}}">
<link rel="stylesheet" href="{{URL::asset('admin_window/css/header-user-dropdown.css')}}">
<link rel="stylesheet" href="{{URL::asset('admin_window/css/sidebar-collapse.css')}}">
<link href='https://fonts.googleapis.com/css?family=Cookie' rel='stylesheet' type='text/css'>
<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css">
<script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/1.8.0/jquery.min.js'></script>
<script src="{{URL::asset('main_window/js/jquery.min.js')}}"></script>
<script src="{{URL::asset('main_window/js/jquery.min.js')}}"></script>
<script src="{{URL::asset('admin_window/js/sidebar.js')}}"></script>
</head>

<body>
<header class="header-user-dropdown">
  <div class="header-limiter">
    <h1 style="color:#FFFFFF">Online Bus Ticketing System</h1>
    <nav>User :  <b><?php echo Auth::user()->username; ?></b>  ||  Logged as : <b><?php echo Auth::user()->usertype; ?>  </b> </nav>
    <div class="header-user-menu"> <img src="{{URL::asset('images/bus.png')}}" alt="User Image"/>
      <ul>
        <li><?php echo Auth::user()->username; ?></li>
        <li><a href="{{route('SignOut')}}" class="highlight">Logout</a></li>
      </ul>
    </div>
  </div>
</header>
<aside class="sidebar-left-collapse">
  <div class="sidebar-links">
    <div class="link-blue selected"> <a href="{{route('addbus')}}"> <i class="fa fa-picture-o"></i>Add bus </a> </div>
    <div class="link-red"> <a href="{{route('addtrip')}}"> <i class="fa fa-heart-o"></i>Add trip </a> </div>
    <div class="link-yellow"> <a href="{{route('busownerdashboard')}}"> <i class="fa fa-keyboard-o"></i>View Bus</a> </div>
  </div>
</aside>

<div style=" margin-left:500px; margin-top:30px; margin-bottom:60px; background-color:rgba(0, 0, 0, 0.8); width:400px;">	
		@if(Session::has('message'))
				<div class ="row">
					<div class="col-md-6">
						<ul>
                        			<div class="my-notify-error" style="text-align:center; color:#00FB2C;">Success!!!</div>
						
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
                        			<div class="my-notify-error" style="text-align:center; color:#FF0004">Error!!!</div>
							@foreach($errors->all() as $error)
							
                                <div class="my-notify-error" style="text-align:center; color:#FF0004">{{$error}}</div>
							@endforeach
                         
						</ul>
					</div>
				</div>
			@endif
</div>

<div class="main-agileinfo" id="addbusowner" style="width:450px;">
  <ul class="resp-tabs-list">
    <li class="resp-tab-item"><span style="color:#000000">Add bus</span></li>
  </ul>
  <div class="clearfix"> </div>
  <div class="resp-tabs-container">
  <form action='{{route('owneraddnewbus')}}' method="post">
      <div class='clear'>
        <h3> Bus ID</h3>
        <input type="text" autocomplete="off" placeholder="ID" name="bus_ID" id="bus_ID" required/>
      </div>
      <div class='clear'>
      <br>
      <h3> No of Seats</h3>
      <input type="text" autocomplete="off" placeholder="No of seats" name="no_ofseats" id="no_ofseats" required/>
      </div>
        <div class='clear'>
        <br>
        <h3> Conductor ID</h3>
        <input type="text" autocomplete="off" placeholder="ID" name="conductorID" id="conductorID" required/>
      </div>
      <div class='clear'>
      <br>
      <h3> Conductor Password</h3>
      <input type="password" style="height:35px; width:390px;" id="password1" placeholder="Password" name="password1" required/>
      </div>
      <div class='clear'>
      <br>
      <h3> Password Reenter</h3>
      <input type="password" style="height:35px; width:390px;" id="password2" placeholder="Password" name="password2" required/>
      <div class="passwordntM" id="passwordntM" style="color:#D8FF00"></div>
      </div>
      <input type="hidden" name="_token" value="{{ Session::token() }}">
      <div class ="centerone" style="text-align:center">
      <input type="submit" value="Add bus">
      </div>
    </form>
  </div>
</div>

<script>
$(document).ready(function() {
  $("#password2").keyup(validate);
  $("#password1").keyup(validate);
});


function validate() {
  var password1 = $("#password1").val();
  var password2 = $("#password2").val();

    
 
    if(password1 == password2) {
       $("#passwordntM").text('Passwords match');        
    }
    else {
        $("#passwordntM").text('Passwords not match');  
    }

    
}

</script>

<script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/1.8.0/jquery.min.js'></script> 
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
</body>
</html>
