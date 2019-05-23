<?php  
	class TrRegistrationDAO
	{
		//GET ALL BY EMAIL AND PASSWORD
		private $getByEmailAndPasswordSP = 
		"
		CREATE PROCEDURE getTrRegistrationByEmailAndPassword
		@email VARCHAR(255),
		@password VARCHAR(255)
		AS
		BEGIN
			SELECT * 
			FROM TrRegistration 
			WHERE Email = @email AND Password = @password
		END
		";

		public function getByEmailAndPassword($email, $pass)
		{
			include "$_SERVER[DOCUMENT_ROOT]/AMDP3/DB/connection.php";
			include_once "../model/customermodel.php";
			include_once "../model/staffmodel.php";
			include_once "../model/managermodel.php";
			include_once "../model/adminmodel.php";

			$query = 
			"{CALL getTrRegistrationByEmailAndPassword (?,?)}";

			//SP params
			$params = array(
	                array(&$email, SQLSRV_PARAM_IN),
	                array(&$pass, SQLSRV_PARAM_IN)
	                );

			//execute SP
			$pst = sqlsrv_query($con, $query, $params);
			if(!$pst) //SP exec fails
			{
				$createSP = sqlsrv_query($con, $this->getByEmailAndPasswordSP); //try to create SP
				$pst = sqlsrv_query($con, $query, $params);
			}
			if(!$pst) {
			     die(print_r(sqlsrv_errors(), true));
			}
			
			while($obj = sqlsrv_fetch_object($pst))
			{
				if($obj->Role == 'customer')
				{
					$customer = new Customer($obj->Nama, $obj->Alamat, $obj->HP, $obj->Email, $obj->Password, $obj->Picture); 
					$customer->setId($obj->RegistrationID);
					return $customer;
				}
				else if($obj->Role == 'staff')
				{
					$staff = new Staff($obj->Nama, $obj->KTP, $obj->Alamat, $obj->Gender, $obj->TglLahir, $obj->HP, $obj->TglGabung, $obj->Email, $obj->Password, $obj->Picture) ; 
					$staff->setId($obj->RegistrationID);
					return $staff;
				}
				else if($obj->Role == 'manager')
				{
					$manager = new Manager($obj->Nama, $obj->KTP, $obj->Alamat, $obj->Gender, $obj->TglLahir, $obj->HP, $obj->TglGabung, $obj->Email, $obj->Password) ; 
					$manager->setId($obj->RegistrationID);
					return $manager;
				}
				else if($obj->Role == 'admin')
				{
					$admin = new Admin($obj->Nama, $obj->KTP, $obj->Alamat, $obj->Gender, $obj->TglLahir, $obj->HP, $obj->TglGabung, $obj->Email, $obj->Password) ; 
					$admin->setId($obj->RegistrationID);
					return $admin;
				}
			}
			return null;
		}
	}
?>