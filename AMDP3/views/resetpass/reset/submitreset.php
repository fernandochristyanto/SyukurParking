<?php 
	if($_POST['role']=='customer')
	{
		include_once "$_SERVER[DOCUMENT_ROOT]/AMDP3/DAO/customerDAO.php";
		//customer req resetpass
		$hp = $_POST['hp'];
		$email = $_POST['email'];
		$customerDAO = new CustomerDAO();
		$customer = (object) $customerDAO->getByEmailAndHp($email, $hp);
		if(isset($customer->registrationId))	
		{
			$newPassword = strrev($customer->hp); //new pass

			//updates user
			$customer->setPassword($newPassword);
			$customerDAO->update($customer);

			//send email
			$msg = "Hello, ".$customer->nama.". This is your new password : ".$newPassword;
			$headers =  'MIME-Version: 1.0' . "\r\n"; 
			$headers .= 'From: SyukurParking <noreplysyukurparking@parking.com>' . "\r\n";
			$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n"; 
			mail($customer->email,"Syukur Parking Password Reset",$msg, $headers);

			//redirects
			header("Location:resetresult.php?ussr=1&uid=".$customer->registrationId);
		}
		else
		{
			header("Location:resetresult.php?ussr=0");
		}
	}
	else if($_POST['role'] == 'staff')
	{
		include_once "$_SERVER[DOCUMENT_ROOT]/AMDP3/DAO/staffDAO.php";
		//staff req resetpass
		$ktp = $_POST['ktp'];
		$tglLahir = $_POST['tglLahir'];
		$email = $_POST['email'];
		$staffDAO = new StaffDAO();
		$staff = (object) $staffDAO->getByKtptglLahirEmail($ktp, $tglLahir, $email);
		if(isset($staff->registrationId))	
		{
			$day = $staff->tglLahir->format("d");
			$mo = $staff->tglLahir->format("m");
			$year = $staff->tglLahir->format("Y");
			$newPassword = $day.''.$mo.''.$year; //new pass

			//updates staff
			$staff->setPassword($newPassword);
			$staffDAO->update($staff);

			//send email
			$msg = "Hello, ".$staff->nama.". This is your new password : ".$newPassword;
			$headers =  'MIME-Version: 1.0' . "\r\n"; 
			$headers .= 'From: SyukurParking <noreplysyukurparking@parking.com>' . "\r\n";
			$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n"; 
			mail($staff->email,"Syukur Parking Password Reset",$msg, $headers);

			//redirects
			header("Location:resetresult.php?ussr=2&uid=".$staff->registrationId);
		}
		else
		{
			header("Location:resetresult.php?ussr=0");
		}
	}
?>