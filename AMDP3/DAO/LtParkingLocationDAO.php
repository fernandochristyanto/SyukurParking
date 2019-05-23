<?php  
	class LtParkingLocationDAO
	{
		//INSERT SP
		private $insertSP = 
		"CREATE PROCEDURE insertLtParkingLocation
			@locationName VARCHAR(255),
			@parkingSpace INT
		AS
		BEGIN
			INSERT INTO LtParkingLocation(LocationName, ParkingSpace) 
			VALUES(@locationName, @parkingSpace)
		END
		";


		//UPDATE SP
		private $updateSP = 
		"
		CREATE PROCEDURE updateLtParkingLocation
			@locationId INT,
			@locationName VARCHAR(255),
			@parkingSpace INT
		AS
		BEGIN
			UPDATE LtParkingLocation 
			SET LocationName = @locationName,
			ParkingSpace = @parkingSpace
			WHERE LocationID = @locationId 
		END
		";


		//DELETE SP
		private $deleteSP = 
		"
		CREATE PROCEDURE deleteLtParkingLocation
			@locationId INT
		AS
		BEGIN
			DELETE FROM LtParkingLocation WHERE LocationID = @locationId
		END
		";


		//GET BY ID SP
		private $getByIdSP = 
		"
		CREATE PROCEDURE getLtParkingLocationById
			@locationId INT
		AS
		BEGIN
			SELECT * FROM LtParkingLocation
			WHERE LocationID = @locationId
		END
		";


		//GET ALL SP
		private $getAllSP = 
		"
		CREATE PROCEDURE getAllLtParkingLocation
		AS
		BEGIN
			SELECT * FROM LtParkingLocation
		END
		";


		private $currIdSP = 
		"
		CREATE PROCEDURE getCurrLtParkingLocationId
		AS
		BEGIN
			SELECT IDENT_CURRENT('LtParkingLocation') as id
		END
		";


		//==========================
		function insert(LtParkingLocation $ltParkingLocation)
		{
			include "$_SERVER[DOCUMENT_ROOT]/AMDP3/DB/connection.php";

			$query = 
			"{CALL insertLtParkingLocation (?,?)}";

			//SP params
			$params = array(
	                array(&$ltParkingLocation->locationName, SQLSRV_PARAM_IN),
	                array(&$ltParkingLocation->parkingSpace, SQLSRV_PARAM_IN)
	                );

			//execute SP
			$pst = sqlsrv_query($con, $query, $params);
			if($pst == false) //SP exec fails
			{
				$createSP = sqlsrv_query($con, $this->insertSP); //try to create SP
				$pst = sqlsrv_query($con, $query, $params);
			}
		}

		function update(LtParkingLocation $ltParkingLocation)
		{
			include "$_SERVER[DOCUMENT_ROOT]/AMDP3/DB/connection.php";

			$query = 
			"{CALL updateLtParkingLocation (?,?,?)}";

			//SP params
			$params = array(
					array(&$ltParkingLocation->locationId, SQLSRV_PARAM_IN),
	                array(&$ltParkingLocation->locationName, SQLSRV_PARAM_IN),
	                array(&$ltParkingLocation->parkingSpace, SQLSRV_PARAM_IN)
	                );

			//execute SP
			$pst = sqlsrv_query($con, $query, $params);
			if($pst == false) //SP exec fails
			{
				$createSP = sqlsrv_query($con, $this->updateSP); //try to create SP
				$pst = sqlsrv_query($con, $query, $params);
			}
		}

		function delete(LtParkingLocation $ltParkingLocation)
		{
			include "$_SERVER[DOCUMENT_ROOT]/AMDP3/DB/connection.php";

			$query = 
			"{CALL deleteLtParkingLocation (?)}";

			//SP params
			$params = array(
					array(&$ltParkingLocation->locationId, SQLSRV_PARAM_IN)
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
			"{CALL getAllLtParkingLocation}";

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
			include "$_SERVER[DOCUMENT_ROOT]/AMDP3/model/ltparkinglocationmodel.php";

			$query = 
			"{CALL getLtParkingLocationById (?)}";

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
					$ltParkingLocation = new LtParkingLocation();
					$ltParkingLocation->setId($obj->LocationID);
					$ltParkingLocation->setLocationName($obj->LocationName);
					$ltParkingLocation->setParkingSpace($obj->ParkingSpace);

					return $ltParkingLocation;
				}
			}
		}


		function getCurrId()
		{
			include "$_SERVER[DOCUMENT_ROOT]/AMDP3/DB/connection.php";

			$query = 
			"{CALL getCurrLtParkingLocationId}";	

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