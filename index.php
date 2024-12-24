<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Data UKT Mahasiswa</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      margin: 0;
      padding: 0;
      background-color: #f9f9f9;
      display: flex;
    }

    .main-container {
      flex: 3;
      padding: 20px;
    }

    .sidebar {
      flex: 1;
      padding: 20px;
      background-color: #007bff;
      color: #fff;
      height: 100vh;
      overflow-y: auto;
    }

    h1 {
      text-align: center;
    }

    .form-container, .button-container {
      margin: 20px 0;
      padding: 20px;
      border-radius: 10px;
      background: #fff;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }

    .form-container input, button {
      width: 100%;
      margin: 10px 0;
      padding: 10px;
      font-size: 16px;
      border: 1px solid #ddd;
      border-radius: 5px;
    }

    .form-container button {
      background-color: #007bff;
      color: #fff;
      border: none;
      cursor: pointer;
    }

    .form-container button:hover {
      background-color: #0056b3;
    }

    .sidebar h3 {
      text-align: center;
      margin-bottom: 20px;
    }

    .sidebar p {
      margin: 10px 0;
    }
  </style>
</head>
<body>

  <!-- Main Content -->
  <div class="main-container">
    <h1>Input Data UKT Mahasiswa</h1>

    <!-- Form untuk Input Data -->
    <div class="form-container">
      <form method="POST">
        <label for="nama">Nama:</label>
        <input type="text" id="nama" name="nama" required>

        <label for="nim">NIM:</label>
        <input type="text" id="nim" name="nim" required>

        <label for="alamat">Alamat:</label>
        <input type="text" id="alamat" name="alamat" required>

        <label for="prodi">Prodi:</label>
        <input type="text" id="prodi" name="prodi" required>

        <label for="ukt">UKT:</label>
        <input type="number" id="ukt" name="ukt" required>

        <button type="submit" name="save_data">Simpan Data</button>
      </form>
    </div>

    <!-- Tombol untuk Query Statistik -->
    <div class="button-container">
      <form method="POST">
        <button type="submit" name="query" value="statistik">Statistik 5 Serangkai</button>
        <button type="submit" name="query" value="pencilan">Data Pencilan</button>
        <button type="submit" name="query" value="standar_deviasi">Standar Deviasi</button>
      </form>
    </div>
  </div>

  <!-- Sidebar -->
  <div class="sidebar">
    <h3>Hasil Query</h3>
    <?php
    // Koneksi ke database
    $conn = new mysqli('localhost', 'root', '', 'db_ukt');

    if ($conn->connect_error) {
      die("Koneksi gagal: " . $conn->connect_error);
    }

    // Simpan Data
    if (isset($_POST['save_data'])) {
      $nama = $_POST['nama'];
      $nim = $_POST['nim'];
      $alamat = $_POST['alamat'];
      $prodi = $_POST['prodi'];
      $ukt = $_POST['ukt'];

      $sql = "INSERT INTO mahasiswa (nama, nim, alamat, prodi, ukt) 
              VALUES ('$nama', '$nim', '$alamat', '$prodi', $ukt)";
      if ($conn->query($sql) === TRUE) {
        echo "<p>Data berhasil disimpan!</p>";
      } else {
        echo "<p>Error: " . $sql . "<br>" . $conn->error . "</p>";
      }
    }

    // Query Statistik
    if (isset($_POST['query'])) {
      $queryType = $_POST['query'];

      if ($queryType === 'statistik') {
        // Statistik 5 serangkai
        $result = $conn->query("SELECT 
                                  MIN(ukt) AS minimum, 
                                  MAX(ukt) AS maksimum, 
                                  AVG(ukt) AS rata_rata 
                                FROM mahasiswa");
        $data = $result->fetch_assoc();
        echo "<p>Minimum: " . $data['minimum'] . "</p>";
        echo "<p>Maksimum: " . $data['maksimum'] . "</p>";
        echo "<p>Rata-rata: " . $data['rata_rata'] . "</p>";

        // Q1 dan Q3
        $result = $conn->query("SELECT ukt FROM mahasiswa ORDER BY ukt");
        $ukts = [];
        while ($row = $result->fetch_assoc()) {
          $ukts[] = $row['ukt'];
        }
        $count = count($ukts);
        $q1 = $ukts[floor(($count - 1) * 0.25)];
        $q3 = $ukts[floor(($count - 1) * 0.75)];
        echo "<p>Q1: " . $q1 . "</p>";
        echo "<p>Q3: " . $q3 . "</p>";

      } elseif ($queryType === 'pencilan') {
        // Data pencilan
        $result = $conn->query("SELECT * FROM mahasiswa WHERE ukt < 1000000 OR ukt > 10000000");
        while ($row = $result->fetch_assoc()) {
          echo "<p>Nama: " . $row['nama'] . " - UKT: " . $row['ukt'] . "</p>";
        }
      } elseif ($queryType === 'standar_deviasi') {
        // Standar deviasi
        $result = $conn->query("SELECT STD(ukt) AS std_deviasi FROM mahasiswa");
        $data = $result->fetch_assoc();
        echo "<p>Standar Deviasi UKT: " . $data['std_deviasi'] . "</p>";
      }
    }

    $conn->close();
    ?>
  </div>

</body>
</html>
