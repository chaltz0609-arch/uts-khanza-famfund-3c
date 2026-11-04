
<?php
require 'Utama/function.php';

// Mengambil kebutuhan yang belum dibayar
// Utama didahulukan, lalu deadline terdekat
$antrian = query_db("SELECT * FROM kebutuhan
                     WHERE status = 'Menunggu'
                     ORDER BY kategori DESC,
                     deadline ASC,
                     tanggal_pengajuan ASC,
                     id ASC");

// Ringkasan antrian
$totalAntrian = count($antrian);
$totalUtama = 0;
$totalDadakan = 0;
$totalNominal = 0;

foreach($antrian as $data){

    $totalNominal += $data["nominal"];

    if($data["kategori"] == "Utama"){
        $totalUtama++;
    }else{
        $totalDadakan++;
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Antrian Prioritas - FamFund</title>
    <link rel="stylesheet" href="Utama/style.css">
</head>

<body>

<div class="layout">

    <!-- SIDEBAR -->
    <aside class="sidebar">

        <div class="logo">
            🏠 Fam<span class="merah">F</span><span class="hijau">u</span><span class="kuning">n</span><span class="biru">d</span>
        </div>

        <p class="menu-label">MENU UTAMA</p>

        <nav>
            <a href="Utama/index.php" class="menu">
                🏠 Dashboard
            </a>

            
<!-- DASHBOARD AYAH -->
<details>
    <summary class="menu ayah-summary">

    <a href="Ayah/ayah.php"
       class="ayah-dashboard-link"
       style="color: #475569 !important; text-decoration: none !important;">
        👨 Dashboard Ayah
    </a>

</summary>

    <a href="Kebutuhan/kebutuhan.php" class="submenu">
        Kebutuhan Keluarga
    </a>

    <a href="Pemasukan/pemasukan.php" class="submenu">
        Pemasukan
    </a>

    <a href="antrian.php" class="submenu">
        Antrian Prioritas
    </a>
</details>


            
<details open>
    <summary>💰 Manajemen Keuangan</summary>

    <a href="Kebutuhan/kebutuhan.php" class="submenu">
        Kebutuhan
    </a>

    <a href="antrian.php" class="submenu active-submenu">
        Antrian Prioritas
    </a>
</details>


           <details>
    <summary>👨‍👩‍👧‍👦 Keluarga</summary>

    <a href="anggota.php" class="submenu">
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
            <span>Dashboard / Antrian Prioritas</span>
            <span>👤 Admin FamFund</span>
        </header>

        <div class="content">

            <h1>Antrian Prioritas</h1>

            <p class="subtitle">
                Daftar kebutuhan keluarga berdasarkan
                kategori dan deadline pembayaran.
            </p>

            <!-- RINGKASAN -->
            <div class="cards">

                <div class="card card-blue">
                    <p>Total Antrian</p>
                    <h2><?= $totalAntrian ?></h2>
                    <span>Kebutuhan belum dibayar</span>
                </div>

                <div class="card card-green">
                    <p>Kebutuhan Utama</p>
                    <h2><?= $totalUtama ?></h2>
                    <span>Prioritas utama keluarga</span>
                </div>

                <div class="card card-yellow">
                    <p>Kebutuhan Dadakan</p>
                    <h2><?= $totalDadakan ?></h2>
                    <span>Kebutuhan tidak terencana</span>
                </div>

                <div class="card card-red">
                    <p>Total Dana Dibutuhkan</p>
                    <h2>
                        Rp <?= number_format($totalNominal, 0, ',', '.') ?>
                    </h2>
                    <span>Seluruh nominal dalam antrian</span>
                </div>

            </div>

            <!-- INFORMASI PRIORITAS -->
            <div class="table-card">

                <h3>Aturan Antrian FamFund</h3>

                <p class="subtitle">
                    Kebutuhan Utama akan didahulukan.
                    Jika kategorinya sama, kebutuhan
                    dengan deadline paling dekat
                    mendapat urutan lebih awal.
                </p>

            </div>

            <!-- DAFTAR ANTRIAN -->
            <div class="table-card">

                <div class="table-header">

                    <h3>Daftar Antrian Pembayaran</h3>

                    <a href="Kebutuhan/tambah_kebutuhan.php"
                       class="btn btn-tambah">
                        + Tambah Kebutuhan
                    </a>

                </div>

                <div class="table-wrapper">

                    <table>
                        <thead>
                            <tr>
                                <th>Prioritas</th>
                                <th>Nama Kebutuhan</th>
                                <th>Pengaju</th>
                                <th>Kategori</th>
                                <th>Nominal</th>
                                <th>Deadline</th>
                                <th>Status</th>
                            </tr>
                        </thead>

                        <tbody>

                            <?php $no = 1; ?>

                            <?php foreach($antrian as $data): ?>

                            <tr>

                                <td>
                                    <span class="nomor-prioritas">
                                        <?= $no ?>
                                    </span>
                                </td>

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
                                    <span class="tag-menunggu">
                                        Menunggu
                                    </span>
                                </td>

                            </tr>

                            <?php $no++; ?>

                            <?php endforeach; ?>

                            <?php if(count($antrian) == 0): ?>

                            <tr>
                                <td colspan="7">
                                    Belum ada kebutuhan dalam antrian.
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
