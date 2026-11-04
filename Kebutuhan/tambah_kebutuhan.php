
<?php
require '../Utama/function.php';

// Proses tambah kebutuhan
if(isset($_POST["submit"])){

    if(tambah_kebutuhan($_POST) > 0){
        echo "<script>
            alert('Kebutuhan berhasil ditambahkan!');
            document.location.href = 'kebutuhan.php';
        </script>";
    }else{
        echo "<script>
            alert('Kebutuhan gagal ditambahkan!');
        </script>";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Tambah Kebutuhan - FamFund</title>
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
            <span>Dashboard / Kebutuhan / Tambah</span>
            <span>👤 Admin FamFund</span>
        </header>

        <div class="content">

            <h1>Tambah Kebutuhan</h1>

            <p class="subtitle">
                Catat pengajuan kebutuhan anggota keluarga.
            </p>

            <!-- FORM -->
            <div class="table-card form-pemasukan">

                <h3>Form Tambah Kebutuhan</h3>

                <form action="" method="post">

                    <!-- NAMA KEBUTUHAN -->
                    <div class="form-group">
                        <label for="nama_kebutuhan">
                            Nama Kebutuhan
                        </label>

                        <input type="text"
                               id="nama_kebutuhan"
                               name="nama_kebutuhan"
                               placeholder="Contoh: Bayar Kos Chaca"
                               maxlength="100"
                               required>
                    </div>

                    <!-- PENGAJU -->
                    <div class="form-group">
                        <label for="pengaju">
                            Diajukan Oleh
                        </label>

                        <select name="pengaju"
                                id="pengaju"
                                required>

                            <option value="">
                                Pilih anggota keluarga
                            </option>

                            <option value="Chaca">
                                Chaca
                            </option>

                            <option value="Ayah">
                                Ayah
                            </option>

                            <option value="Mamah">
                                Mamah
                            </option>

                            <option value="Seril">
                                Seril
                            </option>

                            <option value="Enver">
                                Enver
                            </option>

                        </select>
                    </div>

                    <!-- KATEGORI -->
                    <div class="form-group">
                        <label for="kategori">
                            Kategori Kebutuhan
                        </label>

                        <select name="kategori"
                                id="kategori"
                                required>

                            <option value="">
                                Pilih kategori
                            </option>

                            <option value="Utama">
                                Utama
                            </option>

                            <option value="Dadakan">
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
                               placeholder="Contoh: 500000"
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
                               required>
                    </div>

                    <!-- INFORMASI STATUS -->
                    <div class="info-status">
                        Status awal: Menunggu Pembayaran
                    </div>

                    <!-- TOMBOL -->
                    <div class="button-group">

                        <button type="submit"
                                name="submit"
                                class="btn btn-tambah">
                            Simpan Kebutuhan
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
