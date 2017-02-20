<?php

$reqID=$requestID;
$reqEmail=$email;

?>

<html>
<head>
<title>Customer Detail Form</title>
<!-- Custom CSS -->
<link rel="stylesheet" href="{{URL::asset('orderweb/css/style.css')}}">
<!-- font CSS --><!-------->



</head>
<body class="dashboard-page">
		<div class="main-grid">
			<div class="agile-grids">	
				<!-- validation -->
				<div class="grids">
					<div class="progressbar-heading grids-heading">
						<h2>Bookig Form</h2>
					</div>
					
					<div class="forms-grids">
						<div class="forms3">
						<div class="w3agile-validation w3ls-validation">
							<div class="panel panel-widget agile-validation register-form">
								<div class="validation-grids widget-shadow" data-example-id="basic-forms"> 
									<div class="input-info">
										<h3>Booking Form</h3>
									</div>
									<div class="form-body form-body-info" >
                                   
										<form action='{{route('customerdata')}}' method="post" id="form2">
                                        
											<div class="form-group valid-form">
												<input type="text" class="form-control" id="inputName" name="name" placeholder="Name" required="">
											</div>
                                            
											<div class="form-group valid-form">
											  <input type="text" class="form-control" id="nic"   name="nic" placeholder="NIC number" required="">
											</div>
                                                                                        
											<div class="form-group">
												<input type="email" class="form-control inputEmail" name="email" placeholder="Email" id="email" value="">
											</div>
                                            
											<div class="form-group">
											  <input type="text"  class="form-control " name="telephone" placeholder="Telephone" required="">
											</div>
                                            
                                            <div class="form-group valid-form">
											  <input   class="form-control " name="token" id="token" placeholder="token" type="hidden"  value="">
											</div>

											<div class="form-group">
												<div class="radio">
													<label>
													  <input type="radio" name="payMethod" value="Visa">
													  Visa
													</label>
												</div>
												<div class="radio">
													<label>
													<input type="radio" name="payMethod" required="" value="Paypal">
													Paypal
													</label>
												</div>
											</div>
                                            
                                               <input type="hidden" name="_token" value = "{{Session::token()}}">	
	
											<div >
												<button type="submit" class="btn btn-primary ">Book Now</button>
											</div>
                                            
										</form>
									</div>
								</div>
							</div>
                            </div>
                            </div>
                            </div>
							</div>
                            </div>
                            </div>
                            
                       <script src="{{URL::asset('orderweb/js/jquery.min.js')}}"></script>
                            
                            <script>
                            
                      $( document ).ready(function() {
    						
				var email='<?php echo $email; ?>';
				document.getElementById('email').value = email;
				document.getElementById('token').value ='<?php echo $reqID; ?>';							
					});
                            
                            
                            </script>
							
</body>




</html>
