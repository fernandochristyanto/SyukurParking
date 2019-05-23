<?php  
	class Customer 
    {
        public $registrationId;
        public $nama;
        public $alamat;
        public $hp;
        public $email;
        public $password;
        public $picture;
        public $role;

        public function __construct($nama, $alamat, $hp, $email, $password, $picture) 
        {
    		$this->nama = $nama;
    		$this->alamat = $alamat;
    		$this->hp = $hp;
    		$this->email = $email;
    		$this->password = $password;
    		$this->picture = $picture;
            $this->role = 'customer';
        }

        public function setId($id)
        {
            $this->registrationId = $id;
        }

        public function setNama($nama)
        {
            $this->nama = $nama;
        }

        public function setAlamat($alamat)
        {
            $this->alamat = $alamat;
        }

        public function setHp($hp)
        {
            $this->hp = $hp;
        }

        public function setEmail($email)
        {
            $this->email = $email;
        }

        public function setPicture($picture)
        {
            $this->picture = $picture;
        }

        public function setPassword($password)
        {
            $this->password = $password;
        }
	}
?>