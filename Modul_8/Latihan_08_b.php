
    <h1>Informasi Alumni</h1>
    <?php
    // Deklarasi variabel
    $namaAlumni = "Dede Irawan";
    $tahunKelulusan = 2005;
    $statusAktif = true;
    $jumlahLulusan5Tahun = 300;
    $tahunSekarang = date("Y");

    // Hitung lama kelulusan
    $lamaKelulusan = $tahunSekarang - $tahunKelulusan;

    // Hitung rasio alumni
    $rasioAlumni = $jumlahLulusan5Tahun / 150;

    // Tampilkan lama kelulusan
    echo "<p>Lama Kelulusan: $lamaKelulusan tahun</p>";

    // Jumlah alumni dan kondisi reuni
    $jumlahAlumni = 120;
    $jumlahAlumni += 10;
    if ($jumlahAlumni >= 130) {
        echo "<p>Jumlah sudah mencukupi untuk acara reuni.</p>";
    }

    // Kondisi alumni aktif dan lama kelulusan
    if ($statusAktif && $lamaKelulusan <= 5) {
        echo "<p>$namaAlumni adalah alumni aktif dan lulus dalam 5 tahun terakhir.</p>";
    } else {
        echo "<p>$namaAlumni adalah alumni tidak aktif atau lulus lebih dari 5 tahun yang lalu.</p>";
    }

    // Manipulasi string
    echo "<p>Nama Lengkap: $namaAlumni</p>";
    echo "<p>Nama dalam Huruf Besar: " . strtoupper($namaAlumni) . "</p>";
    echo "<p>Nama dalam Huruf Kecil: " . strtolower($namaAlumni) . "</p>";

    // Ambil inisial
    $namaPart = explode(" ", $namaAlumni);
    $initials = substr($namaPart[0], 0, 1) . substr($namaPart[1], 0, 1);
    echo "<p>Inisial: $initials</p>";
    ?>
