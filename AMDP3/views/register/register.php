<?php  
	include "../../DAO/customerDAO.php";
	include "../../DAO/staffDAO.php";
	include "../../model/customermodel.php";
	include "../../model/staffmodel.php";

	$role = $_POST['role']; //customer | staff
	
	if($role == 'customer')
	{
		//randomize picture name
		$pictureName = strrev($_POST['hp']).strrev($_POST['name']);
		$pictureName = str_shuffle($pictureName);
		$pictureName = trim($pictureName," ");
		//gets extension
		$ext = substr($_FILES['picture']['name'], strrpos($_FILES['picture']['name'], '.'));
		//move pic
		move_uploaded_file($_FILES['picture']['tmp_name'], "$_SERVER[DOCUMENT_ROOT]/AMDP3/public/img/customer/".$pictureName.$ext);

		$customer = new Customer($_POST['name'],
		$_POST['address'], $_POST['hp'], $_POST['email'], $_POST['password'],$pictureName.$ext);

		$customerDAO = new CustomerDAO();
		$customerDAO->insert($customer);

		header("Location:../index.php");
	}
	else if($role == 'staff')
	{
		//randomize picture name
		$pictureName = strrev($_POST['hp']).strrev($_POST['name']).strrev($_POST['ktp']);
		$pictureName = str_shuffle($pictureName);
		$pictureName = trim($pictureName," ");
		//gets extension
		$ext = substr($_FILES['picture']['name'], strrpos($_FILES['picture']['name'], '.'));
		//move pic
		move_uploaded_file($_FILES['picture']['tmp_name'], "$_SERVER[DOCUMENT_ROOT]/AMDP3/public/img/staff/".$pictureName.$ext);

		$staff = new Staff($_POST['name'], $_POST['ktp'], $_POST['address'], $_POST['gender'], $_POST['tglLahir'], $_POST['hp'], $_POST['tglGabung'], $_POST['email'], $_POST['password'], $pictureName.$ext);	

		$staffDAO = new StaffDAO();
		$staffDAO->insert($staff);
		header("Location:../home/parkingavailability.php");
	}
?>