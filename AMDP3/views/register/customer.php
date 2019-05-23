<!DOCTYPE html>
<html>
<head>
	<title>SyukurParking</title>
	<link rel="stylesheet" type="text/css" href="/AMDP3/public/vendor/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="/AMDP3/public/vendor/css/normalize.css">
	<link rel="stylesheet" type="text/css" href="/AMDP3/public/vendor/css/grid.css">
	<link rel="stylesheet" type="text/css" href="/AMDP3/public/vendor/css/ionicons.min.css">
	<link rel="stylesheet" type="text/css" href="/AMDP3/public/css/style.css">
	<link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
	<link href="https://fonts.googleapis.com/css?family=Lato:100,300,400,700" rel="stylesheet">
	<script type="text/javascript" src="/AMDP3/public/vendor/js/jquery-3.2.1.min.js"></script>
	<script type="text/javascript" src="/AMDP3/public/js/regiscustomer.js"></script>
	<script type="text/javascript" src="/AMDP3/public/js/regis.js"></script>
	<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
	<script type="text/javascript" src="/AMDP3/public/js/datepicker/datepicker.js"></script>
	<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
</head>
<body>
	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 registerPage">
		<div class="container-fluid">
			<a class="backHref" href="../index.php">Back</a>
			<div class="registerContainer" id="regisDiv">
				<form id="customerRegisForm" action="register.php" method="POST" role="form" enctype="multipart/form-data">
					<legend>Customer Registration Form</legend>
					<input type="hidden" name="role" value="customer">
					<div class="form-group">
						<label for="name">Name</label>
						<p id="warningName" class="warningTxt"></p>
						<input type="text" class="form-control" id="name" placeholder="Name" name="name">
					</div>

					<div class="form-group">
						<label for="address">Address</label>
						<p id="warningAddress" class="warningTxt"></p>
						<textarea name="address" id="address" class="form-control" rows="3"></textarea>
					</div>

					<div class="form-group">
						<label for="HP">Phone Number</label>
						<p id="warningHP" class="warningTxt"></p>
						<input type="text" class="form-control" id="HP" placeholder="Phone Number" name="hp">
					</div>

					<div class="form-group">
						<label for="email">Email Address</label>
						<p id="warningEmail" class="warningTxt"></p>
						<input type="text" class="form-control" id="email" placeholder="Enter Email" name="email">
					</div>

					<div class="form-group">
						<p id="warningPassword" class="warningTxt"></p>
						<label for="password">Password</label>
						<input type="password" class="form-control" id="password" placeholder="Password" name="password">
					</div>

					<div class="form-group">
						<label for="picture">Profile Picure</label>
						<p id="warningPicture" class="warningTxt"></p>
						<input type="file" id="picture" name="picture">
					</div>
					<p class="light silver">Maximum image size : 2MB</p>

					<button id="submitBtn" type="submit" class="btn btn-primary">Submit</button>
				</form>
			</div>
		</div>
	</div>
</body>
</html>