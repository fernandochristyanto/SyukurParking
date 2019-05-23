<?php  
	session_start();
	include_once "$_SERVER[DOCUMENT_ROOT]/AMDP3/DAO/trBookingLocationDAO.php";
	include_once "$_SERVER[DOCUMENT_ROOT]/AMDP3/DAO/trBookingDAO.php";
	include_once "$_SERVER[DOCUMENT_ROOT]/AMDP3/DAO/TrParkingDAO.php";
	include_once "$_SERVER[DOCUMENT_ROOT]/AMDP3/DAO/trParkingBookingDAO.php";
	include_once "$_SERVER[DOCUMENT_ROOT]/AMDP3/DAO/LtParkingLocationDAO.php";
	include_once "$_SERVER[DOCUMENT_ROOT]/AMDP3/DAO/staffDAO.php";
	include_once "$_SERVER[DOCUMENT_ROOT]/AMDP3/DAO/customerDAO.php";

	include_once "$_SERVER[DOCUMENT_ROOT]/AMDP3/model/trbookinglocationmodel.php";
	include_once "$_SERVER[DOCUMENT_ROOT]/AMDP3/model/trparkingbookingmodel.php";
	include_once "$_SERVER[DOCUMENT_ROOT]/AMDP3/model/trbookingmodel.php";

	$tbldao = new TrBookingLocationDAO();
	$tpdao = new TrParkingDAO();
	$tpbdao = new TrParkingBookingDAO();
	$lpldao = new LtParkingLocationDAO();
	$tbdao = new TrBookingDAO();
	$sdao = new StaffDAO();
	$cdao = new CustomerDAO();

	date_default_timezone_set('Asia/Jakarta');
	$currTime = new DateTime('now');

	$trParkingBookingId = $_POST['trParkingBookingId'];
	$staff = (object)$sdao->getById($_SESSION['id']);

	$trParkingBooking = $tpbdao->getById($trParkingBookingId);
	$trParking = $tpdao->getById($trParkingBooking->parkingId);
	$trParking->setOut($currTime);
	$trParking->setStaff($staff->nama);
	$tpdao->update($trParking);

	if(isset($trParkingBooking->bookingId))
	{
		$trBooking = (object)$tbdao->getById($trParkingBooking->bookingId);
		$customer = (object)$cdao->getById($trBooking->registrationId);
		$location = (object)$lpldao->getById($trParking->locationId);
		//mail
		$msg = "Hello, ".$customer->nama.".\nBooking ID : ".$trBooking->bookingId."\nLocation - License Plate : ".$location->locationName." - ".$trBooking->licensePlate."\nParking ID : ".$trParking->parkingId."\nIN : ".$trParking->intime->format('Y-m-d H:i:s')."\nOUT : ".$trParking->out->format('Y-m-d H:i:s');
		$headers =  'MIME-Version: 1.0' . "\r\n"; 
		$headers .= 'From: SyukurParking <noreplysyukurparking@parking.com>' . "\r\n";
		$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n"; 
		mail($customer->email,"Syukur Parking Check Out Receipt",$msg, $headers);
	}

	echo 'success';
?>