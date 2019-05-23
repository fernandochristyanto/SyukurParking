<?php 
	include_once "$_SERVER[DOCUMENT_ROOT]/AMDP3/DAO/LtParkingLocationDAO.php";
	include_once "$_SERVER[DOCUMENT_ROOT]/AMDP3/DAO/trBookingLocationDAO.php";
	include_once "$_SERVER[DOCUMENT_ROOT]/AMDP3/model/ltparkinglocationmodel.php";
	include_once "$_SERVER[DOCUMENT_ROOT]/AMDP3/DAO/trBookingDAO.php";
	include_once "$_SERVER[DOCUMENT_ROOT]/AMDP3/DAO/trParkingBookingDAO.php";
	include_once "$_SERVER[DOCUMENT_ROOT]/AMDP3/DAO/trParkingDAO.php";

	include_once "$_SERVER[DOCUMENT_ROOT]/AMDP3/model/trbookingmodel.php";
	include_once "$_SERVER[DOCUMENT_ROOT]/AMDP3/model/trparkingbookingmodel.php";
	include_once "$_SERVER[DOCUMENT_ROOT]/AMDP3/model/trbookinglocationmodel.php";
	include_once "$_SERVER[DOCUMENT_ROOT]/AMDP3/views/home/checkbookingvalidity.php";
	
	$locationId = $_GET['id'];

	$lpldao = new LtParkingLocationDAO();
	$tbldao = new TrBookingLocationDAO();
	$tpbdao = new TrParkingBookingDAO();
	$tpdao = new TrParkingDAO();
	$tbdao = new TrBookingDAO();

	$location = (object) $tbldao->getByLocationId($locationId);
	$row = $location->parkingRow; //booking row available --
	$col = $location->parkingColumn; //booking col available ||
	$alphabet_arr = array('A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z');

	$trParkingBookings = $tpbdao->getByBookingLocationId($location->bookingLocationId); //array

	$bookedSpots = array();
	$bookedSpotNames = array();

	$occupiedSpots = array();
	$occupiedSpotsNames = array();
	foreach($trParkingBookings as $tpbs)
	{
		if($tpbs->BookingID == NULL) //so that loop only checks customer who did book
			continue;


		$trBooking = (object)$tbdao->getById($tpbs->BookingID);
		if($tpbs->ParkingID == NULL) //booked, but not yet occupied
		{
			$bookedSpots[] = $trBooking;
			$bookedSpotNames[] = $trBooking->parking;
		}
		else if($tpbs->ParkingID !=NULL) //booked then occupied
		{
			$trParking = (object)$tpdao->getById($tpbs->ParkingID);
			if($trParking->out == NULL) // still parking
			{
				$occupiedSpots[] = $trBooking;
				$occupiedSpotsNames[] = $trBooking->parking;
			}
		}
	}
?>
	<table id="bookingLocationTable">
		<?php 
		for($i = 0 ; $i<$row ; $i++)
		{ ?>
			<tr>
				<?php 
				for($j = 0 ; $j<$col ; $j++)
				{ ?>
					<?php 
					$spotName = trim($alphabet_arr[$j].''.($i+1));
					if(in_array($spotName, $bookedSpotNames)) //booked
					{
					?>
						<td style="width: <?php echo 100/$col ?>%;">
							<div class="booked" id="<?php echo $locationId.'-'.$alphabet_arr[$j].'-'.($i+1);?>">
								<p>BOOKED</p>
								<p><?php echo $alphabet_arr[$j].''.($i+1); ?></p>
							</div>
						</td>
					<?php 
					}
					else if(in_array($spotName, $occupiedSpotsNames))
					{ 
					?>
						<td style="width: <?php echo 100/$col ?>%;">
							<div class="occupied" id="<?php echo $locationId.'-'.$alphabet_arr[$j].'-'.($i+1);?>">
								<p>OCCUPIED</p>
								<p><?php echo $alphabet_arr[$j].''.($i+1); ?></p>
							</div>
						</td>
					<?php 
					}
					else
					{ ?>
						<td style="width: <?php echo 100/$col ?>%;">
							<div class="available" id="<?php echo $locationId.'-'.$alphabet_arr[$j].'-'.($i+1);?>">
								<p style="font-size: <?php echo 100-($col+20) ?>%">
									BOOKING <?php if($row>10){echo '<br>';} ?>AVAILABLE
								</p>
								<p><?php echo $alphabet_arr[$j].''.($i+1); ?></p>
							</div>
						</td>
					<?php 
					}
				} ?>
			</tr>
		<?php 
		} ?>
	</table>