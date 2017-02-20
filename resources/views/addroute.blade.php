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
<aside class="sidebar-left-collapse" style="height:200%">
  <div class="sidebar-links">
    <div class="link-blue"> <a href="{{route('addbusowners')}}"> <i class="fa fa-picture-o"></i>Add bus owner </a> </div>
    <div class="link-red selected"> <a href="{{route('addroutes')}}"> <i class="fa fa-heart-o"></i>Add route </a> </div>
    <div class="link-yellow"> <a href="{{route('busowners')}}"> <i class="fa fa-keyboard-o"></i>View Bus owners </a> </div>
    <div class="link-green"> <a href="{{route('getrouets')}}"> <i class="fa fa-map-marker"></i>View Routes </a> </div>
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
<div class="main-agileinfo" id="addroute" style="width:800px;">
  <ul class="resp-tabs-list">
    <li class="resp-tab-item"><span style="color:#000000">Add new route</span></li>
  </ul>
  <div class="clearfix"> </div>
  <div class="resp-tabs-container">
 
 
    <div >

   <form id="reg-form" action="" method="" autocomplete="off">
   <h3 style="font-size:140%;"> Add a new city </h3>
   <hr>	
 <br>
      <div class='clear'>
        <h3> City Name</h3>
        <input type="text" name="cityname" id="cityname" placeholder="Username" style="width:400px;" />
    	<input type="hidden" name="_token" id='token' value="{{ Session::token() }}">
        </div>
         <div class='clear'>
   <span class="ajaxcity" id="resultnum"></span> 
      </div>
    </form>
      <div class='from'>
      <br>	
      <h3 style="margin-left:30px;"> City ID</h3>
      <input type="text" name="cityid" id="cityid" placeholder="CityID" style="margin-left:25px;width:400px;"/>
      <input type="submit" id="addCity" value="Add City" style="margin-left:25px;">
      <div style="margin-left:200px; margin-top:-30px;" id="result"> </div>
      <br>
      </div>
  
  <form id ="createRoute" action='{{route('createRoute')}}' method="post">
  <div class="clear">
         <h3 style="font-size:140%;"> Add a new route </h3>
   <hr>	
   </div>
    <div class='clear'>
    <br>
        <h3> Route ID</h3>
  <input type="text" placeholder="Route ID " name="routeID" id="routeID" required/>
  </div>
    <div class='clear'>
    <br>
        <h3> Route Number</h3>
  <input type="text" placeholder="Route Number " name="routeNo" id="routeNo" required/>
  </div>
    <div class='clear'>
    <br>
        <h3> Route Name</h3>
  <input type="text" placeholder="Route Name" name="routeName" id="routeName" required/>
  </div>
    <div class='clear'>
    <br>
        <h3> Time Interval</h3>
  <input type="text" placeholder="Time Interval" name="timeInterval" required/>
  </div>
    <div class='clear'>
    <br>
    <h4 style="color:#FCF30C;"> Add cities to route </h4>
    <hr>
 <button class="addbutton" id = "add">Add City</button>
  </div>
  <fieldset id="screens">
    <input type="hidden" name="_token" value="{{ Session::token() }}">
    <input type="hidden" id="numberofCities" name="numberofCities">
    <input type="hidden" id ="numberofmappings" name="numberofmappings">
  </fieldset>
  <br>
  <h4 style="color:#FCF30C;"> Add distance cost to route </h4>
    <hr>
  <button class="addbutton" id = "addDistentCost" >Add Distance-Cost</button>
  
  <fieldset id="DistentCost">
  </fieldset>
  <div class ="Center" style="text-align:center">
   <button class="endbutton" id = "addRoute"  >Add Route</button>
   </div>
</form> 

  </div>
</div>
  
<br>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script> 
<script type="text/javascript" src="https://code.jquery.com/jquery-1.4.1.js"></script> 
<script type="text/javascript">

$(document).ready(function() {
    var max_fields      = 10; //maximum input boxes allowed
    var wrapper         = $("#screens"); //Fields wrapper
    var add_button      = $("#add"); //Add button ID
    
    var x = 0; //initlal text box count
 	var y = 0;
	var autocomp_opt={
	
         source: function(request, response) {
			 var availableAttributes=[]
			 var result =request.term;
			 var url1 = "{{route('getCity')}}";
			 var token = $('meta[name="_token"]').attr('content');
            $.ajax({
                type : 'POST',
    			url  : url1,
    			data : {_token:token, 'result':result},
                success: function(data) {
					availableAttributes[0]= data;	
				response(availableAttributes );
	 
                }
            })
	
       },
        minLength: 2,
 
    };

    $(add_button).click(function(e){ //on add input button click
        e.preventDefault();
        if(x < max_fields){ //max input box allowed
             //text box increment
            $(wrapper).append('<div class ="parent"><div class ="from" style="width:90px; margin-top:20px; "><h3> City no '+ x +'</h3> </div> <div class ="to" style ="margin-top:10px; width:550px;	"><input type="text" style=" width:400px;" name="cityNum_'+ x +'" id="cityNum_'+ x +'" />&nbsp;&nbsp;&nbsp;<i class="fa fa-times-circle-o" id="remove_field" style="cursor:pointer; margin-top:7px; color:red; font-size: 150%;"></i></div><div class ="clear"></div></div>'); 
            
            $(wrapper).find('input[type=text]:last').autocomplete(autocomp_opt);	
            x++;//add input box
        }
    });
    $(wrapper).on("click","#remove_field", function(e){ //user click on remove text
        e.preventDefault(); $(this).parent('div').parent('div').remove(); x--;
    })    
    $("input[name^='mytext']").autocomplete(autocomp_opt);	

$('#addDistentCost').click(function(e){ //on add input button click
        e.preventDefault();
        if(y < max_fields){ //max input box allowed
             //text box increment
			 z1=y+1;
            $('#DistentCost').append('<div class ="parent"><div class ="from" style="width:90px; margin-top:20px; "><h3> Cost map  '+ z1 +'</h3> </div> <div class ="to" style ="margin-top:10px; width:550px;"> <input type="text" style=" width:400px;" name="mapNum_'+ y +'" id="mapNum_'+ y +'" />&nbsp;&nbsp;&nbsp;<i class="fa fa-times-circle-o" id="remove_field" style="cursor:pointer; margin-top:7px; color:red; font-size: 150%;"></i></div><div class ="clear"></div></div>'); 
            
            //$('#DistentCost').find('input[type=text]:last').autocomplete(autocomp_opt);	
           y++; //add input box
        }
    });
    $('#DistentCost').on("click","#remove_field", function(e){ //user click on remove text
        e.preventDefault(); $(this).parent('div').parent('div').remove(); y--;
    })    
    $("input[name^='mytext']").autocomplete(autocomp_opt);	


$('#addRoute').click(function()
{    
document.getElementById('numberofCities').value= x ;
document.getElementById('numberofmappings').value= y ;
var form = document.getElementById('createRoute');
if (form.checkValidity() == true)
{
form.submit();
}
});

});
</script> 
<script type="text/javascript">
$(document).ready(function()
{    
$("#cityname").keyup(function()
 {  
  var name = $(this).val(); 
  console.log(name);
  if(name.length > 2)
  {  var url1 = '{{route("checkcity")}}';
   $("#resultnum").html('checking...');
   var token = $('meta[name="_token"]').attr('content');
   $.ajax({
    type : 'POST',
    url  : url1,
	cache:false,
    data :{	_token:token, 'datafile':name},
	success : function(data)
        {
              $("#resultnum").html(data);
			  console.log(data);
           }
    });
    return false;
  }
  else
  {
   $("#result").html('');
  }
 }); 
});
</script> 
<script type="text/javascript">
 $('#addCity').click(function addCity()
 {  
 if (document.getElementById('cityname').value=="" ||  document.getElementById('cityid').value=="")
 {alert('please enter required fields');
	}
else {
  var name = $("#cityname").val(); 
 
  	var cityID = $("#cityid").val();
	var cityname = name;
	console.log(name);
	var url1= "{{route('cityenter')}}";
  var dataset1 = cityID 
  var dataset2 = cityname ;
     var token = $('meta[name="_token"]').attr('content');
   console.log(cityname);
   $.ajax({
    
    type : 'POST',
    url  : url1,
    data : {_token:token,'dataset1':dataset1,'dataset2':dataset2 },
    success : function(data)
        {
              $("#result").html(data);
			  document.getElementById('cityname').value="";
			  document.getElementById('cityid').value="";
			  document.getElementById('resultnum').value="";
			   $("#result").html(data);
           }
    });
    return false;
}
 
 });
 </script> 

<script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/1.8.0/jquery.min.js'></script> 
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
</body>
</html>
