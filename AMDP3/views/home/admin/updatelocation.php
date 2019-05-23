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
	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
		<div class="container-fluid whiteBg newMapping">
			<h1>Add / Edit Mapping</h1>
			<?php 
			if($_GET['new']==1)
			{ ?>
				<form action="confirmlocation.php" method="POST" role="form">
					<input type="hidden" name="new" value="1"> <!-- 1 = new location-->
					<div class="form-group">
						<label for="location">Location</label>
						<input type="text" class="form-control" id="location" name="location" placeholder="Input Location">
					</div>
				
					<div class="form-group">
						<label for="normalParkingSpace">Normal Parking Space</label>
						<input type="text" class="form-control" id="normalParkingSpace" name="normalParkingSpace" placeholder="Parking Space">
					</div>					
					
					<div class="form-group">
						<label for="bookingRow">Booking Space in Row</label>
						<input type="text" class="form-control" id="bookingRow" name="bookingRow" placeholder="Number of booking rows">
					</div>	

					<div class="form-group">
						<label for="bookingCol">Booking Space in Column</label>
						<input type="text" class="form-control" id="bookingCol" name="bookingCol" placeholder="Number of booking columns">
					</div>	

					<button type="submit" class="btn btn-primary">Submit</button>
				</form>
			<?php 
			}
			else if($_GET['new']==0)
			{ 
				include_once "$_SERVER[DOCUMENT_ROOT]/AMDP3/DAO/LtParkingLocationDAO.php";
				include_once "$_SERVER[DOCUMENT_ROOT]/AMDP3/DAO/trBookingLocationDAO.php";

				$lpldao = new LtParkingLocationDAO();
				$tbldao = new TrBookingLocationDAO();

				$ltParkingLocation = (object)$lpldao->getById($_GET['locId']);
				$trBookingLocation = (object)$tbldao->getByLocationId($_GET['locId']);

				?>
				<form action="confirmlocation.php" method="POST" role="form">
					<input type="hidden" name="new" value="0"> <!-- 1 = new location-->
					<input type="hidden" name="locationId" value="<?php echo $_GET['locId'] ?>">
					<input type="hidden" name="bookingLocationId" value="<?php echo $trBookingLocation->bookingLocationId ?>">
					<div class="form-group">
						<label for="location">Location</label>
						<input type="text" class="form-control" value="<?php echo $ltParkingLocation->locationName ?>" id="location" name="location" placeholder="Input Location">
					</div>
				
					<div class="form-group">
						<label for="normalParkingSpace">Normal Parking Space</label>
						<input type="text" class="form-control" value="<?php echo $ltParkingLocation->parkingSpace ?>" id="normalParkingSpace" name="normalParkingSpace" placeholder="Parking Space">
					</div>					
					
					<div class="form-group">
						<label for="bookingRow">Booking Space in Row</label>
						<input type="text" class="form-control" value="<?php echo $trBookingLocation->parkingRow ?>" id="bookingRow" name="bookingRow" placeholder="Number of booking rows">
					</div>	

					<div class="form-group">
						<label for="bookingCol">Booking Space in Column</label>
						<input type="text" class="form-control" value="<?php echo $trBookingLocation->parkingColumn ?>" id="bookingCol" name="bookingCol" placeholder="Number of booking columns">
					</div>	

					<button type="submit" class="btn btn-primary">Submit</button>
				</form>
			<?php 
			} ?>
		</div>
	</div>
</body>
</html>