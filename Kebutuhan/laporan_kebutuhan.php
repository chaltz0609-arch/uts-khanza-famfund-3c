
<?php
require '../Utama/function.php';

// Mengambil ID kebutuhan
if(!isset($_GET["id"])){
    header("Location: kebutuhan.php");
    exit;
}

$id = (int) $_GET["id"];

$hasilData = query_db("SELECT * FROM kebutuhan WHERE id = $id");

if(count($hasilData) == 0){
    header("Location: kebutuhan.php");
    exit;
}

$kebutuhan = $hasilData[0];
$pesan = "";

// Proses upload laporan
if(isset($_POST["upload"])){

    $hasil = upload_laporan_kebutuhan($id);

    if($hasil > 0){
        echo "<script>
            alert('Foto laporan berhasil diunggah!');
            document.location.href = 'kebutuhan.php';
        </script>";
        exit;
    }else{
        $pesan = "Upload gagal. Pilih foto JPG, JPEG, atau PNG maksimal 2 MB.";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Pembelian - FamFund</title>
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

        <a href="../Ayah/ayah.php" class="menu">
            👨 Dashboard Ayah
        </a>

        <details open>
            <summary>💰 Manajemen Keuangan</summary>

            <a href="kebutuhan.php" class="submenu active-submenu">
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


    <!-- KONTEN -->
    <main class="main-content">

        <header class="topbar">
            <span>Dashboard / Kebutuhan / Laporan Pembelian</span>
            <span>📷 Laporan Keluarga</span>
        </header>

        <div class="content">

            <h1>Laporan Realisasi Pembelian</h1>

            <p class="subtitle">
                Unggah foto barang atau struk sebagai laporan kepada Ayah.
            </p>

            <div class="table-card form-pemasukan">

                <h3><?= $kebutuhan["nama_kebutuhan"] ?></h3>

                <p>Pengaju: <?= $kebutuhan["pengaju"] ?></p>

                <p>
                    Nominal:
                    Rp <?= number_format($kebutuhan["nominal"], 0, ',', '.') ?>
                </p>

                <p>
                    Status: <?= $kebutuhan["status"] ?>
                </p>

                <hr>

                <?php if($pesan != ""): ?>
                    <p style="color: red;">
                        <?= $pesan ?>
                    </p>
                <?php endif; ?>

                <?php if($kebutuhan["bukti"] != ""): ?>

                    <p>Foto laporan sebelumnya:</p>

                   <img src="../img/<?= $kebutuhan["bukti"] ?>"
                         class="foto-laporan-preview"
                         alt="Foto laporan pembelian">

                <?php endif; ?>

                <form action=""
                      method="post"
                      enctype="multipart/form-data">

                    <div class="form-group">

                        <label for="bukti">
                            Foto Barang / Struk Pembelian
                        </label>

                        <input type="file"
                               name="bukti"
                               id="bukti"
                               accept=".jpg,.jpeg,.png"
                               required>

                        <p class="subtitle">
                            Format JPG, JPEG, PNG.
                            Ukuran maksimal 2 MB.
                        </p>

                    </div>

                    <div class="button-group">

                        <button type="submit"
                                name="upload"
                                class="btn btn-tambah">
                            Upload Laporan
                        </button>

                        <a href="kebutuhan.php"
                           class="btn btn-kembali">
                            Kembali
                        </a>

                    </div>

                </form>

            </div>

        </div>

    </main>

</div>

</body>
</html>
