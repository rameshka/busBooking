<?php
  $tripID = $trip_ID;
  $startCity=$start_city;
  $endCity=$end_city;
  $p_price=$price;
  

  
   // return view ('book')->with('tripIDPass',$phpvari);
  //$tripID = '1923';

  ?>
<html>
<head>
<title>Booking</title>
<meta name="_token" content="{{ csrf_token() }}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="{{URL::asset('bookweb/css/seats.css')}}">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

</head>

<body>
<nav class="navbar navbar-inverse">
  <div class="container-fluid">
    <div class="navbar-header"> <a class="navbar-brand" href="#">Online Bus Booking</a> </div>
  </div>
</nav>
<div class="container">
  <hr>
  <!-- Begin of rows -->
  <div class="row carousel-row">
    <div class="col-xs-8 col-xs-offset-2 slide-row">
      <div class="carousel-inner">
        <div class="item active"> <img src="{{URL::asset('bookweb/images/bus1.jpg')}}" alt="Image"> </div>
      </div>
      <div class="slide-content">
        <h4 style="text-align:center;font-family:Gotham, 'Helvetica Neue', Helvetica, Arial, sans-serif;font-size:24px">Continue with booking</h4>
        <p> </p>
      </div>
      <div class="slide-footer"> <span class="pull-right buttons">
        <button class="btn btn-sm btn-default" id="btnseats" ><i class="fa fa-fw fa-eye"></i> View seats</button>
        </span> </div>
    </div>
    
    <!------------form1 starts--------------->
    <div class="row carousel-row" hidden=""  id="formseats">
      <div class="col-xs-8 col-xs-offset-2 slide-row">
        <form action='{{route('booknow')}}' method="post" id="form1">
          <h2 style="font-size:1.2em;"> Choose seats by clicking the corresponding seat in the layout below:</h2>
          <div id="holder">
            <ul  id="place">
            </ul>
          </div>
          <div style="width:600px;text-align:center;overflow:auto">
            <ul id="seatDescription">
              <li id ="available_seat">Available Seat</li>
              <li id="booked_seat">Booked Seat</li>
              <li id="selected_seat">Selected Seat</li>
            </ul>
          </div>
          <div style="width:300px;text-align:center;margin:5px">
            <input type="button" id="btnShowNew" value="Show Selected Seats" class="btn btn-sm btn-default"  />
            <input type="button" id="btnShow" value="Show All" class="btn btn-sm btn-default" />
          </div>
          
          <!--div class="slide-footer">
				  <span class="pull-right buttons">
				  <br>
			  <button class="btn btn-sm btn-default" ><i class="fa fa-bus"></i> Book Seats</button>
  
				  </span>
			  </div-->
          <input type="hidden" name="_token" value = "{{Session::token()}}">
          <input type="hidden" id="myField" name="seat_no" value="" />
          <input type="hidden" name="tripID" value=<?php echo $tripID; ?>/>
          <input type="hidden" name="startCity" value='<?php echo $startCity; ?>'/>
          <input type="hidden" name="endCity" value='<?php echo $endCity; ?>'/>
          <input type="hidden" name="price" value=<?php echo $p_price; ?>/>
          <input type="hidden" name="passemail" id="passemail" value=""/>
        </form>
        
        <div style="margin-left:400px" class="slide-footer"> 
        <i class="fa fa-bus"></i>
          <input class="btn btn-sm btn-default" type="button" id="submitcheck" value="Submit" />
          </div>
      </div>
    </div>
    <div class="confirm" id="confirm" style="display: none;">
      <label>Enter email</label>
      <input type="email" id="email" required/>
      <h1>Confirm your action</h1>
      <p>Do you wanna proceed with current Booking</p>
      <button id="cancel">Cancel</button>
      <button autofocus id ="confrimed">Confirm</button>
    </div>
  </div>
</div>
<script src="https://code.jquery.com/jquery-1.4.1.js" type="text/javascript"></script> 
<script src="{{URL::asset('bookweb/js/jquery.min.js')}}"></script> 
<script src="{{URL::asset('bookweb/js/seats.js')}}"></script> 
<script type="text/javascript">
	 $("#btnseats").click(function(){
    $("#formseats").toggle();
	});
	
	 $('#submitcheck').click(function(){
		$('#confirm').toggle();
	 });
	 
	  $('#confrimed').click(function(){
		 
                var str = [], item;
                $.each($('#place li.' + settings.selectingSeatCss + ' a'), function (index, value) {
                    item = $(this).attr('title');                   
                    str.push(item);                   
                });
          		document.getElementById('myField').value = str.join(',');
				var email=document.getElementById('email').value;
				document.getElementById('passemail').value = email;
				if (document.getElementById('myField').value =="")
				{
					alert ('please select at least one seat');
					
				}
				else if (document.getElementById('passemail').value =="")
				{
					alert ('please enter your email');
				}
				else 
				{console.log(document.getElementById('passemail').value);
				document.getElementById("form1").submit();
				}
	 });
	 
	 $('#cancel').click(function(){
		 $('#confirm').hide();
		 
	 });
	</script>
    
    <script>
	
	  $(document).ready(function(){
    setInterval(function(){
var tripId ='<?php echo $tripID; ?>';


var tripIdData = tripId;
if(tripId!='')
{  var token = $('meta[name="_token"]').attr('content');
	var url1 = "{{route('getseats')}}";
        $.ajax({
             type: "POST",
    		 url: url1,
    		 data: {_token:token,'tripID':tripIdData},
    		 cache: false,
            success: function(response) {
				console.log(response);
				var newBooking=[];
				var array = response.split("@");
				for ( i =0 ; i<array.length;i++){
				newBooking[i]=parseInt( array[i]);
				}
				iniseat(newBooking);

            }
        });
}
    }, 1000);
});
	</script>
</body>
</html>