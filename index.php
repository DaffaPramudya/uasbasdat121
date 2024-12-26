<?php
// index.php - Main entry point yang menjalankan MVC

// Menyertakan file konfigurasi dan autoload untuk model, controller, dan view
include('config.php');  // Koneksi ke database
include('Controller/mahasiswa-controller.php');  // Controller untuk logika aplikasi

// Membuat objek controller
$controller = new MahasiswaController($conn);

$mahasiswaList = $controller->getListMahasiswa();
// Menangani form submission untuk registrasi mahasiswa
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Menyimpan data mahasiswa
    if (isset($_POST['save_data'])) {
        $nama = $_POST['nama'];
        $nim = $_POST['nim'];
        $alamat = $_POST['alamat'];
        $prodi = $_POST['prodi'];
        $ukt = $_POST['ukt'];

        if ($controller->isDuplicateNIM($nim)) {
            echo '<p style="text-align: center; color: red;">Data with the same NIM already exists!</p>';
        } else {
            if ($controller->saveData($nama, $nim, $alamat, $prodi, $ukt)) {
                echo '<p style="text-align: center; color: green;">Data berhasil disimpan!</p>';
            } else {
                echo '<p style="text-align: center; color: red;">Error menyimpan data.</p>';
            }
        }
    }
    // Menangani permintaan statistik
    if (isset($_POST['query'])) {
        $queryType = $_POST['query'];

        if ($queryType === 'statistik') {
            $statistik = $controller->getStatistik();
        } elseif ($queryType === 'pencilan') {
            $pencilan = $controller->getDataPencilan();
        } elseif ($queryType === 'standar_deviasi') {
            $stdDeviasi = $controller->getStandarDeviasi();
        }
    }
}
// Panggil View untuk menampilkan form dan tabel
include('View/register.php');
?>
