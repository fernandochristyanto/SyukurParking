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
		session_start();
		include_once "$_SERVER[DOCUMENT_ROOT]/AMDP3/DB/connection.php";
		include_once "$_SERVER[DOCUMENT_ROOT]/AMDP3/DAO/LtParkingLocationDAO.php";
		$lpldao = new LtParkingLocationDAO();
		$locations = $lpldao->getAll();

		if(!isset($_SESSION['role']) ||	$_SESSION['role']!='staff')
		{
			header("Location:../../index.php?login=0");
		}
	?>
	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
		<div class="container-fluid">
			<h1>Choose Parking</h1>
			<div class="container-fluid">
				<ul>
					<?php 
					foreach ($locations as $loc) 
					{ ?>
						<li>
							<a href="checkoutparking.php?locationId=<?php echo $loc->LocationID; ?>"><?php echo $loc->LocationName; ?></a>
						</li>
					<?php 
					} ?>
				</ul>
			</div>
		</div>
	</div>
</body>
</html>