<?php
if(session_status() == PHP_SESSION_NONE){
    session_start();
}
if(!isset($_SESSION['role'])){
    header("Location: index.php?pesan=belum_login");
    exit();
}
$current_page = basename($_SERVER['PHP_SELF']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laundry Tama Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f8f9fa;
            overflow-x: hidden;
            color: #333;
        }

        #wrapper {
            display: flex;
            min-height: 100vh;
        }

        #sidebar {
            width: 260px;
            background-color: #1a202c; /* Deeper Charcoal */
            color: white;
            transition: all 0.3s;
            z-index: 1000;
        }

        .sidebar-header {
            padding: 1.5rem 1rem 1rem;
            text-align: center;
        }

        .sidebar-header h3 {
            font-weight: 700;
            margin-bottom: 0;
            font-size: 24px;
        }
        
        .sidebar-header h3 span {
            color: #3b82f6; /* Biru muda */
        }
        
        .sidebar-subtitle {
            font-size: 11px;
            color: #6c757d;
            margin-top: 5px;
        }

        .nav-link {
            color: #a0aec0;
            padding: 0.85rem 1.5rem;
            display: flex;
            align-items: center;
            font-weight: 500;
            font-size: 14px;
            border-left: 4px solid transparent;
            transition: all 0.2s;
        }

        .nav-link:hover {
            color: white;
            background-color: rgba(255,255,255,0.05);
        }

        .nav-link.active {
            color: white;
            background-color: #2d3748;
            border-left: 4px solid #6366f1; /* Indigo */
        }

        .nav-link i {
            margin-right: 0.75rem;
            font-size: 1.1rem;
        }
        
        .nav-link.text-danger {
            color: #f87171 !important;
        }

        #content-wrapper {
            flex: 1;
            display: flex;
            flex-direction: column;
            overflow-x: hidden;
        }

        .topbar {
            height: 60px;
            background-color: white;
            display: flex;
            align-items: center;
            padding: 0 1.5rem;
            border-bottom: 1px solid #e2e8f0;
        }

        /* Tabel minimalis */
        .table-custom th {
            border-top: none;
            border-bottom: 1px solid #e2e8f0;
            background-color: white;
            color: #1a202c;
            font-weight: 600;
            font-size: 14px;
            padding: 12px 15px;
        }
        .table-custom td {
            border-bottom: 1px solid #e2e8f0;
            vertical-align: middle;
            font-size: 14px;
            padding: 12px 15px;
        }
        
        /* Tombol aksi outline tipis */
        .btn-aksi {
            border-radius: 4px;
            padding: 4px 8px;
            font-size: 14px;
            background: white;
        }

        @media (max-width: 768px) {
            #sidebar {
                margin-left: -260px;
                position: fixed;
                height: 100%;
            }
            #sidebar.active {
                margin-left: 0;
            }
            #content-wrapper {
                width: 100%;
            }
        }
    </style>
</head>
<body>
    <div id="wrapper">
        <!-- Sidebar -->
        <div id="sidebar">
            <div class="sidebar-header">
                <h3>Laundry <span>Tama</span></h3>
                <div class="sidebar-subtitle">Manajemen Sistem</div>
            </div>
            <ul class="nav flex-column mt-3">
                <li class="nav-item">
                    <a class="nav-link <?php echo $current_page == 'dashboard.php' ? 'active' : ''; ?>" href="dashboard.php">
                        <i class="bi bi-grid-1x2-fill"></i> Dashboard
                    </a>
                </li>
                
                <?php if($_SESSION['role'] != 'owner'): ?>
                <li class="sidebar-section-title px-4 mt-3 mb-2 text-uppercase fw-bold" style="font-size: 10px; color: #718096; letter-spacing: 1px;">Operasional</li>
                
                <li class="nav-item">
                    <a class="nav-link <?php echo ($current_page == 'transaksi.php' || $current_page == 'transaksi_tambah.php') ? 'active' : ''; ?>" href="transaksi.php">
                        <i class="bi bi-file-earmark-text"></i> Transaksi
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link <?php echo $current_page == 'paket.php' ? 'active' : ''; ?>" href="paket.php">
                        <i class="bi bi-box-seam"></i> Paket
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php echo $current_page == 'member.php' ? 'active' : ''; ?>" href="member.php">
                        <i class="bi bi-people"></i> Pelanggan
                    </a>
                </li>

                <li class="sidebar-section-title px-4 mt-3 mb-2 text-uppercase fw-bold" style="font-size: 10px; color: #718096; letter-spacing: 1px;">Manajemen</li>

                <li class="nav-item">
                    <a class="nav-link <?php echo $current_page == 'outlet.php' ? 'active' : ''; ?>" href="outlet.php">
                        <i class="bi bi-shop"></i> Outlet
                    </a>
                </li>

                <?php if($_SESSION['role'] == 'admin'): ?>
                <li class="nav-item">
                    <a class="nav-link <?php echo $current_page == 'user.php' ? 'active' : ''; ?>" href="user.php">
                        <i class="bi bi-person-gear"></i> Pengguna
                    </a>
                </li>
                <?php endif; ?>
                <?php endif; ?>

                <?php if($_SESSION['role'] == 'owner'): ?>
                <!-- Owner specific items if any, currently matching screenshot (empty) -->
                <?php endif; ?>
                
                <li class="nav-item mt-auto">
                    <a class="nav-link text-danger" href="logout.php">
                        <i class="bi bi-box-arrow-right"></i> Logout
                    </a>
                </li>
            </ul>
        </div>

        <!-- Content -->
        <div id="content-wrapper">
            <nav class="navbar navbar-expand bg-white topbar shadow-sm px-4">
                <div class="container-fluid px-0">
                    <button class="btn btn-light d-md-none me-3 border-0" id="sidebarToggle">
                        <i class="bi bi-list fs-5"></i>
                    </button>
                    
                    <div class="ms-auto d-flex align-items-center">
                        <div class="text-end me-3 d-none d-sm-block">
                            <div class="fw-bold text-dark mb-0" style="font-size: 14px;"><?php echo $_SESSION['nama']; ?></div>
                            <div class="text-primary fw-medium" style="font-size: 11px;"><?php echo ucfirst($_SESSION['role']); ?></div>
                        </div>
                        <div class="rounded-circle d-flex align-items-center justify-content-center text-white fw-bold" 
                             style="width: 40px; height: 40px; background-color: #6366f1; font-size: 18px;">
                            <?php echo strtoupper(substr($_SESSION['nama'], 0, 1)); ?>
                        </div>
                    </div>
                </div>
            </nav>

            <div class="container-fluid px-4 pt-4 pb-4">
