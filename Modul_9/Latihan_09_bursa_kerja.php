<?php
include 'Latihan_09_config.php'; // Koneksi database

// Proses penyimpanan data bursa kerja
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $perusahaan = $_POST['perusahaan'];
    $posisi = $_POST['posisi'];
    $deskripsi = $_POST['deskripsi'];

    // Menyimpan data ke dalam database
    $sql = "INSERT INTO bursa_kerja (perusahaan, posisi, deskripsi) VALUES ('$perusahaan', '$posisi', '$deskripsi')";

    if ($conn->query($sql) === TRUE) {
        echo "<div class='alert alert-success'>Lowongan berhasil ditambahkan.</div>";
    } else {
        echo "<div class='alert alert-danger'>Error: " . $conn->error . "</div>";
    }
}

// Mengambil lowongan pekerjaan yang ada
$sql = "SELECT * FROM bursa_kerja ORDER BY tanggal_posting DESC";
$result = $conn->query($sql);
?>

<div class="container mt-5">
    <h2>Bursa Kerja</h2>

    <!-- Form untuk menambahkan lowongan pekerjaan -->
    <form method="POST" action="">
        <div class="mb-3">
            <label for="perusahaan" class="form-label">Perusahaan</label>
            <input type="text" class="form-control" id="perusahaan" name="perusahaan" required>
        </div>
        <div class="mb-3">
            <label for="posisi" class="form-label">Posisi</label>
            <input type="text" class="form-control" id="posisi" name="posisi" required>
        </div>
        <div class="mb-3">
            <label for="deskripsi" class="form-label">Deskripsi Pekerjaan</label>
            <textarea class="form-control" id="deskripsi" name="deskripsi" rows="4" required></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Tambah Lowongan</button>
    </form>

    <hr>

    <h3>Lowongan Pekerjaan Terbaru</h3>
    <?php if ($result->num_rows > 0): ?>
        <ul class="list-group">
            <?php while ($row = $result->fetch_assoc()): ?>
                <li class="list-group-item">
                    <strong><?php echo htmlspecialchars($row['perusahaan']); ?></strong><br>
                    <strong><?php echo htmlspecialchars($row['posisi']); ?></strong><br>
                    <p><?php echo nl2br(htmlspecialchars($row['deskripsi'])); ?></p>
                    <small><i>Diposting pada: <?php echo $row['tanggal_posting']; ?></i></small>
                </li>
            <?php endwhile; ?>
        </ul>
    <?php else: ?>
        <p>Belum ada lowongan pekerjaan yang diposting.</p>
    <?php endif; ?>
</div>

<?php
$conn->close();
?>
