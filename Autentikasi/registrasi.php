
<?php
require '../Utama/function.php';

if(isset($_POST["registrasi"])){

    $hasil = registrasi($_POST);

   if($hasil > 0){
    echo "<script>
        alert('Registrasi berhasil! Silakan login menggunakan akun baru.');
        document.location.href = 'login.php';
    </script>";
}
    elseif($hasil == -1){
        echo "<script>
            alert('Username sudah digunakan!');
        </script>";
    }
    elseif($hasil == -2){
        echo "<script>
            alert('Konfirmasi password tidak sesuai!');
        </script>";
    }
    elseif($hasil == -3){
        echo "<script>
            alert('Username dan password wajib diisi!');
        </script>";
    }
    else{
        echo "<script>
            alert('Registrasi gagal!');
        </script>";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Registrasi - FamFund</title>

<link rel="stylesheet" href="../Utama/style.css">
</head>

<body class="auth-page">

    <div class="auth-card">

        <div class="logo">
            🏠 Fam<span class="merah">F</span><span class="hijau">u</span><span class="kuning">n</span><span class="biru">d</span>
        </div>

        <h1>Buat Akun</h1>

        <p class="subtitle">
            Daftar untuk mengelola keuangan keluarga.
        </p>

        <form action="" method="post">

            <!-- USERNAME -->
            <div class="form-group">

                <label for="username">
                    Username
                </label>

                <input type="text"
                       name="username"
                       id="username"
                       placeholder="Masukkan username"
                       required>

            </div>

            <!-- PASSWORD -->
            <div class="form-group">

                <label for="password">
                    Password
                </label>

                <input type="password"
                       name="password"
                       id="password"
                       placeholder="Masukkan password"
                       required>

            </div>

            <!-- KONFIRMASI PASSWORD -->
            <div class="form-group">

                <label for="konfirmasi">
                    Konfirmasi Password
                </label>

                <input type="password"
                       name="konfirmasi"
                       id="konfirmasi"
                       placeholder="Ulangi password"
                       required>

            </div>

            <!-- TOMBOL -->
            <button type="submit"
                    name="registrasi"
                    class="btn btn-tambah auth-button">
                Daftar Sekarang
            </button>

</form>

<p class="auth-link">
    Sudah punya akun?
    <a href="login.php">Masuk di sini</a>
</p>

<p class="auth-note">

            FamFund — Family Financial Management
        </p>

    </div>

</body>
</html>
