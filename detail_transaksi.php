<?php 
include 'header.php'; 
include 'koneksi.php';

if(!isset($_GET['id'])){
    header("Location: transaksi.php");
    exit();
}

$id_transaksi = $_GET['id'];

// Get Transaction Detail
$query_trx = mysqli_query($conn, "
    SELECT t.*, m.nama as nama_member, m.alamat as alamat_member, m.tlp as tlp_member,
    o.nama as nama_outlet, u.nama as nama_user
    FROM tb_transaksi t
    LEFT JOIN tb_member m ON t.id_member = m.id
    LEFT JOIN tb_outlet o ON t.id_outlet = o.id
    LEFT JOIN tb_user u ON t.id_user = u.id
    WHERE t.id = '$id_transaksi'
");
$trx = mysqli_fetch_assoc($query_trx);

if(!$trx) {
    echo "Transaksi tidak ditemukan.";
    exit();
}

// Calculate totals
$subtotal = 0;
$query_items = mysqli_query($conn, "
    SELECT dt.*, p.nama_paket, p.jenis, p.harga
    FROM tb_detail_transaksi dt
    LEFT JOIN tb_paket p ON dt.id_paket = p.id
    WHERE dt.id_transaksi = '$id_transaksi'
");
$items = [];
while($row = mysqli_fetch_assoc($query_items)){
    $items[] = $row;
    $subtotal += ($row['qty'] * $row['harga']);
}

$diskon_amount = ($subtotal * $trx['diskon']) / 100;
$total = $subtotal - $diskon_amount + $trx['biaya_tambahan'] + $trx['pajak'];

// Badges
$status_bg = '#eef2ff'; $status_color = '#5c59e8';
if($trx['status'] == 'proses'){ $status_bg = '#fffbeb'; $status_color = '#f59e0b'; }
else if($trx['status'] == 'selesai'){ $status_bg = '#ecfdf5'; $status_color = '#10b981'; }
else if($trx['status'] == 'diambil'){ $status_bg = '#f1f5f9'; $status_color = '#64748b'; }

$pay_bg = '#fef2f2'; $pay_color = '#ef4444';
if($trx['dibayar'] == 'dibayar'){ $pay_bg = '#ecfdf5'; $pay_color = '#10b981'; }

?>

<style>
@media print {
    body { background-color: white !important; }
    #sidebar, .topbar, .btn, .d-flex.justify-content-between.align-items-center.mb-4 { display: none !important; }
    #content-wrapper { margin-left: 0 !important; width: 100% !important; padding: 0 !important; }
    .card { border: none !important; box-shadow: none !important; }
}
</style>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h3 class="fw-bold text-dark mb-0 fs-4 d-none d-md-block">Detail Transaksi - <?php echo $trx['kode_invoice']; ?></h3>
</div>

<div class="card border-0 shadow-sm" style="border-radius: 12px; margin-bottom: 2rem;">
    <div class="card-body p-4 p-md-5">
        
        <!-- Header Invoice -->
        <div class="d-flex justify-content-between align-items-start mb-5">
            <div>
                <h4 class="fw-bold text-dark mb-1">Invoice <?php echo $trx['kode_invoice']; ?></h4>
                <div class="text-muted" style="font-size: 14px;"><?php echo date('d M Y, H:i', strtotime($trx['tgl'])); ?></div>
            </div>
            <div>
                <a href="transaksi.php" class="text-decoration-none text-muted d-flex align-items-center" style="font-weight: 500;">
                    <i class="bi bi-arrow-left me-2"></i> Kembali
                </a>
            </div>
        </div>

        <!-- Info Pelanggan & Transaksi -->
        <div class="row mb-5">
            <div class="col-md-6 mb-4 mb-md-0">
                <h6 class="fw-bold text-muted mb-3" style="font-size: 13px; letter-spacing: 1px;">INFORMASI PELANGGAN</h6>
                <div class="d-flex mb-2">
                    <div style="width: 100px;" class="fw-bold text-dark">Nama:</div>
                    <div class="text-dark"><?php echo $trx['nama_member']; ?></div>
                </div>
                <div class="d-flex mb-2">
                    <div style="width: 100px;" class="fw-bold text-dark">Alamat:</div>
                    <div class="text-dark"><?php echo $trx['alamat_member']; ?></div>
                </div>
                <div class="d-flex mb-2">
                    <div style="width: 100px;" class="fw-bold text-dark">Telepon:</div>
                    <div class="text-dark"><?php echo $trx['tlp_member']; ?></div>
                </div>
            </div>
            <div class="col-md-6">
                <h6 class="fw-bold text-muted mb-3" style="font-size: 13px; letter-spacing: 1px;">INFORMASI TRANSAKSI</h6>
                <div class="d-flex mb-2">
                    <div style="width: 120px;" class="fw-bold text-dark">Outlet:</div>
                    <div class="text-dark"><?php echo $trx['nama_outlet']; ?></div>
                </div>
                <div class="d-flex mb-2">
                    <div style="width: 120px;" class="fw-bold text-dark">Batas Waktu:</div>
                    <div class="text-dark"><?php echo date('d M Y, H:i', strtotime($trx['batas_waktu'])); ?></div>
                </div>
                <div class="d-flex mb-2">
                    <div style="width: 120px;" class="fw-bold text-dark">Kasir:</div>
                    <div class="text-dark"><?php echo $trx['nama_user']; ?></div>
                </div>
            </div>
        </div>

        <!-- Detail Item Table -->
        <h6 class="fw-bold text-muted mb-3" style="font-size: 13px; letter-spacing: 1px;">DETAIL ITEM</h6>
        <div class="table-responsive mb-4">
            <table class="table mb-0" style="font-size: 14px;">
                <thead>
                    <tr class="text-muted" style="font-size: 12px; border-bottom: 2px solid #f1f5f9;">
                        <th class="fw-bold border-0 pb-3 ps-0">PAKET</th>
                        <th class="fw-bold border-0 pb-3">JENIS</th>
                        <th class="fw-bold border-0 pb-3 text-center">QTY</th>
                        <th class="fw-bold border-0 pb-3 text-end">HARGA</th>
                        <th class="fw-bold border-0 pb-3 text-end">SUBTOTAL</th>
                        <th class="fw-bold border-0 pb-3 text-end pe-0">KETERANGAN</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($items as $item): ?>
                    <tr style="border-bottom: 1px solid #f1f5f9;">
                        <td class="align-middle py-3 border-0 ps-0 text-dark fw-medium"><?php echo $item['nama_paket']; ?></td>
                        <td class="align-middle py-3 border-0 text-muted"><?php echo ucfirst($item['jenis']); ?></td>
                        <td class="align-middle py-3 border-0 text-center text-dark"><?php echo $item['qty']; ?></td>
                        <td class="align-middle py-3 border-0 text-end fw-medium text-dark">Rp <?php echo number_format($item['harga'], 0, ',', '.'); ?></td>
                        <td class="align-middle py-3 border-0 text-end fw-bold text-dark">Rp <?php echo number_format($item['qty'] * $item['harga'], 0, ',', '.'); ?></td>
                        <td class="align-middle py-3 border-0 text-end text-muted pe-0"><?php echo empty($item['keterangan']) ? '-' : $item['keterangan']; ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <!-- Footer Calculations & Buttons -->
        <div class="row justify-content-end">
            <div class="col-md-5">
                <div class="d-flex justify-content-between mb-2">
                    <span class="text-muted">Subtotal</span>
                    <span class="text-dark fw-medium">Rp <?php echo number_format($subtotal, 0, ',', '.'); ?></span>
                </div>
                <div class="d-flex justify-content-between mb-2">
                    <span style="color: #ef4444;">Diskon (<?php echo $trx['diskon']; ?>%)</span>
                    <span style="color: #ef4444; fw-medium">- Rp <?php echo number_format($diskon_amount, 0, ',', '.'); ?></span>
                </div>
                <div class="d-flex justify-content-between mb-2">
                    <span class="text-muted">Biaya Tambahan</span>
                    <span class="text-dark fw-medium">Rp <?php echo number_format($trx['biaya_tambahan'], 0, ',', '.'); ?></span>
                </div>
                <div class="d-flex justify-content-between mb-4">
                    <span class="text-muted">Pajak</span>
                    <span class="text-dark fw-medium">Rp <?php echo number_format($trx['pajak'], 0, ',', '.'); ?></span>
                </div>
                
                <div class="d-flex justify-content-between align-items-center mb-4 pt-3" style="border-top: 1px solid #e2e8f0;">
                    <span class="fw-bold text-dark fs-5">Total</span>
                    <span class="fw-bold text-dark fs-5">Rp <?php echo number_format($total, 0, ',', '.'); ?></span>
                </div>

                <div class="d-flex justify-content-between align-items-center mb-2">
                    <span class="text-muted">Status:</span>
                    <span class="badge" style="background-color: <?php echo $status_bg; ?>; color: <?php echo $status_color; ?>; padding: 6px 12px; border-radius: 6px; font-weight: 600;">
                        <?php echo ucfirst($trx['status']); ?>
                    </span>
                </div>
                <div class="d-flex justify-content-between align-items-center mb-5">
                    <span class="text-muted">Pembayaran:</span>
                    <span class="badge" style="background-color: <?php echo $pay_bg; ?>; color: <?php echo $pay_color; ?>; padding: 6px 12px; border-radius: 6px; font-weight: 600;">
                        <?php echo $trx['dibayar'] == 'dibayar' ? 'Sudah Dibayar' : 'Belum Dibayar'; ?>
                    </span>
                </div>

                <div class="d-flex justify-content-between mt-4">
                    <button class="btn text-white fw-medium px-4 py-2" data-bs-toggle="modal" data-bs-target="#modalEditStatus" style="background-color: #f59e0b; border-radius: 8px;">Edit Status</button>
                    <button class="btn text-white fw-medium px-4 py-2" onclick="window.print()" style="background-color: #475569; border-radius: 8px;">Cetak Invoice</button>
                </div>
            </div>
        </div>
        
    </div>
</div>

<!-- Modal Edit Status (minimal) -->
<div class="modal fade" id="modalEditStatus" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
    <div class="modal-content">
        <form action="transaksi_aksi.php?aksi=edit_status" method="POST">
        <div class="modal-header">
            <h5 class="modal-title">Edit Status Transaksi</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body text-start">
            <input type="hidden" name="id" value="<?php echo $trx['id']; ?>">
            <div class="mb-3">
            <label class="form-label">Status Pesanan</label>
            <select class="form-select" name="status" required>
                <option value="baru" <?php if($trx['status'] == 'baru') echo 'selected'; ?>>Baru</option>
                <option value="proses" <?php if($trx['status'] == 'proses') echo 'selected'; ?>>Proses</option>
                <option value="selesai" <?php if($trx['status'] == 'selesai') echo 'selected'; ?>>Selesai</option>
                <option value="diambil" <?php if($trx['status'] == 'diambil') echo 'selected'; ?>>Diambil</option>
            </select>
            </div>
            <div class="mb-3">
            <label class="form-label">Status Pembayaran</label>
            <select class="form-select" name="dibayar" required>
                <option value="belum_dibayar" <?php if($trx['dibayar'] == 'belum_dibayar') echo 'selected'; ?>>Belum Dibayar</option>
                <option value="dibayar" <?php if($trx['dibayar'] == 'dibayar') echo 'selected'; ?>>Sudah Dibayar</option>
            </select>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
            <button type="submit" class="btn text-white" style="background-color: #5c59e8;">Simpan</button>
        </div>
        </form>
    </div>
    </div>
</div>

<?php include 'footer.php'; ?>
