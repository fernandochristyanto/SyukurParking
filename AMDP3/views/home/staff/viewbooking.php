<!DOCTYPE html>
<html>
<head>
	<title>SyukurParking</title>
	<link rel="stylesheet" type="text/css" href="/AMDP3/public/vendor/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="/AMDP3/public/vendor/css/normalize.css">
	<link rel="stylesheet" type="text/css" href="/AMDP3/public/vendor/css/grid.css">
	<link rel="stylesheet" type="text/css" href="/AMDP3/public/css/style.css">
	<link href="https://fonts.googleapis.com/css?family=Lato:100,300,400,700" rel="stylesheet">
	<script type="text/javascript" src="/AMDP3/public/vendor/js/jquery-3.2.1.min.js"></script>
	<script type="text/javascript" src="/AMDP3/public/js/viewbooking.js"></script>
	<style>
		body
		{
			background-color: #ecf0f1; /*Clouds*/
		}
	</style>
</head>
<body onload="firstRun(); return false;">
	<?php 
		session_start();
		include_once "$_SERVER[DOCUMENT_ROOT]/AMDP3/DAO/trbookingDAO.php";

		if(!isset($_SESSION['role']) ||	$_SESSION['role']!='staff')
		{
			header("Location:../../index.php?login=0");
		}
	?>
	<header>
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
			<div class="container-fluid">
				<h1>View Booking</h1>
				<ul>
					<li><a href="">View Booking</a></li>
					<li><a href="/AMDP3/views/home/parkingavailability.php">Home</a></li>
				</ul>
			</div>
		</div>
	</header>
	<section class="bookingLayout">
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
			<div class="container-fluid">
				<p class="str">Select Location</p>
				<select id="locationDropdown">
					<?php 
						include_once "$_SERVER[DOCUMENT_ROOT]/AMDP3/DAO/LtParkingLocationDAO.php";
						$lpldao = new LtParkingLocationDAO();
						$locs = $lpldao->getAll();
						foreach($locs as $loc)
						{
							echo '<option value='.$loc->LocationID.'>'.$loc->LocationName.'</option>';
						}
					?>
				</select>
				<div id="onlineBookMapping">
					<!-- content goes here -->
				</div>
			</div>
		</div>
	</section>
</body>
</html>