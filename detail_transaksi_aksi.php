<?php 
session_start();
include 'koneksi.php';

$aksi = $_GET['aksi'];

if($aksi == 'tambah'){
    $id_transaksi = $_POST['id_transaksi'];
    $id_paket = $_POST['id_paket'];
    $qty = $_POST['qty'];
    $keterangan = $_POST['keterangan'];

    mysqli_query($conn, "INSERT INTO tb_detail_transaksi VALUES (NULL, '$id_transaksi', '$id_paket', '$qty', '$keterangan')");
    
    header("location:detail_transaksi.php?id=$id_transaksi");
}
?>
