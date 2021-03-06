
<?php

$tripID = '1923';
$data=array();
$selected_data=array();
$ticket_details=array();


foreach($selected_seats as $selected_seat){

    array_push($selected_data, $selected_seat);
}




foreach($seats as $seat){

    array_push($data, $seat);
}

foreach($ticket_ID as $details){

    array_push($ticket_details, $details->order_ID);
    array_push($ticket_details, $details->ticket_ID);
    array_push($ticket_details, $details->seat_no);
    array_push($ticket_details, $details->price);
    array_push($ticket_details, $details->date_due);
    array_push($ticket_details, $details->status);
    array_push($ticket_details, $details->ticket_manID);
}


//$data= array(1,2,3);
?>





    
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="_token" content="{{ csrf_token() }}">
<title>Admin view</title>
<link rel="stylesheet" href="{{URL::asset('admin_window/css/style.css')}}">
<link rel="stylesheet" href="{{URL::asset('ticketcheck/css/style.css')}}">
<link rel="stylesheet" href="{{URL::asset('main_window/css/jquery-ui.css')}}">
<link rel="stylesheet" href="{{URL::asset('admin_window/css/header-user-dropdown.css')}}">
<link rel="stylesheet" href="{{URL::asset('admin_window/css/sidebar-collapse.css')}}">
<link href='https://fonts.googleapis.com/css?family=Cookie' rel='stylesheet' type='text/css'>
<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css">
<script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/1.8.0/jquery.min.js'></script>
<script src="{{URL::asset('main_window/js/jquery.min.js')}}"></script>
<script src="{{URL::asset('main_window/js/jquery.min.js')}}"></script>
<script src="{{URL::asset('admin_window/js/sidebar.js')}}"></script>
<script src="https://code.jquery.com/jquery-1.4.1.js" type="text/javascript"></script>
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
    <div class="link-blue "> <a href="{{route('addbus')}}"> <i class="fa fa-picture-o"></i>Add bus </a> </div>
    <div class="link-red"> <a href="{{route('addtrip')}}"> <i class="fa fa-heart-o"></i>Add trip </a> </div>
    <div class="link-yellow selected"> <a href="{{route('busownerdashboard')}}"> <i class="fa fa-keyboard-o"></i>View Buses </a> </div>	
  </div>
</aside>
<div style="margin-left:250px; margin-top:100px; width:1000px;">
    <form id="form1" >
       <div id="holder"> 
		<ul  id="place">
        </ul>    
	</div>
	 <div style="width:600px;text-align:center;overflow:auto"> 
	<ul id="seatDescription">
<li id="available_seat" style="margin-top:10px;"><h3>Not booked seats</h3></li>
<li id="booked_seat" style="margin-top:10px;"><h3>Reserved Seats</h3></li>
<li id="selected_seat" style="margin-top:10px;"><h3>Confirmed Reserved Seats</h3></li>
	</ul>        
    </div>
    <div style="margin-left:700px; margin-top:-250px;">
    <ul class="resp-tabs-list">
    <li class="resp-tab-item"><span style="color:#000000">Trip Summary</span></li>
  </ul>
  <div class="clearfix"> </div>
  <div class="resp-tabs-container">
    <form action='{{route('enterBusOwnerData')}}' method="post">
      <div class='clear'>
      <br>
        <h3> Bus Number</h3>
         <label style="color:#22FF00"><?php echo $result2['bus_no']; ?>	</label>
      </div>
      <div class='clear'>
      <br>
      <h3> Trip Date</h3>
      <label  style="color:#22FF00"> <?php echo $result2['day']; ?> </label>
      </div>
      <div class='clear'>
      <br>
      <h3> Start Time</h3>
       <label  style="color:#22FF00"> <?php echo $result2['start_time']; ?></label>
      </div>
      <div class='clear'>
      <br>
      <h3> Route Name</h3>
        <label  style="color:#22FF00"> <?php echo $result2['name']; ?> </label>
      </div>
      <div class='clear'>
      <br>
      <h3> Route Number</h3>
       <label  style="color:#22FF00"> <?php echo $result2['route_no']; ?> </label> 
      </div>
       <div class='clear'>
      <br>
      <h3> Income from online tickets</h3>
         <label  style="color:#22FF00">Rs.<?php if(sizeof($ticket_ID)>0){echo (sizeof($ticket_ID)*$ticket_ID[0]->price);}else{echo ('00');}; ?>.00 </label>	 
      </div>
    </form>
    </div>
  </div>
</div>



    </form>
    <script type="text/javascript">
	
	            var settings = {
                rows: 5,
                cols: 15,
                rowCssPrefix: 'row-',
                colCssPrefix: 'col-',
                seatWidth: 35,
                seatHeight: 35,
                seatCss: 'seat',
                selectedSeatCss: 'selectedSeat',
				selectingSeatCss: 'selectingSeat'
            };
     var bookedSeats =[];
	
     iniseats(bookedSeats);
 
	
	 function iniseats(reservedSeat) {
		  console.log('fsdsd');
                var str = [], seatNo, className;
                for (i = 0; i < settings.rows; i++) {
                    for (j = 0; j < settings.cols; j++) {
                        seatNo = (i + j * settings.rows + 1);
                        className = settings.seatCss + ' ' + settings.rowCssPrefix + i.toString() + ' ' + settings.colCssPrefix + j.toString();
                        if ($.isArray(reservedSeat) && $.inArray(seatNo, reservedSeat) != -1) {
                            className += ' ' + settings.selectedSeatCss;
                        }
                        str.push('<li class="' + className + '"' +
										'id ="'+ seatNo +'"'+
                                  'style="top:' + (i * settings.seatHeight).toString() + 'px;left:' + (j * settings.seatWidth).toString() + 'px">' +
                                  '<a title="' + seatNo + '">' + seatNo + '</a>' +
                                  '</li>');
                    }
                }
                $('#place').html(str.join(''));
            };


	function iniseatred(reservedSeat) {
		
		 for (s = 0; s<reservedSeat.length; s++){
           if (!($('#'+reservedSeat[s]).hasClass(settings.selectedSeatCss))) {
			$('#'+reservedSeat[s]).toggleClass(settings.selectedSeatCss);
				
		   }


		   }
		   
            }

               function iniseatgreen(reservedSeat) {

                   for (s = 0; s<reservedSeat.length; s++){
                       if (!($('#'+reservedSeat[s]).hasClass(settings.selectedSeatCss))) {
                           $('#'+reservedSeat[s]).toggleClass(settings.selectingSeatCss);

                       }


                   }

               }

	
        $(function () {
            //case I: Show from starting
            //init();
//data = [1,2,3,4,5,5,6]
            //Case II: If already booked
            var cat;
            var checkId;
            var selected=<?php echo json_encode($selected_data) ?>;
        var books = <?php echo json_encode($data) ?>;
            var jticket_details=<?php echo json_encode($ticket_details) ?>;
iniseatred(books);
iniseatgreen(selected);
			

            $('.' + settings.seatCss).click(function () {
            checkId=this.id;

                $('#ddd').empty();


				
			if ($(this).hasClass(settings.selectedSeatCss) || $(this).hasClass(settings.selectingSeatCss)){

                var seat=this.id;
                for(n=1;n<100;n++){
                    console.log(this.id+1);
                    if(seat==jticket_details[2+(n-1)*7]){
                        console.log('dududud');

                        cat=jticket_details[6+(n-1)*7];
                        console.log("manufacture id"+cat);

                        $('#ddd').append(
                                "order_id :"+jticket_details[0 + (n - 1) * 7]+"<br />"
                                +"ticket_id : "+jticket_details[1+(n-1)*7]+"<br />"
                                +"seat number : " +jticket_details[2+(n-1)*7]+"<br />"
                                +"price : "+jticket_details[3+(n-1)*7]+"<br />"
                                +"date due : " +jticket_details[4+(n-1)*7]+"<br />"
                                +"status :" +jticket_details[5+(n-1)*7]+"<br />"
                                +"ticket manufacture id : "+jticket_details[6+(n-1)*7])



                    }
                }


                var modal = document.getElementById('myModal');
                var span = document.getElementsByClassName("close")[0];
                modal.style.display = "block";

                span.onclick = function() {
                    modal.style.display = "none";
                }



                $('#check').click(function () {
                 
					  modal.style.display = "none";
                })

            }
			
			
            });

            $('#btnShow').click(function () {
                var str = [];
                $.each($('#place li.' + settings.selectedSeatCss + ' a, #place li.'+ settings.selectingSeatCss + ' a'), function (index, value) {
                    str.push($(this).attr('title'));
                });
                alert(str.join(','));
            })

            $('#btnShowNew').click(function () {
                var str = [], item;
                $.each($('#place li.' + settings.selectingSeatCss + ' a'), function (index, value) {
                    item = $(this).attr('title');                   
                    str.push(item);                   
                });
                alert(str.join(','));
            })
        });
    </script>


    <script src="https://code.jquery.com/jquery-1.4.1.js" type="text/javascript"></script>


    <div id="myModal" class="modal" style="width:800px; margin-left:280px; margin-top:75px;">
        <!-- Modal content -->
        
        <div class="modal-content" >
            <span class="close" style="margin-top:-20px; margin-left:20px;">&times;</span>
            <div class= "details" style="text-align:center; font-weight:400" >
            <p><strong>TICKET DETAILS</strong></p>
            <hr>
            </div>
            <div id="ddd"></div>
            <div class= "details" style="text-align:center">
            <button type="button" id="check" class="endbutton" style="margin-top:10px;">Ok</button>
            
			</div>
        </div>

    </div>


    <script src="https://code.jquery.com/jquery-1.4.1.js" type="text/javascript"></script>

</body>
</html>
