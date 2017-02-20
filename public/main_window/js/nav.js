$('#searchBt').click(function(){
$('#search').show();
$('#signIn').hide();
$('#signUp').hide();
$('#Reservation').hide();		
	});
	
$('#SignInBt').click(function(){
$('#signIn').show();
$('#search').hide();
$('#signUp').hide();
$('#Reservation').hide();		
	});

$('#SignUpBt').click(function(){
$('#signUp').show();
$('#signIn').hide();
$('#search').hide();
$('#Reservation').hide();	
	});
	
$('#Pre-Reservation').click(function(){
$('#Reservation').show();
$('#search').hide();
$('#signIn').hide();
$('#signUp').hide();	
	});
	