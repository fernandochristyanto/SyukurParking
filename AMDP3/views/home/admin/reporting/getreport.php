<?php 
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

	$startD = $_GET['startD'];
	$endD = $_GET['endD'];
	$startMo = $_GET['startMo'];
	$endMo = $_GET['endMo'];
	$startY = $_GET['startY'];
	$endY = $_GET['endY'];

	$tbldao = new TrBookingLocationDAO();
	$tpdao = new TrParkingDAO();
	$tpbdao = new TrParkingBookingDAO();
	$lpldao = new LtParkingLocationDAO();
	$tbdao = new TrBookingDAO();
	$sdao = new StaffDAO();
	$cdao = new CustomerDAO();

	$trParkings = $tpdao->getReporting($startD, $endD, $startMo, $endMo, $startY, $endY);

	$totalCarParked = 0;
	$totalSuccessBook = 0;
	$totalIncome = 0;

	if(!empty($trParkings))
	{
		foreach ($trParkings as $tp) 
		{
			$trParkingBooking = (object)$tpbdao->getByParkingId($tp->ParkingID);
			if(!isset($trParkingBooking->bookingId))
			{
				$totalCarParked+=1;
			}
			else
			{
				$totalSuccessBook+=1;
			}

			//total income count
			$intime = strtotime($tp->INTIME->format('Y-m-d H:i:s'));
			$outtime = strtotime($tp->OUT->format('Y-m-d H:i:s'));
			$interval = $outtime - $intime;
			$durationHour = $interval/3600;
			$durationHour = (int) $durationHour;
			$interval %= 3600;
			$durationMin = $interval/60;
			$durationMin = (int) $durationMin;
			$interval %= 60;
			$durationS = $interval;
			if($tp->VehicleType == 'mobil')
			{
				$totalIncome += 5000;
				if($durationHour>1)
				{
					$totalIncome+=($durationHour-1)*4000;
					if($durationMin>0)
						$totalIncome+=4000;
				}
				else if($tp->VehicleType == 'motor')
				{
					$totalIncome += 2000;
					if($durationHour>1)
					{
						$totalIncome+=($durationHour-1)*1000;
						if($durationMin>0)
							$totalIncome+=1000;
					}
				}
				if(isset($trParkingBooking->bookingId))
				{
					$totalIncome += 10000;
				}
 			}
 		}
 	}
?>
	<div class="reportContainer">
		<h1>Recapitulation Report</h1>
		<table class="reportTable">
			<tr>
				<td><div class="str">Total Car Parked</div></td>
				<td><div class="str">Total Success Book</div></td>
				<td><div class="str">Total Income</div></td>
			</tr>
			<tr>
				<td><div><?php echo $totalCarParked; ?></div></td>
				<td><div><?php echo $totalSuccessBook; ?></div></td>
				<td><div><?php echo 'Rp.'.$totalIncome.',-'; ?></div></td>
			</tr>
		</table>
	</div>