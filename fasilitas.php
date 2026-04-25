<?php
include "koneksi.php";
 
// ================== SIMPAN ==================
if (isset($_POST["simpan"])) {
    $nama = $_POST["nama_fasilitas"];
    $deskripsi = $_POST["deskripsi"];
    $harga = $_POST["harga"];
    $icon = $_POST["icon"];
 
    mysqli_query(
        $conn,
        "INSERT INTO fasilitas (nama_fasilitas, deskripsi, harga_per_hari, icon)
        VALUES ('$nama', '$deskripsi', '$harga', '$icon')",
    );
    header("Location: fasilitas.php");
    exit();
}
 
// ================== HAPUS ==================
if (isset($_GET["hapus"])) {
    mysqli_query($conn, "DELETE FROM fasilitas WHERE id_fasilitas='$_GET[id]'");
    header("Location: fasilitas.php");
    exit();
}
 
// ================== AMBIL DATA EDIT ==================
$edit = null;
if (isset($_GET["edit"])) {
    $ambil = mysqli_query(
        $conn,
        "SELECT * FROM fasilitas WHERE id_fasilitas='$_GET[id]'",
    );
    $edit = mysqli_fetch_array($ambil);
}
 
// ================== UPDATE ==================
if (isset($_POST["update"])) {
    $id = $_POST["id"];
    $nama = $_POST["nama_fasilitas"];
    $deskripsi = $_POST["deskripsi"];
    $harga = $_POST["harga"];
    $icon = $_POST["icon"];
 
    mysqli_query(
        $conn,
        "UPDATE fasilitas SET
        nama_fasilitas='$nama',
        deskripsi='$deskripsi',
        harga_per_hari='$harga',
        icon='$icon'
        WHERE id_fasilitas='$id'",
    );
    header("Location: fasilitas.php");
    exit();
}
?>
 
<!DOCTYPE html>
<html>
<head>
<title>Data Fasilitas - PetCare</title>
 
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
 
<style>
body {
    background: linear-gradient(135deg, #A18CD1 0%, #FBC2EB 100%);
    font-family: 'Segoe UI', sans-serif;
    min-height: 100vh;
}
.card-custom {
    border-radius: 20px;
    border: none;
    box-shadow: 0 10px 25px rgba(0,0,0,0.1);
}
.table-custom {
    border-radius: 15px;
    overflow: hidden;
    background: white;
}
tr:hover {
    background: #fdf2f8;
}
.badge-price {
    background-color: #db2777;
    color: white;
    padding: 0.5em 1em;
    border-radius: 10px;
}
</style>
 
</head>
<body>
 
<div class="container py-5">
 
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="text-white">✨ Data Fasilitas & Tier</h4>
        <a href="index.php" class="btn btn-light">
            <i class="bi bi-arrow-left-circle"></i> Dashboard
        </a>
    </div>
 
    <div class="row g-4">
 
        <div class="col-md-4">
            <div class="card card-custom p-4">
                <h5 class="mb-3">
                    <?= $edit ? "✏️ Edit Tier" : "➕ Tambah Tier" ?>
                </h5>
 
                <form method="POST">
                    <?php if ($edit) { ?>
                        <input type="hidden" name="id" value="<?= $edit[
                            "id_fasilitas"
                        ] ?>">
                    <?php } ?>
 
                    <div class="mb-2">
                        <label class="form-label small">Nama Tier</label>
                        <input type="text" name="nama_fasilitas" class="form-control"
                            placeholder="Contoh: Premium"
                            value="<?= $edit["nama_fasilitas"] ?? "" ?>" required>
                    </div>
 
                    <div class="mb-2">
                        <label class="form-label small">Deskripsi Fasilitas</label>
                        <textarea name="deskripsi" class="form-control" rows="3"
                            placeholder="Apa saja yang didapat?" required><?= $edit[
                                "deskripsi"
                            ] ?? "" ?></textarea>
                    </div>
 
                    <div class="mb-2">
                        <label class="form-label small">Harga / Hari (Rp)</label>
                        <input type="number" name="harga" class="form-control"
                            placeholder="Contoh: 100000"
                            value="<?= $edit["harga_per_hari"] ??
                                "" ?>" required>
                    </div>
 
                    <div class="mb-3">
                        <label class="form-label small">Icon (Emoji)</label>
                        <input type="text" name="icon" class="form-control"
                            placeholder="Contoh: 👑"
                            value="<?= $edit["icon"] ?? "" ?>">
                    </div>
 
                    <?php if ($edit) { ?>
                        <button name="update" class="btn btn-warning w-100 py-2">
                            <i class="bi bi-pencil"></i> Update Fasilitas
                        </button>
                    <?php } else { ?>
                        <button name="simpan" class="btn btn-primary w-100 py-2" style="background-color: #8e44ad; border: none;">
                            <i class="bi bi-save"></i> Simpan Tier
                        </button>
                    <?php } ?>
                </form>
            </div>
        </div>
 
        <div class="col-md-8">
            <div class="card card-custom p-4">
                <h5 class="mb-3">📋 Daftar Layanan Tersedia</h5>
 
                <table class="table table-hover table-custom">
                    <thead class="table-dark">
                        <tr>
                            <th>No</th>
                            <th>Tier</th>
                            <th>Deskripsi</th>
                            <th>Harga</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
 
                    <tbody>
                    <?php
                    $no = 1;
                    $data = mysqli_query(
                        $conn,
                        "SELECT * FROM fasilitas ORDER BY harga_per_hari ASC",
                    );
                    while ($d = mysqli_fetch_array($data)) { ?>
                    <tr class="align-middle">
                        <td><?= $no++ ?></td>
                        <td>
                            <span class="fs-4"><?= $d["icon"] ?></span> <br>
                            <strong><?= $d["nama_fasilitas"] ?></strong>
                        </td>
                        <td class="small text-muted" style="max-width: 250px;"><?= $d[
                            "deskripsi"
                        ] ?></td>
                        <td><span class="badge badge-price">Rp <?= number_format(
                            $d["harga_per_hari"],
                            0,
                            ",",
                            ".",
                        ) ?></span></td>
 
                        <td class="text-center">
                            <div class="btn-group">
                                <a href="?edit&id=<?= $d[
                                    "id_fasilitas"
                                ] ?>" class="btn btn-outline-warning btn-sm">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <a href="?hapus&id=<?= $d["id_fasilitas"] ?>"
                                   class="btn btn-outline-danger btn-sm"
                                   onclick="return confirm('Hapus tier ini?')">
                                    <i class="bi bi-trash"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                    <?php }
                    ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
 
</body>
</html>