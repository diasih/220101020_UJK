<?php
include 'koneksi.php';

// ================== SIMPAN DATA ==================
if (isset($_POST['simpan'])) {

    $masuk = $_POST['masuk'];
    $keluar = $_POST['keluar'];
    $tarif = $_POST['tarif'];

    $lama = (strtotime($keluar) - strtotime($masuk)) / (60*60*24);
    $total = $lama * $tarif;

    mysqli_query($conn, "INSERT INTO penitipan 
    (id_hewan, tanggal_masuk, tanggal_keluar, lama_hari, tarif_per_hari, total_biaya, status, catatan) 
    VALUES 
    ('$_POST[hewan]', '$masuk', '$keluar', '$lama', '$tarif', '$total', 'dititipkan', '$_POST[catatan]')");

    header("Location: penitipan.php");
    exit;
}

// ================== UPDATE DATA (EDIT) ==================
if (isset($_POST['update'])) {

    $id = $_POST['id'];
    $masuk = $_POST['masuk'];
    $keluar = $_POST['keluar'];
    $tarif = $_POST['tarif'];

    $lama = (strtotime($keluar) - strtotime($masuk)) / (60*60*24);
    $total = $lama * $tarif;

    mysqli_query($conn, "UPDATE penitipan SET
        id_hewan='$_POST[hewan]',
        tanggal_masuk='$masuk',
        tanggal_keluar='$keluar',
        lama_hari='$lama',
        tarif_per_hari='$tarif',
        total_biaya='$total',
        catatan='$_POST[catatan]'
        WHERE id_penitipan='$id'
    ");

    header("Location: penitipan.php");
    exit;
}

// ================== MODE EDIT ==================
$edit = null;
if (isset($_GET['edit'])) {
    $edit = mysqli_fetch_array(mysqli_query($conn, 
        "SELECT * FROM penitipan WHERE id_penitipan='$_GET[id]'"));
}

// ================== UPDATE STATUS ==================
if (isset($_GET['ambil'])) {
    mysqli_query($conn, "UPDATE penitipan SET status='diambil' WHERE id_penitipan='$_GET[id]'");
    header("Location: penitipan.php");
    exit;
}

if (isset($_GET['kembali'])) {
    mysqli_query($conn, "UPDATE penitipan SET status='dititipkan' WHERE id_penitipan='$_GET[id]'");
    header("Location: penitipan.php");
    exit;
}

// ================== HAPUS DATA ==================
if (isset($_GET['hapus'])) {
    mysqli_query($conn, "DELETE FROM penitipan WHERE id_penitipan='$_GET[id]'");
    header("Location: penitipan.php");
    exit;
}

$dataHewan = mysqli_query($conn, "SELECT * FROM hewan");
?>

<!DOCTYPE html>
<html>
<head>
<title>Data Penitipan</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

<style>
body {
    background: linear-gradient(135deg, #667eea, #764ba2);
    font-family: 'Segoe UI', sans-serif;
}
.header-box {
    background: rgba(255,255,255,0.2);
    backdrop-filter: blur(10px);
    border-radius: 15px;
    padding: 15px 20px;
    color: white;
}
.card-custom {
    border-radius: 20px;
    border: none;
    box-shadow: 0 10px 25px rgba(0,0,0,0.15);
}
.table-custom {
    border-radius: 15px;
    overflow: hidden;
}
tr:hover {
    background: #f1f5f9;
}
</style>

</head>
<body>

<div class="container py-4">

    <div class="header-box d-flex justify-content-between align-items-center mb-4">
        <h4 class="mb-0">🏨 Data Penitipan</h4>
        <a href="index.php" class="btn btn-light">
            <i class="bi bi-arrow-left-circle"></i> Dashboard
        </a>
    </div>

    <div class="row g-4">

        <!-- FORM -->
        <div class="col-md-4">
            <div class="card card-custom p-4">
                <h5 class="mb-3">
                    <?= $edit ? 'Edit Penitipan' : 'Tambah Penitipan' ?>
                </h5>

                <form method="POST">

                    <?php if($edit){ ?>
                        <input type="hidden" name="id" value="<?= $edit['id_penitipan'] ?>">
                    <?php } ?>

                    <select name="hewan" class="form-control mb-2" required>
                        <option value="">-- Pilih Hewan --</option>
                        <?php 
                        $dataHewan = mysqli_query($conn, "SELECT * FROM hewan");
                        while($h = mysqli_fetch_array($dataHewan)){ 
                        ?>
                        <option value="<?= $h['id_hewan'] ?>"
                        <?= ($edit && $edit['id_hewan']==$h['id_hewan'])?'selected':'' ?>>
                        <?= $h['nama_hewan'] ?>
                        </option>
                        <?php } ?>
                    </select>

                    <input type="date" name="masuk" class="form-control mb-2"
                    value="<?= $edit['tanggal_masuk'] ?? '' ?>" required>

                    <input type="date" name="keluar" class="form-control mb-2"
                    value="<?= $edit['tanggal_keluar'] ?? '' ?>" required>

                    <input type="number" name="tarif" placeholder="Tarif per Hari"
                    class="form-control mb-2"
                    value="<?= $edit['tarif_per_hari'] ?? '' ?>" required>

                    <textarea name="catatan" class="form-control mb-3"><?= $edit['catatan'] ?? '' ?></textarea>

                    <button name="<?= $edit ? 'update' : 'simpan' ?>" 
                        class="btn btn-primary w-100">
                        <?= $edit ? 'Update Data' : 'Simpan' ?>
                    </button>

                </form>
            </div>
        </div>

        <!-- TABLE -->
        <div class="col-md-8">
            <div class="card card-custom p-4">
                <h5 class="mb-3">Daftar Penitipan</h5>

                <table class="table table-hover table-custom">
                    <thead class="table-dark">
                        <tr>
                            <th>No</th>
                            <th>Hewan</th>
                            <th>Masuk</th>
                            <th>Keluar</th>
                            <th>Lama</th>
                            <th>Total</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                    <?php
                    $no=1;
                    $data = mysqli_query($conn, "SELECT p.*, h.nama_hewan 
                    FROM penitipan p 
                    JOIN hewan h ON p.id_hewan = h.id_hewan");

                    while($d = mysqli_fetch_array($data)){
                    ?>
                    <tr>
                        <td><?= $no++ ?></td>
                        <td><?= $d['nama_hewan'] ?></td>
                        <td><?= $d['tanggal_masuk'] ?></td>
                        <td><?= $d['tanggal_keluar'] ?></td>
                        <td><?= $d['lama_hari'] ?> hari</td>
                        <td>Rp <?= number_format($d['total_biaya'],0,',','.') ?></td>

                        <td>
                            <?php if($d['status'] == 'dititipkan'){ ?>
                                <span class="badge bg-warning text-dark">Dititipkan</span>
                            <?php } else { ?>
                                <span class="badge bg-success">Diambil</span>
                            <?php } ?>
                        </td>

                        <td>
                            <!-- EDIT -->
                            <a href="?edit&id=<?= $d['id_penitipan'] ?>" 
                               class="btn btn-warning btn-sm">
                               <i class="bi bi-pencil"></i>
                            </a>

                            <!-- STATUS -->
                            <?php if($d['status'] == 'dititipkan'){ ?>
                                <a href="?ambil&id=<?= $d['id_penitipan'] ?>" 
                                   class="btn btn-success btn-sm"
                                   onclick="return confirm('Yakin sudah diambil?')">
                                   <i class="bi bi-check"></i>
                                </a>
                            <?php } else { ?>
                                <a href="?kembali&id=<?= $d['id_penitipan'] ?>" 
                                   class="btn btn-warning btn-sm"
                                   onclick="return confirm('Ubah ke dititipkan lagi?')">
                                   <i class="bi bi-arrow-repeat"></i>
                                </a>
                            <?php } ?>

                            <!-- HAPUS -->
                            <a href="?hapus&id=<?= $d['id_penitipan'] ?>" 
                               class="btn btn-danger btn-sm"
                               onclick="return confirm('Yakin ingin menghapus data ini?')">
                               <i class="bi bi-trash"></i>
                            </a>
                        </td>

                    </tr>
                    <?php } ?>
                    </tbody>

                </table>

            </div>
        </div>

    </div>

</div>

</body>
</html>