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
	<script type="text/javascript" src="/AMDP3/public/js/editprofile/customer.js"></script>
</head>
<body>
	<?php 
		session_start();
		include_once "$_SERVER[DOCUMENT_ROOT]/AMDP3/DB/connection.php";
		include_once "$_SERVER[DOCUMENT_ROOT]/AMDP3/DAO/customerDAO.php";

		if(!isset($_SESSION['role']) ||	$_SESSION['role']!='customer')
		{
			header("Location:../../index.php?login=0");
		}
		$cdao = new CustomerDAO();

		$customer = (object)$cdao->getById($_SESSION['id']);
	?>
	<header>
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
			<div class="container-fluid">
				<h1>Edit Profile</h1>
				<ul>
					<li><a href="">Edit Profile</a></li>	
					<li><a href="/AMDP3/views/home/parkingavailability.php">Home</a></li>
				</ul>
			</div>
		</div>
	</header>
	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 registerPage">
		<a class="" href="../parkingavailability.php">Back</a>
		<div class="container-fluid">
			<form id="customerEditForm" action="submitedit.php" method="POST" role="form" enctype="multipart/form-data">
				<input type="hidden" name="role" value="customer">
				<div class="form-group">
					<label for="name">Name</label>
					<p id="warningName" class="warningTxt"></p>
					<input type="text" class="form-control" id="name" value="<?php echo $customer->nama; ?>" name="name">
				</div>

				<div class="form-group">
					<label for="address">Address</label>
					<p id="warningAddress" class="warningTxt"></p>
					<textarea name="address" id="address" class="form-control" rows="3"><?php echo $customer->alamat; ?></textarea>
				</div>

				<div class="form-group">
					<label for="HP">Phone Number</label>
					<p id="warningHP" class="warningTxt"></p>
					<input type="text" class="form-control" id="HP" value="<?php echo $customer->hp; ?>" name="hp">
				</div>

				<div class="form-group">
					<label for="email">Email Address</label>
					<input type="text" class="form-control" id="email" value="<?php echo $customer->email; ?>" readonly name="email">
				</div>

				<div class="form-group">
					<p id="warningPassword" class="warningTxt"></p>
					<label for="password">Password</label>
					<input type="password" class="form-control" id="password" value="<?php echo $customer->password; ?>" name="password">
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
</body>
</html>