
<?php
require '../Utama/function.php';

// Mengambil ID dari URL
if(!isset($_GET["id"])){
    echo "<script>
        alert('ID pemasukan tidak ditemukan!');
        document.location.href = 'pemasukan.php';
    </script>";
    exit;
}

$id = (int) $_GET["id"];

// Mengambil data berdasarkan ID
$pemasukan = query_db("SELECT * FROM pemasukan WHERE id = $id");

if(count($pemasukan) == 0){
    echo "<script>
        alert('Data pemasukan tidak ditemukan!');
        document.location.href = 'pemasukan.php';
    </script>";
    exit;
}

$pemasukan = $pemasukan[0];

// Proses perubahan data
if(isset($_POST["submit"])){

    if(ubah_pemasukan($_POST) >= 0){
        echo "<script>
            alert('Data pemasukan berhasil diubah!');
            document.location.href = 'pemasukan.php';
        </script>";
    }else{
        echo "<script>
            alert('Data pemasukan gagal diubah!');
        </script>";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Pemasukan - FamFund</title>
   <link rel="stylesheet" href="../Utama/style.css">
</head>

<body>

<div class="layout">



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

            <a href="../Kebutuhan/kebutuhan.php" class="submenu">
                Kebutuhan Keluarga
            </a>

            <a href="pemasukan.php" class="submenu active-submenu">
                Pemasukan
            </a>

            <a href="../antrian.php" class="submenu">
                Antrian Prioritas
            </a>
        </details>

        <!-- MANAJEMEN KEUANGAN -->
        <details>
            <summary>💰 Manajemen Keuangan</summary>

            <a href="../Kebutuhan/kebutuhan.php" class="submenu">
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
            <span>Dashboard / Pemasukan / Edit</span>
            <span>👤 Admin FamFund</span>
        </header>

        <div class="content">

            <h1>Edit Pemasukan</h1>

            <p class="subtitle">
                Perbarui informasi pemasukan keluarga.
            </p>

            <div class="table-card form-pemasukan">

                <h3>Form Edit Pemasukan</h3>

                <form action="" method="post">

                    <!-- ID DATA -->
                    <input type="hidden"
                           name="id"
                           value="<?= $pemasukan["id"] ?>">

                    <!-- TANGGAL -->
                    <div class="form-group">
                        <label for="tanggal_masuk">
                            Tanggal Masuk
                        </label>

                        <input type="date"
                               id="tanggal_masuk"
                               name="tanggal_masuk"
                               value="<?= $pemasukan["tanggal_masuk"] ?>"
                               required>
                    </div>

                    <!-- SUMBER -->
                    <div class="form-group">
                        <label for="sumber">
                            Sumber Pemasukan
                        </label>

                        <select name="sumber" id="sumber" required>

                            <option value="Gaji Pokok"
                                <?php if($pemasukan["sumber"] == "Gaji Pokok") echo "selected"; ?>>
                                Gaji Pokok
                            </option>

                            <option value="Sampingan"
                                <?php if($pemasukan["sumber"] == "Sampingan") echo "selected"; ?>>
                                Penghasilan Sampingan
                            </option>

                        </select>
                    </div>

                    <!-- NOMINAL -->
                    <div class="form-group">
                        <label for="nominal_masuk">
                            Nominal Pemasukan (Rp)
                        </label>

                        <input type="number"
                               id="nominal_masuk"
                               name="nominal_masuk"
                               value="<?= $pemasukan["nominal_masuk"] ?>"
                               min="0"
                               required>
                    </div>

                    <!-- ALOKASI -->
                    <div class="form-group">
                        <label for="alokasi_keluarga">
                            Alokasi untuk Keluarga (Rp)
                        </label>

                        <input type="number"
                               id="alokasi_keluarga"
                               name="alokasi_keluarga"
                               value="<?= $pemasukan["alokasi_keluarga"] ?>"
                               min="0"
                               required>
                    </div>

                    <!-- KETERANGAN -->
                    <div class="form-group">
                        <label for="keterangan">
                            Keterangan
                        </label>

                        <textarea name="keterangan"
                                  id="keterangan"
                                  rows="4"><?= $pemasukan["keterangan"] ?></textarea>
                    </div>

                    <!-- TOMBOL -->
                    <div class="button-group">

                        <button type="submit"
                                name="submit"
                                class="btn btn-edit">
                            Simpan Perubahan
                        </button>

                        <a href="pemasukan.php"
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
