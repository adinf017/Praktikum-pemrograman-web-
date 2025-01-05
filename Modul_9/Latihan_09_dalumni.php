<?php

// Memasukkan file konfigurasi untuk koneksi database
include 'Latihan_09_config.php';

// Memastikan bahwa parameter 'id' ada dan merupakan angka
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    
    // Mendapatkan ID dari parameter GET
    $id = $_GET['id'];

    // Menyiapkan query DELETE menggunakan prepared statements
    $stmt = $conn->prepare("DELETE FROM alumni WHERE id = ?");
    $stmt->bind_param("i", $id);  // "i" menunjukkan tipe data integer

    // Menjalankan query
    if ($stmt->execute()) {
        // Jika berhasil, tampilkan pesan sukses
        echo "Data berhasil dihapus.";

        // Redirect ke halaman alumni setelah beberapa detik
        header("Refresh: 2; url=Latihan_09_index.php?menu=alumni");
        exit();  // Pastikan untuk keluar setelah redirect
    } else {
        // Jika ada error saat eksekusi query
        echo "Error deleting record: " . $stmt->error;
    }

    // Menutup statement
    $stmt->close();
} else {
    // Jika ID tidak valid atau tidak ada, beri informasi
    echo "ID tidak valid atau tidak ditemukan.";
}

// Menutup koneksi
$conn->close();

?>
