<?php
session_start();
include 'koneksi.php';

// Check login
if(!isset($_SESSION['role'])){
    header("Location: index.php?pesan=belum_login");
    exit();
}

$aksi = isset($_GET['aksi']) ? $_GET['aksi'] : '';

if($aksi == 'tambah'){
    $nama = $_POST['nama'];
    $alamat = $_POST['alamat'];
    $tlp = $_POST['tlp'];

    $query = "INSERT INTO tb_outlet (nama, alamat, tlp) VALUES ('$nama', '$alamat', '$tlp')";
    mysqli_query($conn, $query);
    
    header("Location: outlet.php");
    exit();
}
elseif($aksi == 'edit'){
    $id = $_POST['id'];
    $nama = $_POST['nama'];
    $alamat = $_POST['alamat'];
    $tlp = $_POST['tlp'];

    $query = "UPDATE tb_outlet SET nama='$nama', alamat='$alamat', tlp='$tlp' WHERE id='$id'";
    mysqli_query($conn, $query);
    
    header("Location: outlet.php");
    exit();
}
elseif($aksi == 'hapus'){
    $id = $_GET['id'];
    
    $query = "DELETE FROM tb_outlet WHERE id='$id'";
    mysqli_query($conn, $query);
    
    header("Location: outlet.php");
    exit();
}
else {
    header("Location: outlet.php");
    exit();
}
?>
