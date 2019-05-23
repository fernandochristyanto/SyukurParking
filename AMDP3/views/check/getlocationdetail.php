<?php 
	include_once "$_SERVER[DOCUMENT_ROOT]/AMDP3/DAO/LtParkingLocationDAO.php";
	include_once "$_SERVER[DOCUMENT_ROOT]/AMDP3/DAO/trBookingLocationDAO.php";
	include_once "$_SERVER[DOCUMENT_ROOT]/AMDP3/DAO/trParkingBookingDAO.php";
	include_once "$_SERVER[DOCUMENT_ROOT]/AMDP3/DAO/TrParkingDAO.php";

	$locationId = $_GET['locationId'];

	$tbldao = new TrBookingLocationDAO();
	$lpldao = new LtParkingLocationDAO();
	$tpbdao = new TrParkingBookingDAO();
	$tpdao = new TrParkingDAO();

	$loc = (object) $lpldao->getById($locationId);
	$locDetails = (object) $tbldao->getByLocationId($locationId);

	//checks for booked and occupied spots
	$trParkingBookings = $tpbdao->getByBookingLocationId($locDetails->bookingLocationId);

	$bookedSpots = 0;
	$occupiedParking = 0;
	foreach($trParkingBookings as $tpbs)
	{
		if($tpbs->BookingID != NULL) //booked / occupied
		{
			$trParking = (object) $tpdao->getById($tpbs->ParkingID);
			if(!isset($trParking->out))
				$bookedSpots+=1;
		}
		else if($tpbs->BookingID==NULL && $tpbs->ParkingID!=NULL) //occupied w/o booking
		{
			$trParking = (object) $tpdao->getById($tpbs->ParkingID);
			if(!isset($trParking->out))
				$occupiedParking+=1;
		}
	}
?>

<p>Booking Available : <?php echo ($locDetails->parkingRow*$locDetails->parkingColumn)-($bookedSpots); ?></p>
<p>Parking Available : <?php echo $loc->parkingSpace-$occupiedParking; ?></p>
<p>
	<?php 
		date_default_timezone_set('Asia/Jakarta'); 
		echo date('l, j F Y, H:i:s');
	?>
</p>