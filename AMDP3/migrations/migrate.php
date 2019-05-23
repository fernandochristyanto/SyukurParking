<?php  

	function createTrRegistration($con)
	{
		$query = 
		"CREATE TABLE TrRegistration
		(
		    RegistrationID INT not null IDENTITY(1, 1) PRIMARY KEY,
			Nama VARCHAR(255) NOT NULL,
			KTP VARCHAR(15),
			Alamat VARCHAR(255) NOT NULL,
		    Gender VARCHAR(24),
			TglLahir DATE,
			HP VARCHAR(24) NOT NULL,
			TglGabung DATE,
			Email VARCHAR(255) NOT NULL,
			Password VARCHAR(255),
			Picture VARCHAR(255),
			Role VARCHAR(24),
			StatusBan INT
		)
		";

		$result = sqlsrv_query($con, $query);
	}

	function createMsMember($con)
	{
		$query = 
		"CREATE TABLE MsMember
		(
			MemberID INT NOT NULL IDENTITY(1, 1) PRIMARY KEY,
			Nama VARCHAR(255) NOT NULL,
			KTP VARCHAR(15) NOT NULL,
			Alamat VARCHAR(255) NOT NULL,
			Gender VARCHAR(24) NOT NULL,
			TglLahir DATE NOT NULL,
			HP VARCHAR(24) NOT NULL,
			TglValid DATE,
			Email VARCHAR(255) NOT NULL,
			TagID VARCHAR(24)
		)
		";

		$result = sqlsrv_query($con, $query);
	}

	function createLtParkingLocation($con)
	{
		$query = 
		"
		CREATE TABLE LtParkingLocation
		(
			LocationID INT NOT NULL IDENTITY(1, 1) PRIMARY KEY,
			LocationName VARCHAR(255) NOT NULL,
			ParkingSpace INT
		)
		";

		$result = sqlsrv_query($con, $query);
	}

	function createTrBookingLocation($con)
	{
		$query = 
		"
		CREATE TABLE TrBookingLocation
		(
			BookingLocationID INT NOT NULL IDENTITY(1, 1) PRIMARY KEY,
			LocationID INT NOT NULL FOREIGN KEY(LocationID) REFERENCES LtParkingLocation(LocationID) ON UPDATE CASCADE ON DELETE CASCADE,
			ParkingRow INT,
			ParkingColumn INT
		)
		";

		$result = sqlsrv_query($con, $query);
	}

	function createTrParking($con)
	{
		$query = 
		"
		CREATE TABLE TrParking
		(
			ParkingID INT NOT NULL IDENTITY(1, 1) PRIMARY KEY,
			LocationID INT NOT NULL FOREIGN KEY(LocationID) REFERENCES LtParkingLocation(LocationID) ON UPDATE CASCADE ON DELETE CASCADE,
			MemberID INT FOREIGN KEY(MemberID) REFERENCES MsMember(MemberID) ON UPDATE CASCADE ON DELETE CASCADE,
			INTIME DATETIME,
			OUT DATETIME,
			VehicleType VARCHAR(24),
			Staff VARCHAR(255)
		)
		";

		$result = sqlsrv_query($con, $query);
	}

	function createTrBooking($con)
	{
		$query = 
		"
		CREATE TABLE TrBooking
		(
			BookingID INT NOT NULL IDENTITY(1, 1) PRIMARY KEY,
			RegistrationID INT NOT NULL FOREIGN KEY REFERENCES TrRegistration(RegistrationID) ON UPDATE CASCADE ON DELETE CASCADE,
			Parking VARCHAR(24),
			LicensePlate VARCHAR(24),
			BookingTime DATETIME
		)
		";

		$result = sqlsrv_query($con, $query);
	}

	function createTrParkingBooking($con)
	{
		$query = 
		"
		CREATE TABLE TrParkingBooking
		(
			ParkingBookingID INT NOT NULL IDENTITY(1, 1) PRIMARY KEY,
			ParkingID INT FOREIGN KEY(ParkingID) REFERENCES TrParking(ParkingID),
			BookingID INT FOREIGN KEY(BookingID) REFERENCES TrBooking(BookingID) ON UPDATE CASCADE ON DELETE CASCADE,
			BookingLocationID INT NOT NULL FOREIGN KEY(BookingLocationID) REFERENCES TrBookingLocation(BookingLocationID) ON UPDATE CASCADE ON DELETE CASCADE
		)
		";

		$result = sqlsrv_query($con, $query);
	}

	function migrate($con)
	{
		createTrRegistration($con);
		createMsMember($con);
		createLtParkingLocation($con);
		createTrBookingLocation($con);
		createTrParking($con);
		createTrBooking($con);
		createTrParkingBooking($con);
	}

	function down($con)
	{
		//drop tables
	}
?>
