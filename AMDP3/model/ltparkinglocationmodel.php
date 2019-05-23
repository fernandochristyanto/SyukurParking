<?php  
	class LtParkingLocation 
    {
        public $locationId;
        public $locationName;
        public $parkingSpace;

        public function setId($id)
        {
            $this->locationId = $id;
        }

        public function setLocationName($locationName)
        {
            $this->locationName = $locationName;
        }

        public function setParkingSpace($parkingSpace)
        {
            $this->parkingSpace = $parkingSpace;
        }
	}
?>