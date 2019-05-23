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
</head>
<body>
	<?php 
		// MIDDLEWARE like
		session_start();
		if(isset($_SESSION['id']))
		{
			if($_SESSION['role']!='manager')
			{
				header("Location:../../index.php");
			}
		}
		else
		{
			header("Location:../../index.php");
		}
	?>
	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
		<div class="container-fluid assignAdminDiv">
			<h1>Assign Admin</h1>
			<a href="../parkingavailability.php">Back</a>
			<br clear="clearboth">
			<hr>
			<form method="POST" action="assignadmin.php">
				<table class="assignAdminTable">
					<tr>
						<td><div class="assignAdminHeader">#</div></td>
						<td><div class="assignAdminHeader">Name</div></td>
						<td><div class="assignAdminHeader">ID Card Number</div></td>
						<td><div class="assignAdminHeader">Phone Number</div></td>
						<td><div class="assignAdminHeader">Join Date</div></td>
						<td><div class="assignAdminHeader">Assign</div></td>
					</tr>
					<!-- to assign admin page -->
					<?php 
					include_once "$_SERVER[DOCUMENT_ROOT]/AMDP3/DAO/staffDAO.php";
					$staffDAO = new StaffDAO();
					$staffs = $staffDAO->getAll();
					$i = 1; //index
					//loop through staff arr of objs
					foreach ($staffs as $staff) 
					{
					?>
						<tr>
							<td><?php echo $i; $i++; ?></td>
							<td><?php echo $staff->Nama ?></td>
							<td><?php echo $staff->KTP ?></td>
							<td><?php echo $staff->HP ?></td>
							<td><?php echo $staff->TglGabung->format("Y-m-d"); ?></td>
							<td>
								<div class="checkbox">
									<label>
										<input type="checkbox" name="chosenstaff[]" value="<?php echo $staff->RegistrationID; ?>">
									</label>
								</div>
							</td>
						</tr>
					<?php 
					} 
					?>
				</table>
				<button type="Submit" class="btn btn-default">Assign as admin</button>
				<br clear="clearboth">
			</form>
		</div>
	</div>
</body>
</html>