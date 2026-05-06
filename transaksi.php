<?php 
include 'header.php'; 
include 'koneksi.php';
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h3 class="fw-bold text-dark mb-0 fs-4">Daftar Transaksi</h3>
</div>

<div class="card border-0 shadow-sm" style="border-radius: 12px;">
    <div class="card-body p-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h5 class="fw-bold text-dark mb-0">Data Transaksi</h5>
            <div>
                <button class="btn text-white fw-medium px-3 py-2 me-2" style="background-color: #5b657a; border-radius: 6px; font-size: 14px;">Tempat Sampah</button>
                <a href="transaksi_tambah.php" class="btn text-white fw-medium px-3 py-2" style="background-color: #5c59e8; border-radius: 6px; font-size: 14px; text-decoration: none;">+ Transaksi Baru</a>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table mb-0" style="font-size: 14px;">
                <thead>
                    <tr class="text-muted" style="font-size: 12px; border-bottom: 2px solid #f1f5f9;">
                        <th class="fw-bold border-0 pb-3">INVOICE</th>
                        <th class="fw-bold border-0 pb-3">MEMBER</th>
                        <th class="fw-bold border-0 pb-3">TANGGAL</th>
                        <th class="fw-bold border-0 pb-3 text-center">STATUS</th>
                        <th class="fw-bold border-0 pb-3 text-center">PEMBAYARAN</th>
                        <th class="fw-bold border-0 pb-3 text-end">TOTAL</th>
                        <th class="fw-bold border-0 pb-3 text-end">AKSI</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    // Query to get transactions with their total from details
                    $query = mysqli_query($conn, "
                        SELECT t.*, m.nama as nama_member, 
                        IFNULL(SUM(dt.qty * p.harga), 0) as subtotal
                        FROM tb_transaksi t 
                        LEFT JOIN tb_member m ON t.id_member = m.id 
                        LEFT JOIN tb_detail_transaksi dt ON t.id = dt.id_transaksi
                        LEFT JOIN tb_paket p ON dt.id_paket = p.id
                        GROUP BY t.id
                        ORDER BY t.id DESC
                    ");

                    while($data = mysqli_fetch_array($query)){
                        // Calculate total
                        $subtotal = $data['subtotal'];
                        $diskon_amount = ($subtotal * $data['diskon']) / 100;
                        $total = $subtotal - $diskon_amount + $data['biaya_tambahan'] + $data['pajak'];

                        // Status Badge Color
                        $status_bg = '#eef2ff'; $status_color = '#5c59e8';
                        if($data['status'] == 'proses'){ $status_bg = '#fffbeb'; $status_color = '#f59e0b'; }
                        else if($data['status'] == 'selesai'){ $status_bg = '#ecfdf5'; $status_color = '#10b981'; }
                        else if($data['status'] == 'diambil'){ $status_bg = '#f1f5f9'; $status_color = '#64748b'; }

                        // Payment Badge Color
                        $pay_bg = '#fef2f2'; $pay_color = '#ef4444';
                        if($data['dibayar'] == 'dibayar'){ $pay_bg = '#ecfdf5'; $pay_color = '#10b981'; }
                    ?>
                    <tr style="border-bottom: 1px solid #f1f5f9;">
                        <td class="align-middle py-3 border-0">
                            <span style="color: #5c59e8; font-weight: 600;"><?php echo $data['kode_invoice']; ?></span>
                        </td>
                        <td class="align-middle py-3 border-0 text-dark fw-medium"><?php echo $data['nama_member']; ?></td>
                        <td class="align-middle py-3 border-0 text-muted">
                            <div class="text-dark mb-1"><?php echo date('d M Y', strtotime($data['tgl'])); ?>, <?php echo date('H:i', strtotime($data['tgl'])); ?></div>
                        </td>
                        <td class="align-middle py-3 border-0 text-center">
                            <span class="badge" style="background-color: <?php echo $status_bg; ?>; color: <?php echo $status_color; ?>; padding: 6px 12px; border-radius: 6px; font-weight: 600;">
                                <?php echo ucfirst($data['status']); ?>
                            </span>
                        </td>
                        <td class="align-middle py-3 border-0 text-center">
                            <span class="badge" style="background-color: <?php echo $pay_bg; ?>; color: <?php echo $pay_color; ?>; padding: 6px 12px; border-radius: 6px; font-weight: 600;">
                                <?php echo $data['dibayar'] == 'dibayar' ? 'Dibayar' : 'Belum<br>Dibayar'; ?>
                            </span>
                        </td>
                        <td class="align-middle py-3 border-0 text-end">
                            <div class="fw-bold text-dark fs-6">Rp <?php echo number_format($total, 0, ',', '.'); ?></div>
                        </td>
                        <td class="align-middle py-3 border-0 text-end">
                            <a href="detail_transaksi.php?id=<?php echo $data['id']; ?>" class="text-decoration-none me-2" style="color: #5c59e8; font-weight: 500;">Detail</a>
                            <a href="#" data-bs-toggle="modal" data-bs-target="#modalEditStatus<?php echo $data['id']; ?>" class="text-decoration-none me-2" style="color: #f59e0b; font-weight: 500;">Edit</a>
                            <a href="transaksi_aksi.php?aksi=hapus&id=<?php echo $data['id']; ?>" class="text-decoration-none" style="color: #ef4444; font-weight: 500;" onclick="return confirm('Yakin hapus transaksi ini?')">Hapus</a>
                        </td>
                    </tr>

                    <!-- Modal Edit Status (minimal) -->
                    <div class="modal fade" id="modalEditStatus<?php echo $data['id']; ?>" tabindex="-1" aria-hidden="true">
                      <div class="modal-dialog">
                        <div class="modal-content">
                          <form action="transaksi_aksi.php?aksi=edit_status" method="POST">
                            <div class="modal-header">
                              <h5 class="modal-title">Edit Status Transaksi</h5>
                              <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body text-start">
                              <input type="hidden" name="id" value="<?php echo $data['id']; ?>">
                              <div class="mb-3">
                                <label class="form-label">Status Pesanan</label>
                                <select class="form-select" name="status" required>
                                  <option value="baru" <?php if($data['status'] == 'baru') echo 'selected'; ?>>Baru</option>
                                  <option value="proses" <?php if($data['status'] == 'proses') echo 'selected'; ?>>Proses</option>
                                  <option value="selesai" <?php if($data['status'] == 'selesai') echo 'selected'; ?>>Selesai</option>
                                  <option value="diambil" <?php if($data['status'] == 'diambil') echo 'selected'; ?>>Diambil</option>
                                </select>
                              </div>
                              <div class="mb-3">
                                <label class="form-label">Status Pembayaran</label>
                                <select class="form-select" name="dibayar" required>
                                  <option value="belum_dibayar" <?php if($data['dibayar'] == 'belum_dibayar') echo 'selected'; ?>>Belum Dibayar</option>
                                  <option value="dibayar" <?php if($data['dibayar'] == 'dibayar') echo 'selected'; ?>>Sudah Dibayar</option>
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

                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>



<?php include 'footer.php'; ?>
