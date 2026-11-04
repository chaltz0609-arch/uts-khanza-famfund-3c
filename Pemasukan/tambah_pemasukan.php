
<?php
require '../Utama/function.php';

if(isset($_POST["submit"])){

    if(tambah_pemasukan($_POST) > 0){
        echo "<script>
            alert('Data pemasukan berhasil ditambahkan!');
            document.location.href = 'pemasukan.php';
        </script>";
    }else{
        echo "<script>
            alert('Data pemasukan gagal ditambahkan!');
        </script>";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Pemasukan - FamFund</title>
    <link rel="stylesheet" 	href="../Utama/style.css">
</head>

<body>

<div class="layout">

   

<!-- SIDEBAR AYAH -->
<aside class="sidebar">

    <div class="logo">
        🏠 Fam<span class="merah">F</span><span class="hijau">u</span><span class="kuning">n</span><span class="biru">d</span>
    </div>

    <p class="menu-label">MENU AYAH</p>

    <nav>

        <a href="../Ayah/ayah.php" class="menu">
            🏠 Dashboard Ayah
        </a>

        <a href="../Kebutuhan/kebutuhan.php" class="menu">
            📋 Kebutuhan Keluarga
        </a>

        <a href="pemasukan.php" class="menu active">
            💰 Pemasukan
        </a>

        <a href="../antrian.php" class="menu">
            ⏳ Antrian Prioritas
        </a>

    </nav>

    <p class="menu-label">NAVIGASI</p>

    <nav>

        <a href="../Utama/index.php" class="menu">
            📊 Dashboard Admin
        </a>

        <a href="../Autentikasi/logout.php" class="menu">
            🚪 Logout
        </a>

    </nav>

</aside>



    <!-- KONTEN UTAMA -->
    <main class="main-content">

        <header class="topbar">
            <span>Dashboard / Pemasukan / Tambah</span>
            <span>👤 Admin FamFund</span>
        </header>

        <div class="content">

            <h1>Tambah Pemasukan</h1>

            <p class="subtitle">
                Catat pemasukan dan alokasi dana keluarga.
            </p>

            <div class="table-card form-pemasukan">

                <h3>Form Tambah Pemasukan</h3>

                <form action="" method="post">

                    <!-- TANGGAL -->
                    <div class="form-group">
                        <label for="tanggal_masuk">
                            Tanggal Masuk
                        </label>

                        <input type="date"
                               id="tanggal_masuk"
                               name="tanggal_masuk"
                               required>
                    </div>

                    <!-- SUMBER -->
                    <div class="form-group">
                        <label for="sumber">
                            Sumber Pemasukan
                        </label>

                        <select name="sumber" id="sumber" required>
                            <option value="">Pilih sumber</option>
                            <option value="Gaji Pokok">Gaji Pokok</option>
                            <option value="Sampingan">Penghasilan Sampingan</option>
                        </select>
                    </div>

                    <!-- NOMINAL MASUK -->
                    <div class="form-group">
                        <label for="nominal_masuk">
                            Nominal Pemasukan (Rp)
                        </label>

                        <input type="number"
                               id="nominal_masuk"
                               name="nominal_masuk"
                               placeholder="Contoh: 5000000"
                               min="0"
                               required>
                    </div>

                    <!-- ALOKASI KELUARGA -->
                    <div class="form-group">
                        <label for="alokasi_keluarga">
                            Alokasi untuk Keluarga (Rp)
                        </label>

                        <input type="number"
                               id="alokasi_keluarga"
                               name="alokasi_keluarga"
                               placeholder="Contoh: 4000000"
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
                                  rows="4"
                                  placeholder="Tambahkan keterangan pemasukan..."></textarea>
                    </div>

                    <!-- TOMBOL -->
                    <div class="button-group">

                        <button type="submit"
                                name="submit"
                                class="btn btn-tambah">
                            Simpan Pemasukan
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
