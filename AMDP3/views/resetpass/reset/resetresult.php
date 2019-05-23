<!DOCTYPE html>
<html>
<head>
	<title>SyukurParking</title>
</head>
<body>
	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
		<div class="container-fluid">
			<?php 
			if($_GET['ussr'] == 0)
			{ ?>
				<h1>Cannot find user</h1>
				<hr>
				<a href="../../index.php">Back to login</a>
			<?php 
			}
			else if($_GET['ussr'] == 1)
			{?>
				<h1>An email has been sent to 
					<?php 
						include_once "$_SERVER[DOCUMENT_ROOT]/AMDP3/DAO/customerDAO.php"; 
						$customerDAO = new CustomerDAO();
						$customer = $customerDAO->getById($_GET['uid']);
						echo $customer->email;
					?>
				</h1>
				<hr>
				<a href="../../index.php">Back to Login</a>
			<?php 
			} 
			else if($_GET['ussr'] == 2)
			{?>
				<h1>An email has been sent to 
					<?php 
						include_once "$_SERVER[DOCUMENT_ROOT]/AMDP3/DAO/staffDAO.php"; 
						$staffDAO = new StaffDAO();
						$staff = $staffDAO->getById($_GET['uid']);
						echo $staff->email;
					?>
				</h1>
				<hr>
				<a href="../../index.php">Back to Login</a>
			<?php 
			} ?>
		</div>
	</div>
</body>
</html>