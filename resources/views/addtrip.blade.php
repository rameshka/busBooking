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
<link rel="stylesheet" href="{{URL::asset('main_window/css/cityfinder.css')}}">
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
    <div class="link-blue"> <a href="{{route('addbus')}}"> <i class="fa fa-picture-o"></i>Add bus </a> </div>
    <div class="link-red selected"> <a href="{{route('addtrip')}}"> <i class="fa fa-heart-o"></i>Add trip </a> </div>
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
    <li class="resp-tab-item"><span style="color:#000000">Add trip</span></li>
  </ul>
  <div class="clearfix"> </div>
  <div class="resp-tabs-container">
    <form action='{{route('addtripdata')}}' method="post">
      <div class='clear'>
        <h3> Bus no</h3>
        <div id="result" style="width:374px;"></div>
        <input type="text" autocomplete="off" placeholder="ID" name="bus_no" id="ID" required/>
        </div>
      <div class="date">
      <br>	
        			<h3>Date</h3>
        				<input  name="date" type="date" value="dd-mm-yyyy" min="<?php echo date("Y-m-d"); ?>">
      		</div>
      		<div class="clear"></div>
      <div class='clear'>	
      <h3> Trip Route</h3>
     <select name="routecheck" id="routecheck">
  		<option>Choose Route Number</option>
  		<?php	
    	foreach($routes as $route) { ?>
      	<option value="<?= $route['route_no'] ?>" data-time="<?= $route['timeinterval'] ?>" data-row ="<?= $route['name'] ?>" data-catch ="<?= $route['ID'] ?>"><?= $route['route_no'] ?></option>
  		<?php
    	} 	?>    	
		</select></br>
        </div>
       <input type="hidden" autocomplete="off" placeholder="ID" name="route" id="route" required/>
       <div class='clear'>
      <br>
       <h3>Start Time </h3>
        <select id="start" name='start'> Choose Route Number </select></br>
    	</div>
        <div class='clear'>
      <br>
      <h3>  End Time</h3>
        <label id="end" name='end' style="color:#F0FF00" ></label>
       <input type="text" id="endfiled" placeholder="coding" name="end" required hidden=""/><br>
      </div>
          <div class='clear' id="optionButton" hidden="">
      <br>
      <input type="radio" name="direction" id="forwardOpt" value="positive" /><label id ="forward" style="color:#FFCE00;"></label>&nbsp;&nbsp;
      <input type="radio" name="direction" id="backwardOpt" value="negative"/><label id ="backward" style="color:#FFCE00;"></label>
      </div>
      <input type="hidden" name="_token" value="{{ Session::token() }}">
      <div class ="centerone" style="text-align:center">
      <input type="submit" value="Add bus">
      </div>
    </form>
  </div>
</div>

<script>
$( document ).ready(function(){
$("#ID").keyup(function() 
{ 

var searchid = $(this).val();
var dataString = searchid;
var token = $('meta[name="_token"]').attr('content');
var url1='{{route("busnumpick")}}';
if(searchid!='')
{
    $.ajax({
    type: "POST",
    url: url1 ,
    data: { _token:token , 'datafile':dataString },
    cache: false,
    success: function(html)
    {
		console.log(html);	
    $("#result").html(html).show();
    }
    });
}return false;    
});
jQuery("#result").on("click",function(e){ 
    var $clicked = $(e.target);
    var $name = $clicked.find('.name').html();
    var decoded = $("<div/>").html($name).text();
    $('#ID').val(decoded);
});
jQuery(document).on('click',  function(e) { 
    var $clicked = $(e.target);
    if (! $clicked.hasClass("searchBus")){
    jQuery("#result").fadeOut(); 
    }
});
});

$('#routecheck').change(function(){
	var check = jQuery(jQuery("#routecheck option")[this.selectedIndex]).data("row");
	var RID = jQuery(jQuery("#routecheck option")[this.selectedIndex]).data("catch");
	$('#optionButton').show();
	$('#forward').html(check);
	var array1 = check.split('-');
	var check2= array1[1]+'-'+array1[0];
	$('#backward').html(check2);
	$('#route').val(RID);
	console.log(jQuery(jQuery("#routecheck option")[this.selectedIndex]).data("catch"));
});

var selectedInterrval;
jQuery("#routecheck").on('change',function(e){
	document.getElementById("start").innerHTML = "";
	selectedInterrval = jQuery(jQuery("#routecheck option")[this.selectedIndex]).data("time");
	for (i = 0; i <=24; i+=selectedInterrval) { 
    	var html = "<option value=" + i + ">" + i+':00h' + "</option>";
		$("#start").append(html);
	}
});
jQuery("#start").on('change',function(e){
	$("#end").empty();
	var tempstart = document.getElementById("start");
	var start = tempstart.options[tempstart.selectedIndex].text;
	var endTime = parseInt(start)+parseInt(selectedInterrval);
	var html = endTime+':00h';
	$('#endfiled').val(html);
	$("#end").append(html);
});

</script>

<script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/1.8.0/jquery.min.js'></script> 
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
</body>
</html>
