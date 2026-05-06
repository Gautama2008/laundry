<?php 
include 'header.php'; 
include 'koneksi.php';
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h3 class="fw-normal text-secondary mb-0">Manajemen User</h3>
    <button class="btn btn-primary fw-medium px-3 py-2" style="border-radius: 6px; font-size: 14px;">+ Tambah User Baru</button>
</div>

<div class="card border-0 shadow-sm" style="border-radius: 8px;">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-custom mb-0">
                <thead>
                    <tr>
                        <th width="5%">No</th>
                        <th width="30%">Nama</th>
                        <th width="25%">Username</th>
                        <th width="20%">Role</th>
                        <th width="20%">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $no = 1;
                    $query = mysqli_query($conn, "SELECT * FROM tb_user");
                    while($data = mysqli_fetch_array($query)){
                        // Atur warna badge
                        $badge_class = 'bg-primary';
                        if($data['role'] == 'kasir') $badge_class = 'bg-success';
                        if($data['role'] == 'owner') $badge_class = 'bg-warning text-dark';
                    ?>
                    <tr>
                        <td><?php echo $no++; ?></td>
                        <td><?php echo $data['nama']; ?></td>
                        <td><?php echo $data['username']; ?></td>
                        <td><span class="badge <?php echo $badge_class; ?> px-2 py-1" style="border-radius: 4px; font-weight: 600; font-size: 12px;"><?php echo ucfirst($data['role']); ?></span></td>
                        <td>
                            <button class="btn btn-outline-warning btn-aksi text-warning" style="border-color: #f6c23e;"><i class="bi bi-pencil"></i></button>
                            <button class="btn btn-outline-danger btn-aksi text-danger" style="border-color: #e74a3b;"><i class="bi bi-trash"></i></button>
                        </td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>
