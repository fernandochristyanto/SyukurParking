<!DOCTYPE html>
<html>
<head>
	<title>SyukurParking</title>
	<title>SyukurParking</title>
	<link rel="stylesheet" type="text/css" href="/AMDP3/public/vendor/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="/AMDP3/public/vendor/css/normalize.css">
	<link rel="stylesheet" type="text/css" href="/AMDP3/public/vendor/css/grid.css">
	<link rel="stylesheet" type="text/css" href="/AMDP3/public/css/style.css">
	<link href="https://fonts.googleapis.com/css?family=Lato:100,300,400,700" rel="stylesheet">
	<script type="text/javascript" src="/AMDP3/public/vendor/js/jquery-3.2.1.min.js"></script>
	<script type="text/javascript" src="/AMDP3/public/js/resetpass.js"></script>
</head>
<body onload="reqPage('customer.php'); return false;">
	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
		<div class="container-fluid resetTitle">
			<h1>Reset Password</h1>
			<hr>
		</div>
		<section class="resetPass">
			<div class="container-fluid">
				<a href="../index.php">Back</a>
				<div class="resetHeader">
					<ul>
						<li id="customer" onclick="reqPage('customer.php'); return false;">I am Customer</li>
						<li id="staff" onclick="reqPage('staff.php'); return false;">I am Staff</li>
					</ul>
					<div id="resetDiv">
						
					</div>
				</div>
			</div>	
		</section>
	</div>	
</body>
</html>