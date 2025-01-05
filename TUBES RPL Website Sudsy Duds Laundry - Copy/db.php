<?php
$host = "localhost"; // Bisa juga "127.0.0.1"
$user = "root";
$password = ""; // Kosong jika tidak ada password
$database = "db_tugasimpal";

$conn = new mysqli($host, $user, $password, $database);

// Periksa koneksi dan tampilkan pesan error yang lebih informatif
if ($conn->connect_errno) {
    // Gunakan connect_error untuk pesan error, bukan connect_errno
    die("Koneksi ke database gagal: " . $conn->connect_error . " (Kode Error: " . $conn->connect_errno . ")");
} else {
    echo "Koneksi ke database berhasil!"; // Hapus baris ini setelah pengujian
}
    // Opsional: Baris ini bisa dihapus setelah pengujian berhasil
    // echo "Koneksi ke database berhasil!";


// Set charset ke UTF-8 (Penting untuk karakter khusus)
$conn->set_charset("utf8mb4"); // Rekomendasi untuk mendukung emoji dan karakter khusus lainnya

//Opsi lain jika set_charset tidak berfungsi
//if (!$conn->query("SET NAMES 'utf8mb4'")) {
//    printf("Error loading character set utf8mb4: %s\n", $conn->error);
//    exit();
//}
?>
