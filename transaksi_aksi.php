<?php 
session_start();
include 'koneksi.php';

$aksi = $_GET['aksi'];

if($aksi == 'tambah'){
    $id_outlet = $_POST['id_outlet'];
    $kode_invoice = "INV" . date('YmdHis');
    $id_member = $_POST['id_member'];
    $tgl = $_POST['tgl'];
    $batas_waktu = $_POST['batas_waktu'];
    $biaya_tambahan = $_POST['biaya_tambahan'];
    $diskon = $_POST['diskon'];
    $pajak = $_POST['pajak'];
    $status = $_POST['status'];
    $dibayar = $_POST['dibayar'];
    
    if($dibayar == 'dibayar'){
        $tgl_bayar = date('Y-m-d H:i:s');
        $query_tgl = "'$tgl_bayar'";
    } else {
        $query_tgl = "NULL";
    }
    
    $id_user = $_SESSION['id'];

    // Insert main transaction
    mysqli_query($conn, "INSERT INTO tb_transaksi VALUES (NULL, '$id_outlet', '$kode_invoice', '$id_member', '$tgl', '$batas_waktu', $query_tgl, '$biaya_tambahan', '$diskon', '$pajak', '$status', '$dibayar', '$id_user')");
    
    // Get the ID of the transaction just created
    $id_transaksi = mysqli_insert_id($conn);

    // Insert package items
    $id_pakets = $_POST['id_paket'];
    $qtys = $_POST['qty'];
    $keterangans = $_POST['keterangan'];

    for($i = 0; $i < count($id_pakets); $i++) {
        $id_paket = $id_pakets[$i];
        $qty = $qtys[$i];
        $keterangan = $keterangans[$i];

        if(!empty($id_paket)) {
            mysqli_query($conn, "INSERT INTO tb_detail_transaksi VALUES (NULL, '$id_transaksi', '$id_paket', '$qty', '$keterangan')");
        }
    }
    
    header("location:transaksi.php");
} elseif($aksi == 'edit_status'){
    $id = $_POST['id'];
    $status = $_POST['status'];
    $dibayar = $_POST['dibayar'];
    
    if($dibayar == 'dibayar'){
        $tgl_bayar = date('Y-m-d H:i:s');
        $query_tgl = "tgl_bayar='$tgl_bayar',";
    } else {
        $query_tgl = "tgl_bayar=NULL,";
    }
    
    mysqli_query($conn, "UPDATE tb_transaksi SET status='$status', $query_tgl dibayar='$dibayar' WHERE id='$id'");
    
    // Redirect back to either list or detail depending on HTTP_REFERER or just to transaksi.php
    $referer = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : 'transaksi.php';
    header("location: $referer");
} elseif($aksi == 'hapus'){
    $id = $_GET['id'];
    mysqli_query($conn, "DELETE FROM tb_transaksi WHERE id='$id'");
    header("location:transaksi.php");
}
?>
