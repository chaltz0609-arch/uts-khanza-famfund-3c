
<?php
require '../Utama/function.php';

// mengambil seluruh data pemasukan
$pemasukan = query_db("SELECT * FROM pemasukan");

// menghitung total pemasukan
$totalPemasukan = 0;
$totalAlokasi = 0;

foreach($pemasukan as $data){
    $totalPemasukan += $data["nominal_masuk"];
    $totalAlokasi += $data["alokasi_keluarga"];
}

// mencari data pemasukan
if(isset($_POST["cari"])){
    $keyword = $_POST["keyword"];
    $pemasukan = cari_pemasukan($keyword);
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Pemasukan - FamFund</title>
   <link rel="stylesheet" href="../Utama/style.css">
</head>

<body>

<div class="layout">

    
<!-- SIDEBAR AYAH -->

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
           <summary class="menu ayah-summary">

  <a href="../Ayah/ayah.php"
   class="ayah-dashboard-link"
   style="color: #475569 !important; text-decoration: none !important;">
    👨 Dashboard Ayah
</a>

</summary>

            <a href="../Kebutuhan/kebutuhan.php"
               class="submenu">
                Kebutuhan Keluarga
            </a>

            <a href="pemasukan.php"
               class="submenu active-submenu">
                Pemasukan
            </a>

            <a href="../antrian.php"
               class="submenu">
                Antrian Prioritas
            </a>
        </details>

        <!-- MANAJEMEN KEUANGAN -->
        <details>
            <summary>💰 Manajemen Keuangan</summary>

            <a href="../Kebutuhan/kebutuhan.php"
               class="submenu">
                Kebutuhan
            </a>

            <a href="../antrian.php"
               class="submenu">
                Antrian Prioritas
            </a>
        </details>

        <!-- KELUARGA -->
        <details>
            <summary>👨‍👩‍👧‍👦 Keluarga</summary>

            <a href="../anggota.php"
               class="submenu">
                Anggota Keluarga
            </a>
        </details>

        <!-- LAPORAN DAN RIWAYAT -->
        <details>
            <summary>📋 Laporan & Riwayat</summary>

            <a href="../Ayah/riwayat.php"
               class="submenu">
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
            <span>Dashboard / Manajemen Pemasukan</span>
            <span>👤 Admin FamFund</span>
        </header>

        <div class="content">

            <h1>Manajemen Pemasukan</h1>

            <p class="subtitle">
                Kelola semua sumber pemasukan keluarga dalam satu tempat.
            </p>

            <!-- RINGKASAN PEMASUKAN -->
            <div class="cards">

                <div class="card card-green">
                    <p>Total Pemasukan Tercatat</p>
                    <h2>Rp <?= $totalPemasukan ?></h2>
                    <span>Seluruh pemasukan yang dicatat</span>
                </div>

                <div class="card card-yellow">
                    <p>Total Alokasi Keluarga</p>
                    <h2>Rp <?= $totalAlokasi ?></h2>
                    <span>Dana untuk kebutuhan keluarga</span>
                </div>

            </div>

            <!-- DATA PEMASUKAN -->
            <div class="table-card">

                <div class="table-header">
                    <h3>Daftar Pemasukan</h3>

                    <a href="tambah_pemasukan.php" class="btn btn-tambah">
                        + Tambah Pemasukan
                    </a>
                </div>

                <!-- SEARCH -->
                <form action="" method="post" class="filter-row">

                    <input type="text"
                           name="keyword"
                           class="search-input"
                           placeholder="Cari sumber, tanggal, atau keterangan...">

                    <button type="submit" name="cari" class="btn btn-cari">
                        Cari
                    </button>

                </form>

                <!-- TABEL PEMASUKAN -->
                <div class="table-wrapper">

                    <table>
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Tanggal Masuk</th>
                                <th>Sumber</th>
                                <th>Nominal Masuk</th>
                                <th>Alokasi Keluarga</th>
                                <th>Keterangan</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>

                        <tbody>

                            <?php $no = 1; ?>

                            <?php foreach($pemasukan as $data): ?>

                            <tr>
                                <td><?= $no ?></td>

                                <td><?= $data["tanggal_masuk"] ?></td>

                                <td><?= $data["sumber"] ?></td>

                                <td>Rp <?= $data["nominal_masuk"] ?></td>

                                <td>Rp <?= $data["alokasi_keluarga"] ?></td>

                                <td><?= $data["keterangan"] ?></td>

                                <td>
                                    <div class="table-actions">

                                        <a href="edit_pemasukan.php?id=<?= $data["id"] ?>"
                                           class="btn btn-edit">
                                            Edit
                                        </a>

                                       <a href="hapus_pemasukan.php?id=<?= $data["id"] ?>"
   onclick="return confirm('Yakin ingin menghapus data pemasukan ini?')"
   class="btn btn-hapus">
    Hapus
</a>

                                    </div>
                                </td>
                            </tr>

                            <?php $no++; ?>

                            <?php endforeach; ?>

                            <?php if(count($pemasukan) == 0): ?>
                            <tr>
                                <td colspan="7">
                                    Belum ada data pemasukan.
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
