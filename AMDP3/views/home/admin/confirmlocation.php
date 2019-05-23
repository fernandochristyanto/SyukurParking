<?php  
	include_once "$_SERVER[DOCUMENT_ROOT]/AMDP3/DAO/LtParkingLocationDAO.php";
	include_once "$_SERVER[DOCUMENT_ROOT]/AMDP3/DAO/trBookingLocationDAO.php";
	include_once "$_SERVER[DOCUMENT_ROOT]/AMDP3/model/ltparkinglocationmodel.php";
	include_once "$_SERVER[DOCUMENT_ROOT]/AMDP3/model/trbookinglocationmodel.php";
	if($_POST['new']==1)
	{
		//new parking location
		$ltParkingLocation = new LtParkingLocation();
		$ltParkingLocation->setLocationName($_POST['location']);
		$ltParkingLocation->setParkingSpace($_POST['normalParkingSpace']);
		
		$lplDAO = new LtParkingLocationDAO();
		$lplDAO->insert($ltParkingLocation);

		$ltParkingLocationId = $lplDAO->getCurrId(); //last inserted id
		
		$tbldao = new TrBookingLocationDAO();
		$trBookingLocation = new TrBookingLocation();
		$trBookingLocation->setLocationId($ltParkingLocationId);
		$trBookingLocation->setParkingRow($_POST['bookingRow']);
		$trBookingLocation->setParkingColumn($_POST['bookingCol']);
		$tbldao->insert($trBookingLocation);
		header("Location:mappingparkir.php");
	}
	else if($_POST['new']==0)
	{
		//update parking location
		$ltParkingLocation = new LtParkingLocation();
		$ltParkingLocation->setLocationName($_POST['location']);
		$ltParkingLocation->setParkingSpace($_POST['normalParkingSpace']);
		$ltParkingLocation->setId($_POST['locationId']);

		$lplDAO = new LtParkingLocationDAO();
		$lplDAO->update($ltParkingLocation);
		
		$tbldao = new TrBookingLocationDAO();
		$trBookingLocation = new TrBookingLocation();
		$trBookingLocation->setId($_POST['bookingLocationId']);
		$trBookingLocation->setLocationId($_POST['locationId']);
		$trBookingLocation->setParkingRow($_POST['bookingRow']);
		$trBookingLocation->setParkingColumn($_POST['bookingCol']);
		$tbldao->update($trBookingLocation);
		header("Location:mappingparkir.php");
	}
?>