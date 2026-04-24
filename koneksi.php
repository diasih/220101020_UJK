<?php
$conn = mysqli_connect("localhost", "root", "", "penitipan_hewan");

if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

// update status
if (isset($_GET['ambil'])) {
    mysqli_query($conn, "UPDATE penitipan SET status='diambil' WHERE id_penitipan='$_GET[id]'");
}

if (isset($_GET['kembali'])) {
    mysqli_query($conn, "UPDATE penitipan SET status='dititipkan' WHERE id_penitipan='$_GET[id]'");
}
?>