<?php  
	class TrParking 
    {
        public $parkingId;
        public $locationId;
        public $memberId;
        public $intime;
        public $out;
        public $vehicleType;
        public $staff;

        public function setId($id)
        {
            $this->parkingId = $id;
        }

        public function setLocationId($locationId)
        {
            $this->locationId = $locationId;
        }

        public function setMemberId($memberId)
        {
            $this->memberId = $memberId;
        }

        public function setInTime($inTime)
        {
            $this->intime = $inTime;
        }

        public function setOut($out)
        {
            $this->out = $out;
        }

        public function setVehicleType($vehicleType)
        {
            $this->vehicleType = $vehicleType;
        }

        public function setStaff($staff)
        {
            $this->staff = $staff;
        }
	}
?>