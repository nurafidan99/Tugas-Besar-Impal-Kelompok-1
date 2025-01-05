<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include "db.php";
if (!$conn) {
    die("Koneksi database gagal: " . mysqli_connect_error());
}

define('TABLE_NAME', 'database_website_laundry');
define('COL_NAMA', 'nama');
define('COL_EMAIL', 'email');
define('COL_JENIS_LAYANAN', 'jenis_layanan');
define('COL_SERVICE_DATE', 'tanggal');
define('COL_ALAMAT', 'alamat');
define('COL_NO_TELEPON', 'nomor_hp');
define('COL_JUMLAH_PAKAIAN', 'jumlah_pakaian');
define('COL_SPECIAL_REQUEST', 'special_request');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $errors = [];

    // Ambil data dari form dan sanitasi
    $nama = htmlspecialchars($_POST['nama']);
    $email = htmlspecialchars($_POST['email']);
    $jenis_layanan = htmlspecialchars($_POST['jenis_layanan']);
    $service_date = htmlspecialchars($_POST['service_date']);
    $alamat = htmlspecialchars($_POST['alamat']);
    $no_telepon = htmlspecialchars($_POST['no_telepon']);
    $jumlah_pakaian = htmlspecialchars($_POST['jumlah_pakaian']);
    $special_request = htmlspecialchars($_POST['special_request']);

    // Validasi form
    if (empty($nama) || empty($email) || empty($jenis_layanan) || empty($service_date) || empty($alamat) || empty($no_telepon) || empty($jumlah_pakaian)) {
        $errors[] = "Semua field harus diisi.";
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Format email tidak valid.";
    }
    if (!preg_match("/^\+62\d{8,}$/", $no_telepon)) {
        $errors[] = "Format nomor telepon tidak valid. Contoh: +6281234567890";
    }
    if (!is_numeric($jumlah_pakaian) || $jumlah_pakaian < 1) {
        $errors[] = "Jumlah pakaian harus berupa angka dan minimal 1.";
    }

    // Validasi format tanggal
    $date = DateTime::createFromFormat('Y-m-d', $service_date);
    if (!$date) {
        $errors[] = "Format tanggal tidak valid (YYYY-MM-DD).";
    }

    // Jika ada error, tampilkan pesan error
    if (!empty($errors)) {
        foreach ($errors as $error) {
            echo "<p style='color: red;'>$error</p>";
        }
    } else {
        try {
            // Versi dengan nama kolom langsung (untuk tes)
            $sql = "INSERT INTO database_website_laundry (nama, email, jenis_layanan, tanggal, alamat, nomor_hp, jumlah_pakaian, special_request) 
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

            //$sql = "INSERT INTO " . strtolower(TABLE_NAME) . " (" . strtolower(COL_NAMA) . ", " . strtolower(COL_EMAIL) . ", " . strtolower(COL_JENIS_LAYANAN) . ", " . strtolower(COL_SERVICE_DATE) . ", " . strtolower(COL_ALAMAT) . ", " . strtolower(COL_NO_TELEPON) . ", " . strtolower(COL_JUMLAH_PAKAIAN) . ", " . strtolower(COL_SPECIAL_REQUEST) . ") VALUES (?, ?, ?, ?, ?, ?, ?, ?)"; // Versi dengan strtolower()

            $stmt = $conn->prepare($sql);

            if ($stmt === false) {
                throw new Exception("Error preparing statement: " . $conn->error . "<br>SQL: " . $sql);
            }

            // Bind parameter dengan tipe data yang tepat
            $stmt->bind_param("ssssssis", $nama, $email, $jenis_layanan, $service_date, $alamat, $no_telepon, $jumlah_pakaian, $special_request);

            // Debugging: Menampilkan query yang dipersiapkan dan nilai parameter
            echo "SQL Query: " . $sql . "<br>";
            var_dump($nama, $email, $jenis_layanan, $service_date, $alamat, $no_telepon, $jumlah_pakaian, $special_request);

            if ($stmt->execute()) {
                header("Location: thank_you.php");
                exit;
            } else {
                throw new Exception("Error executing statement: " . $stmt->error);
            }
        } catch (Exception $e) {
            echo "Terjadi kesalahan: " . $e->getMessage();
        } finally {
            // Tutup statement dan koneksi
            if (isset($stmt)) $stmt->close();
            $conn->close();
        }
    }
}
?>