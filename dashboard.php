<?php 
include 'header.php'; 
include 'koneksi.php';

// Fetch Statistics
// 1. Total Pendapatan Bersih (Hanya yang sudah dibayar)
$q_pendapatan = mysqli_query($conn, "
    SELECT SUM((dt.qty * p.harga) - ((dt.qty * p.harga) * t.diskon / 100) + t.biaya_tambahan + t.pajak) as total
    FROM tb_transaksi t
    JOIN tb_detail_transaksi dt ON t.id = dt.id_transaksi
    JOIN tb_paket p ON dt.id_paket = p.id
    WHERE t.dibayar = 'dibayar'
");
$d_pendapatan = mysqli_fetch_assoc($q_pendapatan);
$total_pendapatan = $d_pendapatan['total'] ?? 0;

// 2. Transaksi Selesai & Diambil
$q_selesai = mysqli_query($conn, "SELECT COUNT(*) as total FROM tb_transaksi WHERE status IN ('selesai', 'diambil')");
$d_selesai = mysqli_fetch_assoc($q_selesai);
$total_selesai = $d_selesai['total'] ?? 0;

// 3. Belum Dibayar
$q_belum_bayar = mysqli_query($conn, "SELECT COUNT(*) as total FROM tb_transaksi WHERE dibayar = 'belum_dibayar'");
$d_belum_bayar = mysqli_fetch_assoc($q_belum_bayar);
$total_belum_bayar = $d_belum_bayar['total'] ?? 0;

// 4. Counts by Status
$q_status = mysqli_query($conn, "SELECT status, COUNT(*) as total FROM tb_transaksi GROUP BY status");
$status_counts = [];
while($row = mysqli_fetch_assoc($q_status)) {
    $status_counts[$row['status']] = $row['total'];
}
?>

<div class="mb-4">
    <h3 class="fw-bold text-dark mb-0 fs-4">Ringkasan Data</h3>
</div>

<!-- Welcome Banner -->
<div class="card border-0 mb-4 shadow-sm" style="background: linear-gradient(90deg, #6366f1 0%, #a855f7 100%); border-radius: 16px;">
    <div class="card-body p-4 p-md-5 text-white">
        <h2 class="fw-bold mb-2">Halo, <?php echo $_SESSION['nama']; ?>! 👋</h2>
        <p class="mb-0 opacity-75" style="font-size: 16px;">Selamat datang kembali di sistem Manajemen Laundry Ibu.</p>
    </div>
</div>

<!-- Summary Cards -->
<div class="row g-4 mb-4">
    <div class="col-md-4">
        <div class="card border-0 shadow-sm h-100" style="border-radius: 12px; border-left: 5px solid #22c55e !important;">
            <div class="card-body p-4">
                <p class="text-muted fw-medium small text-uppercase mb-2">Total Pendapatan Bersih</p>
                <h3 class="fw-bold text-dark mb-0">Rp <?php echo number_format($total_pendapatan, 0, ',', '.'); ?></h3>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card border-0 shadow-sm h-100" style="border-radius: 12px; border-left: 5px solid #3b82f6 !important;">
            <div class="card-body p-4">
                <p class="text-muted fw-medium small text-uppercase mb-2">Transaksi Selesai & Diambil</p>
                <h3 class="fw-bold text-dark mb-0"><?php echo $total_selesai; ?></h3>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card border-0 shadow-sm h-100" style="border-radius: 12px; border-left: 5px solid #f97316 !important;">
            <div class="card-body p-4">
                <p class="text-muted fw-medium small text-uppercase mb-2">Belum Dibayar</p>
                <h3 class="fw-bold text-dark mb-0"><?php echo $total_belum_bayar; ?></h3>
            </div>
        </div>
    </div>
</div>

<!-- Pendapatan Chart Placeholder -->
<div class="card border-0 shadow-sm mb-4" style="border-radius: 12px;">
    <div class="card-body p-4">
        <h5 class="fw-bold text-dark mb-5">Pendapatan 6 Bulan Terakhir</h5>
        <div class="d-flex align-items-center justify-content-center py-5">
            <p class="text-muted fst-italic mb-0">Belum ada data transaksi yang sudah selesai dan dibayar.</p>
        </div>
    </div>
</div>

<!-- Status Breakdowns -->
<div class="card border-0 shadow-sm" style="border-radius: 12px;">
    <div class="card-body p-4">
        <h5 class="fw-bold text-dark mb-4">Transaksi Berdasarkan Status</h5>
        <div class="row g-4">
            <div class="col-md-3">
                <div class="p-3 bg-light text-center" style="border-radius: 12px;">
                    <div class="d-inline-block rounded-circle mb-2" style="width: 10px; height: 10px; background-color: #94a3b8;"></div>
                    <p class="text-muted small mb-1">Baru</p>
                    <h4 class="fw-bold mb-0"><?php echo $status_counts['baru'] ?? 0; ?></h4>
                </div>
            </div>
            <div class="col-md-3">
                <div class="p-3 bg-light text-center" style="border-radius: 12px;">
                    <div class="d-inline-block rounded-circle mb-2" style="width: 10px; height: 10px; background-color: #fb923c;"></div>
                    <p class="text-muted small mb-1">Proses</p>
                    <h4 class="fw-bold mb-0"><?php echo $status_counts['proses'] ?? 0; ?></h4>
                </div>
            </div>
            <div class="col-md-3">
                <div class="p-3 bg-light text-center" style="border-radius: 12px;">
                    <div class="d-inline-block rounded-circle mb-2" style="width: 10px; height: 10px; background-color: #4ade80;"></div>
                    <p class="text-muted small mb-1">Selesai</p>
                    <h4 class="fw-bold mb-0"><?php echo $status_counts['selesai'] ?? 0; ?></h4>
                </div>
            </div>
            <div class="col-md-3">
                <div class="p-3 bg-light text-center" style="border-radius: 12px;">
                    <div class="d-inline-block rounded-circle mb-2" style="width: 10px; height: 10px; background-color: #6366f1;"></div>
                    <p class="text-muted small mb-1">Diambil</p>
                    <h4 class="fw-bold mb-0"><?php echo $status_counts['diambil'] ?? 0; ?></h4>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>
