
<?php
require '../Utama/function.php';

// Mengambil data pemasukan
$pemasukan = query_db("SELECT * FROM pemasukan");

$totalAlokasi = 0;

foreach($pemasukan as $data){
    $totalAlokasi += $data["alokasi_keluarga"];
}

// Mengambil seluruh kebutuhan
$kebutuhan = query_db("SELECT * FROM kebutuhan");

$totalDibayar = 0;
$totalMenunggu = 0;
$nominalMenunggu = 0;

foreach($kebutuhan as $data){

    if($data["status"] == "Dibayar"){
        $totalDibayar += $data["nominal"];
    }

    if($data["status"] == "Menunggu"){
        $totalMenunggu++;
        $nominalMenunggu += $data["nominal"];
    }
}

// Saldo keluarga
$saldo = $totalAlokasi - $totalDibayar;

// Daftar kebutuhan belum dibayar
$antrian = query_db("SELECT * FROM kebutuhan
                     WHERE status = 'Menunggu'
                     ORDER BY kategori DESC,
                              deadline ASC,
                              tanggal_pengajuan ASC,
                              id ASC");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Ayah - FamFund</title>
   <link rel="stylesheet" href="../Utama/style.css">
</head>

<body>

<div class="layout">

    <!-- SIDEBAR AYAH -->
   <!-- SIDEBAR FAMFUND -->
<aside class="sidebar">

    <div class="logo">
        🏠 Fam<span class="merah">F</span><span class="hijau">u</span><span class="kuning">n</span><span class="biru">d</span>
    </div>

    <p class="menu-label">MENU UTAMA</p>

    <nav>

        <!-- DASHBOARD ADMIN -->
        <a href="../Utama/index.php" class="menu">
            🏠 Dashboard
        </a>

       
<!-- DASHBOARD AYAH -->
<details open>
 <summary class="menu active ayah-summary"
         style="background: #e8f0fe; border-left: 3px solid #4285f4;">

    <a href="ayah.php"
       class="ayah-dashboard-link"
       style="color: #1a73e8 !important; text-decoration: none !important; font-weight: bold;">
        👨 Dashboard Ayah
    </a>

</summary>

    <a href="../Kebutuhan/kebutuhan.php" class="submenu">
        Kebutuhan Keluarga
    </a>

    <a href="../Pemasukan/pemasukan.php" class="submenu">
        Pemasukan
    </a>

    <a href="../antrian.php" class="submenu">
        Antrian Prioritas
    </a>
</details>


        <!-- KELUARGA -->
        <details>
            <summary>👨‍👩‍👧‍👦 Keluarga</summary>

            <a href="../anggota.php" class="submenu">
                Anggota Keluarga
            </a>
        </details>

        <!-- LAPORAN DAN RIWAYAT -->
        <details>
            <summary>📋 Laporan & Riwayat</summary>

            <a href="riwayat.php" class="submenu">
                Riwayat Pembayaran
            </a>
        </details>

    </nav>

    <p class="menu-label">PENGATURAN</p>

    <nav>
        <a href="../Autentikasi/logout.php" class="menu">
            🚪 Logout
        </a>
    </nav>

</aside>

    <!-- KONTEN UTAMA -->
    <main class="main-content">

        <header class="topbar">
            <span>FamFund / Dashboard Ayah</span>
            <span>👨 Mode Ayah (Demo)</span>
        </header>

        <div class="content">

            <h1>Halo, Ayah! 👋</h1>

            <p class="subtitle">
                Pantau dana keluarga dan kebutuhan yang
                menunggu pembayaran.
            </p>

            <!-- RINGKASAN KEUANGAN -->
            <div class="cards">

                <div class="card card-green">
                    <p>Saldo Keluarga</p>

                    <h2>
                        Rp <?= number_format($saldo, 0, ',', '.') ?>
                    </h2>

                    <span>Dana yang masih tersedia</span>
                </div>

                <div class="card card-blue">
                    <p>Total Alokasi Keluarga</p>

                    <h2>
                        Rp <?= number_format($totalAlokasi, 0, ',', '.') ?>
                    </h2>

                    <span>Dana dari seluruh pemasukan</span>
                </div>

                <div class="card card-yellow">
                    <p>Kebutuhan Menunggu</p>

                    <h2><?= $totalMenunggu ?></h2>

                    <span>Pengajuan belum dibayar</span>
                </div>

                <div class="card card-red">
                    <p>Dana yang Dibutuhkan</p>

                    <h2>
                        Rp <?= number_format($nominalMenunggu, 0, ',', '.') ?>
                    </h2>

                    <span>Total nominal belum dibayar</span>
                </div>

            </div>

            <!-- DAFTAR PEMBAYARAN -->
            <div class="table-card">

                <div class="table-header">

                    <h3>Kebutuhan yang Menunggu Pembayaran</h3>

                    <span class="tag-menunggu">
                        <?= $totalMenunggu ?> Menunggu
                    </span>

                </div>

                <p class="subtitle">
                    Kebutuhan Utama ditampilkan terlebih dahulu,
                    kemudian diurutkan berdasarkan deadline.
                </p>

                <div class="table-wrapper">

                    <table>

                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Nama Kebutuhan</th>
                                <th>Pengaju</th>
                                <th>Kategori</th>
                                <th>Nominal</th>
                                <th>Deadline</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>

                        <tbody>

                            <?php $no = 1; ?>

                            <?php foreach($antrian as $data): ?>

                            <tr>

                                <td><?= $no ?></td>

                                <td>
                                    <?= $data["nama_kebutuhan"] ?>
                                </td>

                                <td>
                                    <?= $data["pengaju"] ?>
                                </td>

                                <td>
                                    <?php if($data["kategori"] == "Utama"): ?>

                                        <span class="tag-utama">
                                            Utama
                                        </span>

                                    <?php else: ?>

                                        <span class="tag-dadakan">
                                            Dadakan
                                        </span>

                                    <?php endif; ?>
                                </td>

                                <td>
                                    Rp <?= number_format($data["nominal"], 0, ',', '.') ?>
                                </td>

                                <td>
                                    <?= $data["deadline"] ?>
                                </td>

                                <td>
                                    <a href="bayar.php?id=<?= $data["id"] ?>"
                                       class="btn btn-bayar">
                                        Saya Mau Bayar
                                    </a>
                                </td>

                            </tr>

                            <?php $no++; ?>

                            <?php endforeach; ?>

                            <?php if(count($antrian) == 0): ?>

                            <tr>
                                <td colspan="7">
                                    Tidak ada kebutuhan yang menunggu pembayaran.
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
