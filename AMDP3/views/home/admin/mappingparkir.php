<!DOCTYPE html>
<html>
<head>
	<title>SyukurParking</title>
	<link rel="stylesheet" type="text/css" href="/AMDP3/public/vendor/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="/AMDP3/public/vendor/css/normalize.css">
	<link rel="stylesheet" type="text/css" href="/AMDP3/public/css/style.css">
	<link href="https://fonts.googleapis.com/css?family=Lato:100,300,400,700" rel="stylesheet">
	<script type="text/javascript" src="/AMDP3/public/vendor/js/jquery-3.2.1.min.js"></script>
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
		if(!isset($_SESSION['role']) ||	 $_SESSION['role']!='admin')
		{
			header("Location:../../index.php?login=0");
		}
	?>
	<header>
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
			<div class="container-fluid">
				<h1>Mapping Parkir</h1>
				<ul>
					<li><a href="/AMDP3/views/home/parkingavailability.php">Mapping Parkir</a></li>
					<li><a href="../parkingavailability.php">Home</a></li>
				</ul>
				<br clear="clearboth">
			</div>
		</div>
	</header>
	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
		<div class="container-fluid whiteBg mappingParkirDiv">
			<h4>Mapping Parkir</h4>
			<hr>
			<table class="mappingParkirTable">
				<tr>
					<td>#</td>
					<td>Location</td>
					<td>Normal Parking Space</td>
					<td>Booking Space</td>
					<td>Action</td>
				</tr>
				<!-- gets rows of parking location data -->
				<?php  
				include_once "$_SERVER[DOCUMENT_ROOT]/AMDP3/DAO/LtParkingLocationDAO.php";
				include_once "$_SERVER[DOCUMENT_ROOT]/AMDP3/DAO/trBookingLocationDAO.php";

				$tbldao = new TrBookingLocationDAO();
				$lpldao = new LtParkingLocationDAO();
				$parkingLocations = $lpldao->getAll();
				$i = 0; //index
				//loop through arr of objs
				foreach ($parkingLocations as $loc)
				{ 
				?>
					<!-- gets loc data per row -->
					<?php 
						$locDetails = (object) $tbldao->getByLocationId($loc->LocationID);
						$i++;
					?>
					<tr>
						<td><?php echo $i.'.' ?></td>
						<td><?php echo $loc->LocationName ?></td>
						<td><?php echo $loc->ParkingSpace ?></td>
						<td><?php echo $locDetails->parkingRow*$locDetails->parkingColumn ?></td>
						<td><a href="updatelocation.php?new=0&locId=<?php echo $loc->LocationID ?>">Edit</a></td>
					</tr>
				<?php 
				} ?>
			</table>
			<a href="updatelocation.php?new=1" class="greenBtn">Add New Location</a>
		</div>
	</div>
</body>
</html>