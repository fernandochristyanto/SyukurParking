<?php 
	session_start();
	include_once "$_SERVER[DOCUMENT_ROOT]/AMDP3/model/customermodel.php";
	include_once "$_SERVER[DOCUMENT_ROOT]/AMDP3/DAO/customerDAO.php";

	$cdao = new CustomerDAO();

	$customer = (object)$cdao->getById($_SESSION['id']); //gets current logged in customer

	$customer->setNama($_POST['name']);
	$customer->setAlamat($_POST['address']);
	$customer->setHp($_POST['hp']);
	$customer->setPassword($_POST['password']);
	if(is_uploaded_file($_FILES['picture']['tmp_name']))
	{
		if(isset($customer->picture))
		{
			unlink("$_SERVER[DOCUMENT_ROOT]/AMDP3/public/img/customer/".$customer->picture);
			move_uploaded_file($_FILES['picture']['tmp_name'], "$_SERVER[DOCUMENT_ROOT]/AMDP3/public/img/customer/".$customer->picture);
		}
		else //just uploaded
		{
			//randomize picture name
			$pictureName = strrev($_POST['hp']).strrev($_POST['name']).strrev($_POST['ktp']);
			$pictureName = str_shuffle($pictureName);
			$pictureName = trim($pictureName," ");
			//gets extension
			$ext = substr($_FILES['picture']['name'], strrpos($_FILES['picture']['name'], '.'));
			//move pic
			move_uploaded_file($_FILES['picture']['tmp_name'], "$_SERVER[DOCUMENT_ROOT]/AMDP3/public/img/customer/".$pictureName.$ext);
			$customer->setPicture($pictureName.$ext);
		}
	}
	$cdao->update($customer);
	header("Location:../parkingavailability.php");
 ?>