<?php 
include 'header.php'; 
include 'koneksi.php';
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h3 class="fw-normal text-secondary mb-0">Manajemen Member</h3>
    <button class="btn text-white fw-medium px-3 py-2" data-bs-toggle="modal" data-bs-target="#modalTambahMember" style="background-color: #0f9d58; border-radius: 6px; font-size: 14px;">+ Tambah Member Baru</button>
</div>

<div class="card border-0 shadow-sm" style="border-radius: 8px;">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-custom mb-0">
                <thead>
                    <tr>
                        <th width="5%">No</th>
                        <th width="25%">Nama Member</th>
                        <th width="25%">Alamat</th>
                        <th width="10%">L/P</th>
                        <th width="20%">Telepon</th>
                        <th width="15%">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $no = 1;
                    $query = mysqli_query($conn, "SELECT * FROM tb_member");
                    while($data = mysqli_fetch_array($query)){
                    ?>
                    <tr>
                        <td><?php echo $no++; ?></td>
                        <td><i class="bi bi-person text-secondary me-2"></i> <?php echo $data['nama']; ?></td>
                        <td><?php echo $data['alamat']; ?></td>
                        <td>
                            <span class="badge bg-info d-inline-flex align-items-center justify-content-center" style="width: 24px; height: 24px; border-radius: 6px; font-size: 12px; font-weight: 600;">
                                <?php echo $data['jenis_kelamin']; ?>
                            </span>
                        </td>
                        <td><?php echo $data['tlp']; ?></td>
                        <td>
                            <button type="button" class="btn btn-outline-warning btn-aksi text-warning" data-bs-toggle="modal" data-bs-target="#modalEdit<?php echo $data['id']; ?>" style="border-color: #f6c23e;"><i class="bi bi-pencil"></i></button>
                            <a href="member_aksi.php?aksi=hapus&id=<?php echo $data['id']; ?>" class="btn btn-outline-danger btn-aksi text-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')" style="border-color: #e74a3b;"><i class="bi bi-trash"></i></a>
                        </td>
                    </tr>

                    <!-- Modal Edit -->
                    <div class="modal fade" id="modalEdit<?php echo $data['id']; ?>" tabindex="-1" aria-labelledby="modalEditLabel" aria-hidden="true">
                      <div class="modal-dialog">
                        <div class="modal-content">
                          <form action="member_aksi.php?aksi=edit" method="POST">
                            <div class="modal-header">
                              <h5 class="modal-title" id="modalEditLabel">Edit Member</h5>
                              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                              <input type="hidden" name="id" value="<?php echo $data['id']; ?>">
                              <div class="mb-3">
                                <label class="form-label">Nama Member</label>
                                <input type="text" class="form-control" name="nama" value="<?php echo $data['nama']; ?>" required>
                              </div>
                              <div class="mb-3">
                                <label class="form-label">Alamat</label>
                                <textarea class="form-control" name="alamat" rows="2" required><?php echo $data['alamat']; ?></textarea>
                              </div>
                              <div class="mb-3">
                                <label class="form-label">Jenis Kelamin</label>
                                <select class="form-select" name="jenis_kelamin" required>
                                    <option value="L" <?php if($data['jenis_kelamin'] == 'L') echo 'selected'; ?>>Laki-laki (L)</option>
                                    <option value="P" <?php if($data['jenis_kelamin'] == 'P') echo 'selected'; ?>>Perempuan (P)</option>
                                </select>
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

<!-- Modal Tambah Member -->
<div class="modal fade" id="modalTambahMember" tabindex="-1" aria-labelledby="modalTambahLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <form action="member_aksi.php?aksi=tambah" method="POST">
        <div class="modal-header">
          <h5 class="modal-title" id="modalTambahLabel">Tambah Member Baru</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="mb-3">
            <label class="form-label">Nama Member</label>
            <input type="text" class="form-control" name="nama" required>
          </div>
          <div class="mb-3">
            <label class="form-label">Alamat</label>
            <textarea class="form-control" name="alamat" rows="2" required></textarea>
          </div>
          <div class="mb-3">
            <label class="form-label">Jenis Kelamin</label>
            <select class="form-select" name="jenis_kelamin" required>
                <option value="L">Laki-laki (L)</option>
                <option value="P">Perempuan (P)</option>
            </select>
          </div>
          <div class="mb-3">
            <label class="form-label">Telepon</label>
            <input type="text" class="form-control" name="tlp" required>
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

<?php include 'footer.php'; ?>
