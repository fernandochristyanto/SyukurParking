<?php  
	class AdminDAO
	{
		//UPDATE SP
		private $updateSP = 
		"
		CREATE PROCEDURE updateAdmin
			@registrationID INT,
			@nama VARCHAR(255),
			@ktp VARCHAR(24),
			@alamat VARCHAR(255),
			@gender VARCHAR(24),
			@tglLahir DATE,
			@hp VARCHAR(24),
			@tglGabung DATE,
			@email VARCHAR(255),
			@password VARCHAR(255),
			@picture VARCHAR(255),
			@role VARCHAR(24)
		AS
		BEGIN
			UPDATE TrRegistration 
			SET 
			Nama = @nama,
			KTP = @ktp,
			Alamat = @alamat,
			Gender = @gender,
			TglLahir = @tglLahir,
			HP = @hp,
			TglGabung = @tglGabung,
			Email = @email,
			Password = @password,
			Picture = @picture,
			Role = @role
			WHERE Role LIKE 'admin' AND RegistrationID = @registrationID
		END
		";


		//DELETE SP
		private $deleteSP = 
		"
		CREATE PROCEDURE deleteAdmin
			@registrationID INT
		AS
		BEGIN
			DELETE FROM TrRegistration WHERE Role LIKE 'admin' AND RegistrationID = @registrationID
		END
		";


		//GET BY ID SP
		private $getByIdSP = 
		"
		CREATE PROCEDURE getAdminById
			@registrationID INT
		AS
		BEGIN
		SELECT * FROM TrRegistration WHERE RegistrationID = @registrationID AND Role = 'admin'
		END
		";


		//GET ALL SP
		private $getAllSP = 
		"
		CREATE PROCEDURE getAllAdmin
		AS
		BEGIN
			SELECT * FROM TrRegistration WHERE Role = 'admin'
		END
		";


		//==========================
		function update(Staff $staff)
		{
			include "$_SERVER[DOCUMENT_ROOT]/AMDP3/DB/connection.php";

			$query = 
			"{CALL updateAdmin (?,?,?,?,?,?,?,?,?,?,?,?)}";
			//SP params
			$params = array(
					array(&$staff->registrationId, SQLSRV_PARAM_IN),
	                array(&$staff->nama, SQLSRV_PARAM_IN),
	                array(&$staff->ktp, SQLSRV_PARAM_IN),
	                array(&$staff->alamat, SQLSRV_PARAM_IN),
	                array(&$staff->gender, SQLSRV_PARAM_IN),
	                array(&$staff->tglLahir, SQLSRV_PARAM_IN),
	                array(&$staff->hp, SQLSRV_PARAM_IN),
	                array(&$staff->tglGabung,SQLSRV_PARAM_IN),
	                array(&$staff->email, SQLSRV_PARAM_IN),
	                array(&$staff->password, SQLSRV_PARAM_IN),
	                array(&$staff->picture, SQLSRV_PARAM_IN),
	                array(&$staff->role, SQLSRV_PARAM_IN)
	                );

			//execute SP
			$pst = sqlsrv_query($con, $query, $params);
			if($pst == false) //SP exec fails
			{
				$createSP = sqlsrv_query($con, $this->updateSP); //try to create SP
				$pst = sqlsrv_query($con, $query, $params);
			}
		}

		function delete(Staff $staff)
		{
			include "$_SERVER[DOCUMENT_ROOT]/AMDP3/DB/connection.php";

			$query = 
			"{CALL deleteAdmin (?)}";

			//SP params
			$params = array(
					array(&$staff->registrationId, SQLSRV_PARAM_IN)
	                );

			//execute SP
			$pst = sqlsrv_query($con, $query, $params);
			if($pst == false) //SP exec fails
			{
				$createSP = sqlsrv_query($con, $this->deleteSP); //try to create SP
				$pst = sqlsrv_query($con, $query, $params);
			}
		}

		function getAll()
		{
			include "$_SERVER[DOCUMENT_ROOT]/AMDP3/DB/connection.php";

			$query = 
			"{CALL getAllAdmin}";

			//execute SP
			$pst = sqlsrv_query($con, $query);
			if($pst == false) //SP exec fails
			{
				$createSP = sqlsrv_query($con, $this->getAllSP); //try to create SP
				$pst = sqlsrv_query($con, $query, $params);
			}
			if($pst)
			{
				$result = array();
				while($obj = sqlsrv_fetch_object($pst))
				{
					$result[] = $obj;
				}
				return $result;
			}
		}

		function getById($id)
		{
			include "$_SERVER[DOCUMENT_ROOT]/AMDP3/DB/connection.php";
			include "$_SERVER[DOCUMENT_ROOT]/AMDP3/model/staffmodel.php";

			$query = 
			"{CALL getAdminById (?)}";

			$params = array(
					array(&$id, SQLSRV_PARAM_IN)
	                );

			//execute SP
			$pst = sqlsrv_query($con, $query, $params);
			if($pst == false) //SP exec fails
			{
				$createSP = sqlsrv_query($con, $this->getByIdSP); //try to create SP
				$pst = sqlsrv_query($con, $query, $params);
			}
			if($pst)
			{
				while($obj = sqlsrv_fetch_object($pst))
				{
					//
					$staff = new Staff($obj->Nama, $obj->KTP, $obj->Alamat, $obj->Gender, $obj->TglLahir, $obj->HP, $obj->TglGabung, $obj->Email, $obj->Password, $obj->Picture); 
					$staff->setId($obj->RegistrationID);
					return $staff;
				}
			}
		}
	}
?>