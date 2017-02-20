<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name = "_token" content= "{{csrf_token()}}">
<title>Online Bus Ticketing System</title>
<link rel="stylesheet" href="{{URL::asset('con_window/css/style.css')}}">
<link rel="stylesheet" href="{{URL::asset('main_window/css/jquery-ui.css')}}">
<link rel="stylesheet" href="{{URL::asset('admin_window/css/header-user-dropdown.css')}}">
<link rel="stylesheet" href="{{URL::asset('admin_window/css/sidebar-collapse.css')}}">
<link href='https://fonts.googleapis.com/css?family=Cookie' rel='stylesheet' type='text/css'>
<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css">
<script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/1.8.0/jquery.min.js'></script>
<script src="{{URL::asset('main_window/js/jquery.min.js')}}"></script>
<script src="{{URL::asset('main_window/js/jquery.min.js')}}"></script>
<script src="{{URL::asset('admin_window/js/sidebar.js')}}"></script>
<style>
table {
	background: #f5f5f5;
	border-collapse: separate;
	box-shadow: inset 0 1px 0 #fff;
	font-size: 12px;
	line-height: 24px;
	margin: 30px auto;
	text-align: left;
	width: 800px;
}	

th {
	background: url(https://jackrugile.com/images/misc/noise-diagonal.png), linear-gradient(#777, #444);
	border-left: 1px solid #555;
	border-right: 1px solid #777;
	border-top: 1px solid #555;
	border-bottom: 1px solid #333;
	box-shadow: inset 0 1px 0 #999;
	color: #fff;
  font-weight: bold;
	padding: 10px 15px;
	position: relative;
	text-shadow: 0 1px 0 #000;	
}

th:after {
	background: linear-gradient(rgba(255,255,255,0), rgba(255,255,255,.08));
	content: '';
	display: block;
	height: 25%;
	left: 0;
	margin: 1px 0 0 0;
	position: absolute;
	top: 25%;
	width: 100%;
}

th:first-child {
	border-left: 1px solid #777;	
	box-shadow: inset 1px 1px 0 #999;
}

th:last-child {
	box-shadow: inset -1px 1px 0 #999;
}

td {
	border-right: 1px solid #fff;
	border-left: 1px solid #e8e8e8;
	border-top: 1px solid #fff;
	border-bottom: 1px solid #e8e8e8;
	padding: 10px 15px;
	position: relative;
	transition: all 300ms;
}

td:first-child {
	box-shadow: inset 1px 0 0 #fff;
}	

td:last-child {
	border-right: 1px solid #e8e8e8;
	box-shadow: inset -1px 0 0 #fff;
}	


tr:last-of-type td {
	box-shadow: inset 0 -1px 0 #fff; 
}

tr:last-of-type td:first-child {
	box-shadow: inset 1px -1px 0 #fff;
}	

tr:last-of-type td:last-child {
	box-shadow: inset -1px -1px 0 #fff;
}	




</style>
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
    <div class="link-blue "> <a href="{{route('addbusowners')}}"> <i class="fa fa-picture-o"></i>Add bus owner </a> </div>
    <div class="link-red"> <a href="{{route('addroutes')}}"> <i class="fa fa-heart-o"></i>Add route </a> </div>
    <div class="link-yellow selected"> <a href="{{route('busowners')}}"> <i class="fa fa-keyboard-o"></i>View Bus owners </a> </div>
    <div class="link-green"> <a href="{{route('getrouets')}}"> <i class="fa fa-map-marker"></i>View Routes </a> </div>
  </div>
</aside>
    <table  >
        <tr >
            <th>Owner ID&emsp; </th>
            <th>&nbsp Owner Name &emsp; </th>
            <th> Created By </th>
            

        </tr>
<?php $d=0;?>
        @foreach($result as $owner)
            <?php $d++; ?>
            <tr id =<?php echo $d; ?>>
                <td id="id"> {!! $owner->ID !!}&emsp; </td>
                <td id="day">{!! $owner->name !!}&emsp;</td>
                <td id="tripID">{!! $owner->createdBy!!}&emsp;&emsp;</td>
               


            </tr>
        @endforeach

    </table>
    <br>
<div class="main-agileinfo" style="width:400px" id="Reservation">
  <ul class="resp-tabs-list">
    <li class="resp-tab-item"><span style="color:#000000">Search Bus Owners</span></li>
  </ul>
  <div class="clearfix"> </div>
  <div class="resp-tabs-container">
  <br>
<div class="clear" style="margin-bottom:60px;">
    <h3 style="margin-left:20px;"> Search by name </h3>

	<input  name="name" type="text" id="search" style="margin-left:20px; width:320px;">
   </div>
<hr>

</div>
</div>
  <script >
        $("#search").keyup( function() {
    var value = $(this).val();

    $("table tr").each(function(index) {
        if (index !== 0) {

            $row = $(this);

            var id = $row.find("td:nth-child(2)").text().replace(/\s/g, "") ;
		
            if (id.indexOf(value)>=0) {
                 $row.show();
            }
            else {
            
				   $row.hide();
            }
        }
    });
});

    </script>
  
 <script src="{{URL::asset('main_window/js/datepicker.js')}}"></script>
 <script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/1.8.0/jquery.min.js'></script> 
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
</body>
</html>    