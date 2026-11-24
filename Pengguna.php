
<?php

class Pengguna
{
    protected $nama;
    protected $email;
    protected $no_hp;

    public function __construct($nama, $email, $no_hp)
    {
        $this->nama = $nama;
        $this->email = $email;
        $this->no_hp = $no_hp;
    }

    public function getNama()
    {
        return $this->nama;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function getNoHp()
    {
        return $this->no_hp;
    }

    public function tampilkanData()
    {
        return "Nama: " . $this->nama .
            " | Email: " . $this->email .
            " | No HP: " . $this->no_hp;
    }
}
