<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Data UKT Mahasiswa</title>
  <link rel="stylesheet" href="View/css/styles.css">
</head>
<body>


  <div class="main-container">
    <h1>Input Data UKT Mahasiswa</h1>

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

    <div class="button-container">
    <table class="data-mahasiswa">
        <thead>
            <tr>
                <th>Nama</th>
                <th>NIM</th>
                <th>Alamat</th>
                <th>Prodi</th>
                <th>UKT</th>
            </tr>
        </thead>
        <tbody>
        <?php
            // Display data from database
            if (!empty($mahasiswaList)) {
              foreach ($mahasiswaList as $row) {
                echo "<tr>
                  <td>{$row['nama']}</td>
                  <td>{$row['nim']}</td>
                  <td>{$row['alamat']}</td>
                  <td>{$row['prodi']}</td>
                  <td>{$row['ukt']}</td>
                </tr>";
                }
            } else {
                echo "<tr><td colspan='5'>No data available</td></tr>";
            }
            ?>
        </tbody>
    </table>
      <form method="POST">
        <button type="submit" name="query" value="statistik">Statistik 5 Serangkai</button>
        <button type="submit" name="query" value="pencilan">Data Pencilan</button>
        <button type="submit" name="query" value="standar_deviasi">Standar Deviasi</button>
      </form>
    </div>
  </div>

  <div class="sidebar">
    <h3>Hasil Query</h3>
    <?php
 
    if (isset($statistik)) {
        echo "<p>Minimum: " . $statistik['minimum'] . "</p>";
        echo "<p>Maksimum: " . $statistik['maksimum'] . "</p>";
        echo "<p>Rata-rata: " . $statistik['rata_rata'] . "</p>";
        echo "<p>Q1: " . $statistik['q1'] . "</p>";
        echo "<p>Q3: " . $statistik['q3'] . "</p>";
    }

    if (isset($pencilan)) {
        if (!empty($pencilan)) {
            foreach ($pencilan as $row) {
                echo "Nama: " . $row['nama'] . " - UKT: " . $row['ukt'] . "<br>";
            }
        } else {
            echo "Tidak ada data pencilan yang ditemukan.<br>";
        }
    }

    if (isset($stdDeviasi)) {
        echo "<p>Standar Deviasi UKT: " . $stdDeviasi['std_deviasi'] . "</p>";
    }
    ?>
  </div>
</body>
</html>
