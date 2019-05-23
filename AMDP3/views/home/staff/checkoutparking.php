<!DOCTYPE html>
<html>
<head>
	<title>SyukurParking</title>
	<link rel="stylesheet" type="text/css" href="/AMDP3/public/vendor/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="/AMDP3/public/vendor/css/normalize.css">
	<link rel="stylesheet" type="text/css" href="/AMDP3/public/css/style.css">
	<link href="https://fonts.googleapis.com/css?family=Lato:100,300,400,700" rel="stylesheet">
	<script type="text/javascript" src="/AMDP3/public/vendor/js/jquery-3.2.1.min.js"></script>
	<script type="text/javascript" src="/AMDP3/public/js/portal/checkoutportal.js"></script>
	<style>
		body
		{
			background-color: #ecf0f1; /*Clouds*/
		}
	</style>
</head>
<body>
	<?php 
		session_start();
		include_once "$_SERVER[DOCUMENT_ROOT]/AMDP3/DAO/trbookingDAO.php";
		include_once "$_SERVER[DOCUMENT_ROOT]/AMDP3/DB/connection.php";
		include_once "$_SERVER[DOCUMENT_ROOT]/AMDP3/DAO/LtParkingLocationDAO.php";
		include_once "$_SERVER[DOCUMENT_ROOT]/AMDP3/DAO/trBookingLocationDAO.php";
		include_once "$_SERVER[DOCUMENT_ROOT]/AMDP3/DAO/staffDAO.php";

		if(!isset($_SESSION['role']) ||	$_SESSION['role']!='staff')
		{
			header("Location:../../index.php?login=0");
		}

		$sdao = new StaffDAO();
		$lpldao = new LtParkingLocationDAO();
		$tbldao = new TrBookingLocationDAO();

		$staff = (object) $sdao->getById($_SESSION['id']);
		$ltParkingLocation = $lpldao->getById($_GET['locationId']);
		$trBookingLocation = $tbldao->getByLocationId($_GET['locationId']);
	?>
	<header>
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
			<div class="container-fluid">
				<h1>Checkout Parking</h1>
				<ul>
					<li><a href="">Checkout Parking</a></li>
					<li><a href="/AMDP3/views/home/parkingavailability.php">Home</a></li>
				</ul>
			</div>
		</div>
	</header>
	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
		<div class="container-fluid">
			<div class="panel">
				<h1><?php echo $ltParkingLocation->locationName; ?><p>Login : <?php echo $staff->nama; ?></p></h1>
				<div>
					<input type="hidden" id="locId" name="locationId" value="<?php echo $_GET['locationId']; ?>">
					<input type="hidden" id="vehicleType" value="<?php echo $_GET['vehicle']; ?>">
					<p class="str">Input Parking Code / Booking Code / License Plate</p>
					<input type="text" name="checkout" id="checkoutTxt" class="form-control">
					<button type="button" class="btn btn-default" id="generateBillBtn">Generate Bill</button>
					<p id="currTime"></p>
				</div>
			</div>

			<div id="invoice">
					<!-- content goes here -->
			</div>
		</div>
	</div>
</body>
</html>