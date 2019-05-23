<!DOCTYPE html>
<html>
<head>
	<title>SyukurParking</title>
	<link rel="stylesheet" type="text/css" href="/AMDP3/public/vendor/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="/AMDP3/public/vendor/css/normalize.css">
	<link rel="stylesheet" type="text/css" href="/AMDP3/public/css/style.css">
	<link href="https://fonts.googleapis.com/css?family=Lato:100,300,400,700" rel="stylesheet">
	<script type="text/javascript" src="/AMDP3/public/vendor/js/jquery-3.2.1.min.js"></script>
	<script type="text/javascript" src="/AMDP3/public/js/portal/checkinportal.js"></script>
	<style>
		body
		{
			background-color: #ecf0f1; /*Clouds*/
		}
	</style>
</head>
<body>
	<?php 	
		include_once "$_SERVER[DOCUMENT_ROOT]/AMDP3/DB/connection.php";
		include_once "$_SERVER[DOCUMENT_ROOT]/AMDP3/DAO/LtParkingLocationDAO.php";
		include_once "$_SERVER[DOCUMENT_ROOT]/AMDP3/DAO/trBookingLocationDAO.php";

		$lpldao = new LtParkingLocationDAO();
		$tbldao = new TrBookingLocationDAO();

		$ltParkingLocation = $lpldao->getById($_GET['locationId']);
		$trBookingLocation = $tbldao->getByLocationId($_GET['locationId']);
	?>
	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
		<div class="container-fluid">
			<div class="panel">
				<h1>Welcome to <?php echo $ltParkingLocation->locationName; ?></h1>
				<div>
					<input type="hidden" id="locId" name="locationId" value="<?php echo $_GET['locationId']; ?>">
					<input type="hidden" id="vehicleType" value="<?php echo $_GET['vehicle']; ?>">
					<p class="str">Input Booking Number</p>
					<input type="text" name="bookingNumber" id="bookingNumberTxt" class="form-control">
					<div id="panelbtnDiv">
						<button type="button" class="btn btn-default" id="ticketBtn">Get Ticket</button>
					</div>
					<div id="locationDetail">
						
					</div>
				</div>
			</div>
		</div>
	</div>
</body>
</html>