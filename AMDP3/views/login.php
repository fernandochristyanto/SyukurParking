<?php  
	include "../model/customermodel.php";
	include "../DAO/trregistrationDAO.php";
	include "$_SERVER[DOCUMENT_ROOT]/AMDP3/DB/connection.php";

	$email = $_POST['email'];
	$password = $_POST['password'];

	$trRegistrationDAO = new TrRegistrationDAO();
	$user =(object) $trRegistrationDAO->getByEmailAndPassword($email, $password);

	if($user->role == 'customer')
	{
		session_start();
		$_SESSION['id'] = $user->registrationId;
		$_SESSION['role'] = 'customer';
		header("Location:home/customer/onlinebook.php");
	}
	else if($user->role == 'staff')
	{
		session_start();
		$_SESSION['id'] = $user->registrationId;
		$_SESSION['role'] = 'staff';
		header("Location:home/parkingavailability.php");
	}
	else if($user->role == 'manager')
	{
		session_start();
		$_SESSION['id'] = $user->registrationId;
		$_SESSION['role'] = 'manager';
		header("Location:home/parkingavailability.php");
	}
	else if($user->role == 'admin')
	{
		session_start();
		$_SESSION['id'] = $user->registrationId;
		$_SESSION['role'] = 'admin';
		header("Location:home/parkingavailability.php");
	}
	else
	{
		header("Location:index.php");
	}
?>
