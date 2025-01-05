<?php
// Memasukkan file konfigurasi untuk koneksi database
include 'Latihan_09_config.php';

// Proses penyimpanan data buku tamu
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama = $_POST['nama'];
    $pesan = $_POST['pesan'];

    // Menyimpan data ke dalam database
    $sql = "INSERT INTO buku_tamu (nama, pesan) VALUES ('$nama', '$pesan')";

    if ($conn->query($sql) === TRUE) {
        echo "<div class='alert alert-success'>Pesan berhasil disimpan.</div>";
    } else {
        echo "<div class='alert alert-danger'>Error: " . $conn->error . "</div>";
    }
}

// Mengambil data buku tamu dari database
$sql = "SELECT * FROM buku_tamu ORDER BY tanggal DESC";
$result = $conn->query($sql);
?>

<div class="container mt-5">
    <h2>Buku Tamu</h2>

    <!-- Form Buku Tamu -->
    <form method="POST" action="">
        <div class="mb-3">
            <label for="nama" class="form-label">Nama</label>
            <input type="text" class="form-control" id="nama" name="nama" required>
        </div>
        <div class="mb-3">
            <label for="pesan" class="form-label">Pesan</label>
            <textarea class="form-control" id="pesan" name="pesan" rows="3" required></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Kirim Pesan</button>
    </form>

    <hr>

    <h3>Pesan Tamu Terbaru</h3>
    <?php if ($result->num_rows > 0): ?>
        <ul class="list-group">
            <?php while($row = $result->fetch_assoc()): ?>
                <li class="list-group-item">
                    <strong><?php echo htmlspecialchars($row['nama']); ?></strong><br>
                    <small><i>Di-post pada <?php echo $row['tanggal']; ?></i></small>
                    <p><?php echo nl2br(htmlspecialchars($row['pesan'])); ?></p>
                </li>
            <?php endwhile; ?>
        </ul>
    <?php else: ?>
        <p>Belum ada pesan.</p>
    <?php endif; ?>
</div>

<?php
$conn->close();
?>
