
<?php
require '../Utama/function.php';

// Mengambil semua kebutuhan yang sudah dibayar
$riwayat = query_db("SELECT * FROM kebutuhan
                     WHERE status = 'Dibayar'
                     ORDER BY tanggal_bayar DESC, id DESC");

// Menghitung ringkasan pembayaran
$totalTransaksi = count($riwayat);
$totalPembayaran = 0;
$totalTransfer = 0;
$totalTunai = 0;

foreach($riwayat as $data){

    $totalPembayaran += $data["nominal"];

    if($data["metode_bayar"] == "Transfer"){
        $totalTransfer++;
    }

    if($data["metode_bayar"] == "Tunai"){
        $totalTunai++;
    }
}

// SEARCH RIWAYAT PEMBAYARAN
if(isset($_POST["cari"])){

    $keyword = mysqli_real_escape_string($conn, $_POST["keyword"]);

    $riwayat = query_db("SELECT * FROM kebutuhan
                         WHERE status = 'Dibayar'
                         AND (
                             nama_kebutuhan LIKE '%$keyword%'
                             OR pengaju LIKE '%$keyword%'
                             OR metode_bayar LIKE '%$keyword%'
                             OR tanggal_bayar LIKE '%$keyword%'
                         )
                         ORDER BY tanggal_bayar DESC, id DESC");
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Riwayat Pembayaran - FamFund</title>
    <link rel="stylesheet" href="../Utama/style.css">
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

        <a href="../Utama/index.php" class="menu">
            🏠 Dashboard
        </a>

        <a href="ayah.php" class="menu">
            👨 Dashboard Ayah
        </a>

        <details>
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

        <details open>
            <summary>📋 Laporan & Riwayat</summary>

            <a href="riwayat.php" class="submenu active-submenu">
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
            <span>Dashboard / Riwayat Pembayaran</span>
            <span>👤 Admin FamFund</span>
        </header>

        <div class="content">

            <h1>Riwayat Pembayaran</h1>

            <p class="subtitle">
                Pantau seluruh kebutuhan keluarga
                yang telah selesai dibayarkan.
            </p>

            <!-- RINGKASAN -->
            <div class="cards">

                <div class="card card-blue">
                    <p>Total Transaksi</p>
                    <h2><?= $totalTransaksi ?></h2>
                    <span>Transaksi berhasil dicatat</span>
                </div>

                <div class="card card-green">
                    <p>Total Pembayaran</p>
                    <h2>
                        Rp <?= number_format($totalPembayaran, 0, ',', '.') ?>
                    </h2>
                    <span>Seluruh nominal yang dibayarkan</span>
                </div>

                <div class="card card-yellow">
                    <p>Pembayaran Transfer</p>
                    <h2><?= $totalTransfer ?></h2>
                    <span>Transaksi melalui bank</span>
                </div>

                <div class="card card-red">
                    <p>Pembayaran Tunai</p>
                    <h2><?= $totalTunai ?></h2>
                    <span>Transaksi secara tunai</span>
                </div>

            </div>

            <!-- TABEL RIWAYAT -->
            <div class="table-card">

                <div class="table-header">

                    <h3>Daftar Riwayat Pembayaran</h3>

                    <span class="tag-dibayar">
                        Sudah Dibayar
                    </span>

                </div>

                <!-- SEARCH -->
                <form action="" method="post" class="filter-row">

                    <input type="text"
                           name="keyword"
                           class="search-input"
                           placeholder="Cari kebutuhan, pengaju, metode, tanggal..."
                           value="<?php
                               if(isset($_POST['keyword'])){
                                   echo $_POST['keyword'];
                               }
                           ?>">

                    <button type="submit"
                            name="cari"
                            class="btn btn-cari">
                        Cari
                    </button>

                    <a href="riwayat.php"
                       class="btn btn-kembali">
                        Reset
                    </a>

                </form>

                <!-- DATA PEMBAYARAN -->
                <div class="table-wrapper">

                    <table>

                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Nama Kebutuhan</th>
                                <th>Pengaju</th>
                                <th>Kategori</th>
                                <th>Nominal</th>
                                <th>Tanggal Bayar</th>
                                <th>Metode Bayar</th>
                                <th>Status</th>
                            </tr>
                        </thead>

                        <tbody>

                            <?php $no = 1; ?>

                            <?php foreach($riwayat as $data): ?>

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
                                    <?= $data["tanggal_bayar"] ?>
                                </td>

                                <td>
                                    <?= $data["metode_bayar"] ?>
                                </td>

                                <td>
                                    <span class="tag-dibayar">
                                        Dibayar
                                    </span>
                                </td>

                            </tr>

                            <?php $no++; ?>

                            <?php endforeach; ?>

                            <?php if(count($riwayat) == 0): ?>

                            <tr>
                                <td colspan="8">
                                    Belum ada riwayat pembayaran.
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
