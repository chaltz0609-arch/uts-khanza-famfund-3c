
<?php
require '../Utama/function.php';

if(!isset($_GET["id"])){
    echo "<script>
        alert('ID kebutuhan tidak ditemukan!');
        document.location.href = 'kebutuhan.php';
    </script>";
    exit;
}

$id = (int) $_GET["id"];

if(hapus_kebutuhan($id) > 0){

    echo "<script>
        alert('Data kebutuhan berhasil dihapus!');
        document.location.href = 'kebutuhan.php';
    </script>";

}else{

    echo "<script>
        alert('Data kebutuhan gagal dihapus atau tidak ditemukan!');
        document.location.href = 'kebutuhan.php';
    </script>";

}
?>
