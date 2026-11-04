
<?php
require '../Utama/function.php';

// Mengambil ID kebutuhan dari URL
if(!isset($_GET["id"])){
    header("Location: ayah.php");
    exit;
}

$id = (int) $_GET["id"];

$kebutuhan = query_db("SELECT * FROM kebutuhan WHERE id = $id");

// Memeriksa apakah data tersedia
if(count($kebutuhan) == 0){
    echo "<script>
        alert('Kebutuhan tidak ditemukan!');
        document.location.href = 'ayah.php';
    </script>";
    exit;
}

$kebutuhan = $kebutuhan[0];

// Hanya kebutuhan menunggu yang dapat dibayar
if($kebutuhan["status"] != "Menunggu"){
    echo "<script>
        alert('Kebutuhan ini sudah dibayar!');
        document.location.href = 'ayah.php';
    </script>";
    exit;
}

// Proses konfirmasi pembayaran
if(isset($_POST["bayar"])){

    $metode_bayar = $_POST["metode_bayar"];

    if(bayar_kebutuhan($id, $metode_bayar) > 0){

        echo "<script>
            alert('Pembayaran berhasil dicatat!');
            document.location.href = 'ayah.php';
        </script>";
        exit;

    }else{

        echo "<script>
            alert('Pembayaran gagal dicatat!');
        </script>";

    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Konfirmasi Pembayaran - FamFund</title>
    <link rel="stylesheet" href="../Utama/style.css">
</head>

<body class="auth-page">

    <div class="auth-card bayar-card">

        <div class="logo">
            🏠 Fam<span class="merah">F</span><span class="hijau">u</span><span class="kuning">n</span><span class="biru">d</span>
        </div>

        <h1>Konfirmasi Pembayaran</h1>

        <p class="subtitle">
            Periksa kebutuhan sebelum mencatat pembayaran.
        </p>

        <!-- INFORMASI KEBUTUHAN -->
        <div class="detail-pembayaran">

            <p>Nama Kebutuhan</p>
            <h3><?= $kebutuhan["nama_kebutuhan"] ?></h3>

            <p>Diajukan Oleh</p>
            <strong><?= $kebutuhan["pengaju"] ?></strong>

            <p>Deadline</p>
            <strong><?= $kebutuhan["deadline"] ?></strong>

            <p>Jumlah Pembayaran</p>

            <h2>
                Rp <?= number_format($kebutuhan["nominal"], 0, ',', '.') ?>
            </h2>

        </div>

        <!-- FORM PEMBAYARAN -->
        <form action="" method="post">

            <div class="form-group">

                <label for="metode_bayar">
                    Metode Pembayaran
                </label>

                <select name="metode_bayar"
                        id="metode_bayar"
                        required>

                    <option value="">
                        Pilih metode pembayaran
                    </option>

                    <option value="Transfer">
                        Transfer Bank
                    </option>

                    <option value="Tunai">
                        Tunai
                    </option>

                </select>

            </div>

            <button type="submit"
                    name="bayar"
                    onclick="return confirm('Konfirmasi bahwa kebutuhan ini sudah dibayar?')"
                    class="btn btn-tambah auth-button">
                Konfirmasi Sudah Dibayar
            </button>

        </form>

        <p class="auth-link">
            <a href="ayah.php">
                ← Kembali ke Dashboard Ayah
            </a>
        </p>

    </div>

</body>
</html>
