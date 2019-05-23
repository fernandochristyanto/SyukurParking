<?php 
	include_once "$_SERVER[DOCUMENT_ROOT]/AMDP3/DAO/LtParkingLocationDAO.php";
	include_once "$_SERVER[DOCUMENT_ROOT]/AMDP3/DAO/trBookingLocationDAO.php";
	include_once "$_SERVER[DOCUMENT_ROOT]/AMDP3/DAO/trParkingBookingDAO.php";
	include_once "$_SERVER[DOCUMENT_ROOT]/AMDP3/DAO/TrParkingDAO.php";


	$tbldao = new TrBookingLocationDAO();
	$lpldao = new LtParkingLocationDAO();
	$tpbdao = new TrParkingBookingDAO();
	$tpdao = new TrParkingDAO();
	$parkingLocations = $lpldao->getAll();

	//loop through arr of objs
	foreach ($parkingLocations as $loc)
	{
		$locDetails = (object) $tbldao->getByLocationId($loc->LocationID);

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

		<table>
			<tr>
				<td><div class="parkingPlace"><?php echo $loc->LocationName; ?></div></td>
			</tr>
			<tr>
				<td><div class="parkingPlaceDetail">Booking available : <?php echo ($locDetails->parkingRow*$locDetails->parkingColumn)-$bookedSpots; ?></div></td>
			</tr>
			<tr>
				<td><div class="parkingPlaceDetail">Parking Available : <?php echo ($loc->ParkingSpace)-$occupiedParking; ?></div></td>
			</tr>
		</table>
<?php 
	} ?>