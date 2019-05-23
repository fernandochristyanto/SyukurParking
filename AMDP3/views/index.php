<!DOCTYPE html>
<html>
<head>
	<title>SyukurParking</title>
	<link rel="stylesheet" type="text/css" href="/AMDP3/public/vendor/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="/AMDP3/public/vendor/css/normalize.css">
	<link rel="stylesheet" type="text/css" href="/AMDP3/public/vendor/css/ionicons.min.css">
	<link rel="stylesheet" type="text/css" href="/AMDP3/public/css/style.css">
	<link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
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
	<?php include "../DB/connection.php" ?>
	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
		<div class="container-fluid loginPage">
			<h1><span class="bold">Syukur</span><span class="light">Parking</span></h1>
			<div class="loginForm">
				<h4>Sign in to start your session</h4>
				<?php 
				if(isset($_GET['login']))
				{
					if($_GET['login']==0)
					{
						echo "<p class="."redTxt".">You are not authorized, please login first</p>";
					}
				} ?>
				<form action="login.php" method="POST" role="form">
					<div class="form-group">
						<input type="text" class="fa form-control" id="email" name="email" placeholder="Email &#xf0e0;">
					</div>
					<div class="form-group">
						<input type="password" class="fa form-control" name="password" id="password" placeholder="Password &#xf023;">
					</div>
					<div>
						<div class="checkbox">
							<label>
								<input type="checkbox" value="Remember me">
								Remember Me
							</label>
						</div>
						<div>
							<button type="submit" class="btn">Submit</button>
						</div>
						<br class="clearboth">
					</div>
				</form>
				<p><a href="resetpass/reset.php">I forgot my password</a></p>
				<p><a href="resetpass/reset.php">Reset my password</a></p>
				<p><a href="register/customer.php">Register a new membership</a></p>
				<br>
				<p><a href="home/parkingavailability.php">Check Parking Availability</a></p>
			</div>
		</div>
	</div>
</body>
</html>