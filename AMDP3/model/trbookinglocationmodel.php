<?php  
	class TrBookingLocation 
    {
        public $bookingLocationId;
        public $locationId;
        public $parkingRow;
        public $parkingColumn;

        public function setId($id)
        {
            $this->bookingLocationId = $id;
        }

        public function setLocationId($locationId)
        {
            $this->locationId = $locationId;
        }

        public function setParkingRow($parkingRow)
        {
            $this->parkingRow = $parkingRow;
        }

        public function setParkingColumn($parkingColumn)
        {
            $this->parkingColumn = $parkingColumn;
        }
	}
?>