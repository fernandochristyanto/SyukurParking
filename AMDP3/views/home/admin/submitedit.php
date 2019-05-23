<?php 
	session_start();
	include_once "$_SERVER[DOCUMENT_ROOT]/AMDP3/DAO/adminDAO.php";
	include_once "$_SERVER[DOCUMENT_ROOT]/AMDP3/model/adminmodel.php";

	$adao = new AdminDAO();

	$admin = (object)$adao->getById($_SESSION['id']); //gets current logged in admin

	$admin->setNama($_POST['name']);
	$admin->setAlamat($_POST['address']);
	$admin->setHp($_POST['hp']);
	$admin->setPassword($_POST['password']);
	if(is_uploaded_file($_FILES['picture']['tmp_name']))
	{
		if(isset($admin->picture))
		{
			unlink("$_SERVER[DOCUMENT_ROOT]/AMDP3/public/img/staff/".$admin->picture);
			move_uploaded_file($_FILES['picture']['tmp_name'], "$_SERVER[DOCUMENT_ROOT]/AMDP3/public/img/staff/".$admin->picture);
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
			$admin->setPicture($pictureName.$ext);
		}
	}
	$admin->setRole('admin');
	$adao->update($admin);
	header("Location:../parkingavailability.php");
 ?>