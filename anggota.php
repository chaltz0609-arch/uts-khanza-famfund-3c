
<?php
require 'Utama/function.php';

// Daftar anggota keluarga
$anggota = [
    ["nama" => "Ayah", "ikon" => "👨", "peran" => "Pengelola Dana"],
    ["nama" => "Mamah", "ikon" => "👩", "peran" => "Anggota Keluarga"],
    ["nama" => "Chaca", "ikon" => "👩‍💻", "peran" => "Anggota Keluarga"],
    ["nama" => "Seril", "ikon" => "👧", "peran" => "Anggota Keluarga"],
    ["nama" => "Enver", "ikon" => "👦", "peran" => "Anggota Keluarga"]
];

// Ambil seluruh kebutuhan dari database
$kebutuhan = query_db("SELECT * FROM kebutuhan ORDER BY deadline ASC");

// Filter anggota melalui GET
$namaDipilih = "";

if(isset($_GET["nama"])){
    foreach($anggota as $orang){
        if($_GET["nama"] == $orang["nama"]){
            $namaDipilih = $orang["nama"];
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Anggota Keluarga - FamFund</title>
    <link rel="stylesheet" href="Utama/style.css">
</head>

<body>

<div class="layout">

   
<!-- SIDEBAR ADMIN -->
<aside class="sidebar">

    <div class="logo">
        🏠 Fam<span class="merah">F</span><span class="hijau">u</span><span class="kuning">n</span><span class="biru">d</span>
    </div>

    <p class="menu-label">MENU UTAMA</p>

    <nav>

        <a href="Utama/index.php" class="menu">
            🏠 Dashboard
        </a>

        <a href="Ayah/ayah.php" class="menu">
            👨 Dashboard Ayah
        </a>

        <details>
            <summary>💰 Manajemen Keuangan</summary>

            <a href="Kebutuhan/kebutuhan.php" class="submenu">
                Kebutuhan
            </a>

            <a href="antrian.php" class="submenu">
                Antrian Prioritas
            </a>
        </details>

        <details open>
            <summary>👨‍👩‍👧‍👦 Keluarga</summary>

            <a href="anggota.php" class="submenu active-submenu">
                Anggota Keluarga
            </a>
        </details>

        <details>
            <summary>📋 Laporan & Riwayat</summary>

            <a href="Ayah/riwayat.php" class="submenu">
                Riwayat Pembayaran
            </a>
        </details>

    </nav>

    <p class="menu-label">PENGATURAN</p>

    <nav>
        <a href="Autentikasi/logout.php" class="menu">
            🚪 Logout
        </a>
    </nav>

</aside>


    <!-- KONTEN -->
    <main class="main-content">

        <header class="topbar">
            <span>Dashboard / Anggota Keluarga</span>
            <span>👤 Admin FamFund</span>
        </header>

        <div class="content">

            <h1>Anggota Keluarga</h1>

            <p class="subtitle">
                Lihat anggota keluarga dan kebutuhan yang diajukan.
            </p>

            <!-- KARTU ANGGOTA -->
            <div class="anggota-grid">

                <?php foreach($anggota as $orang): ?>

                <?php
                    $total = 0;
                    $menunggu = 0;
                    $dibayar = 0;

                    foreach($kebutuhan as $data){

                        if($data["pengaju"] == $orang["nama"]){
                            $total++;

                            if($data["status"] == "Menunggu"){
                                $menunggu++;
                            }

                            if($data["status"] == "Dibayar"){
                                $dibayar++;
                            }
                        }
                    }
                ?>

                <div class="anggota-card">

                    <div class="anggota-avatar">
                        <?= $orang["ikon"] ?>
                    </div>

                    <h3><?= $orang["nama"] ?></h3>

                    <p class="anggota-role">
                        <?= $orang["peran"] ?>
                    </p>

                    <div class="anggota-stat">
                        <span>Total Kebutuhan</span>
                        <strong><?= $total ?></strong>
                    </div>

                    <div class="anggota-stat">
                        <span>Menunggu</span>
                        <strong><?= $menunggu ?></strong>
                    </div>

                    <div class="anggota-stat">
                        <span>Dibayar</span>
                        <strong><?= $dibayar ?></strong>
                    </div>

                   
<a href="anggota.php?nama=<?= $orang["nama"] ?>#rincian-kebutuhan"
   class="btn btn-lihat">
    Lihat Kebutuhan
</a>


                </div>

                <?php endforeach; ?>

            </div>

            <!-- TABEL KEBUTUHAN PER ANGGOTA -->
            <div class="table-card" id="rincian-kebutuhan">

                <div class="table-header">

                    <h3>
                        <?php if($namaDipilih == ""): ?>
                            Semua Kebutuhan Keluarga
                        <?php else: ?>
                            Kebutuhan <?= $namaDipilih ?>
                        <?php endif; ?> 
                    </h3>

                    <a href="anggota.php" class="btn btn-cari">
                        Tampilkan Semua
                    </a>

                </div>

                <div class="table-wrapper">

                    <table>
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Pengaju</th>
                                <th>Nama Kebutuhan</th>
                                <th>Kategori</th>
                                <th>Nominal</th>
                                <th>Deadline</th>
                                <th>Status</th>
                            </tr>
                        </thead>

                        <tbody>

                            <?php $no = 1; ?>

                            <?php foreach($kebutuhan as $data): ?>

                                <?php if($namaDipilih == "" || $data["pengaju"] == $namaDipilih): ?>

                                <tr>
                                    <td><?= $no ?></td>

                                    <td><?= $data["pengaju"] ?></td>

                                    <td><?= $data["nama_kebutuhan"] ?></td>

                                    <td>
                                        <?php if($data["kategori"] == "Utama"): ?>
                                            <span class="tag-utama">Utama</span>
                                        <?php else: ?>
                                            <span class="tag-dadakan">Dadakan</span>
                                        <?php endif; ?>
                                    </td>

                                    <td>Rp <?= $data["nominal"] ?></td>

                                    <td><?= $data["deadline"] ?></td>

                                    <td>
                                        <?php if($data["status"] == "Dibayar"): ?>
                                            <span class="tag-dibayar">Dibayar</span>
                                        <?php else: ?>
                                            <span class="tag-menunggu">Menunggu</span>
                                        <?php endif; ?>
                                    </td>
                                </tr>

                                <?php $no++; ?>

                                <?php endif; ?>

                            <?php endforeach; ?>

                            <?php if($no == 1): ?>
                                <tr>
                                    <td colspan="7">
                                        Belum ada kebutuhan yang tercatat.
                                    </td>
                                </tr>
                            <?php endif; ?>

                        </tbody>

                    </table>

                </div>

            </div>

        </div>

    </main>

</div>

</body>
</html>
