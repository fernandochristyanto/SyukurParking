<?php 
	include_once "$_SERVER[DOCUMENT_ROOT]/AMDP3/DAO/trBookingLocationDAO.php";
	include_once "$_SERVER[DOCUMENT_ROOT]/AMDP3/DAO/trBookingDAO.php";
	include_once "$_SERVER[DOCUMENT_ROOT]/AMDP3/DAO/TrParkingDAO.php";
	include_once "$_SERVER[DOCUMENT_ROOT]/AMDP3/DAO/trParkingBookingDAO.php";
	include_once "$_SERVER[DOCUMENT_ROOT]/AMDP3/DAO/staffDAO.php";

	include_once "$_SERVER[DOCUMENT_ROOT]/AMDP3/model/trbookinglocationmodel.php";
	include_once "$_SERVER[DOCUMENT_ROOT]/AMDP3/model/trparkingbookingmodel.php";
	include_once "$_SERVER[DOCUMENT_ROOT]/AMDP3/model/trbookingmodel.php";

	$input = $_GET['input'];
	$locationId = $_GET['locationId'];

	$tbldao = new TrBookingLocationDAO();
	$tpdao = new TrParkingDAO();
	$tpbdao = new TrParkingBookingDAO();
	$tbdao = new TrBookingDAO();

	$flag = 1;

	$trBooking;
	$trParkingBooking = (object) $tpbdao->getByParkingId($input); 
	//try to get by Parking ID

	if(!isset($trParkingBooking->parkingBookingId))
	{
		$flag = 2;
		$trParkingBooking = (object) $tpbdao->getByBookingId($input);
		//try to get by booking ID

		if(!isset($trParkingBooking->parkingBookingId))
		{
			$trBookings = $tbdao->getByLicensePlate($input);
			//try to get by license plate

			$flag = 0;
			foreach ($trBookings as $tb) 
			{	
				$trBooking = new TrBooking();
				$trBooking->setId($tb->BookingID);
				$trBooking->setRegistrationId($tb->RegistrationID);
				$trBooking->setParking($tb->Parking);
				$trBooking->setLicensePlate($tb->LicensePlate);
				$trBooking->setBookingTime($tb->BookingTime);
				if(isset($tb->BookingID))
				{
					$trParkingBooking = (object) $tpbdao->getByBookingId($tb->BookingID);
					$trParking = $tpdao->getById($trParkingBooking->parkingId);

					if(!isset($trParking->out))
					{
						$flag = 3;
					}
				}
			}
		}
	}
	if($flag == 1) //get by parkingID
	{
		if(!isset($trParkingBooking->parkingId))
		{
			$flag = 0;
		}
		else
		{
			$trBooking = (object) $tbdao->getById($trParkingBooking->bookingId);
			$trParking = (object) $tpdao->getById($trParkingBooking->parkingId);
			if($trParking->locationId!=$locationId || isset($trParking->out))
			{
				$flag = 0; //if parking place is not same
			}
		}
	}
	else if($flag == 2)
	{
		if(!isset($trParkingBooking->parkingId))
		{
			$flag = 0;
		}
		else
		{
			$trBooking = (object) $tbdao->getById($trParkingBooking->bookingId);
			$trParking = (object) $tpdao->getById($trParkingBooking->parkingId);

			if($trParking->locationId!=$locationId || isset($trParking->out))
			{
				$flag = 0; //if parking place is not same
			}
		}
	}
	else if($flag == 3)
	{
		$trParkingBooking = $tpbdao->getByBookingId($trBooking->bookingId);
		$trParking = (object) $tpdao->getById($trParkingBooking->parkingId);
		if($trParking->locationId!=$locationId || isset($trParking->out))
		{
			$flag = 0; //if parking place is not same
		}
		if(!isset($trParkingBooking->parkingId))
		{
			$flag = 0;
		}
	}

	if($flag!=0)
	{
		date_default_timezone_set('Asia/Jakarta');
		$currTime = new DateTime('now');

		if(isset($trParkingBooking->bookingId))
		{
			$bookingId = $trParkingBooking->bookingId;
			$parking = $trBooking->parking;
			$licensePlate = $trBooking->licensePlate;
		}
		$vehicleType = $trParking->vehicleType;

		// counts total
		$timeNow = strtotime($currTime->format('Y-m-d H:i:s'));
		$intime = strtotime($trParking->intime->format('Y-m-d H:i:s'));
		$interval = $timeNow - $intime;
		$durationHour = $interval/3600;
		$durationHour = (int) $durationHour;
		$interval %= 3600;
		$durationMin = $interval/60;
		$durationMin = (int) $durationMin;
		$interval %= 60;
		$durationS = $interval;

		$intime = $trParking->intime->format('Y-m-d H:i:s');
		$out = $currTime->format('Y-m-d H:i:s');

		if($trParking->vehicleType == 'mobil')
		{
			$total = 5000;
			if($durationHour>1)
			{
				$total+=($durationHour-1)*4000;
				if($durationMin>0)
					$total+=4000;
			}
		}
		else if($trParking->vehicleType == 'motor')
		{
			$total = 2000;
			if($durationHour>1)
			{
				$total+=($durationHour-1)*1000;
				if($durationMin>0)
					$total+=1000;
			}
		}
		if(isset($trParkingBooking->bookingId))
		{
			$total += 10000;
		}	
 ?>
 		<h1>Invoice</h1>
		<div>
			<p class="total">Total : Rp. <?php echo $total ?>,-</p>
			<?php 
			if(isset($trParkingBooking->bookingId))
			{?>
				<p>Booking : <?php echo $bookingId; ?> / PARKING : <?php echo $parking; ?></p>
				<p><?php echo $licensePlate; ?> / <?php echo $vehicleType; ?></p>
			<?php 
			} ?>
			<p>Duration : <?php echo $durationHour.' Hour '.$durationMin.' Minute '.$durationS.' Second'; ?></p>
			<p>IN : <?php echo $intime; ?></p>
			<p>OUT : <?php echo $out; ?></p>
			<input type="hidden" id="parkingBookingId" value="<?php echo $trParkingBooking->parkingBookingId; ?>">
		</div>
 <?php 
 	}
 	else if($flag == 0)
 	{
 		echo 0;
 	} 
?>