<?php
session_start();
$file = 'data/alumni.csv';

// Fungsi untuk membaca data dari file CSV
function readAlumniData($file) {
    $data = [];
    if (file_exists($file)) {
        $handle = fopen($file, 'r');
        while (($row = fgetcsv($handle)) !== false) {
            $data[] = $row;
        }
        fclose($handle);
    }
    return $data;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tracer Alumni</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <div class="container my-5">
        <h2 class="text-center">Tracer Alumni</h2>
        <div class="text-center">
            <a href="add_alumni.php" class="btn btn-primary my-3">Tambah Alumni</a>
        </div>

        <!-- Daftar Alumni -->
        <h4>Daftar Alumni:</h4>
        <table class="table table-bordered" id="alumniTable">
            <thead>
                <tr>
                    <th>NIM</th>
                    <th>Nama</th>
                    <th>Jurusan</th>
                    <th>Angkatan</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $alumni = readAlumniData($file);
                foreach ($alumni as $index => $alumnus) {
                    echo "<tr data-index='$index'>
                            <td>{$alumnus[0]}</td>
                            <td>{$alumnus[1]}</td>
                            <td>{$alumnus[2]}</td>
                            <td>{$alumnus[3]}</td>
                            <td>{$alumnus[4]}</td>
                            <td>
                                <button class='btn btn-danger delete-btn'>Hapus</button>
                            </td>
                          </tr>";
                }
                ?>
            </tbody>
        </table>
    </div>

    <script>
        // Menghapus alumni dengan menggunakan jQuery
        $(document).on('click', '.delete-btn', function() {
            var row = $(this).closest('tr');
            var index = row.data('index');

            // Kirim permintaan DELETE menggunakan AJAX
            $.ajax({
                url: 'delete_alumni.php',
                type: 'POST',
                data: { index: index },
                success: function(response) {
                    row.remove();
                    alert("Alumni berhasil dihapus!");
                }
            });
        });
    </script>
</body>
</html>
