<?php
include 'Latihan_09_config.php'; // Koneksi database

// Mengambil data alumni berdasarkan pencarian
$search = '';
if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['search'])) {
    $search = $_GET['search'];
    $sql = "SELECT * FROM alumni WHERE nama LIKE '%$search%' OR jurusan LIKE '%$search%' OR tahun_lulus LIKE '%$search%'";
} else {
    $sql = "SELECT * FROM alumni";
}

$result = $conn->query($sql);
?>

<div class="container mt-5">
    <h2>Penelusuran Alumni</h2>

    <!-- Form pencarian alumni -->
    <form method="GET" action="">
        <div class="mb-3">
            <label for="search" class="form-label">Cari Alumni</label>
            <input type="text" class="form-control" id="search" name="search" value="<?php echo htmlspecialchars($search); ?>" placeholder="Nama, Jurusan, atau Tahun Lulus">
        </div>
        <button type="submit" class="btn btn-primary">Cari</button>
    </form>

    <hr>

    <h3>Hasil Pencarian</h3>
    <?php if ($result->num_rows > 0): ?>
        <ul class="list-group">
            <?php while ($row = $result->fetch_assoc()): ?>
                <li class="list-group-item">
                    <strong><?php echo htmlspecialchars($row['nama']); ?></strong><br>
                    <small><?php echo htmlspecialchars($row['jurusan']); ?> - <?php echo htmlspecialchars($row['tahun_lulus']); ?></small>
                </li>
            <?php endwhile; ?>
        </ul>
    <?php else: ?>
        <p>Alumni tidak ditemukan.</p>
    <?php endif; ?>
</div>

<?php
$conn->close();
?>
