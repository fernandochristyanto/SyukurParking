<?php  
	class TrBooking 
    {
        public $bookingId;
        public $registrationId;
        public $parking;
        public $licensePlate;
        public $bookingTime;

        public function setId($id)
        {
            $this->bookingId = $id;
        }

        public function setRegistrationId($registrationId)
        {
            $this->registrationId = $registrationId;
        }

        public function setParking($parking)
        {
            $this->parking = $parking;
        }

        public function setLicensePlate($licensePlate)
        {
            $this->licensePlate = $licensePlate;
        }

        public function setBookingTime($bookingTime)
        {
            $this->bookingTime = $bookingTime;
        }
	}
?>