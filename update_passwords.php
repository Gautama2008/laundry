<?php
include 'koneksi.php';

$users = [
    'admin' => 'admin123',
    'kasir' => 'kasir123',
    'owner' => 'owner123'
];

foreach ($users as $username => $password) {
    $hashed = md5($password);
    $query = "UPDATE tb_user SET password='$hashed' WHERE username='$username'";
    if (mysqli_query($conn, $query)) {
        echo "Password for $username updated successfully.<br>";
    } else {
        echo "Error updating $username: " . mysqli_error($conn) . "<br>";
    }
}
?>
