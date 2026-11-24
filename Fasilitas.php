<?php

class Fasilitas {

    private $nama_fasilitas;
    private $keterangan;

    public function __construct($nama, $keterangan) {
        $this->nama_fasilitas = $nama;
        $this->keterangan = $keterangan;
    }

    public function getNamaFasilitas() {
        return $this->nama_fasilitas;
    }

    public function getKeterangan() {
        return $this->keterangan;
    }
}