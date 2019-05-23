<?php 
	include_once "$_SERVER[DOCUMENT_ROOT]/AMDP3/barcodebakery/class/BCGFontFile.php";
	include_once "$_SERVER[DOCUMENT_ROOT]/AMDP3/barcodebakery/class/BCGColor.php";
	include_once "$_SERVER[DOCUMENT_ROOT]/AMDP3/barcodebakery/class/BCGDrawing.php";
	include_once "$_SERVER[DOCUMENT_ROOT]/AMDP3/barcodebakery/class/BCGcode128.barcode.php";
	include_once "$_SERVER[DOCUMENT_ROOT]/AMDP3/wideimage/WideImage.php";

	include_once "$_SERVER[DOCUMENT_ROOT]/AMDP3/DAO/trBookingLocationDAO.php";
	include_once "$_SERVER[DOCUMENT_ROOT]/AMDP3/DAO/TrParkingDAO.php";
	include_once "$_SERVER[DOCUMENT_ROOT]/AMDP3/DAO/LtParkingLocationDAO.php";
	include_once "$_SERVER[DOCUMENT_ROOT]/AMDP3/DAO/trParkingBookingDAO.php";
	include_once "$_SERVER[DOCUMENT_ROOT]/AMDP3/DAO/trBookingDAO.php";
	include_once "$_SERVER[DOCUMENT_ROOT]/AMDP3/DAO/customerDAO.php";
	include_once "$_SERVER[DOCUMENT_ROOT]/AMDP3/model/trbookinglocationmodel.php";
	include_once "$_SERVER[DOCUMENT_ROOT]/AMDP3/model/trparkingmodel.php";
	include_once "$_SERVER[DOCUMENT_ROOT]/AMDP3/model/trparkingbookingmodel.php";
	include_once "$_SERVER[DOCUMENT_ROOT]/AMDP3/model/trbookingmodel.php";

	//DAOs
	$tbldao = new TrBookingLocationDAO();
	$tpdao = new TrParkingDAO();
	$tpbdao = new TrParkingBookingDAO();
	$tbdao = new TrBookingDAO();
	$lpldao = new LtParkingLocationDAO();
	$cdao = new CustomerDAO();

	$locationId = $_POST['locationId'];
	$location = (object) $lpldao->getById($locationId);
	
	$trBookingLocation = (object) $tbldao->getByLocationId($locationId);
	$vehicleType = $_POST['vehicleType'] == 1 ? 'mobil':'motor';
	//1 = mobil
	//0 = motor
	
	date_default_timezone_set('Asia/Jakarta');
	$currTime = date('Y-m-d H:i:s');

	if($_POST['booked']==0)
	{
		//generate ticket (not booked)
		
		//not booked -> insert TrParkingBooking with BookingID = NULL & ParkingID = FK
		$trParking = new TrParking();
		$trParking->setLocationId($locationId);
		$trParking->setMemberId(NULL);
		$trParking->setInTime($currTime);
		$trParking->setOut(NULL);
		$trParking->setVehicleType($vehicleType);
		$trParking->setStaff(NULL);
		$tpdao->insert($trParking);

		$insertedTrParkingId = $tpdao->getCurrId();

		$trParkingBooking = new TrParkingBooking();
		$trParkingBooking->setParkingId($insertedTrParkingId);
		$trParkingBooking->setBookingId(NULL);
		$trParkingBooking->setBookingLocationId($trBookingLocation->bookingLocationId);
		$tpbdao->insert($trParkingBooking);	
		echo 'Parking successfully registered';
	}
	else if($_POST['booked']==1)
	{
		//generate booked ticket
		$bookingId = $_POST['bookingId'];
		$trBooking = (object) $tbdao->getById($_POST['bookingId']);
		$trParking = new TrParking();
		$trParking->setLocationId($locationId);
		$trParking->setMemberId(NULL);
		$trParking->setInTime($currTime);
		$trParking->setOut(NULL);
		$trParking->setVehicleType($vehicleType);
		$trParking->setStaff(NULL);
		$tpdao->insert($trParking);

		$insertedTrParkingId = $tpdao->getCurrId();

		$trParkingBooking = (object) $tpbdao->getByBookingId($bookingId);
		$trParkingBooking->setParkingId($insertedTrParkingId);
		$tpbdao->update($trParkingBooking);	
		echo 'Booked Parking successfully registered';

		$customer = (object)$cdao->getById($trBooking->registrationId);
		//send email
		$msg = "Hello, ".$customer->nama.". This is your Booking ID : ".$trBooking->bookingId."\nLocation - License Plate : ".$location->locationName." - ".$trBooking->licensePlate."\nParking ID : ".$insertedTrParkingId;
		$headers =  'MIME-Version: 1.0' . "\r\n"; 
		$headers .= 'From: SyukurParking <noreplysyukurparking@parking.com>' . "\r\n";
		$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n"; 
		mail($customer->email,"Syukur Parking Check In Receipt",$msg, $headers);
	}

	// barcode ==
	$barcodeText = "SYUKUR PARKING\n".$location->locationName."\n".$insertedTrParkingId."\n"; //barcode text
	if($_POST['booked']==0)
	{
		$barcodeText .= $vehicleType."\n".$currTime;
	}
	else if($_POST['booked']==1)
	{
		$barcodeText .= "Booking : ".$_POST['bookingId']." / Parking : ".$trBooking->parking."\n";
		$barcodeText .= $trBooking->licensePlate." / ".$vehicleType."\n".$currTime;
	}

	$colorFront = new BCGColor(0, 0, 0);
	$colorBack = new BCGColor(255, 255, 255);
	$font = new BCGFontFile("$_SERVER[DOCUMENT_ROOT]/AMDP3/barcodebakery/font/Arial.ttf", 70);
	$code = new BCGcode128();
	$code->setScale(3);
	$code->setThickness(20);
	$code->setForegroundColor($colorFront); // Color of bars
	$code->setBackgroundColor($colorBack); // Color of spaces
	$code->setFont($font);
	$code->parse($barcodeText);

	$drawing = new BCGDrawing('barcode/barcode.png', $colorBack);
	$drawing->setBarcode($code);
	$drawing->draw();
	$drawing->finish(BCGDrawing::IMG_FORMAT_PNG);
	$drawing->finish();
	// === end barcode ===

	WideImage::load('barcode/barcode.png')->saveToFile('barcode/final.bmp');

	$handle = printer_open();
	printer_start_doc($handle, "My Document");
	printer_start_page($handle);
	$font = printer_create_font("Arial", 78, 48, 400, false, false, false, 0);
	// printer_select_font($handle, $font);
	// printer_draw_text($handle, 'the text that will be printed', 100, 100);
	printer_draw_bmp($handle,"$_SERVER[DOCUMENT_ROOT]/AMDP3/views/check/barcode/final.bmp",1,1);
	// printer_delete_font($font);
	printer_end_page($handle);
	printer_end_doc($handle);
	printer_close($handle);


	unlink("barcode/barcode.png");
	unlink("barcode/final.bmp");

?>