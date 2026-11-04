
<?php
require '../Utama/function.php';

// Mengambil ID kebutuhan dari URL
if(!isset($_GET["id"])){
    echo "<script>
        alert('ID kebutuhan tidak ditemukan!');
        document.location.href = 'kebutuhan.php';
    </script>";
    exit;
}

$id = (int) $_GET["id"];

// Mengambil data kebutuhan berdasarkan ID
$hasil = query_db("SELECT * FROM kebutuhan WHERE id = $id");

if(count($hasil) == 0){
    echo "<script>
        alert('Data kebutuhan tidak ditemukan!');
        document.location.href = 'kebutuhan.php';
    </script>";
    exit;
}

$kebutuhan = $hasil[0];

// Proses menyimpan perubahan
if(isset($_POST["submit"])){

    if(ubah_kebutuhan($_POST) >= 0){
        echo "<script>
            alert('Data kebutuhan berhasil diubah!');
            document.location.href = 'kebutuhan.php';
        </script>";
        exit;
    }else{
        echo "<script>
            alert('Data kebutuhan gagal diubah!');
        </script>";
    }
}
?>




<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Kebutuhan - FamFund</title>
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


    <!-- KONTEN UTAMA -->
    <main class="main-content">

        <header class="topbar">
            <span>Dashboard / Kebutuhan / Edit</span>
            <span>👤 Admin FamFund</span>
        </header>

        <div class="content">

            <h1>Edit Kebutuhan</h1>

            <p class="subtitle">
                Perbarui informasi pengajuan kebutuhan keluarga.
            </p>

            <div class="table-card form-pemasukan">

                <h3>Form Edit Kebutuhan</h3>

                <form action="" method="post">

                    <!-- ID KEBUTUHAN -->
                    <input type="hidden"
                           name="id"
                           value="<?= $kebutuhan["id"] ?>">

                    <!-- NAMA KEBUTUHAN -->
                    <div class="form-group">
                        <label for="nama_kebutuhan">
                            Nama Kebutuhan
                        </label>

                        <input type="text"
                               id="nama_kebutuhan"
                               name="nama_kebutuhan"
                               value="<?= $kebutuhan["nama_kebutuhan"] ?>"
                               maxlength="100"
                               required>
                    </div>

                    <!-- PENGAJU -->
                    <div class="form-group">
                        <label for="pengaju">
                            Diajukan Oleh
                        </label>

                        <select name="pengaju" id="pengaju" required>

                            <option value="Chaca"
                                <?php if($kebutuhan["pengaju"] == "Chaca") echo "selected"; ?>>
                                Chaca
                            </option>
                            <option value="Ayah"
                                <?php if($kebutuhan["pengaju"] == "Ayah") echo "selected"; ?>>
                                Ayah
                            </option>

                            <option value="Mamah"
                                <?php if($kebutuhan["pengaju"] == "Mamah") echo "selected"; ?>>
                                Mamah
                            </option>

                            <option value="Seril"
                                <?php if($kebutuhan["pengaju"] == "Seril") echo "selected"; ?>>
                                Seril
                            </option>

                            <option value="Enver"
                                <?php if($kebutuhan["pengaju"] == "Enver") echo "selected"; ?>>
                                Enver
                            </option>

                        </select>
                    </div>

                    <!-- KATEGORI -->
                    <div class="form-group">
                        <label for="kategori">
                            Kategori Kebutuhan
                        </label>

                        <select name="kategori" id="kategori" required>

                            <option value="Utama"
                                <?php if($kebutuhan["kategori"] == "Utama") echo "selected"; ?>>
                                Utama
                            </option>

                            <option value="Dadakan"
                                <?php if($kebutuhan["kategori"] == "Dadakan") echo "selected"; ?>>
                                Dadakan
                            </option>

                        </select>
                    </div>

                    <!-- NOMINAL -->
                    <div class="form-group">
                        <label for="nominal">
                            Nominal Kebutuhan (Rp)
                        </label>

                        <input type="number"
                               id="nominal"
                               name="nominal"
                               value="<?= $kebutuhan["nominal"] ?>"
                               min="1"
                               required>
                    </div>

                    <!-- DEADLINE -->
                    <div class="form-group">
                        <label for="deadline">
                            Deadline Pembayaran
                        </label>

                        <input type="date"
                               id="deadline"
                               name="deadline"
                               value="<?= $kebutuhan["deadline"] ?>"
                               required>
                    </div>

                    <!-- BULAN KEBUTUHAN -->
                    <div class="form-group">
                        <label for="bulan_kebutuhan">
                            Bulan Kebutuhan
                        </label>

                        <input type="month"
                               id="bulan_kebutuhan"
                               name="bulan_kebutuhan"
                               value="<?= $kebutuhan["bulan_kebutuhan"] ?>"
                               required>
                    </div>

                    <!-- STATUS SAAT INI -->
                    <div class="info-status">
                        Status saat ini:
                        <?= $kebutuhan["status"] ?>
                    </div>

                    <!-- TOMBOL -->
                    <div class="button-group">

                        <button type="submit"
                                name="submit"
                                class="btn btn-edit">
                            Simpan Perubahan
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
