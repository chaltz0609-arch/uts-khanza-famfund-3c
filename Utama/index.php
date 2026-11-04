
<?php
require 'function.php';

$pemasukan = query_db("SELECT * FROM pemasukan");
$kebutuhan = query_db("SELECT * FROM kebutuhan");

// Menghitung pemasukan
$totalPemasukan = 0;
$totalAlokasi = 0;

foreach($pemasukan as $data){
    $totalPemasukan += $data["nominal_masuk"];
    $totalAlokasi += $data["alokasi_keluarga"];
}

// Menghitung kebutuhan
$totalDibayar = 0;
$utamaMenunggu = 0;
$dadakanMenunggu = 0;

foreach($kebutuhan as $data){

    if($data["status"] == "Dibayar"){
        $totalDibayar += $data["nominal"];
    }

    if($data["status"] == "Menunggu"){
        if($data["kategori"] == "Utama"){
            $utamaMenunggu++;
        }else{
            $dadakanMenunggu++;
        }
    }
}

$saldo = $totalAlokasi - $totalDibayar;
$totalMenunggu = $utamaMenunggu + $dadakanMenunggu;
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FamFund - Dashboard</title>
    <link rel="stylesheet" href="style.css">
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

        <a href="index.php" class="menu active">
            🏠 Dashboard
        </a>

        <a href="../Ayah/ayah.php" class="menu">
            👨 Dashboard Ayah
        </a>

        <details open>
            <summary>💰 Manajemen Keuangan</summary>

            <a href="../Kebutuhan/kebutuhan.php" class="submenu">
                Kebutuhan
            </a>

            <a href="../antrian.php" class="submenu">
                Antrian Prioritas
            </a>
        </details>

        <details>
            <summary>👨‍👩‍👧‍👦 Keluarga</summary>

            <a href="../anggota.php" class="submenu">
                Anggota Keluarga
            </a>
        </details>

        <details>
            <summary>📋 Laporan & Riwayat</summary>

            <a href="../Ayah/riwayat.php" class="submenu">
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
            <span>Dashboard / Keuangan Keluarga</span>
            <span>👤 Admin FamFund</span>
        </header>

        <div class="content">

            <h1>Dashboard</h1>
            <p class="subtitle">
                Ringkasan kondisi keuangan keluarga
            </p>

            <!-- CARD RINGKASAN -->
            <div class="cards">

                <div class="card card-green">
                    <p>Saldo Tersedia</p>
                    <h2>Rp <?= $saldo ?></h2>
                    <span>Dana alokasi keluarga</span>
                </div>

                <div class="card card-blue">
                    <p>Total Pemasukan</p>
                    <h2>Rp <?= $totalPemasukan ?></h2>
                    <span>Seluruh pemasukan tercatat</span>
                </div>

                <div class="card card-yellow">
                    <p>Kebutuhan Utama Menunggu</p>
                    <h2><?= $utamaMenunggu ?></h2>
                    <span>Belum dibayarkan</span>
                </div>

                <div class="card card-red">
                    <p>Kebutuhan Dadakan Menunggu</p>
                    <h2><?= $dadakanMenunggu ?></h2>
                    <span>Belum dibayarkan</span>
                </div>

            </div>

            <!-- DAFTAR KEBUTUHAN -->
         <div class="table-header">
    <h3>Daftar Kebutuhan Menunggu</h3>

    <a href="../Kebutuhan/kebutuhan.php"
       class="btn btn-cari">
        Lihat Semua &rarr;
    </a>
</div>

                <div class="table-wrapper">
                    <table>
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Kebutuhan</th>
                                <th>Pengaju</th>
                                <th>Kategori</th>
                                <th>Nominal</th>
                                <th>Deadline</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php $no = 1; ?>

                            <?php foreach($kebutuhan as $data): ?>

                                <?php if($data["status"] == "Menunggu" && $no <= 5): ?>

                                <tr>
                                    <td><?= $no ?></td>

                                    <td>
                                        <?= $data["nama_kebutuhan"] ?>
                                    </td>

                                    <td><?= $data["pengaju"] ?></td>

                                    <td>
                                        <?php if($data["kategori"] == "Utama"): ?>
                                            <span class="tag-utama">Utama</span>
                                        <?php else: ?>
                                            <span class="tag-dadakan">Dadakan</span>
                                        <?php endif; ?>
                                    </td>

                                    <td>Rp <?= $data["nominal"] ?></td>

                                    <td><?= $data["deadline"] ?></td>
                                </tr>

                                <?php $no++; ?>

                                <?php endif; ?>

                            <?php endforeach; ?>

                            <?php if($no == 1): ?>
                            <tr>
                                <td colspan="6">
                                    Belum ada kebutuhan menunggu.
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
