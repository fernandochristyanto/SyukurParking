<!DOCTYPE html>
<html>
<head>
	<title>SyukurParking</title>
	<link rel="stylesheet" type="text/css" href="/AMDP3/public/vendor/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="/AMDP3/public/vendor/css/normalize.css">
	<link rel="stylesheet" type="text/css" href="/AMDP3/public/css/style.css">
	<link href="https://fonts.googleapis.com/css?family=Lato:100,300,400,700" rel="stylesheet">
	<script type="text/javascript" src="/AMDP3/public/vendor/js/jquery-3.2.1.min.js"></script>
	<script type="text/javascript" src="/AMDP3/public/js/editprofile/staff.js"></script>
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
		include_once "$_SERVER[DOCUMENT_ROOT]/AMDP3/DAO/adminDAO.php";

		if(!isset($_SESSION['role']) ||	$_SESSION['role']!='admin')
		{
			header("Location:../../index.php?login=0");
		}
		$adao = new AdminDAO();

		$admin = (object)$adao->getById($_SESSION['id']);
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
	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
		<div class="container-fluid">
			<a class="backBtn" href="../parkingavailability.php">Back</a>
			<form id="staffEditProfile" action="submitedit.php" method="POST" role="form" enctype="multipart/form-data">
				<input type="hidden" name="role" value="admin">
				<div class="form-group">
					<label for="name">Name</label>
					<p id="warningName" class="warningTxt"></p>
					<input type="text" class="form-control" id="name" value="<?php echo $admin->nama;?>"  name="name">
				</div>

				<div class="form-group">
					<label for="ktp">ID Card Number</label>
					<input type="text" class="form-control" id="ktp" value="<?php echo $admin->ktp;?>" readonly name="ktp">
				</div>

				<div class="form-group">
					<label for="address">Address</label>
					<p id="warningAddress" class="warningTxt"></p>
					<textarea name="address" id="address" class="form-control" rows="3"><?php echo $admin->alamat;?></textarea>
				</div>

				<div class="form-group">
					<label for="gender">Gender</label>
					<input type="text" class="form-control" id="gender" value="<?php echo $admin->gender;?>" readonly name="gender">
				</div>

				<div class="form-group">
					<label for="tglLahir">Birth Date</label>
					<input type="text" name="tglLahir" value="<?php echo $admin->tglLahir->format('d/m/y'); ?>" readonly id="tglLahir" class="form-control">
				</div>

				<div class="form-group">
					<label for="HP">Phone Number</label>
					<p id="warningHP" class="warningTxt"></p>
					<input type="text" class="form-control" id="HP" value="<?php echo $admin->hp; ?>" placeholder="Phone Number" name="hp">
				</div>

				<div class="form-group">
					<label for="tglGabung">Join Date</label>
					<input type="text" name="tglGabung" id="tglGabung" value="<?php echo $admin->tglGabung->format('d/m/y'); ?>" readonly class="form-control">
				</div>

				<div class="form-group">
					<label for="email">Email Address</label>
					<p id="warningEmail" class="warningTxt"></p>
					<input type="text" class="form-control" id="email" value="<?php echo $admin->email; ?>" readonly name="email">
				</div>

				<div class="form-group">
					<label for="password">Password</label>
					<p id="warningPassword" class="warningTxt"></p>
					<input type="password" class="form-control" id="password" value="<?php echo $admin->password; ?>" name="password">
				</div>

				<div class="form-group">
					<label for="picture">Profile Picure</label>
					<p id="warningPicture" class="warningTxt"></p>
					<input type="file" id="picture" name="picture">
				</div>
				<p class="light silver">Maximum image size : 2MB</p>

				<button type="submit" class="btn btn-primary">Submit</button>
			</form>
		</div>
	</div>
</body>
</html>