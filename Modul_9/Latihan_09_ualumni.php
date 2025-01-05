<?php

// Memasukkan file konfigurasi untuk koneksi database
include 'Latihan_09_config.php'; // Pastikan file konfigurasi koneksi sudah benar

// Memeriksa apakah parameter ID ada dalam URL
if (isset($_GET['id']) && is_numeric($_GET['id'])) {

    $id = $_GET['id'];

    // Mengambil data alumni berdasarkan ID
    $sql = "SELECT * FROM alumni WHERE id = $id";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();  // Menyimpan data alumni yang ditemukan
    } else {
        echo "<div class='alert alert-danger'>Data tidak ditemukan.</div>";
    }

    // Menangani pembaruan data ketika form di-submit
    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        $id = $_POST['id'];
        $nama = $_POST['nama'];
        $tahun_lulus = $_POST['tahun_lulus'];
        $jurusan = $_POST['jurusan'];

        // Mengelola pembaruan foto
        $target_dir = "uploads/"; // Pastikan Anda memiliki folder 'uploads' di server Anda
        $uploadOk = 1;
        $target_file = $target_dir . basename($_FILES["foto"]["name"]);
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        // Memeriksa apakah file benar-benar gambar
        if (isset($_FILES['foto']) && $_FILES['foto']['error'] == 0) {
            $check = getimagesize($_FILES["foto"]["tmp_name"]);
            if ($check === false) {
                echo "<div class='alert alert-danger'>File bukan gambar.</div>";
                $uploadOk = 0;
            }

            // Memeriksa ukuran file (5MB maksimal)
            if ($_FILES["foto"]["size"] > 5000000) {
                echo "<div class='alert alert-danger'>Ukuran file terlalu besar.</div>";
                $uploadOk = 0;
            }

            // Mengizinkan format file tertentu (JPG, JPEG, PNG, GIF)
            if ($imageFileType != "jpg" && $imageFileType != "jpeg" && $imageFileType != "png" && $imageFileType != "gif") {
                echo "<div class='alert alert-danger'>Hanya file JPG, JPEG, PNG, & GIF yang diizinkan.</div>";
                $uploadOk = 0;
            }

            // Cek apakah $uploadOk sudah di-set menjadi 0 oleh error
            if ($uploadOk == 0) {
                echo "<div class='alert alert-danger'>File tidak berhasil diunggah.</div>";
            } else {
                // Jika file berhasil diunggah, update data di database
                if (move_uploaded_file($_FILES["foto"]["tmp_name"], $target_file)) {
                    $foto = $target_file;
                } else {
                    echo "<div class='alert alert-danger'>Terjadi kesalahan saat mengunggah file.</div>";
                    $foto = null;
                }
            }
        } else {
            // Jika tidak ada foto yang diunggah, foto tetap menggunakan foto yang lama
            $foto = null;
        }

        // Query untuk memperbarui data alumni
        if ($foto) {
            $sql = "UPDATE alumni SET nama='$nama', tahun_lulus='$tahun_lulus', jurusan='$jurusan', foto='$foto' WHERE id=$id";
        } else {
            $sql = "UPDATE alumni SET nama='$nama', tahun_lulus='$tahun_lulus', jurusan='$jurusan' WHERE id=$id";
        }

        // Eksekusi query untuk pembaruan data
        if ($conn->query($sql) === TRUE) {
            echo "<div class='alert alert-success'>Data berhasil diperbarui.</div>";
        } else {
            echo "<div class='alert alert-danger'>Error: " . $conn->error . "</div>";
        }

        // Menutup koneksi database
        $conn->close();
    }

} else {
    echo "<div class='alert alert-danger'>ID tidak valid.</div>";
}

?>

<div class="container mt-5">
    <h2 class="mb-4">Update Data Alumni</h2>

    <!-- Form update data -->
    <?php if (isset($row)) { ?>
        <form method="POST" action="" enctype="multipart/form-data">
            <input type="hidden" name="id" value="<?php echo $row['id']; ?>">

            <div class="mb-3">
                <label for="nama" class="form-label">Nama</label>
                <input type="text" class="form-control" id="nama" name="nama" value="<?php echo $row['nama']; ?>" required>
            </div>

            <div class="mb-3">
                <label for="tahun_lulus" class="form-label">Tahun Lulus</label>
                <input type="number" class="form-control" id="tahun_lulus" name="tahun_lulus" value="<?php echo $row['tahun_lulus']; ?>" required>
            </div>

            <div class="mb-3">
                <label for="jurusan" class="form-label">Jurusan</label>
                <input type="text" class="form-control" id="jurusan" name="jurusan" value="<?php echo $row['jurusan']; ?>" required>
            </div>

            <div class="mb-3">
                <label for="foto" class="form-label">Foto (biarkan kosong jika tidak diubah)</label>
                <input type="file" class="form-control" id="foto" name="foto">
            </div>

            <button type="submit" class="btn btn-primary">Perbarui Data</button>
        </form>
    <?php } ?>
</div>
