<?php  
	class TrBookingLocationDAO
	{
		//INSERT SP
		private $insertSP = 
		"CREATE PROCEDURE insertTrBookingLocation
			@locationId INT,
			@parkingRow INT,
			@parkingColumn INT
		AS
		BEGIN
			INSERT INTO TrBookingLocation(LocationID, ParkingRow, ParkingColumn)
			VALUES(@locationId, @parkingRow, @parkingColumn)
		END
		";


		//UPDATE SP
		private $updateSP = 
		"
		CREATE PROCEDURE updateTrBookingLocation
			@bookingLocationId INT,
			@locationId INT,
			@parkingRow INT,
			@parkingColumn INT
		AS
		BEGIN
			UPDATE TrBookingLocation SET
			LocationID = @locationId,
			ParkingRow = @parkingRow,
			ParkingColumn = @parkingColumn
			WHERE BookingLocationID = @bookingLocationId
		END
		";


		//DELETE SP
		private $deleteSP = 
		"
		CREATE PROCEDURE deleteTrBookingLocation
			@bookingLocationId INT
		AS
		BEGIN
			DELETE FROM TrBookingLocation
			WHERE BookingLocationID = @bookingLocationId
		END
		";


		//GET BY ID SP
		private $getByIdSP = 
		"
		CREATE PROCEDURE getTrBookingLocationById
			@bookingLocationId INT
		AS
		BEGIN
			SELECT * FROM TrBookingLocation
			WHERE BookingLocationID = @bookingLocationId
		END
		";


		//GET ALL SP
		private $getAllSP = 
		"
		CREATE PROCEDURE getAllTrBookingLocation
		AS
		BEGIN
			SELECT * FROM TrBookingLocation
		END
		";


		//GET BY LOCATIONID
		private $getByLocationIdSP = 
		"
		CREATE PROCEDURE getTrBookingLocationByLocationId
			@locationId INT
		AS
		BEGIN
			SELECT * FROM TrBookingLocation
			WHERE LocationID = @locationId
		END
		";


		//==========================
		function insert(TrBookingLocation $trBookingLocation)
		{
			include "$_SERVER[DOCUMENT_ROOT]/AMDP3/DB/connection.php";

			$query = 
			"{CALL insertTrBookingLocation (?,?,?)}";

			//SP params
			$params = array(
	                array(&$trBookingLocation->locationId, SQLSRV_PARAM_IN),
	                array(&$trBookingLocation->parkingRow, SQLSRV_PARAM_IN),
	                array(&$trBookingLocation->parkingColumn, SQLSRV_PARAM_IN)
	                );

			//execute SP
			$pst = sqlsrv_query($con, $query, $params);
			if($pst == false) //SP exec fails
			{
				$createSP = sqlsrv_query($con, $this->insertSP); //try to create SP
				$pst = sqlsrv_query($con, $query, $params);
			}
		}

		function update(TrBookingLocation $trBookingLocation)
		{
			include "$_SERVER[DOCUMENT_ROOT]/AMDP3/DB/connection.php";

			$query = 
			"{CALL updateTrBookingLocation (?,?,?,?)}";

			//SP params
			$params = array(
					array(&$trBookingLocation->bookingLocationId, SQLSRV_PARAM_IN),
					array(&$trBookingLocation->locationId, SQLSRV_PARAM_IN),
	                array(&$trBookingLocation->parkingRow, SQLSRV_PARAM_IN),
	                array(&$trBookingLocation->parkingColumn, SQLSRV_PARAM_IN)
	                );

			//execute SP
			$pst = sqlsrv_query($con, $query, $params);
			if($pst == false) //SP exec fails
			{
				$createSP = sqlsrv_query($con, $this->updateSP); //try to create SP
				$pst = sqlsrv_query($con, $query, $params);
			}
		}

		function delete(TrBookingLocation $trBookingLocation)
		{
			include "$_SERVER[DOCUMENT_ROOT]/AMDP3/DB/connection.php";

			$query = 
			"{CALL deleteTrBookingLocation (?)}";

			//SP params
			$params = array(
					array(&$trBookingLocation->bookingLocationId, SQLSRV_PARAM_IN)
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
			"{CALL getAllTrBookingLocation}";

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
			include_once "$_SERVER[DOCUMENT_ROOT]/AMDP3/model/trbookinglocationmodel.php";

			$query = 
			"{CALL getTrBookingLocationById (?)}";

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
					$trBookingLocation = new TrBookingLocation();
					$trBookingLocation->setId($obj->BookingLocationID);
					$trBookingLocation->setLocationId($obj->LocationID);
					$trBookingLocation->setParkingRow($obj->ParkingRow);
					$trBookingLocation->setParkingColumn($obj->ParkingColumn);

					return $trBookingLocation;
				}
			}
		}


		function getByLocationId($id)
		{
			include "$_SERVER[DOCUMENT_ROOT]/AMDP3/DB/connection.php";
			include_once "$_SERVER[DOCUMENT_ROOT]/AMDP3/model/trbookinglocationmodel.php";

			$query = 
			"{CALL getTrBookingLocationByLocationId (?)}";

			$params = array(
					array(&$id, SQLSRV_PARAM_IN)
	                );

			//execute SP
			$pst = sqlsrv_query($con, $query, $params);
			if($pst == false) //SP exec fails
			{
				$createSP = sqlsrv_query($con, $this->getByLocationIdSP); //try to create SP
				$pst = sqlsrv_query($con, $query, $params);
			}
			if($pst)
			{
				while($obj = sqlsrv_fetch_object($pst))
				{
					//
					$trBookingLocation = new TrBookingLocation();
					$trBookingLocation->setId($obj->BookingLocationID);
					$trBookingLocation->setLocationId($obj->LocationID);
					$trBookingLocation->setParkingRow($obj->ParkingRow);
					$trBookingLocation->setParkingColumn($obj->ParkingColumn);

					return $trBookingLocation;
				}
			}
		}
	}
?>