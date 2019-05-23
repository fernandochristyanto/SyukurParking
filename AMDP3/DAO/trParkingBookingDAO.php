<?php  
	class TrParkingBookingDAO
	{
		//INSERT SP
		private $insertSP = 
		"CREATE PROCEDURE insertTrParkingBooking
			@parkingId INT,
			@bookingId INT,
			@bookingLocationId INT
		AS
		BEGIN
			INSERT INTO TrParkingBooking(ParkingID, BookingID, BookingLocationID)
			VALUES(@parkingId, @bookingId, @bookingLocationId)
		END
		";


		//UPDATE SP
		private $updateSP = 
		"
		CREATE PROCEDURE updateTrParkingBooking
			@parkingBookingId INT,
			@parkingId INT,
			@bookingId INT,
			@bookingLocationId INT
		AS
		BEGIN
			UPDATE TrParkingBooking SET 
			ParkingID = @parkingId,
			BookingID = @bookingId,
			BookingLocationID = @bookingLocationId
			WHERE ParkingBookingID = @parkingBookingId
		END
		";


		//DELETE SP
		private $deleteSP = 
		"
		CREATE PROCEDURE deleteTrParkingBooking
			@parkingBookingId INT
		AS
		BEGIN
			DELETE FROM TrParkingBooking 
			WHERE ParkingBookingID = @parkingBookingId
		END
		";


		//GET BY ID SP
		private $getByIdSP = 
		"
		CREATE PROCEDURE getTrParkingBookingById
			@parkingBookingId INT
		AS
		BEGIN
			SELECT * FROM TrParkingBooking
			WHERE ParkingBookingID = @parkingBookingId
		END
		";


		//GET ALL SP
		private $getAllSP = 
		"
		CREATE PROCEDURE getAllTrParkingBooking
		AS
		BEGIN
			SELECT * FROM TrParkingBooking
		END
		";


		//GET BY LOCATIONID
		private $getByParkingIdSP = 
		"
		CREATE PROCEDURE getTrParkingBookingByParkingId
			@parkingId INT
		AS
		BEGIN
			SELECT * FROM TrParkingBooking
			WHERE ParkingID = @parkingId
		END
		";



		private $getByBookingIdSP = 
		"
		CREATE PROCEDURE getTrParkingBookingByBookingId
			@bookingId INT
		AS
		BEGIN
			SELECT * FROM TrParkingBooking
			WHERE BookingID = @bookingId
		END
		";


		private $getByBookingLocationIdSP = 
		"
		CREATE PROCEDURE getTrParkingBookingByBookingLocationId
			@bookingLocationId INT
		AS
		BEGIN
			SELECT * FROM TrParkingBooking
			WHERE BookingLocationID = @bookingLocationId
		END
		";

		
		private $getAllActiveSP = 
		"
		CREATE PROCEDURE getAllActiveTrParkingBooking
		AS
		BEGIN
			SELECT * FROM TrParkingBooking
			WHERE ParkingID IS NOT NULL
		END
		";


		//==========================
		function insert(TrParkingBooking $trParkingBooking)
		{
			include "$_SERVER[DOCUMENT_ROOT]/AMDP3/DB/connection.php";

			$query = 
			"{CALL insertTrParkingBooking (?,?,?)}";

			//SP params
			$params = array(
	                array(&$trParkingBooking->parkingId, SQLSRV_PARAM_IN),
	                array(&$trParkingBooking->bookingId, SQLSRV_PARAM_IN),
	                array(&$trParkingBooking->bookingLocationId, SQLSRV_PARAM_IN)
	                );

			//execute SP
			$pst = sqlsrv_query($con, $query, $params);
			if($pst == false) //SP exec fails
			{
				$createSP = sqlsrv_query($con, $this->insertSP); //try to create SP
				$pst = sqlsrv_query($con, $query, $params);
			}
		}

		function update(TrParkingBooking $trParkingBooking)
		{
			include "$_SERVER[DOCUMENT_ROOT]/AMDP3/DB/connection.php";

			$query = 
			"{CALL updateTrParkingBooking (?,?,?,?)}";

			//SP params
			$params = array(
					array(&$trParkingBooking->parkingBookingId, SQLSRV_PARAM_IN),
					array(&$trParkingBooking->parkingId, SQLSRV_PARAM_IN),
	                array(&$trParkingBooking->bookingId, SQLSRV_PARAM_IN),
	                array(&$trParkingBooking->bookingLocationId, SQLSRV_PARAM_IN)
	                );

			//execute SP
			$pst = sqlsrv_query($con, $query, $params);
			if($pst == false) //SP exec fails
			{
				$createSP = sqlsrv_query($con, $this->updateSP); //try to create SP
				$pst = sqlsrv_query($con, $query, $params);
			}
		}

		function delete(TrParkingBooking $trParkingBooking)
		{
			include "$_SERVER[DOCUMENT_ROOT]/AMDP3/DB/connection.php";

			$query = 
			"{CALL deleteTrParkingBooking (?)}";

			//SP params
			$params = array(
					array(&$trParkingBooking->parkingBookingId, SQLSRV_PARAM_IN)
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
			"{CALL getAllTrParkingBooking}";

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
			include_once "$_SERVER[DOCUMENT_ROOT]/AMDP3/model/trparkingbookingmodel.php";

			$query = 
			"{CALL getTrParkingBookingById (?)}";

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
					$trParkingBooking = new TrParkingBooking();
					$trParkingBooking->setId($obj->ParkingBookingID);
					$trParkingBooking->setParkingId($obj->ParkingID);
					$trParkingBooking->setBookingId($obj->BookingID);
					$trParkingBooking->setBookingLocationId($obj->BookingLocationID);

					return $trParkingBooking;
				}
			}
		}


		function getByParkingId($id)
		{
			include "$_SERVER[DOCUMENT_ROOT]/AMDP3/DB/connection.php";
			include_once "$_SERVER[DOCUMENT_ROOT]/AMDP3/model/trparkingbookingmodel.php";

			$query = 
			"{CALL getTrParkingBookingByParkingId (?)}";

			$params = array(
					array(&$id, SQLSRV_PARAM_IN)
	                );

			//execute SP
			$pst = sqlsrv_query($con, $query, $params);
			if($pst == false) //SP exec fails
			{
				$createSP = sqlsrv_query($con, $this->getByParkingIdSP); //try to create SP
				$pst = sqlsrv_query($con, $query, $params);
			}
			if($pst)
			{
				while($obj = sqlsrv_fetch_object($pst))
				{
					//
					$trParkingBooking = new TrParkingBooking();
					$trParkingBooking->setId($obj->ParkingBookingID);
					$trParkingBooking->setParkingId($obj->ParkingID);
					$trParkingBooking->setBookingId($obj->BookingID);
					$trParkingBooking->setBookingLocationId($obj->BookingLocationID);

					return $trParkingBooking;
				}
			}
		}

		function getByBookingId($id)
		{
			include "$_SERVER[DOCUMENT_ROOT]/AMDP3/DB/connection.php";
			include_once "$_SERVER[DOCUMENT_ROOT]/AMDP3/model/trparkingbookingmodel.php";

			$query = 
			"{CALL getTrParkingBookingByBookingId (?)}";

			$params = array(
					array(&$id, SQLSRV_PARAM_IN)
	                );

			//execute SP
			$pst = sqlsrv_query($con, $query, $params);
			if($pst == false) //SP exec fails
			{
				$createSP = sqlsrv_query($con, $this->getByBookingIdSP); //try to create SP
				$pst = sqlsrv_query($con, $query, $params);
			}
			if($pst)
			{
				while($obj = sqlsrv_fetch_object($pst))
				{
					//
					$trParkingBooking = new TrParkingBooking();
					$trParkingBooking->setId($obj->ParkingBookingID);
					$trParkingBooking->setParkingId($obj->ParkingID);
					$trParkingBooking->setBookingId($obj->BookingID);
					$trParkingBooking->setBookingLocationId($obj->BookingLocationID);

					return $trParkingBooking;
				}
			}
		}

		function getByBookingLocationId($id)
		{
			include "$_SERVER[DOCUMENT_ROOT]/AMDP3/DB/connection.php";
			include_once "$_SERVER[DOCUMENT_ROOT]/AMDP3/model/trparkingbookingmodel.php";

			$query = 
			"{CALL getTrParkingBookingByBookingLocationId (?)}";

			$params = array(
					array(&$id, SQLSRV_PARAM_IN)
	                );

			//execute SP
			$pst = sqlsrv_query($con, $query, $params);
			if($pst == false) //SP exec fails
			{
				$createSP = sqlsrv_query($con, $this->getByBookingLocationIdSP); //try to create SP
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

		function getAllActive()
		{
			include "$_SERVER[DOCUMENT_ROOT]/AMDP3/DB/connection.php";

			$query = 
			"{CALL getAllActiveTrParkingBooking}";

			//execute SP
			$pst = sqlsrv_query($con, $query);
			if($pst == false) //SP exec fails
			{
				$createSP = sqlsrv_query($con, $this->getAllActiveSP); //try to create SP
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
	}
?>