<?php
// controllers/MahasiswaController.php

include_once('Model/mahasiswa-model.php');

class MahasiswaController {
    private $mahasiswaModel;

    // Koneksi ke model
    public function __construct($db) {
        $this->mahasiswaModel = new MahasiswaModel($db);
    }

    // Menyimpan data mahasiswa
    public function saveData($nama, $nim, $alamat, $prodi, $ukt) {
        return $this->mahasiswaModel->saveMahasiswa($nama, $nim, $alamat, $prodi, $ukt);
    }

    // Mendapatkan statistik
    public function getStatistik() {
        return $this->mahasiswaModel->getStatistik();
    }

    // Mendapatkan data pencilan
    public function getDataPencilan() {
        return $this->mahasiswaModel->getDataPencilan();
    }

    // Mendapatkan standar deviasi
    public function getStandarDeviasi() {
        return $this->mahasiswaModel->getStandarDeviasi();
    }
}
?>
