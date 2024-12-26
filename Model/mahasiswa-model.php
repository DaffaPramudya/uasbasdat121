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
    public function getAllMahasiswa() {
        $sql = "SELECT * FROM mahasiswa";
        $result = $this->conn->query($sql);
        $mahasiswaList = [];

        if ($result->num_rows > 0) {
            // Fetch all records as an associative array
            while ($row = $result->fetch_assoc()) {
                $mahasiswaList[] = $row;
            }
        }
        return $mahasiswaList;
    }

    //cek duplikat
    public function isDuplicateNIM($nim) {
        $sql = "SELECT * FROM mahasiswa WHERE nim = ?";
        $stmt = $this->conn->prepare($sql); 
        $stmt->bind_param("s", $nim);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->num_rows > 0; // True jika ada duplikat
    }

    // Mengambil statistik 5 serangkai
    public function getStatistik() {
        $result = $this->conn->query("SELECT 
                                  MIN(ukt) AS minimum, 
                                  MAX(ukt) AS maksimum, 
                                  AVG(ukt) AS rata_rata 
                                FROM mahasiswa");
        $data = $result->fetch_assoc();

        $q1q2 = $this->conn->query("SELECT ukt FROM mahasiswa ORDER BY ukt");
        $ukts = [];
        while ($row = $q1q2->fetch_assoc()) {
          $ukts[] = $row['ukt'];
        }
        $count = count($ukts);
        $q1 = $ukts[floor(($count - 1) * 0.25)];
        $q3 = $ukts[floor(($count - 1) * 0.75)];
        return [
            'minimum' => $data['minimum'],
            'maksimum' => $data['maksimum'],
            'rata_rata' => $data['rata_rata'],
            'q1' => $q1,
            'q3' => $q3
        ];
    }


    public function getDataPencilan() {
        $result = $this->conn->query("SELECT COUNT(*) AS total_count FROM mahasiswa");
        $data = $result->fetch_assoc();
        $total_count = $data['total_count'];


        $q1_offset = floor($total_count * 0.25);
        $q3_offset = floor($total_count * 0.75);


        $result = $this->conn->query("SELECT amount INTO @q1
                                    FROM (
                                        SELECT ukt AS amount, ROW_NUMBER() OVER (ORDER BY ukt) AS row_num
                                        FROM mahasiswa
                                    ) AS subquery
                                    WHERE row_num = $q1_offset");
        $q1 = $this->conn->query("SELECT @q1 AS q1_value")->fetch_assoc()['q1_value'];
        // Mengambil Q3
        $result = $this->conn->query("SELECT amount INTO @q3
                                    FROM (
                                        SELECT ukt AS amount, ROW_NUMBER() OVER (ORDER BY ukt) AS row_num
                                        FROM mahasiswa
                                    ) AS subquery
                                    WHERE row_num = $q3_offset");
        $q3 = $this->conn->query("SELECT @q3 AS q3_value")->fetch_assoc()['q3_value'];

        $iqr = $q3 - $q1;
        $lower_bound = max(0, $q1 - (1.5 * $iqr));
        $upper_bound = $q3 + (1.5 * $iqr);
        
        $sql = "SELECT * FROM mahasiswa 
                WHERE ukt < $lower_bound OR ukt > $upper_bound";
        $result = $this->conn->query($sql);

        if ($result->num_rows > 0) {
            $pencilanData = [];
            $result->data_seek(0);  
            while ($row = $result->fetch_assoc()) {
                $pencilanData[] = $row; 
}
        } else {
            $pencilanData = [];
        }
        return $pencilanData;

    }

    public function getStandarDeviasi() {
        $result = $this->conn->query("SELECT STD(ukt) AS std_deviasi FROM mahasiswa");
        return $result->fetch_assoc();
    }
}
?>
