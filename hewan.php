<?php
include "koneksi.php";

// ================== SIMPAN ==================
if (isset($_POST["simpan"])) {
    mysqli_query(
        $conn,
        "INSERT INTO hewan (nama_hewan, jenis_hewan, pemilik, no_hp)
    VALUES ('$_POST[nama]','$_POST[jenis]','$_POST[pemilik]','$_POST[hp]')",
    );
    header("Location: hewan.php");
    exit();
}

// ================== HAPUS ==================
if (isset($_GET["hapus"])) {
    mysqli_query($conn, "DELETE FROM hewan WHERE id_hewan='$_GET[id]'");
    header("Location: hewan.php");
    exit();
}

// ================== AMBIL DATA EDIT ==================
$edit = null;
if (isset($_GET["edit"])) {
    $ambil = mysqli_query(
        $conn,
        "SELECT * FROM hewan WHERE id_hewan='$_GET[id]'",
    );
    $edit = mysqli_fetch_array($ambil);
}

// ================== UPDATE ==================
if (isset($_POST["update"])) {
    mysqli_query(
        $conn,
        "UPDATE hewan SET
    nama_hewan='$_POST[nama]',
    jenis_hewan='$_POST[jenis]',
    pemilik='$_POST[pemilik]',
    no_hp='$_POST[hp]'
    WHERE id_hewan='$_POST[id]'
",
    );
    header("Location: hewan.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Data Hewan</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

<style>
body {
    background: linear-gradient(135deg, #74ebd5, #ACB6E5);
    font-family: 'Segoe UI', sans-serif;
}
.card-custom {
    border-radius: 20px;
    border: none;
    box-shadow: 0 10px 25px rgba(0,0,0,0.1);
}
.table-custom {
    border-radius: 15px;
    overflow: hidden;
}
.btn-modern {
    border-radius: 10px;
}
tr:hover {
    background: #f1f5f9;
}
</style>

</head>
<body>

<div class="container py-5">

    <!-- HEADER -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4>🐾 Data Hewan</h4>
        <a href="index.php" class="btn btn-light">
            <i class="bi bi-arrow-left-circle"></i> Dashboard
        </a>
    </div>

    <div class="row g-4">

        <!-- FORM -->
        <div class="col-md-4">
            <div class="card card-custom p-4">
                <h5 class="mb-3">
                    <?= $edit ? "✏️ Edit Hewan" : "➕ Tambah Hewan" ?>
                </h5>

                <form method="POST">

                    <?php if ($edit) { ?>
                        <input type="hidden" name="id" value="<?= $edit[
                            "id_hewan"
                        ] ?>">
                    <?php } ?>

                    <input type="text" name="nama" class="form-control mb-2"
                        placeholder="Nama Hewan"
                        value="<?= $edit["nama_hewan"] ?? "" ?>" required>

                    <input type="text" name="jenis" class="form-control mb-2"
                        placeholder="Jenis Hewan"
                        value="<?= $edit["jenis_hewan"] ?? "" ?>" required>

                    <input type="text" name="pemilik" class="form-control mb-2"
                        placeholder="Nama Pemilik"
                        value="<?= $edit["pemilik"] ?? "" ?>" required>

                    <input type="text" name="hp" class="form-control mb-3"
                        placeholder="No HP"
                        value="<?= $edit["no_hp"] ?? "" ?>" required>

                    <?php if ($edit) { ?>
                        <button name="update" class="btn btn-warning w-100">
                            <i class="bi bi-pencil"></i> Update
                        </button>
                    <?php } else { ?>
                        <button name="simpan" class="btn btn-success w-100">
                            <i class="bi bi-save"></i> Simpan
                        </button>
                    <?php } ?>

                </form>
            </div>
        </div>

        <!-- TABLE -->
        <div class="col-md-8">
            <div class="card card-custom p-4">
                <h5 class="mb-3">📋 Daftar Hewan</h5>

                <table class="table table-hover table-custom">
                    <thead class="table-dark">
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>Jenis</th>
                            <th>Pemilik</th>
                            <th>Nomor Hp</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                    <?php
                    $no = 1;
                    $data = mysqli_query($conn, "SELECT * FROM hewan");
                    while ($d = mysqli_fetch_array($data)) { ?>
                    <tr>
    <td><?= $no++ ?></td>
    <td><?= $d["nama_hewan"] ?></td>
    <td><?= $d["jenis_hewan"] ?></td>
    <td><?= $d["pemilik"] ?></td>
    <td><?= $d["no_hp"] ?></td>

    <td>
        <!-- EDIT -->
        <a href="?edit&id=<?= $d["id_hewan"] ?>"
           class="btn btn-warning btn-sm">
           <i class="bi bi-pencil"></i>
        </a>

        <!-- HAPUS -->
        <a href="?hapus&id=<?= $d["id_hewan"] ?>"
           class="btn btn-danger btn-sm"
           onclick="return confirm('Yakin hapus data?')">
           <i class="bi bi-trash"></i>
        </a>
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
