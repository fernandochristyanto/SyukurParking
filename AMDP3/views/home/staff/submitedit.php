<?php 
	session_start();
	include_once "$_SERVER[DOCUMENT_ROOT]/AMDP3/DAO/staffDAO.php";
	include_once "$_SERVER[DOCUMENT_ROOT]/AMDP3/model/staffmodel.php";

	$sdao = new StaffDAO();

	$staff = (object)$sdao->getById($_SESSION['id']); //gets current logged in staff

	$staff->setNama($_POST['name']);
	$staff->setAlamat($_POST['address']);
	$staff->setHp($_POST['hp']);
	$staff->setPassword($_POST['password']);

	if(is_uploaded_file($_FILES['picture']['tmp_name']))
	{
		if(isset($staff->picture))
		{
			unlink("$_SERVER[DOCUMENT_ROOT]/AMDP3/public/img/staff/".$staff->picture);
			move_uploaded_file($_FILES['picture']['tmp_name'], "$_SERVER[DOCUMENT_ROOT]/AMDP3/public/img/staff/".$staff->picture);
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
			move_uploaded_file($_FILES['picture']['tmp_name'], "$_SERVER[DOCUMENT_ROOT]/AMDP3/public/img/staff/".$pictureName.$ext);
			$staff->setPicture($pictureName.$ext);
		}
	}

	$sdao->update($staff);
	header("Location:../parkingavailability.php");
 ?>