<?php  
	class CustomerDAO
	{
		//INSERT SP
		private $insertSP = 
		"CREATE PROCEDURE insertCustomer
			@nama VARCHAR(255),
			@alamat VARCHAR(255),
			@hp VARCHAR(24),
			@email VARCHAR(255),
			@password VARCHAR(255),
			@picture VARCHAR(255)
		AS
		BEGIN
			INSERT INTO TrRegistration (Nama, Alamat, HP, Email, Password, Picture, Role) 
			VALUES (@nama, @alamat, @hp, @email, @password, @picture, 'customer');
		END
		";


		//UPDATE SP
		private $updateSP = 
		"
		CREATE PROCEDURE updateCustomer
			@registrationID INT,
			@nama VARCHAR(255),
			@alamat VARCHAR(255),
			@hp VARCHAR(24),
			@email VARCHAR(255),
			@password VARCHAR(255),
			@picture VARCHAR(255)
		AS
		BEGIN
			UPDATE TrRegistration 
			SET 
			Nama = @nama,
			Alamat = @alamat,
			HP = @hp,
			Email = @email,
			Password = @password,
			Picture = @picture
			WHERE Role LIKE 'customer' AND RegistrationID = @registrationID
		END
		";


		//DELETE SP
		private $deleteSP = 
		"
		CREATE PROCEDURE deleteCustomer
			@registrationID INT
		AS
		BEGIN
			DELETE FROM TrRegistration WHERE Role LIKE 'customer' AND RegistrationID = @registrationID
		END
		";


		//GET BY ID SP
		private $getByIdSP = 
		"
		CREATE PROCEDURE getCustomerById
			@registrationID INT
		AS
		BEGIN
			SELECT * FROM TrRegistration WHERE RegistrationID = @registrationID AND Role = 'customer'
		END
		";


		//GET ALL SP
		private $getAllSP = 
		"
		CREATE PROCEDURE getAllCustomer
		AS
		BEGIN
			SELECT * FROM TrRegistration WHERE Role = 'customer'
		END
		";


		//GET BY EMAIL AND HP
		private $getByEmailAndHpSP = 
		"
		CREATE PROCEDURE getCustomerByEmailAndHp
			@email VARCHAR(255),
			@hp VARCHAR(24)
		AS
		BEGIN
			SELECT * FROM TrRegistration WHERE Role = 'customer' AND Email = @email AND HP = @hp
		END
		";


		//==========================
		function insert(Customer $customer)
		{
			include "$_SERVER[DOCUMENT_ROOT]/AMDP3/DB/connection.php";

			$query = 
			"{CALL insertCustomer (?,?,?,?,?,?)}";

			//SP params
			$params = array(
	                array(&$customer->nama, SQLSRV_PARAM_IN),
	                array(&$customer->alamat, SQLSRV_PARAM_IN),
	                array(&$customer->hp, SQLSRV_PARAM_IN),
	                array(&$customer->email, SQLSRV_PARAM_IN),
	                array(&$customer->password, SQLSRV_PARAM_IN),
	                array(&$customer->picture, SQLSRV_PARAM_IN)
	                );

			//execute SP
			$pst = sqlsrv_query($con, $query, $params);
			if($pst == false) //SP exec fails
			{
				$createSP = sqlsrv_query($con, $this->insertSP); //try to create SP
				$pst = sqlsrv_query($con, $query, $params);
			}
		}

		function update(Customer $customer)
		{
			include "$_SERVER[DOCUMENT_ROOT]/AMDP3/DB/connection.php";

			$query = 
			"{CALL updateCustomer (?,?,?,?,?,?,?)}";

			//SP params
			$params = array(
					array(&$customer->registrationId, SQLSRV_PARAM_IN),
	                array(&$customer->nama, SQLSRV_PARAM_IN),
	                array(&$customer->alamat, SQLSRV_PARAM_IN),
	                array(&$customer->hp, SQLSRV_PARAM_IN),
	                array(&$customer->email, SQLSRV_PARAM_IN),
	                array(&$customer->password, SQLSRV_PARAM_IN),
	                array(&$customer->picture, SQLSRV_PARAM_IN)
	                );

			//execute SP
			$pst = sqlsrv_query($con, $query, $params);
			if($pst == false) //SP exec fails
			{
				$createSP = sqlsrv_query($con, $this->updateSP); //try to create SP
				$pst = sqlsrv_query($con, $query, $params);
			}
		}

		function delete(Customer $customer)
		{
			include "$_SERVER[DOCUMENT_ROOT]/AMDP3/DB/connection.php";

			$query = 
			"{CALL deleteCustomer (?)}";

			//SP params
			$params = array(
					array(&$customer->registrationId, SQLSRV_PARAM_IN)
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
			"{CALL getAllCustomer}";

			//execute SP
			$pst = sqlsrv_query($con, $query);
			if($pst == false) //SP exec fails
			{
				$createSP = sqlsrv_query($con, $this->getAllSP); //try to create SP
				$pst = sqlsrv_query($con, $query);
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
			include_once "$_SERVER[DOCUMENT_ROOT]/AMDP3/model/customermodel.php";

			$query = 
			"{CALL getCustomerById (?)}";

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
					$customer = new Customer($obj->Nama, $obj->Alamat, $obj->HP, $obj->Email, $obj->Password, $obj->Picture); 
					$customer->setId($obj->RegistrationID);
					return $customer;
				}
			}
		}


		function getByEmailAndHp($email, $hp)
		{
			include "$_SERVER[DOCUMENT_ROOT]/AMDP3/DB/connection.php";
			include "$_SERVER[DOCUMENT_ROOT]/AMDP3/model/customermodel.php";

			$query = 
			"{CALL getCustomerByEmailAndHp (?,?)}";

			$params = array(
					array(&$email, SQLSRV_PARAM_IN),
					array(&$hp,SQLSRV_PARAM_IN)
	                );

			//execute SP
			$pst = sqlsrv_query($con, $query, $params);
			if($pst == false) //SP exec fails
			{
				$createSP = sqlsrv_query($con, $this->getByEmailAndHpSP); //try to create SP
				$pst = sqlsrv_query($con, $query, $params);
			}
			if($pst)
			{
				while($obj = sqlsrv_fetch_object($pst))
				{
					//
					$customer = new Customer($obj->Nama, $obj->Alamat, $obj->HP, $obj->Email, $obj->Password, $obj->Picture); 
					$customer->setId($obj->RegistrationID);
					return $customer;
				}
				return null;
			}
		}
	}
?>