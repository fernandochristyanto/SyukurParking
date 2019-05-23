<?php  
	class TrBookingDAO
	{
		//INSERT SP
		private $insertSP = 
		"CREATE PROCEDURE insertTrBooking
			@registrationId INT,
			@parking VARCHAR(24),
			@licensePlate VARCHAR(24),
			@bookingTime DATETIME
		AS
		BEGIN
			INSERT INTO TrBooking(RegistrationID, Parking, LicensePlate, BookingTime)
			VALUES(@registrationId, @parking, @licensePlate, @bookingTime)
		END
		";


		//UPDATE SP
		private $updateSP = 
		"
		CREATE PROCEDURE updateTrBooking
			@bookingId INT,
			@registrationId INT,
			@parking VARCHAR(24),
			@licensePlate VARCHAR(24),
			@bookingTime DATETIME
		AS
		BEGIN
			UPDATE TrBooking SET
			RegistrationID = @registrationId,
			Parking = @parking,
			LicensePlate = @licensePlate,
			BookingTime = @bookingTime
			WHERE BookingID = @bookingId
		END
		";


		//DELETE SP
		private $deleteSP = 
		"
		CREATE PROCEDURE deleteTrBooking
			@bookingId INT
		AS
		BEGIN
			DELETE FROM TrBooking
			WHERE BookingID = @bookingId
		END
		";


		//GET BY ID SP
		private $getByIdSP = 
		"
		CREATE PROCEDURE getTrBookingById
			@bookingId INT
		AS
		BEGIN
			SELECT * FROM TrBooking
			WHERE BookingID = @bookingId
		END
		";


		private $getByRegistrationIdSP = 
		"
		CREATE PROCEDURE getTrBookingByRegistrationId
			@registrationId INT
		AS
		BEGIN
			SELECT * FROM TrBooking
			WHERE RegistrationID = @registrationId
		END
		";


		private $getByLicensePlateSP = 
		"
		CREATE PROCEDURE getTrBookingByLicensePlate
			@licensePlate VARCHAR(255)
		AS
		BEGIN
			SELECT * FROM TrBooking
			WHERE LicensePlate = @licensePlate
		END
		";


		//GET ALL SP
		private $getAllSP = 
		"
		CREATE PROCEDURE getAllTrBooking
		AS
		BEGIN
			SELECT * FROM TrBooking
		END
		";


		private $currIdSP = 
		"
		CREATE PROCEDURE getCurrTrBookingId
		AS
		BEGIN
			SELECT IDENT_CURRENT('TrBooking') as id
		END
		";



		//==========================
		function insert(TrBooking $trBooking)
		{
			include "$_SERVER[DOCUMENT_ROOT]/AMDP3/DB/connection.php";

			$query = 
			"{CALL insertTrBooking (?,?,?,?)}";

			//SP params
			$params = array(
	                array(&$trBooking->registrationId, SQLSRV_PARAM_IN),
	                array(&$trBooking->parking, SQLSRV_PARAM_IN),
	                array(&$trBooking->licensePlate, SQLSRV_PARAM_IN),
	                array(&$trBooking->bookingTime, SQLSRV_PARAM_IN)
	                );

			//execute SP
			$pst = sqlsrv_query($con, $query, $params);
			if($pst == false) //SP exec fails
			{
				$createSP = sqlsrv_query($con, $this->insertSP); //try to create SP
				$pst = sqlsrv_query($con, $query, $params);
			}
		}

		function update(TrBooking $trBooking)
		{
			include "$_SERVER[DOCUMENT_ROOT]/AMDP3/DB/connection.php";

			$query = 
			"{CALL updateTrBooking (?,?,?,?,?)}";

			//SP params
			$params = array(
					array(&$trBooking->bookingId, SQLSRV_PARAM_IN),
					array(&$trBooking->registrationId, SQLSRV_PARAM_IN),
	                array(&$trBooking->parking, SQLSRV_PARAM_IN),
	                array(&$trBooking->licensePlate, SQLSRV_PARAM_IN),
	                array(&$trBooking->bookingTime, SQLSRV_PARAM_IN)
	                );

			//execute SP
			$pst = sqlsrv_query($con, $query, $params);
			if($pst == false) //SP exec fails
			{
				$createSP = sqlsrv_query($con, $this->updateSP); //try to create SP
				$pst = sqlsrv_query($con, $query, $params);
			}
		}

		function delete(TrBooking $trBooking)
		{
			include "$_SERVER[DOCUMENT_ROOT]/AMDP3/DB/connection.php";

			$query = 
			"{CALL deleteTrBooking (?)}";

			//SP params
			$params = array(
					array(&$trBooking->bookingId, SQLSRV_PARAM_IN)
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
			"{CALL getAllTrBooking}";

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
			include_once "$_SERVER[DOCUMENT_ROOT]/AMDP3/model/trbookingmodel.php";

			$query = 
			"{CALL getTrBookingById (?)}";

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
					$trBooking = new TrBooking();
					$trBooking->setId($obj->BookingID);
					$trBooking->setRegistrationId($obj->RegistrationID);
					$trBooking->setParking($obj->Parking);
					$trBooking->setLicensePlate($obj->LicensePlate);
					$trBooking->setBookingTime($obj->BookingTime);

					return $trBooking;
				}
			}
		}

		function getByRegistrationId($id)
		{
			include "$_SERVER[DOCUMENT_ROOT]/AMDP3/DB/connection.php";
			include_once "$_SERVER[DOCUMENT_ROOT]/AMDP3/model/trbookingmodel.php";

			$query = 
			"{CALL getTrBookingByRegistrationId (?)}";

			$params = array(
					array(&$id, SQLSRV_PARAM_IN)
	                );

			//execute SP
			$pst = sqlsrv_query($con, $query, $params);
			if($pst == false) //SP exec fails
			{
				$createSP = sqlsrv_query($con, $this->getByRegistrationIdSP); //try to create SP
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


		function getByLicensePlate($lp)
		{
			include "$_SERVER[DOCUMENT_ROOT]/AMDP3/DB/connection.php";
			include_once "$_SERVER[DOCUMENT_ROOT]/AMDP3/model/trbookingmodel.php";

			$query = 
			"{CALL getTrBookingByLicensePlate (?)}";

			$params = array(
					array(&$lp, SQLSRV_PARAM_IN)
	                );

			//execute SP
			$pst = sqlsrv_query($con, $query, $params);
			if($pst == false) //SP exec fails
			{
				$createSP = sqlsrv_query($con, $this->getByLicensePlateSP); //try to create SP
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


		function getCurrId()
		{
			include "$_SERVER[DOCUMENT_ROOT]/AMDP3/DB/connection.php";

			$query = 
			"{CALL getCurrTrBookingId}";	

			//execute SP
			$pst = sqlsrv_query($con, $query);
			if($pst == false) //SP exec fails
			{
				$createSP = sqlsrv_query($con, $this->currIdSP); //try to create SP
				$pst = sqlsrv_query($con, $query);
			}
			if($pst)
			{
				while($obj = sqlsrv_fetch_object($pst))
				{
					//
					$id = $obj->id;
					return $id;
				}
			}
		}
	}
?>