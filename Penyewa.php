
<?php

class Penyewa extends \Pengguna
{
    private $id_penyewa;
    private $nomor_kamar;

    public function __construct($id_penyewa, $nama, $email, $no_hp, $nomor_kamar)
    {
        parent::__construct($nama, $email, $no_hp);

        $this->id_penyewa = $id_penyewa;
        $this->nomor_kamar = $nomor_kamar;
    }

    public function getIdPenyewa()
    {
        return $this->id_penyewa;
    }

    public function getNomorKamar()
    {
        return $this->nomor_kamar;
    }

    public function bayarKos()
    {
        return "Penyewa " . $this->getNama() . " melakukan pembayaran kos.";
    }
}
