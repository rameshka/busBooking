  <?php
  $tripID = $ssdsd;
   // return view ('book')->with('tripIDPass',$phpvari);
  //$tripID = '1923';
  
  //first split works
  $busData=explode("+",$tripID);
  
  $count=count($busData);
  
  $trip_ID;
  $start_time;
  $end_time;
  $bus_no;
  
  $i=0;
  
while  ($i < $count)
{
 	$temp1=explode("*",$busData[$i]);
 
	$trip_ID[$i]=$temp1[0];
 	$start_time[$i]=$temp1[1];
 	$end_time[$i]=$temp1[2];
 	$bus_no[$i]=$temp1[3];
	$i++;
 
}





  ?>

 <html>
  <head>
  <title>Booking</title>
  
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    
   <link rel="stylesheet" href="{{URL::asset('bookweb/css/seats.css')}}">
   
     <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <link rel="stylesheet" href="{{URL::asset('main_window/css/style.css')}}">
<link rel="stylesheet" href="{{URL::asset('main_window/css/jquery-ui.css')}}" />

  	
 
  </head>
  
  <body>
  <nav class="navbar navbar-inverse">
	<div class="container-fluid">
	  <div class="navbar-header">
		<a class="navbar-brand">Online Bus Booking</a>
	  </div>
  
	</div>
  </nav>
  <div class="container">
  
	  <hr>
	  <!-- Begin of rows -->
      
       <div id = 'repeat'>
	
      </div>
	  
  </div>
   <script src="https://code.jquery.com/jquery-1.9.1.js"></script>
  <script src="{{URL::asset('bookweb/js/jquery.min.js')}}"></script>

<script>

 $(document).ready(function(){

	 
	 var count= <?php echo $count; ?>;
	 
	 var tripIDArray = <?php echo json_encode($trip_ID); ?>;
	 var startimeArray = <?php echo json_encode($start_time); ?>;
	 var endtimeArray = <?php echo json_encode($end_time); ?>;
	 var busNoArray = <?php echo json_encode($bus_no); ?>;
	 var destArray = <?php echo json_encode($dest); ?>;
	 
	 
	
	 
	 
	 for (i = 0; i <count; i++) {
	var url = '{{URL::route('book', ['trip' => 'datareplace','sCity'=>'startcity','eCity'=>'endcity'])}}';
	url = url.replace('datareplace', tripIDArray[i]);
	url = url.replace('startcity', destArray[0]);
	url = url.replace('endcity', destArray[1]);
	$("#repeat").append( '<div class="row carousel-row"><div class="col-xs-8 col-xs-offset-2 slide-row"><div class="carousel-inner"><div class="item active"><img src="{{URL::asset("bookweb/images/bus1.jpg")}}" alt="Image"></div></div><div class="slide-content">&nbsp;<label>'+destArray[0]+'</label>&nbsp;</t></t><label>to  '+destArray[1]+'</label>&nbsp;</br><label>Starting: '+startimeArray[i]+'h</label>&nbsp;</t></t><label> to: '+endtimeArray[i]+'h</label>&nbsp;</br><label>Bus no: '+busNoArray[i]+'</label><p> </p> </div><div class="slide-footer"><span class="pull-right buttons"><a href="'+url+'"><button class="btn btn-sm btn-default" id="btnseats" ><i class="fa fa-fw fa-eye"></i> View seats</button></a></span></div></div></div>');
	 
    
	}
      
		
       });
   

</script>
    
  </body>
  </html>