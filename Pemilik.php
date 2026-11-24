
<?php

class Pemilik extends \Pengguna
{
    private $id_pemilik;

    public function __construct($id, $nama, $email, $no_hp)
    {
        parent::__construct($nama, $email, $no_hp);
        $this->id_pemilik = $id;
    }

    public function getIdPemilik()
    {
        return $this->id_pemilik;
    }

    public function kelolaKos()
    {
        return "Pemilik " . $this->nama . " sedang mengelola kos.";
    }
}
