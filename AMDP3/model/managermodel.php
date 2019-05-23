<?php  
	class Manager 
    {
        public $registrationId;
        public $nama;
        public $alamat;
        public $hp;
        public $email;
        public $password;
        public $role;

        public function __construct($nama, $alamat, $hp, $email, $password) 
        {
    		$this->nama = $nama;
    		$this->alamat = $alamat;
    		$this->hp = $hp;
    		$this->email = $email;
    		$this->password = $password;
            $this->role = 'manager';
        }

        public function setId($id)
        {
            $this->registrationId = $id;
        }
	}
?>