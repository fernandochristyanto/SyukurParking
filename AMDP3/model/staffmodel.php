<?php  
	class Staff 
    {
        public $registrationId;
        public $nama;
        public $ktp;
        public $alamat;
        public $gender;
        public $tglLahir;
        public $hp;
        public $tglGabung;
        public $email;
        public $password;
        public $picture;
        public $role;

        public function __construct($nama, $ktp, $alamat, $gender, $tglLahir, $hp, $tglGabung, $email, $password, $picture) 
        {
    		$this->nama = $nama;
    		$this->ktp = $ktp;
    		$this->alamat = $alamat;
    		$this->gender = $gender;
    		$this->tglLahir = $tglLahir;
    		$this->hp = $hp;
    		$this->tglGabung = $tglGabung;
    		$this->email = $email;
    		$this->password = $password;
    		$this->picture = $picture;
            $this->role = 'staff';
        }

        public function setId($id)
        {
            $this->registrationId = $id;
        }

        public function setNama($nama)
        {
            $this->nama = $nama;
        }

        public function setKtp($ktp)
        {
            $this->ktp = $ktp;
        }

        public function setAlamat($alamat)
        {
            $this->alamat = $alamat;
        }

        public function setGender($gender)
        {
            $this->gender = $gender;
        }

        public function setTglLahir($tglLahir)
        {
            $this->tglLahir = $tglLahir;
        }

        public function setHp($hp)
        {
            $this->hp = $hp;
        }

        public function setTglGabung($tglGabung)
        {
            $this->tglGabung=$tglGabung;
        }

        public function setEmail($email)
        {
            $this->email = $email;
        }

        public function setPicture($picture)
        {
            $this->picture = $picture;
        }

        public function setRole($role)
        {
            $this->role = $role;
        }

        public function setPassword($password)
        {
            $this->password = $password;
        }
	}
?>