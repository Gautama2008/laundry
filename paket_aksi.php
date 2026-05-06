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
    $id_outlet = $_POST['id_outlet'];
    $jenis = $_POST['jenis'];
    $nama_paket = $_POST['nama_paket'];
    $harga = $_POST['harga'];

    $query = "INSERT INTO tb_paket (id_outlet, jenis, nama_paket, harga) VALUES ('$id_outlet', '$jenis', '$nama_paket', '$harga')";
    mysqli_query($conn, $query);
    
    header("Location: paket.php");
    exit();
}
elseif($aksi == 'edit'){
    $id = $_POST['id'];
    $id_outlet = $_POST['id_outlet'];
    $jenis = $_POST['jenis'];
    $nama_paket = $_POST['nama_paket'];
    $harga = $_POST['harga'];

    $query = "UPDATE tb_paket SET id_outlet='$id_outlet', jenis='$jenis', nama_paket='$nama_paket', harga='$harga' WHERE id='$id'";
    mysqli_query($conn, $query);
    
    header("Location: paket.php");
    exit();
}
elseif($aksi == 'hapus'){
    $id = $_GET['id'];
    
    $query = "DELETE FROM tb_paket WHERE id='$id'";
    mysqli_query($conn, $query);
    
    header("Location: paket.php");
    exit();
}
else {
    header("Location: paket.php");
    exit();
}
?>
