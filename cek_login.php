<?php 
session_start();
include 'koneksi.php';

$username = $_POST['username'];
$password = md5($_POST['password']); // MD5 for simple UKK standard

$login = mysqli_query($conn, "SELECT * FROM tb_user WHERE username='$username' AND password='$password'");
$cek = mysqli_num_rows($login);

if($cek > 0){
	$data = mysqli_fetch_assoc($login);
	
	$_SESSION['id'] = $data['id'];
	$_SESSION['nama'] = $data['nama'];
	$_SESSION['username'] = $data['username'];
	$_SESSION['role'] = $data['role'];
	$_SESSION['id_outlet'] = $data['id_outlet'];
	
	header("location:dashboard.php");
} else {
	header("location:index.php?pesan=gagal");
}
?>
