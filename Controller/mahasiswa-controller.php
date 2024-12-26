<?php
// controllers/MahasiswaController.php

include_once 'Model/mahasiswa-model.php';

class MahasiswaController {
    private $mahasiswaModel;

    public function __construct($db) {
        $this->mahasiswaModel = new MahasiswaModel($db);
    }

    public function isDuplicateNIM($nim) {
        return $this->mahasiswaModel->isDuplicateNIM($nim); 
    }

    public function saveData($nama, $nim, $alamat, $prodi, $ukt) {
        return $this->mahasiswaModel->saveMahasiswa($nama, $nim, $alamat, $prodi, $ukt);
    }

    public function getStatistik(){
        return $this->mahasiswaModel->getStatistik();
    }

    public function getDataPencilan() {
        $pencilanData = $this->mahasiswaModel->getDataPencilan();
        return $pencilanData;
    }

    public function getStandarDeviasi() {
        return $this->mahasiswaModel->getStandarDeviasi();
    }
}
?>
