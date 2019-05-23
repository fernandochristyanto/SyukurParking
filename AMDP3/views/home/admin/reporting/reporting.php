<!DOCTYPE html>
<html>
<head>
	<title>SyukurParking</title>
	<link rel="stylesheet" type="text/css" href="/AMDP3/public/vendor/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="/AMDP3/public/vendor/css/normalize.css">
	<link rel="stylesheet" type="text/css" href="/AMDP3/public/css/style.css">
	<link href="https://fonts.googleapis.com/css?family=Lato:100,300,400,700" rel="stylesheet">
	<script type="text/javascript" src="/AMDP3/public/vendor/js/jquery-3.2.1.min.js"></script>
	<script type="text/javascript" src="/AMDP3/public/js/reporting/reporting.js"></script>
	<style>
		body
		{
			background-color: #ecf0f1; /*Clouds*/
		}
	</style>
	<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
	<script type="text/javascript" src="/AMDP3/public/js/datepicker/datepicker.js"></script>
	<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
</head>
<body>
	<?php 
		session_start();
		if(!isset($_SESSION['role']) ||	 $_SESSION['role']!='admin')
		{
			header("Location:../../../index.php?login=0");
		}
	?>
	<header>
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
			<div class="container-fluid">
				<h1>Reporting</h1>
				<ul>
					<li><a href="#">Reporting</a></li>
					<li><a href="../../parkingavailability.php">Home</a></li>
				</ul>
				<br clear="clearboth">
			</div>
		</div>
	</header>
	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
		<div class="container-fluid">
			<div class="reportInput">
				<p>Report Type : Recapitulation Report</p>
				<label for="startDate">Start Date</label>
				<input class="form-control datepick" type="text" name="startDate" id="startDate" placeholder="MM/dd/YYYY">
				<label for="endDate">End Date</label>
				<input class="form-control datepick" type="text" name="endDate" id="endDate" placeholder="MM/dd/YYYY">
				<button class="btn btn-default" id="view">View</button>
				<div id="reportResult">
					
				</div>
			</div>
		</div>
	</div>
</body>
</html>