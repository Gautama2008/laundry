<?php 
include 'header.php'; 
include 'koneksi.php';
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h3 class="fw-normal text-secondary mb-0">Manajemen Outlet</h3>
    <button class="btn text-white fw-medium px-3 py-2" data-bs-toggle="modal" data-bs-target="#modalTambahOutlet" style="background-color: #00bcd4; border-radius: 6px; font-size: 14px;">+ Tambah Outlet Baru</button>
</div>

<div class="card border-0 shadow-sm" style="border-radius: 8px;">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-custom mb-0">
                <thead>
                    <tr>
                        <th width="5%">No</th>
                        <th width="30%">Nama Outlet</th>
                        <th width="30%">Alamat</th>
                        <th width="20%">Telepon Hotline</th>
                        <th width="15%">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $no = 1;
                    $query = mysqli_query($conn, "SELECT * FROM tb_outlet");
                    while($data = mysqli_fetch_array($query)){
                    ?>
                    <tr>
                        <td><?php echo $no++; ?></td>
                        <td><i class="bi bi-shop text-info me-2"></i> <?php echo $data['nama']; ?></td>
                        <td><?php echo $data['alamat']; ?></td>
                        <td><?php echo $data['tlp']; ?></td>
                        <td>
                            <button type="button" class="btn btn-outline-warning btn-aksi text-warning" data-bs-toggle="modal" data-bs-target="#modalEdit<?php echo $data['id']; ?>" style="border-color: #f6c23e;"><i class="bi bi-pencil"></i></button>
                            <a href="outlet_aksi.php?aksi=hapus&id=<?php echo $data['id']; ?>" class="btn btn-outline-danger btn-aksi text-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')" style="border-color: #e74a3b;"><i class="bi bi-trash"></i></a>
                        </td>
                    </tr>

                    <!-- Modal Edit -->
                    <div class="modal fade" id="modalEdit<?php echo $data['id']; ?>" tabindex="-1" aria-labelledby="modalEditLabel" aria-hidden="true">
                      <div class="modal-dialog">
                        <div class="modal-content">
                          <form action="outlet_aksi.php?aksi=edit" method="POST">
                            <div class="modal-header">
                              <h5 class="modal-title" id="modalEditLabel">Edit Outlet</h5>
                              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                              <input type="hidden" name="id" value="<?php echo $data['id']; ?>">
                              <div class="mb-3">
                                <label class="form-label">Nama Outlet</label>
                                <input type="text" class="form-control" name="nama" value="<?php echo $data['nama']; ?>" required>
                              </div>
                              <div class="mb-3">
                                <label class="form-label">Alamat</label>
                                <textarea class="form-control" name="alamat" rows="2" required><?php echo $data['alamat']; ?></textarea>
                              </div>
                              <div class="mb-3">
                                <label class="form-label">Telepon</label>
                                <input type="text" class="form-control" name="tlp" value="<?php echo $data['tlp']; ?>" required>
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

<!-- Modal Tambah Outlet -->
<div class="modal fade" id="modalTambahOutlet" tabindex="-1" aria-labelledby="modalTambahLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <form action="outlet_aksi.php?aksi=tambah" method="POST">
        <div class="modal-header">
          <h5 class="modal-title" id="modalTambahLabel">Tambah Outlet Baru</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="mb-3">
            <label class="form-label">Nama Outlet</label>
            <input type="text" class="form-control" name="nama" required>
          </div>
          <div class="mb-3">
            <label class="form-label">Alamat</label>
            <textarea class="form-control" name="alamat" rows="2" required></textarea>
          </div>
          <div class="mb-3">
            <label class="form-label">Telepon</label>
            <input type="text" class="form-control" name="tlp" required>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-info text-white">Simpan</button>
        </div>
      </form>
    </div>
  </div>
</div>

<?php include 'footer.php'; ?>
