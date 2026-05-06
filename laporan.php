<?php 
include 'header.php'; 
include 'koneksi.php';

// Hitung total data
$q_member = mysqli_query($conn, "SELECT COUNT(*) as total FROM tb_member");
$t_member = mysqli_fetch_assoc($q_member)['total'];

$q_outlet = mysqli_query($conn, "SELECT COUNT(*) as total FROM tb_outlet");
$t_outlet = mysqli_fetch_assoc($q_outlet)['total'];
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h3 class="fw-normal text-secondary mb-0"><i class="bi bi-file-earmark-text text-secondary me-2"></i> Laporan Layanan Laundry</h3>
    <button class="btn btn-outline-secondary fw-medium px-3 py-2" onclick="window.print()" style="border-radius: 6px; font-size: 14px; background: white;"><i class="bi bi-printer me-1"></i> Cetak Laporan</button>
</div>

<div class="row gx-3 mb-4">
    <div class="col-md-6 mb-3 mb-md-0">
        <div class="card border-0 h-100 position-relative overflow-hidden" style="background-color: #00bcd4; color: white; border-radius: 8px;">
            <div class="card-body p-4">
                <p class="mb-1" style="font-size: 13px; font-weight: 500;">Total Member</p>
                <h2 class="fw-bold mb-0"><?php echo $t_member; ?> Pelanggan</h2>
                <i class="bi bi-people position-absolute opacity-25" style="font-size: 4rem; right: 20px; bottom: 5px;"></i>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card border-0 h-100 position-relative overflow-hidden" style="background-color: #1a8f56; color: white; border-radius: 8px;">
            <div class="card-body p-4">
                <p class="mb-1" style="font-size: 13px; font-weight: 500;">Total Cabang Outlet</p>
                <h2 class="fw-bold mb-0"><?php echo $t_outlet; ?> Cabang</h2>
                <i class="bi bi-shop position-absolute opacity-25" style="font-size: 4rem; right: 20px; bottom: 5px;"></i>
            </div>
        </div>
    </div>
</div>

<div class="card border-0 shadow-sm mb-4" style="border-radius: 8px;">
    <div class="card-header bg-white border-bottom-0 pt-4 pb-2 px-4">
        <h6 class="fw-bold mb-0"><i class="bi bi-person text-info me-2"></i> Laporan Data Member</h6>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-custom mb-0">
                <thead>
                    <tr>
                        <th width="5%">No</th>
                        <th width="25%">Nama Member</th>
                        <th width="25%">Alamat</th>
                        <th width="20%">Jenis Kelamin</th>
                        <th width="25%">Telepon</th>
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
                        <td><?php echo $data['nama']; ?></td>
                        <td><?php echo $data['alamat']; ?></td>
                        <td><?php echo $data['jenis_kelamin'] == 'L' ? 'Laki-laki' : 'Perempuan'; ?></td>
                        <td><?php echo $data['tlp']; ?></td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="card border-0 shadow-sm" style="border-radius: 8px;">
    <div class="card-header bg-white border-bottom-0 pt-4 pb-2 px-4">
        <h6 class="fw-bold mb-0"><i class="bi bi-shop text-success me-2"></i> Laporan Data Outlet</h6>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-custom mb-0">
                <thead>
                    <tr>
                        <th width="5%">No</th>
                        <th width="30%">Nama Outlet</th>
                        <th width="35%">Alamat</th>
                        <th width="30%">Telepon Hotline</th>
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
                        <td><?php echo $data['nama']; ?></td>
                        <td><?php echo $data['alamat']; ?></td>
                        <td><?php echo $data['tlp']; ?></td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>
