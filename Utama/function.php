<?php
// koneksi ke database
$conn = mysqli_connect("localhost", "root", "", "db_famfund");

function query_db($query) {
    global $conn;

    $result = mysqli_query($conn, $query);
    $rows = [];

    while($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }

    return $rows;
}

// SEARCH PEMASUKAN
function cari_pemasukan($keyword) {
    global $conn;

    $keyword = mysqli_real_escape_string($conn, $keyword);

    $query = "SELECT * FROM pemasukan
              WHERE
              sumber LIKE '%$keyword%' OR
              keterangan LIKE '%$keyword%' OR
              tanggal_masuk LIKE '%$keyword%'";

    return query_db($query);
}


 // TAMBAH PEMASUKAN
function tambah_pemasukan($data) {
    global $conn;

    $tanggal_masuk = $data["tanggal_masuk"];
    $sumber = $data["sumber"];
    $nominal_masuk = $data["nominal_masuk"];
    $alokasi_keluarga = $data["alokasi_keluarga"];
    $keterangan = $data["keterangan"];

    $query = "INSERT INTO pemasukan
              (tanggal_masuk, sumber, nominal_masuk, alokasi_keluarga, keterangan)
              VALUES
              ('$tanggal_masuk', '$sumber', '$nominal_masuk', '$alokasi_keluarga', '$keterangan')";

    mysqli_query($conn, $query);

    return mysqli_affected_rows($conn);
}

 // EDIT PEMASUKAN
function ubah_pemasukan($data) {
    global $conn;

    $id = (int) $data["id"];
    $tanggal_masuk = $data["tanggal_masuk"];
    $sumber = $data["sumber"];
    $nominal_masuk = $data["nominal_masuk"];
    $alokasi_keluarga = $data["alokasi_keluarga"];
    $keterangan = $data["keterangan"];

    $query = "UPDATE pemasukan SET
                tanggal_masuk = '$tanggal_masuk',
                sumber = '$sumber',
                nominal_masuk = '$nominal_masuk',
                alokasi_keluarga = '$alokasi_keluarga',
                keterangan = '$keterangan'
              WHERE id = $id";

    mysqli_query($conn, $query);

    return mysqli_affected_rows($conn);
}


// EDIT KEBUTUHAN
function ubah_kebutuhan($data) {
    global $conn;

    $id = (int) $data["id"];
    $nama_kebutuhan = mysqli_real_escape_string($conn, $data["nama_kebutuhan"]);
    $pengaju = mysqli_real_escape_string($conn, $data["pengaju"]);
    $kategori = mysqli_real_escape_string($conn, $data["kategori"]);
    $nominal = (int) $data["nominal"];
    $deadline = $data["deadline"];
    $bulan_kebutuhan = $data["bulan_kebutuhan"];

    if($nominal <= 0){
        return -1;
    }

    $query = "UPDATE kebutuhan SET
                nama_kebutuhan = '$nama_kebutuhan',
                pengaju = '$pengaju',
                kategori = '$kategori',
                nominal = '$nominal',
                deadline = '$deadline',
                bulan_kebutuhan = '$bulan_kebutuhan'
              WHERE id = $id";

    mysqli_query($conn, $query);

    return mysqli_affected_rows($conn);
}


// HAPUS PEMASUKAN
function hapus_pemasukan($id) {
    global $conn;

    $id = (int) $id;

    $query = "DELETE FROM pemasukan WHERE id = $id";

    mysqli_query($conn, $query);

    return mysqli_affected_rows($conn);
}


 // SEARCH KEBUTUHAN
function cari_kebutuhan($keyword) {
    global $conn;

    $keyword = mysqli_real_escape_string($conn, $keyword);

    $query = "SELECT * FROM kebutuhan
              WHERE
              nama_kebutuhan LIKE '%$keyword%' OR
              pengaju LIKE '%$keyword%' OR
              kategori LIKE '%$keyword%' OR
              status LIKE '%$keyword%'
              ORDER BY deadline ASC";

    return query_db($query);
}

// TAMBAH KEBUTUHAN
function tambah_kebutuhan($data) {
    global $conn;

    $nama_kebutuhan = mysqli_real_escape_string($conn, $data["nama_kebutuhan"]);
    $pengaju = $data["pengaju"];
    $kategori = $data["kategori"];
    $nominal = (int) $data["nominal"];
    $deadline = $data["deadline"];
    $bulan_kebutuhan = $data["bulan_kebutuhan"];

    if($nominal <= 0){
        return 0;
    }

    $query = "INSERT INTO kebutuhan
              (nama_kebutuhan, pengaju, kategori, nominal, deadline, bulan_kebutuhan, status)
              VALUES
              ('$nama_kebutuhan', '$pengaju', '$kategori', '$nominal', '$deadline', '$bulan_kebutuhan', 'Menunggu')";

    mysqli_query($conn, $query);

    return mysqli_affected_rows($conn);
}



// HAPUS KEBUTUHAN
function hapus_kebutuhan($id) {
    global $conn;

    $id = (int) $id;

    $query = "DELETE FROM kebutuhan WHERE id = $id";

    mysqli_query($conn, $query);

    return mysqli_affected_rows($conn);
}


 // REGISTRASI AKUN
function registrasi($data) {
    global $conn;

    $username = mysqli_real_escape_string($conn, $data["username"]);
    $password = $data["password"];
    $konfirmasi = $data["konfirmasi"];

    // Memeriksa isian kosong
    if($username == "" || $password == ""){
        return -3;
    }

    // Memeriksa username yang sudah ada
    $result = mysqli_query($conn,
        "SELECT * FROM user WHERE username = '$username'"
    );

    if(mysqli_num_rows($result) > 0){
        return -1;
    }

    // Memeriksa konfirmasi password
    if($password !== $konfirmasi){
        return -2;
    }

    // Mengubah password menjadi hash
    $password = password_hash($password, PASSWORD_DEFAULT);

    // Menyimpan akun ke database
    $query = "INSERT INTO user (username, password)
              VALUES ('$username', '$password')";

    mysqli_query($conn, $query);

    return mysqli_affected_rows($conn);
}


 // PEMBAYARAN KEBUTUHAN OLEH AYAH
function bayar_kebutuhan($id, $metode_bayar) {
    global $conn;

    $id = (int) $id;
    $tanggal_bayar = date("Y-m-d");

    if($metode_bayar != "Transfer" && $metode_bayar != "Tunai"){
        return 0;
    }

    $query = "UPDATE kebutuhan SET
                status = 'Dibayar',
                metode_bayar = '$metode_bayar',
                tanggal_bayar = '$tanggal_bayar'
              WHERE id = $id AND status = 'Menunggu'";

    mysqli_query($conn, $query);

    return mysqli_affected_rows($conn);
}


 // UPLOAD FOTO LAPORAN KEBUTUHAN
function upload_laporan_kebutuhan($id) {
    global $conn;

    $id = (int) $id;

    $namaFile = $_FILES["bukti"]["name"];
    $ukuranFile = $_FILES["bukti"]["size"];
    $error = $_FILES["bukti"]["error"];
    $tmpName = $_FILES["bukti"]["tmp_name"];

    // Periksa apakah file dipilih
    if($error !== 0){
        return -1;
    }

    // Periksa ekstensi gambar
    $ekstensiValid = ["jpg", "jpeg", "png"];

    $ekstensi = explode(".", $namaFile);
    $ekstensi = strtolower(end($ekstensi));

    if(!in_array($ekstensi, $ekstensiValid)){
        return -2;
    }

    // Maksimal 2 MB
    if($ukuranFile > 2000000){
        return -3;
    }

    // Membuat nama file baru
    $namaBaru = uniqid() . "." . $ekstensi;

  // Menyimpan gambar
if(!move_uploaded_file($tmpName, "../img/" . $namaBaru)){
    return -4;
}

    // Menyimpan nama gambar ke database
    $query = "UPDATE kebutuhan
              SET bukti = '$namaBaru'
              WHERE id = $id";

    mysqli_query($conn, $query);

    return mysqli_affected_rows($conn);
}


?>