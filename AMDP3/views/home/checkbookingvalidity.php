<?php  
	include_once "$_SERVER[DOCUMENT_ROOT]/AMDP3/DAO/LtParkingLocationDAO.php";
	include_once "$_SERVER[DOCUMENT_ROOT]/AMDP3/DAO/trBookingLocationDAO.php";
	include_once "$_SERVER[DOCUMENT_ROOT]/AMDP3/model/ltparkinglocationmodel.php";
	include_once "$_SERVER[DOCUMENT_ROOT]/AMDP3/DAO/trBookingDAO.php";
	include_once "$_SERVER[DOCUMENT_ROOT]/AMDP3/DAO/trParkingBookingDAO.php";

	include_once "$_SERVER[DOCUMENT_ROOT]/AMDP3/model/trbookingmodel.php";
	include_once "$_SERVER[DOCUMENT_ROOT]/AMDP3/model/trparkingbookingmodel.php";
	include_once "$_SERVER[DOCUMENT_ROOT]/AMDP3/model/trbookinglocationmodel.php";

	$tpbdao = new TrParkingBookingDAO();
	$tbdao = new TrBookingDAO();

	date_default_timezone_set('Asia/Jakarta'); //sets default timezone to asia

	$trParkingBookings = $tpbdao->getAll();
	foreach($trParkingBookings as $tpbs)
	{
		if($tpbs->ParkingID == NULL) //booked
		{
			//check for validity
			$trBooking = (object)$tbdao->getById($tpbs->BookingID);
			$currTime =new DateTime('now');

			$difference = (int)$currTime->diff($trBooking->bookingTime)->format('%i');
			$differenceInH = (int)$currTime->diff($trBooking->bookingTime)->format('%h');

			$differenceInD = (int)$currTime->diff($trBooking->bookingTime)->format('%d');
			
			if($difference>=60 || $differenceInH>=1 || $differenceInD>=1) //if 1 hour passes
			{
				$trParkingBooking = $tpbdao->getById($tpbs->ParkingBookingID);
				$tpbdao->delete($trParkingBooking);
				$tbdao->delete($trBooking);
			}		
		}
	}
?>