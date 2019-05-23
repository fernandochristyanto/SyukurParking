<?php 
	include_once "$_SERVER[DOCUMENT_ROOT]/AMDP3/DAO/trBookingDAO.php";
	include_once "$_SERVER[DOCUMENT_ROOT]/AMDP3/DAO/trParkingBookingDAO.php";
	include_once "$_SERVER[DOCUMENT_ROOT]/AMDP3/DAO/trBookingLocationDAO.php";

	include_once "$_SERVER[DOCUMENT_ROOT]/AMDP3/model/trbookingmodel.php";
	include_once "$_SERVER[DOCUMENT_ROOT]/AMDP3/model/trparkingbookingmodel.php";
	include_once "$_SERVER[DOCUMENT_ROOT]/AMDP3/model/trbookinglocationmodel.php";

	session_start();

	$licensePlate = $_POST['licensePlate'];
	$name = $_POST['name'];
	$hp = $_POST['hp'];
	$email = $_POST['email'];
	$row = $_POST['row'];
	$col = $_POST['col'];
	$locationId = $_POST['locationId'];

	$parking = $row.''.$col; //gets parking slot

	date_default_timezone_set('Asia/Jakarta'); //sets default timezone to asia
	$currTime = date('Y-m-d H:i:s');

	$tbdao = new TrBookingDAO();
	$tpbdao = new TrParkingBookingDAO();
	$tbldao = new TrBookingLocationDAO();

	$trBooking = new TrBooking();
	$trBooking->setRegistrationId($_SESSION['id']);
	$trBooking->setParking($parking);
	$trBooking->setLicensePlate($licensePlate);
	$trBooking->setBookingTime($currTime);

	$tbdao->insert($trBooking);

	$newlyInsertedBookingId = $tbdao->getCurrId(); //gets newly inserted trbooking

	$trBookingLocation = (object) $tbldao->getByLocationId($locationId);

	$trParkingBooking = new TrParkingBooking();
	$trParkingBooking->setParkingId(null);
	$trParkingBooking->setBookingId($newlyInsertedBookingId);
	$trParkingBooking->setBookingLocationId($trBookingLocation->bookingLocationId);

	$tpbdao->insert($trParkingBooking);

	header("Location:../parkingavailability.php");
?>