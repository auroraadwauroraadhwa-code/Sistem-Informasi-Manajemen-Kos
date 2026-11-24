<?php

class Kamar {

    private $nomor_kamar;
    private $harga;
    private $status;

    public function __construct($nomor, $harga, $status) {
        $this->nomor_kamar = $nomor;
        $this->harga = $harga;
        $this->status = $status;
    }

    public function getNomor() {
        return $this->nomor_kamar;
    }

    public function getHarga() {
        return $this->harga;
    }

    public function getStatus() {
        return $this->status;
    }

    public static function formatRupiah($harga) {
        return "Rp " . number_format($harga, 0, ',', '.');
    }
}