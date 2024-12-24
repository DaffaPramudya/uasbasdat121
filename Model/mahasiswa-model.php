<?php
include 'config.php';
class MahasiswaModel {
    private $conn;

    // Koneksi database
    public function __construct($db) {
        $this->conn = $db;
    }

    // Menyimpan data mahasiswa
    public function saveMahasiswa($nama, $nim, $alamat, $prodi, $ukt) {
        $sql = "INSERT INTO mahasiswa (nama, nim, alamat, prodi, ukt) 
                VALUES ('$nama', '$nim', '$alamat', '$prodi', $ukt)";
        if ($this->conn->query($sql) === TRUE) {
            return true;
        } else {
            return false;
        }
    }

    // Mengambil statistik 5 serangkai
    public function getStatistik() {
        $result = $this->conn->query("SELECT MIN(ukt) AS minimum, MAX(ukt) AS maksimum, AVG(ukt) AS rata_rata FROM mahasiswa");
        return $result->fetch_assoc();
    }

    // Mengambil data pencilan
    public function getDataPencilan() {
        $result = $this->conn->query("SELECT * FROM mahasiswa WHERE ukt < 1000000 OR ukt > 10000000");
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    // Mengambil standar deviasi UKT
    public function getStandarDeviasi() {
        $result = $this->conn->query("SELECT STD(ukt) AS std_deviasi FROM mahasiswa");
        return $result->fetch_assoc();
    }
}
?>
