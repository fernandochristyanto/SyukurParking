<?php  
	class TrParkingBooking 
    {
        public $parkingBookingId;
        public $parkingId;
        public $bookingId;
        public $bookingLocationId;

        public function setId($id)
        {
            $this->parkingBookingId = $id;
        }

        public function setParkingId($parkingId)
        {
            $this->parkingId = $parkingId;
        }

        public function setBookingId($bookingId)
        {
            $this->bookingId = $bookingId;
        }

        public function setBookingLocationId($bookingLocationId)
        {
            $this->bookingLocationId = $bookingLocationId;
        }
	}
?>