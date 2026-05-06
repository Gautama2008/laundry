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
    $jenis_kelamin = $_POST['jenis_kelamin'];
    $tlp = $_POST['tlp'];

    $query = "INSERT INTO tb_member (nama, alamat, jenis_kelamin, tlp) VALUES ('$nama', '$alamat', '$jenis_kelamin', '$tlp')";
    mysqli_query($conn, $query);
    
    header("Location: member.php");
    exit();
}
elseif($aksi == 'edit'){
    $id = $_POST['id'];
    $nama = $_POST['nama'];
    $alamat = $_POST['alamat'];
    $jenis_kelamin = $_POST['jenis_kelamin'];
    $tlp = $_POST['tlp'];

    $query = "UPDATE tb_member SET nama='$nama', alamat='$alamat', jenis_kelamin='$jenis_kelamin', tlp='$tlp' WHERE id='$id'";
    mysqli_query($conn, $query);
    
    header("Location: member.php");
    exit();
}
elseif($aksi == 'hapus'){
    $id = $_GET['id'];
    
    $query = "DELETE FROM tb_member WHERE id='$id'";
    mysqli_query($conn, $query);
    
    header("Location: member.php");
    exit();
}
else {
    header("Location: member.php");
    exit();
}
?>
