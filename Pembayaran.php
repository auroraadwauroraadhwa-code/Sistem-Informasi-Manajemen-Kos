<?php

class Pembayaran {

    private $id_pembayaran;
    private $nama_penyewa;
    private $jumlah;
    private $tanggal;
    private $status;

    public function __construct($id, $nama, $jumlah, $tanggal, $status) {
        $this->id_pembayaran = $id;
        $this->nama_penyewa = $nama;
        $this->jumlah = $jumlah;
        $this->tanggal = $tanggal;
        $this->status = $status;
    }

    public function getJumlah() {
        return $this->jumlah;
    }

    public function tampilkanPembayaran() {
        return [
            "id" => $this->id_pembayaran,
            "nama" => $this->nama_penyewa,
            "jumlah" => $this->jumlah,
            "tanggal" => $this->tanggal,
            "status" => $this->status
        ];
    }
}