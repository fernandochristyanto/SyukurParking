<?php 
	include_once "$_SERVER[DOCUMENT_ROOT]/AMDP3/DAO/trBookingLocationDAO.php";
	include_once "$_SERVER[DOCUMENT_ROOT]/AMDP3/DAO/LtParkingLocationDAO.php";
	include_once "$_SERVER[DOCUMENT_ROOT]/AMDP3/DAO/trParkingBookingDAO.php";
	include_once "$_SERVER[DOCUMENT_ROOT]/AMDP3/DAO/trBookingDAO.php";

	$lpldao = new LtParkingLocationDAO();
	$tbldao = new TrBookingLocationDAO();
	$tpbdao = new TrParkingBookingDAO();
	$tbdao = new TrBookingDAO();

	$bookingNumber = $_POST['bookingNumber']; //bookingId
	$locationId = $_POST['locationId']; //locationid

	$booking = (object) $tbdao->getById($bookingNumber); //trBooking objct

	if(isset($booking->registrationId)) //makes sure trBooking obj is a valid booking
	{
		$trParkingBooking = (object)$tpbdao->getByBookingId($booking->bookingId);
		$trBookingLocation = (object)$tbldao->getById($trParkingBooking->bookingLocationId);
		
		if($trBookingLocation->locationId != $locationId) //wrong booking location
		{
			echo 0;
		}
		else if(!isset($trParkingBooking->parkingId)) //booked but not yet entered
		{
			echo 1;
		}
	}
	else //booking id input fails
	{
		echo 0;
	}
?>