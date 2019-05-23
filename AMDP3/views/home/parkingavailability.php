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
	<script type="text/javascript" src="/AMDP3/public/js/parkingavailability.js"></script>
	<style>
		body
		{
			background-color: #ecf0f1; /*Clouds*/
		}
	</style>
</head>
<body>
	<?php session_start(); ?>
	<?php include_once "checkbookingvalidity.php"; ?>
	<header>
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
			<div class="container-fluid">
				<h1>Parking Availability</h1>
				<ul>
					<li><a href="/AMDP3/views/home/parkingavailability.php">Parking Availability</a></li>
					<li><a href="">Home</a></li>
				</ul>
			</div>
		</div>
	</header>
	<?php 
	if(isset($_SESSION['id']))
	{ 
	?>
		<?php  
			include_once "$_SERVER[DOCUMENT_ROOT]/AMDP3/DAO/customerDAO.php";
			include_once "$_SERVER[DOCUMENT_ROOT]/AMDP3/DAO/staffDAO.php";
			include_once "$_SERVER[DOCUMENT_ROOT]/AMDP3/DAO/adminDAO.php";
			include_once "$_SERVER[DOCUMENT_ROOT]/AMDP3/DAO/trbookingDAO.php";
			include_once "$_SERVER[DOCUMENT_ROOT]/AMDP3/DAO/TrParkingDAO.php";
			include_once "$_SERVER[DOCUMENT_ROOT]/AMDP3/DAO/trParkingBookingDAO.php";

			if($_SESSION['role']=='customer')
			{
				$customerDAO = new CustomerDAO();
				$customer = (object) $customerDAO->getById($_SESSION['id']);
			}	
			else if($_SESSION['role']=='staff')
			{
				$staffDAO = new StaffDAO();
				$staff = (object) $staffDAO->getById($_SESSION['id']);
			}
			else if($_SESSION['role']=='admin')
			{
				$adminDAO = new AdminDAO();
				$admin = (object) $adminDAO->getById($_SESSION['id']);
			}
		?>
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
			<div class="container-fluid headerUser">
				<h4>
					Welcome, 
					<?php 
						if($_SESSION['role']=='customer')
						{		
							echo $customer->nama;
						}
						else if($_SESSION['role']=='staff')
						{
							echo $staff->nama;
						}
						else if($_SESSION['role']=='admin')
						{
							echo $admin->nama;
						}
						else if($_SESSION['role']=='manager')
						{
							echo "Manager";
						}
					?>
				</h4>
				<ul>
					<?php 
					$parkingIdFlag = 1;

					if($_SESSION['role']=='customer')
					{ 
						$tbdao = new TrBookingDAO();
						$trBookings = (object)$tbdao->getByRegistrationId($_SESSION['id']); //get bookings done yg customer
						foreach ($trBookings as $tb) //loop through booking done by this customer
						{
							$trParkingBooking = $tpbdao->getByBookingId($tb->BookingID); //for each trBooking, get trParkingBooking
							$trBooking = new TrBooking();
							$trBooking->setId($tb->BookingID);
							$trBooking->setRegistrationId($tb->RegistrationID);
							$trBooking->setParking($tb->Parking);
							$trBooking->setLicensePlate($tb->LicensePlate);
							$trBooking->setBookingTime($tb->BookingTime);
							if(!isset($trParkingBooking->parkingId)) //if parkingId is not set (booked but not yet entered)
							{
								$parkingIdFlag = 0;
								break;
							}
						}
						$flag = 0;
						if($parkingIdFlag==1) //this customer already parked
						{
							if(isset($trBooking->bookingId))
							{
								//if this customer has booked
								$tpbdao = new TrParkingBookingDAO();
								$trParkingBooking = $tpbdao->getByBookingId($trBooking->bookingId);
								if(isset($trParkingBooking->parkingId))
								{
									//if still in booking
									$tpdao = new TrParkingDAO();
									$trParking = $tpdao->getById($trParkingBooking->parkingId);

									if(isset($trParking->parkingId))
									{
										if(isset($trParking->out))
										{
											//already out
											$flag = 1;
										}
									}
								}
							}
						}
						if($parkingIdFlag == 0 && $flag == 0)
						{
							echo '<li>Booking ID : '.$trBooking->bookingId.'</li>';
						}
						else
						{
					?>
							<li><a href="customer/onlinebook.php">Online Booking</a></li>
					<?php 
						}
						?>
							<li><a href="customer/editprofile.php">Edit Profile</a></li>
					<?php
					}
					else if($_SESSION['role']=='staff')
					{ ?>
						<li><a href="staff/viewbooking.php">View Booking</a></li>
						<li><a href="staff/choosecheckout.php">Check out Parking</a></li>
						<li><a href="staff/editprofile.php">Edit Profile</a></li>
					<?php 
					}
					else if($_SESSION['role']=='manager')
					{ ?>
						<li><a href="manager/adminselection.php">Assign Admin</a></li>
						<li><a href="../register/staff.php">Register Staff</a></li>
					<?php 
					}
					else if($_SESSION['role']=='admin')
					{ ?>
						<li><a href="admin/mappingparkir.php">Mapping Parkir</a></li>
						<li><a href="admin/reporting/reporting.php">Reporting</a></li>
						<li><a href="../register/staff.php">Register Staff</a></li>
						<li><a href="admin/editprofile.php">Edit Profile</a></li>
					<?php 
					} ?>
					<!--  -->
					<?php 
					if($_SESSION['role']!='manager')
					{ ?>
						<!-- <li><a href="">Edit Profile</a></li> -->
					<?php 
					} ?>
					<li><a href="../logout.php">Logout</a></li>
				</ul>
				<br class="clearboth">
			</div>
		</div>
	<?php 
	} 
	else
	{
	?>	
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
			<div class="container-fluid">
				<section class="needLogin">
					<p><a href="../index.php">Login</a></p>
				</section>
			</div>
		</div>
	<?php 
	} 
	?>
	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
		<div class="container-fluid">
			<section class="parkingSpots">
				<!-- parking tables goes here (AJAX CALL from parkingavailability.js) -->
			</section>
		</div>
	</div>
</body>
</html>