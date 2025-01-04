<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nim = $_POST['nim'];
    $nama = $_POST['nama'];
    $jurusan = $_POST['jurusan'];
    $angkatan = $_POST['angkatan'];
    $status = $_POST['status'];

    $file = 'data/alumni.csv';
    $data = [];

    // Membaca data yang ada
    if (file_exists($file)) {
        $handle = fopen($file, 'r');
        while (($row = fgetcsv($handle)) !== false) {
            $data[] = $row;
        }
        fclose($handle);
    }

    // Menambah alumni baru
    $data[] = [$nim, $nama, $jurusan, $angkatan, $status];

    // Menyimpan kembali data ke file CSV
    $handle = fopen($file, 'w');
    foreach ($data as $row) {
        fputcsv($handle, $row);
    }
    fclose($handle);

    header("Location: index.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Alumni</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container my-5">
        <h2>Tambah Alumni</h2>
        <form method="POST" action="add_alumni.php">
            <div class="form-group">
                <label for="nim">NIM:</label>
                <input type="text" class="form-control" id="nim" name="nim" required>
            </div>
            <div class="form-group">
                <label for="nama">Nama:</label>
                <input type="text" class="form-control" id="nama" name="nama" required>
            </div>
            <div class="form-group">
                <label for="jurusan">Jurusan:</label>
                <input type="text" class="form-control" id="jurusan" name="jurusan" required>
            </div>
            <div class="form-group">
                <label for="angkatan">Angkatan:</label>
                <input type="number" class="form-control" id="angkatan" name="angkatan" required>
            </div>
            <div class="form-group">
                <label for="status">Status:</label>
                <select class="form-control" id="status" name="status" required>
                    <option value="Aktif">Aktif</option>
                    <option value="Tidak Aktif">Tidak Aktif</option>
                </select>
            </div>
            <button type="submit" class="btn btn-success">Tambah Alumni</button>
        </form>
    </div>
</body>
</html>
