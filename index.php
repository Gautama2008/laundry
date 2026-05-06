<?php
session_start();
if(isset($_SESSION['role'])){
    header("Location: dashboard.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Laundry Tama</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            background-color: #e6f0f9;
            font-family: 'Inter', sans-serif;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .card-login {
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
            border: none;
            width: 100%;
            max-width: 400px;
            padding: 40px 30px;
            background-color: #ffffff;
        }
        .title-text {
            color: #1976d2; /* Biru seperti di gambar */
            font-weight: 700;
            font-size: 24px;
            margin-bottom: 5px;
        }
        .subtitle-text {
            color: #6c757d;
            font-size: 14px;
            margin-bottom: 30px;
        }
        .form-label {
            font-weight: 600;
            font-size: 14px;
            color: #333;
            margin-bottom: 5px;
        }
        .form-control {
            padding: 10px 15px;
            border-radius: 6px;
            border: 1px solid #ced4da;
            font-size: 14px;
        }
        .form-control:focus {
            border-color: #1976d2;
            box-shadow: 0 0 0 0.2rem rgba(25, 118, 210, 0.25);
        }
        .btn-masuk {
            background-color: #1976d2;
            border-color: #1976d2;
            color: white;
            font-weight: 600;
            padding: 10px;
            border-radius: 6px;
            font-size: 15px;
            letter-spacing: 0.5px;
            margin-top: 10px;
        }
        .btn-masuk:hover {
            background-color: #1565c0;
            border-color: #1565c0;
            color: white;
        }
    </style>
</head>
<body>
    <div class="card-login text-center">
        <h1 class="title-text">Laundry Tama</h1>
        <p class="subtitle-text">Masuk untuk melanjutkan</p>
        
        <?php if(isset($_GET['pesan'])): ?>
            <div class="alert alert-danger py-2" role="alert" style="font-size: 14px;">
                <?php 
                if($_GET['pesan'] == "gagal"){
                    echo "Username atau password salah!";
                } else if($_GET['pesan'] == "logout"){
                    echo "Anda telah berhasil logout.";
                } else if($_GET['pesan'] == "belum_login"){
                    echo "Anda harus login terlebih dahulu.";
                }
                ?>
            </div>
        <?php endif; ?>

        <form action="cek_login.php" method="POST" class="text-start">
            <div class="mb-3">
                <label for="username" class="form-label">Username</label>
                <input type="text" class="form-control" id="username" name="username" placeholder="Masukkan username" required>
            </div>
            <div class="mb-4">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" id="password" name="password" placeholder="Masukkan password" required>
            </div>
            <button type="submit" class="btn btn-masuk w-100">
                MASUK
            </button>
        </form>
    </div>
</body>
</html>
