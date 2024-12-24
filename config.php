<?php
// config.php - Mengonfigurasi koneksi database

$servername = "localhost";  // Ganti dengan nama host Anda jika berbeda
$username = "root";         // Ganti dengan username MySQL Anda
$password = "";             // Ganti dengan password MySQL Anda jika ada
$dbname = "db_ukt";         // Nama database yang ingin digunakan

// Membuat koneksi ke MySQL
$conn = new mysqli($servername, $username, $password);

// Memeriksa apakah koneksi berhasil
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Mengecek apakah database db_ukt ada, jika belum dibuat
$sql = "CREATE DATABASE IF NOT EXISTS $dbname";
if ($conn->query($sql) === TRUE) {
    //echo "Database '$dbname' sudah ada atau berhasil dibuat.<br>";
} else {
    die("Error creating database: " . $conn->error);
}

// Pilih database yang telah dibuat atau ada
$conn->select_db($dbname);

// Membuat tabel mahasiswa jika belum ada
$table_sql = "CREATE TABLE IF NOT EXISTS mahasiswa (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nama VARCHAR(100) NOT NULL,
    nim VARCHAR(20) NOT NULL,
    alamat TEXT NOT NULL,
    prodi VARCHAR(50) NOT NULL,
    ukt INT NOT NULL
)";

if ($conn->query($table_sql) === TRUE) {
    //echo "Tabel 'mahasiswa' sudah ada atau berhasil dibuat.<br>";
} else {
    die("Error creating table: " . $conn->error);
}

//$conn->close();
?>
