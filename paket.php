<?php 
include 'header.php'; 
include 'koneksi.php';
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h3 class="fw-normal text-secondary mb-0">Data Paket</h3>
    <button class="btn text-white fw-medium px-3 py-2" data-bs-toggle="modal" data-bs-target="#modalTambahPaket" style="background-color: #0f9d58; border-radius: 6px; font-size: 14px;">+ Tambah Paket Baru</button>
</div>

<div class="card border-0 shadow-sm" style="border-radius: 8px;">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-custom mb-0">
                <thead>
                    <tr>
                        <th width="5%">No</th>
                        <th width="20%">Nama Outlet</th>
                        <th width="15%">Jenis</th>
                        <th width="30%">Nama Paket</th>
                        <th width="15%">Harga</th>
                        <th width="15%">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $no = 1;
                    $query = mysqli_query($conn, "SELECT tb_paket.*, tb_outlet.nama as nama_outlet FROM tb_paket LEFT JOIN tb_outlet ON tb_paket.id_outlet = tb_outlet.id");
                    while($data = mysqli_fetch_array($query)){
                    ?>
                    <tr>
                        <td><?php echo $no++; ?></td>
                        <td><?php echo $data['nama_outlet']; ?></td>
                        <td><span class="badge bg-secondary"><?php echo strtoupper($data['jenis']); ?></span></td>
                        <td><?php echo $data['nama_paket']; ?></td>
                        <td>Rp <?php echo number_format($data['harga'], 0, ',', '.'); ?></td>
                        <td>
                            <button type="button" class="btn btn-outline-warning btn-aksi text-warning" data-bs-toggle="modal" data-bs-target="#modalEdit<?php echo $data['id']; ?>" style="border-color: #f6c23e;"><i class="bi bi-pencil"></i></button>
                            <a href="paket_aksi.php?aksi=hapus&id=<?php echo $data['id']; ?>" class="btn btn-outline-danger btn-aksi text-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')" style="border-color: #e74a3b;"><i class="bi bi-trash"></i></a>
                        </td>
                    </tr>

                    <!-- Modal Edit -->
                    <div class="modal fade" id="modalEdit<?php echo $data['id']; ?>" tabindex="-1" aria-labelledby="modalEditLabel" aria-hidden="true">
                      <div class="modal-dialog">
                        <div class="modal-content">
                          <form action="paket_aksi.php?aksi=edit" method="POST">
                            <div class="modal-header">
                              <h5 class="modal-title" id="modalEditLabel">Edit Paket</h5>
                              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                              <input type="hidden" name="id" value="<?php echo $data['id']; ?>">
                              <div class="mb-3">
                                <label class="form-label">Outlet</label>
                                <select class="form-select" name="id_outlet" required>
                                  <?php 
                                  $outlet = mysqli_query($conn, "SELECT * FROM tb_outlet");
                                  while($o = mysqli_fetch_array($outlet)){
                                  ?>
                                  <option value="<?php echo $o['id']; ?>" <?php if($data['id_outlet'] == $o['id']){echo "selected";} ?>><?php echo $o['nama']; ?></option>
                                  <?php } ?>
                                </select>
                              </div>
                              <div class="mb-3">
                                <label class="form-label">Jenis Paket</label>
                                <select class="form-select" name="jenis" required>
                                  <option value="kiloan" <?php if($data['jenis'] == 'kiloan'){echo "selected";} ?>>Kiloan</option>
                                  <option value="selimut" <?php if($data['jenis'] == 'selimut'){echo "selected";} ?>>Selimut</option>
                                  <option value="bed_cover" <?php if($data['jenis'] == 'bed_cover'){echo "selected";} ?>>Bed Cover</option>
                                  <option value="kaos" <?php if($data['jenis'] == 'kaos'){echo "selected";} ?>>Kaos</option>
                                  <option value="lain" <?php if($data['jenis'] == 'lain'){echo "selected";} ?>>Lainnya</option>
                                </select>
                              </div>
                              <div class="mb-3">
                                <label class="form-label">Nama Paket</label>
                                <input type="text" class="form-control" name="nama_paket" value="<?php echo $data['nama_paket']; ?>" required>
                              </div>
                              <div class="mb-3">
                                <label class="form-label">Harga</label>
                                <input type="number" class="form-control" name="harga" value="<?php echo $data['harga']; ?>" required>
                              </div>
                            </div>
                            <div class="modal-footer">
                              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                              <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
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

<!-- Modal Tambah Paket -->
<div class="modal fade" id="modalTambahPaket" tabindex="-1" aria-labelledby="modalTambahLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <form action="paket_aksi.php?aksi=tambah" method="POST">
        <div class="modal-header">
          <h5 class="modal-title" id="modalTambahLabel">Tambah Paket Baru</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="mb-3">
            <label class="form-label">Outlet</label>
            <select class="form-select" name="id_outlet" required>
              <option value="" disabled selected>Pilih Outlet...</option>
              <?php 
              $outlet = mysqli_query($conn, "SELECT * FROM tb_outlet");
              while($o = mysqli_fetch_array($outlet)){
              ?>
              <option value="<?php echo $o['id']; ?>"><?php echo $o['nama']; ?></option>
              <?php } ?>
            </select>
          </div>
          <div class="mb-3">
            <label class="form-label">Jenis Paket</label>
            <select class="form-select" name="jenis" required>
              <option value="" disabled selected>Pilih Jenis Paket...</option>
              <option value="kiloan">Kiloan</option>
              <option value="selimut">Selimut</option>
              <option value="bed_cover">Bed Cover</option>
              <option value="kaos">Kaos</option>
              <option value="lain">Lainnya</option>
            </select>
          </div>
          <div class="mb-3">
            <label class="form-label">Nama Paket</label>
            <input type="text" class="form-control" name="nama_paket" required>
          </div>
          <div class="mb-3">
            <label class="form-label">Harga</label>
            <input type="number" class="form-control" name="harga" required>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-success">Simpan</button>
        </div>
      </form>
    </div>
  </div>
</div>
