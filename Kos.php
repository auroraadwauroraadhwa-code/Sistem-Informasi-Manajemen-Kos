
<?php

class Kos
{
    private $nama_kos;
    private $alamat;
    private $kamar = [];
    private $fasilitas = [];

    public function __construct($nama_kos, $alamat)
    {
        $this->nama_kos = $nama_kos;
        $this->alamat = $alamat;
    }

    // Menambahkan data kamar
    public function tambahKamar(\Kamar $kamar)
    {
        $this->kamar[] = $kamar;
    }

    // Menambahkan data fasilitas
    public function tambahFasilitas(\Fasilitas $fasilitas)
    {
        $this->fasilitas[] = $fasilitas;
    }

    // Mengambil nama kos
    public function getNamaKos()
    {
        return $this->nama_kos;
    }

    // Mengambil alamat kos
    public function getAlamat()
    {
        return $this->alamat;
    }

    // Mengambil semua data kamar
    public function getKamar()
    {
        return $this->kamar;
    }

    // Mengambil semua data fasilitas
    public function getFasilitas()
    {
        return $this->fasilitas;
    }

    // Menghitung jumlah kamar
    public function jumlahKamar()
    {
        return count($this->kamar);
    }
}
