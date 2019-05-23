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
		$lpldao = new LtParkingLocationDAO();
		$locations = $lpldao->getAll();
	?>
	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
		<div class="container-fluid">
			<h1>Choose Parking</h1>
			<div class="container-fluid">
				<ul>
					<?php 
					if(!empty($locations))
					{
						foreach ($locations as $loc) 
						{ ?>
							<li>
								<?php echo $loc->LocationName; ?>
								<a href="checkinpanel.php?locationId=<?php echo $loc->LocationID; ?>&vehicle=1">Mobil</a>
								<a href="checkinpanel.php?locationId=<?php echo $loc->LocationID; ?>&vehicle=0">Motor</a>

							</li>
						<?php 
						}
					} ?>
				</ul>
			</div>
		</div>
	</div>
</body>
</html>