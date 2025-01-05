<h3>FORM DATA ALUMNI</h3>
<hr>

<?php

// Memasukkan file konfigurasi untuk koneksi database
include 'Latihan_09_config.php';

// Menangani form submit
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Menangkap data dari form
    $nama = $_POST['nama'];
    $tahun_lulus = $_POST['tahun_lulus'];
    $jurusan = $_POST['jurusan'];

    // Mengelola Upload Foto
    if (isset($_FILES['foto']) && $_FILES['foto']['error'] == 0) {

        $target_dir = "uploads/";  // Tentukan direktori penyimpanan
        if (!is_dir($target_dir)) {
            mkdir($target_dir, 0777, true); // Membuat folder jika belum ada
        }

        // Membuat nama file yang unik
        $target_file = $target_dir . time() . "_" . basename($_FILES["foto"]["name"]);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        // Memeriksa apakah file benar-benar gambar
        $check = getimagesize($_FILES["foto"]["tmp_name"]);
        if ($check !== false) {
            $uploadOk = 1;
        } else {
            echo "<div class='alert alert-danger'>File bukan gambar.</div>";
            $uploadOk = 0;
        }

        // Memeriksa ukuran file (maksimal 5MB)
        if ($_FILES["foto"]["size"] > 5000000) {
            echo "<div class='alert alert-danger'>Ukuran file terlalu besar. Maksimal 5MB.</div>";
            $uploadOk = 0;
        }

        // Mengizinkan format file tertentu (JPG, JPEG, PNG, GIF)
        if (!in_array($imageFileType, ['jpg', 'jpeg', 'png', 'gif'])) {
            echo "<div class='alert alert-danger'>Hanya file JPG, JPEG, PNG, & GIF yang diizinkan.</div>";
            $uploadOk = 0;
        }

        // Cek apakah $uploadOk sudah di-set menjadi 0 oleh error
        if ($uploadOk == 0) {
            echo "<div class='alert alert-danger'>File tidak berhasil diunggah.</div>";
        } else {
            // Jika file berhasil diunggah, tambahkan data ke database
            if (move_uploaded_file($_FILES["foto"]["tmp_name"], $target_file)) {

                // Menyimpan data ke dalam database menggunakan prepared statements untuk mencegah SQL injection
                $stmt = $conn->prepare("INSERT INTO alumni (nama, tahun_lulus, jurusan, foto) VALUES (?, ?, ?, ?)");
                $stmt->bind_param("ssss", $nama, $tahun_lulus, $jurusan, $target_file);

                // Menjalankan query
                if ($stmt->execute()) {
                    echo "<div class='alert alert-success'>Data berhasil ditambahkan.</div>";
                } else {
                    echo "<div class='alert alert-danger'>Error: " . $stmt->error . "</div>";
                }

                // Menutup statement
                $stmt->close();
            } else {
                echo "<div class='alert alert-danger'>Terjadi kesalahan saat mengunggah file.</div>";
            }
        }
    } else {
        echo "<div class='alert alert-danger'>Tidak ada file yang diunggah atau file terlalu besar.</div>";
    }

    // Menutup koneksi database
    $conn->close();
}
?>

<div class="container mt-5">
    <h2 class="mb-4">Tambah Data Alumni</h2>

    <!-- Form tambah data alumni -->
    <form method="POST" action="" enctype="multipart/form-data">
        <div class="mb-3">
            <label for="nama" class="form-label">Nama</label>
            <input type="text" class="form-control" id="nama" name="nama" required>
        </div>

        <div class="mb-3">
            <label for="tahun_lulus" class="form-label">Tahun Lulus</label>
            <input type="number" class="form-control" id="tahun_lulus" name="tahun_lulus" required>
        </div>

        <div class="mb-3">
            <label for="jurusan" class="form-label">Jurusan</label>
            <input type="text" class="form-control" id="jurusan" name="jurusan" required>
        </div>

        <div class="mb-3">
            <label for="foto" class="form-label">Foto</label>
            <input type="file" class="form-control" id="foto" name="foto">
        </div>

        <button type="submit" class="btn btn-primary">Tambah Data</button>
    </form>
</div>
