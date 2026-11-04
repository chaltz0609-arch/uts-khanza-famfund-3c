
<?php
require '../Utama/function.php';

if(!isset($_GET["id"])){
    echo "<script>
        alert('ID pemasukan tidak ditemukan!');
        document.location.href = 'pemasukan.php';
    </script>";
    exit;
}

$id = (int) $_GET["id"];

if(hapus_pemasukan($id) > 0){

    echo "<script>
        alert('Data pemasukan berhasil dihapus!');
        document.location.href = 'pemasukan.php';
    </script>";

}else{

    echo "<script>
        alert('Data pemasukan gagal dihapus atau tidak ditemukan!');
        document.location.href = 'pemasukan.php';
    </script>";

}
?>
