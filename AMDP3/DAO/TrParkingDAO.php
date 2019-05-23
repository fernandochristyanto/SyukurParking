<?php  
	class TrParkingDAO
	{
		//INSERT SP
		private $insertSP = 
		"
		CREATE PROCEDURE insertTrParking
			@locationId INT,
			@memberId INT,
			@intime DATETIME,
			@out DATETIME,
			@vehicleType VARCHAR(24),
			@staff VARCHAR(255)
		AS
		BEGIN
			INSERT INTO TrParking(LocationID, MemberID, INTIME, OUT, VehicleType, Staff)
			VALUES(@locationId, @memberId, @intime, @out, @vehicleType,@staff)
		END
		";


		//UPDATE SP
		private $updateSP = 
		"
		CREATE PROCEDURE updateTrParking
			@parkingId INT,
			@locationId INT,
			@memberId INT,
			@intime DATETIME,
			@out DATETIME,
			@vehicleType VARCHAR(24),
			@staff VARCHAR(255)
		AS
		BEGIN
			UPDATE TrParking SET 
			LocationID = @locationId,
			MemberID = @memberId,
			INTIME = @intime,
			OUT = @out,
			VehicleType = @vehicleType,
			Staff = @staff
			WHERE ParkingID = @parkingId
		END
		";


		//DELETE SP
		private $deleteSP = 
		"
		CREATE PROCEDURE deleteTrParking
			@parkingId INT,
		AS
		BEGIN
			DELETE FROM TrParking WHERE ParkingID = @parkingId
		END
		";


		//GET BY ID SP
		private $getByIdSP = 
		"
		CREATE PROCEDURE getTrParkingById
			@parkingId INT
		AS
		BEGIN
			SELECT * FROM TrParking
			WHERE ParkingID = @parkingId
		END
		";


		// GET BY PARKING ID SP
		private $getByParkingIdSP = 
		"
		CREATE PROCEDURE getTrParkingByParkingId
			@parkingId INT
		AS
		BEGIN
			SELECT * FROM TrParking
			WHERE ParkingID = @parkingId
		END
		";

		private $getReportingSP = 
		"
		CREATE PROCEDURE getTrParkingReport
			@startD INT,
			@endD INT,
			@startMo INT,
			@endMo INT,
			@startY INT,
			@endY INT
		AS
		BEGIN
			SELECT * FROM TrParking 
			WHERE MONTH(INTIME) BETWEEN @startMo AND @endMo
			AND DAY(INTIME) BETWEEN @startD AND @endD
			AND YEAR(INTIME) BETWEEN @startY AND @endY
			AND TrParking.OUT IS NOT NULL
		END
		";


		//GET ALL SP
		private $getAllSP = 
		"
		CREATE PROCEDURE getAllTrParking
		AS
		BEGIN
			SELECT * FROM TrParking
		END
		";


		private $currIdSP = 
		"
		CREATE PROCEDURE getCurrTrParkingId
		AS
		BEGIN
			SELECT IDENT_CURRENT('TrParking') as id
		END
		";


		//==========================
		function insert(TrParking $trParking)
		{
			include "$_SERVER[DOCUMENT_ROOT]/AMDP3/DB/connection.php";

			$query = 
			"{CALL insertTrParking (?,?,?,?,?,?)}";

			//SP params
			$params = array(
	                array(&$trParking->locationId, SQLSRV_PARAM_IN),
	              	array(&$trParking->memberId, SQLSRV_PARAM_IN),
	                array(&$trParking->intime, SQLSRV_PARAM_IN),
	                array(&$trParking->out, SQLSRV_PARAM_IN),
	                array(&$trParking->vehicleType, SQLSRV_PARAM_IN),
	                array(&$trParking->staff, SQLSRV_PARAM_IN)
	                );

			//execute SP
			$pst = sqlsrv_query($con, $query, $params);
			if($pst == false) //SP exec fails
			{
				$createSP = sqlsrv_query($con, $this->insertSP); //try to create SP
				$pst = sqlsrv_query($con, $query, $params);
			}
		}

		function update(TrParking $trParking)
		{
			include "$_SERVER[DOCUMENT_ROOT]/AMDP3/DB/connection.php";

			$query = 
			"{CALL updateTrParking (?,?,?,?,?,?,?)}";

			//SP params
			$params = array(
					array(&$trParking->parkingId, SQLSRV_PARAM_IN),
					array(&$trParking->locationId, SQLSRV_PARAM_IN),
	              	array(&$trParking->memberId, SQLSRV_PARAM_IN),
	                array(&$trParking->intime, SQLSRV_PARAM_IN),
	                array(&$trParking->out, SQLSRV_PARAM_IN),
	                array(&$trParking->vehicleType, SQLSRV_PARAM_IN),
	                array(&$trParking->staff, SQLSRV_PARAM_IN)
	                );

			//execute SP
			$pst = sqlsrv_query($con, $query, $params);
			if($pst == false) //SP exec fails
			{
				$createSP = sqlsrv_query($con, $this->updateSP); //try to create SP
				$pst = sqlsrv_query($con, $query, $params);
			}
		}

		function delete(TrParking $trParking)
		{
			include "$_SERVER[DOCUMENT_ROOT]/AMDP3/DB/connection.php";

			$query = 
			"{CALL deleteTrParking (?)}";

			//SP params
			$params = array(
					array(&$trParking->parkingId, SQLSRV_PARAM_IN)
	                );

			//execute SP
			$pst = sqlsrv_query($con, $query, $params);
			if($pst == false) //SP exec fails
			{
				$createSP = sqlsrv_query($con, $this->deleteSP); //try to create SP
				$pst = sqlsrv_query($con, $query, $params);
			}
		}

		function getReporting($startD, $endD, $startMo, $endMo, $startY, $endY)
		{
			include "$_SERVER[DOCUMENT_ROOT]/AMDP3/DB/connection.php";

			$query = 
			"{CALL getTrParkingReport(?,?,?,?,?,?)}";

			$params = array(
				array(&$startD, SQLSRV_PARAM_IN),
				array(&$endD, SQLSRV_PARAM_IN),
              	array(&$startMo, SQLSRV_PARAM_IN),
                array(&$endMo, SQLSRV_PARAM_IN),
                array(&$startY, SQLSRV_PARAM_IN),
                array(&$endY, SQLSRV_PARAM_IN)
                );

			//execute SP
			$pst = sqlsrv_query($con, $query, $params);
			if($pst == false) //SP exec fails
			{
				$createSP = sqlsrv_query($con, $this->getReportingSP); //try to create SP
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

		function getAll()
		{
			include "$_SERVER[DOCUMENT_ROOT]/AMDP3/DB/connection.php";

			$query = 
			"{CALL getAllTrParking}";

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
			include_once "$_SERVER[DOCUMENT_ROOT]/AMDP3/model/trparkingmodel.php";

			$query = 
			"{CALL getTrParkingById (?)}";

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
					$trParking = new TrParking();
					$trParking->setId($obj->ParkingID);
					$trParking->setLocationId($obj->LocationID);
					$trParking->setMemberId($obj->MemberID);
					$trParking->setInTime($obj->INTIME);
					$trParking->setOut($obj->OUT);
					$trParking->setVehicleType($obj->VehicleType);
					$trParking->setStaff($obj->Staff);

					return $trParking;
				}
			}
		}


		function getCurrId()
		{
			include "$_SERVER[DOCUMENT_ROOT]/AMDP3/DB/connection.php";

			$query = 
			"{CALL getCurrTrParkingId}";	

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