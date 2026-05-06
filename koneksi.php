<?php
$host = "localhost";
$user = "root";
$pass = "";
$db   = "laundry_tama";

$conn = mysqli_connect($host, $user, $pass, $db);

if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}
?>
