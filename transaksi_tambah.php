<?php 
include 'header.php'; 
include 'koneksi.php';
?>

<div class="mb-4">
    <h3 class="fw-bold text-dark mb-0 fs-4">Transaksi Baru</h3>
</div>

<form action="transaksi_aksi.php?aksi=tambah" method="POST">
    <div class="card border-0 shadow-sm" style="border-radius: 12px;">
        <div class="card-body p-4 p-md-5">
            <div class="row g-4">
                <!-- Outlet & Member -->
                <div class="col-md-6">
                    <label class="form-label fw-bold text-dark small mb-2 text-uppercase">Outlet</label>
                    <select class="form-select border-0 bg-light p-3" name="id_outlet" required style="border-radius: 8px;">
                        <?php
                        $outlet = mysqli_query($conn, "SELECT * FROM tb_outlet");
                        while($o = mysqli_fetch_array($outlet)){
                            $selected = ($o['id'] == $_SESSION['id_outlet']) ? 'selected' : '';
                            echo "<option value='".$o['id']."' $selected>".$o['nama']."</option>";
                        }
                        ?>
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-bold text-dark small mb-2 text-uppercase">Member</label>
                    <select class="form-select border-0 bg-light p-3" name="id_member" required style="border-radius: 8px;">
                        <option value="">-- Pilih Member --</option>
                        <?php
                        $member = mysqli_query($conn, "SELECT * FROM tb_member");
                        while($m = mysqli_fetch_array($member)){
                            echo "<option value='".$m['id']."'>".$m['nama']."</option>";
                        }
                        ?>
                    </select>
                </div>

                <!-- Tanggal & Batas Waktu -->
                <div class="col-md-6">
                    <label class="form-label fw-bold text-dark small mb-2 text-uppercase">Tanggal</label>
                    <input type="datetime-local" class="form-control border-0 bg-light p-3" name="tgl" 
                           value="<?php echo date('Y-m-d\TH:i'); ?>" required style="border-radius: 8px;">
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-bold text-dark small mb-2 text-uppercase">Batas Waktu</label>
                    <input type="datetime-local" class="form-control border-0 bg-light p-3" name="batas_waktu" 
                           value="<?php echo date('Y-m-d\TH:i', strtotime('+2 days')); ?>" required style="border-radius: 8px;">
                </div>

                <!-- Item Paket -->
                <div class="col-12 mt-5">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <label class="form-label fw-bold text-dark small mb-0 text-uppercase">Item Paket</label>
                        <button type="button" class="btn btn-link text-decoration-none fw-bold p-0" id="btnTambahItem" style="color: #5c59e8; font-size: 14px;">+ Tambah Item</button>
                    </div>
                    
                    <div id="paket-container">
                        <div class="row g-3 mb-3 paket-row">
                            <div class="col-md-5">
                                <select class="form-select border-0 bg-light p-3" name="id_paket[]" required style="border-radius: 8px;">
                                    <option value="">-- Pilih Paket --</option>
                                    <?php
                                    $paket = mysqli_query($conn, "SELECT * FROM tb_paket");
                                    while($p = mysqli_fetch_array($paket)){
                                        echo "<option value='".$p['id']."'>".$p['nama_paket']."</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <input type="number" class="form-control border-0 bg-light p-3" name="qty[]" placeholder="Qty" required style="border-radius: 8px;">
                            </div>
                            <div class="col-md-5 d-flex gap-2">
                                <input type="text" class="form-control border-0 bg-light p-3" name="keterangan[]" placeholder="Keterangan" style="border-radius: 8px;">
                                <button type="button" class="btn btn-light text-danger border-0 p-3 btnHapusItem d-none" style="border-radius: 8px;"><i class="bi bi-trash"></i></button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Biaya, Diskon, Pajak -->
                <div class="col-md-4">
                    <label class="form-label fw-bold text-dark small mb-2 text-uppercase">Biaya Tambahan</label>
                    <input type="number" class="form-control border-0 bg-light p-3" name="biaya_tambahan" value="0" style="border-radius: 8px;">
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-bold text-dark small mb-2 text-uppercase">Diskon (%)</label>
                    <input type="number" class="form-control border-0 bg-light p-3" name="diskon" value="0" style="border-radius: 8px;">
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-bold text-dark small mb-2 text-uppercase">Pajak</label>
                    <input type="number" class="form-control border-0 bg-light p-3" name="pajak" value="0" style="border-radius: 8px;">
                </div>

                <!-- Status & Pembayaran -->
                <div class="col-md-6">
                    <label class="form-label fw-bold text-dark small mb-2 text-uppercase">Status</label>
                    <select class="form-select border-0 bg-light p-3" name="status" required style="border-radius: 8px;">
                        <option value="baru">Baru</option>
                        <option value="proses">Proses</option>
                        <option value="selesai">Selesai</option>
                        <option value="diambil">Diambil</option>
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-bold text-dark small mb-2 text-uppercase">Pembayaran</label>
                    <select class="form-select border-0 bg-light p-3" name="dibayar" required style="border-radius: 8px;">
                        <option value="belum_dibayar">Belum Dibayar</option>
                        <option value="dibayar">Sudah Dibayar</option>
                    </select>
                </div>

                <div class="col-12 mt-5 d-flex justify-content-between align-items-center">
                    <button type="submit" class="btn text-white fw-bold px-4 py-3" style="background-color: #5c59e8; border-radius: 8px; font-size: 16px;">Simpan Transaksi</button>
                    <a href="transaksi.php" class="text-muted text-decoration-none fw-medium">Batal</a>
                </div>
            </div>
        </div>
    </div>
</form>

<script>
document.getElementById('btnTambahItem').addEventListener('click', function() {
    const container = document.getElementById('paket-container');
    const firstRow = container.querySelector('.paket-row');
    const newRow = firstRow.cloneNode(true);
    
    // Clear inputs
    newRow.querySelectorAll('input').forEach(input => input.value = '');
    newRow.querySelectorAll('select').forEach(select => select.selectedIndex = 0);
    
    // Show delete button
    const btnHapus = newRow.querySelector('.btnHapusItem');
    btnHapus.classList.remove('d-none');
    
    container.appendChild(newRow);
});

document.getElementById('paket-container').addEventListener('click', function(e) {
    if (e.target.closest('.btnHapusItem')) {
        e.target.closest('.paket-row').remove();
    }
});
</script>

<?php include 'footer.php'; ?>
