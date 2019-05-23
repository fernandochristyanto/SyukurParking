<?php 
	include_once "$_SERVER[DOCUMENT_ROOT]/AMDP3/DAO/LtParkingLocationDAO.php";
	include_once "$_SERVER[DOCUMENT_ROOT]/AMDP3/DAO/trBookingLocationDAO.php";
	include_once "$_SERVER[DOCUMENT_ROOT]/AMDP3/DAO/customerDAO.php";
	include_once "$_SERVER[DOCUMENT_ROOT]/AMDP3/model/ltparkinglocationmodel.php";
	include_once "$_SERVER[DOCUMENT_ROOT]/AMDP3/model/trbookinglocationmodel.php";
	include_once "$_SERVER[DOCUMENT_ROOT]/AMDP3/model/customermodel.php";
		

	$locationId = $_GET['locationId'];
	$row = $_GET['row'];
	$col = $_GET['col'];
?>

<div>
	<p class="alignCenter">
		Please Fill this Booking Form for parking to :
		 <span class="str"><?php echo $row.''.$col ?></span>
	</p>
	<form id="bookingForm" action="submitbooking.php" method="POST" role="form">
		<input type="hidden" name="locationId" value="<?php echo $locationId; ?>">
		<input type="hidden" name="row" value="<?php echo $row; ?>">
		<input type="hidden" name="col" value="<?php echo $col; ?>">
		<div class="form-group">
			<label for="licensePlate">License Plate Number</label>
			<input type="text" class="form-control" id="licensePlate" name="licensePlate" placeholder="Input field">
		</div>
		<div class="form-group">
			<label for="name">Name</label>
			<input type="text" class="form-control" id="name" name="name" placeholder="Input field">
		</div>
		<div class="form-group">
			<label for="name">Phone Number</label>
			<input type="text" class="form-control" id="name" name="hp" placeholder="Input field">
		</div>
		<div class="form-group">
			<label for="email">Email Address</label>
			<input type="text" class="form-control" id="email" name="email" placeholder="Input field">
		</div>
		<div class="checkbox">
			<label>
				<input id="agreement" type="checkbox" value="agree">
				I Agree that this booking is valid for 1 hour <span class="str">after</span> submitting this form. This booking will charge you extra 10.000
			</label>
		</div>
		<button type="submit" class="btn btn-primary">Book Now</button>
	</form>
</div>