
<?php
require '../Utama/function.php';

// Mengambil seluruh data kebutuhan
$kebutuhan = query_db("SELECT * FROM kebutuhan ORDER BY deadline ASC");

// Menghitung ringkasan kebutuhan
$totalPengajuan = count($kebutuhan);
$totalMenunggu = 0;
$totalDibayar = 0;
$nominalMenunggu = 0;

foreach($kebutuhan as $data){

    if($data["status"] == "Menunggu"){
        $totalMenunggu++;
        $nominalMenunggu += $data["nominal"];
    }

    if($data["status"] == "Dibayar"){
        $totalDibayar++;
    }
}

// SEARCH KEBUTUHAN
if(isset($_POST["cari"])){
    $keyword = $_POST["keyword"];
    $kebutuhan = cari_kebutuhan($keyword);
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Kebutuhan - FamFund</title>
    <link rel="stylesheet" href="../Utama/style.css">
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

            <!-- DASHBOARD -->
            <a href="../Utama/index.php" class="menu">
                🏠 Dashboard
            </a>

            <!-- DASHBOARD AYAH -->
            <details>
                <summary class="menu ayah-summary">

                    <a href="../Ayah/ayah.php"
                       class="ayah-dashboard-link"
                       style="color:#475569; text-decoration:none;">
                        👨 Dashboard Ayah
                    </a>

                </summary>

                <a href="kebutuhan.php" class="submenu">
                    Kebutuhan Keluarga
                </a>

                <a href="../Pemasukan/pemasukan.php" class="submenu">
                    Pemasukan
                </a>

                <a href="../antrian.php" class="submenu">
                    Antrian Prioritas
                </a>

            </details>

            <!-- MANAJEMEN KEUANGAN -->
            <details open>

                <summary>💰 Manajemen Keuangan</summary>

                <a href="kebutuhan.php"
                   class="submenu active-submenu">
                    Kebutuhan
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
            <span>Dashboard / Manajemen Kebutuhan</span>
            <span>👤 Admin FamFund</span>
        </header>

        <div class="content">

            <h1>Manajemen Kebutuhan</h1>

            <p class="subtitle">
                Kelola pengajuan kebutuhan seluruh anggota keluarga.
            </p>


            <!-- CARD RINGKASAN -->
            <div class="cards">

                <div class="card card-blue">
                    <p>Total Pengajuan</p>
                    <h2><?= $totalPengajuan ?></h2>
                    <span>Seluruh kebutuhan tercatat</span>
                </div>

                <div class="card card-yellow">
                    <p>Menunggu Pembayaran</p>
                    <h2><?= $totalMenunggu ?></h2>
                    <span>Kebutuhan belum dibayar</span>
                </div>

                <div class="card card-green">
                    <p>Sudah Dibayar</p>
                    <h2><?= $totalDibayar ?></h2>
                    <span>Kebutuhan telah diselesaikan</span>
                </div>

                <div class="card card-red">
                    <p>Total Nominal Menunggu</p>

                    <h2>
                        Rp <?= number_format($nominalMenunggu, 0, ',', '.') ?>
                    </h2>

                    <span>Jumlah kebutuhan belum dibayar</span>
                </div>

            </div>


            <!-- DAFTAR KEBUTUHAN -->
            <div class="table-card">

                <div class="table-header">

                    <h3>Daftar Kebutuhan Keluarga</h3>

                    <a href="tambah_kebutuhan.php"
                       class="btn btn-tambah">
                        + Tambah Kebutuhan
                    </a>

                </div>


                <!-- SEARCH -->
                <form action="" method="post" class="filter-row">

                    <input type="text"
                           name="keyword"
                           class="search-input"
                           placeholder="Cari kebutuhan, pengaju, kategori, status..."
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

                    <a href="kebutuhan.php"
                       class="btn btn-kembali">
                        Reset
                    </a>

                </form>


                <!-- TABEL KEBUTUHAN -->
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
                                <th>Bulan</th>
                                <th>Status</th>
                                <th>Aksi Kebutuhan</th>
                                <th>Foto Laporan</th>
                                <th>Aksi Foto</th>
                            </tr>
                        </thead>

                        <tbody>

                            <?php $no = 1; ?>

                            <?php foreach($kebutuhan as $data): ?>

                            <tr>

                                <!-- NOMOR -->
                                <td>
                                    <?= $no ?>
                                </td>

                                <!-- NAMA KEBUTUHAN -->
                                <td>
                                    <?= $data["nama_kebutuhan"] ?>
                                </td>

                                <!-- PENGAJU -->
                                <td>
                                    <?= $data["pengaju"] ?>
                                </td>

                                <!-- KATEGORI -->
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

                                <!-- NOMINAL -->
                                <td>
                                    Rp <?= number_format($data["nominal"], 0, ',', '.') ?>
                                </td>

                                <!-- DEADLINE -->
                                <td>
                                    <?= $data["deadline"] ?>
                                </td>

                                <!-- BULAN KEBUTUHAN -->
                                <td>
                                    <?= $data["bulan_kebutuhan"] ?>
                                </td>

                                <!-- STATUS PEMBAYARAN -->
                                <td>

                                    <?php if($data["status"] == "Dibayar"): ?>

                                        <span class="tag-dibayar">
                                            Dibayar
                                        </span>

                                    <?php else: ?>

                                        <span class="tag-menunggu">
                                            Menunggu
                                        </span>

                                    <?php endif; ?>

                                </td>


                                <!-- AKSI KEBUTUHAN -->
                                <td>

                                    <div class="table-actions">

                                        <a href="edit_kebutuhan.php?id=<?= $data["id"] ?>"
                                           class="btn btn-edit">
                                            Edit
                                        </a>

                                        <a href="hapus_kebutuhan.php?id=<?= $data["id"] ?>"
                                           onclick="return confirm('Yakin ingin menghapus kebutuhan ini?')"
                                           class="btn btn-hapus">
                                            Hapus
                                        </a>

                                    </div>

                                </td>


                                <!-- FOTO LAPORAN -->
                                <td>

                                    <?php if($data["bukti"] != ""): ?>

                                        <a href="../img/<?= $data["bukti"] ?>"
                                           target="_blank">

                                            <img
                                                src="../img/<?= $data["bukti"] ?>"
                                                alt="Foto laporan pembelian"
                                                class="foto-laporan"
                                                width="70"
                                                height="70"
                                                style="width:70px; height:70px; max-width:70px; object-fit:cover; display:block; border-radius:8px;">

                                        </a>

                                    <?php else: ?>

                                        <span>Belum ada foto</span>

                                    <?php endif; ?>

                                </td>


                                <!-- AKSI FOTO LAPORAN -->
                                <td>

                                    <div class="table-actions">

                                        <a href="laporan_kebutuhan.php?id=<?= $data["id"] ?>"
                                           class="btn btn-cari"
                                           style="white-space:nowrap;">

                                            <?php if($data["bukti"] != ""): ?>

                                                Edit Foto

                                            <?php else: ?>

                                                Upload Foto

                                            <?php endif; ?>

                                        </a>


                                        <?php if($data["bukti"] != ""): ?>

                                            <form action="hapus_foto_kebutuhan.php"
                                                  method="post"
                                                  onsubmit="return confirm('Yakin ingin menghapus foto laporan ini?')">

                                                <input type="hidden"
                                                       name="id"
                                                       value="<?= $data["id"] ?>">

                                                <button type="submit"
                                                        name="hapus_foto"
                                                        class="btn btn-hapus"
                                                        style="white-space:nowrap;">
                                                    Hapus Foto
                                                </button>

                                            </form>

                                        <?php endif; ?>

                                    </div>

                                </td>

                            </tr>

                            <?php $no++; ?>

                            <?php endforeach; ?>


                            <!-- JIKA DATA KOSONG -->
                            <?php if(count($kebutuhan) == 0): ?>

                            <tr>
                                <td colspan="11">
                                    Belum ada data kebutuhan.
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
