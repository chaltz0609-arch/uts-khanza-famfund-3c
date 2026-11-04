
<?php
session_start();

require '../Utama/function.php';

// Jika sudah login, langsung ke dashboard
if(isset($_SESSION["login"])){
    header("Location: ../Utama/index.php");
    exit;
}

// Proses login
if(isset($_POST["login"])){

    $username = mysqli_real_escape_string($conn, $_POST["username"]);
    $password = $_POST["password"];

    // Cari username di database
    $result = mysqli_query($conn,
        "SELECT * FROM user WHERE username = '$username'"
    );

    // Periksa apakah username ditemukan
    if(mysqli_num_rows($result) === 1){

        $data = mysqli_fetch_assoc($result);

        // Periksa password
        if(password_verify($password, $data["password"])){

           $_SESSION["login"] = true;
            $_SESSION["username"] = $data["username"];

            header("Location: ../Utama/index.php");
            exit;
        }
    }

    // Jika username atau password salah
    $error = true;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Login - FamFund</title>
   <link rel="stylesheet" href="../Utama/style.css">
</head>

<body class="auth-page">

    <div class="auth-card">

        <!-- LOGO -->
        <div class="logo">
            🏠 Fam<span class="merah">F</span><span class="hijau">u</span><span class="kuning">n</span><span class="biru">d</span>
        </div>

        <h1>Selamat Datang!</h1>

        <p class="subtitle">
            Masuk untuk mengelola keuangan keluarga.
        </p>

        <!-- PESAN LOGIN GAGAL -->
        <?php if(isset($error)): ?>

            <p class="login-error">
                Username atau password salah!
            </p>

        <?php endif; ?>

        <!-- FORM LOGIN -->
        <form action="" method="post">

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

            <button type="submit"
                    name="login"
                    class="btn btn-cari auth-button">
                Masuk ke FamFund
            </button>

        </form>

        <p class="auth-link">
            Belum punya akun?
            <a href="registrasi.php">Daftar Sekarang</a>
        </p>

        <p class="auth-note">
            FamFund — Family Financial Management
        </p>

    </div>

</body>
</html>
