
<form action='{{route('customerdata')}}' method="post" id="form3">
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
        Visa </label>
    </div>
    <div class="radio">
      <label>
        <input type="radio" name="payMethod" required="" value="Paypal">
        Paypal </label>
    </div>
  </div>
  <input type="hidden" name="_token" value = "{{Session::token()}}">
  <div >
    <button type="submit" class="btn btn-primary ">Book Now</button>
  </div>
</form>



<div class="main-agileinfo" id="Reservation" hidden="">
  <ul class="resp-tabs-list">
    <li class="resp-tab-item"><span style="color:#000000">Continue Reservation</span></li>
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
        				<input  name="date" type="date" value="dd-mm-yyyy" >
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
