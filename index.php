<?php 
session_start(); 
if (!isset($_SESSION['login'])) { 
    header("Location: login.php"); 
} 
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Dashboard Pet Care</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

<style>
body {
    margin: 0;
    font-family: 'Poppins', sans-serif;
    background: #f1f5f9;
}

/* Sidebar */
.sidebar {
    width: 250px;
    height: 100vh;
    position: fixed;
    background: linear-gradient(180deg, #4f46e5, #9333ea);
    color: white;
    padding: 20px;
}

.sidebar h4 {
    font-weight: bold;
}

.sidebar a {
    display: block;
    color: white;
    text-decoration: none;
    margin: 15px 0;
    padding: 10px;
    border-radius: 10px;
}

.sidebar a:hover {
    background: rgba(255,255,255,0.2);
}

/* Content */
.content {
    margin-left: 250px;
    padding: 20px;
}

/* Topbar */
.topbar {
    background: white;
    padding: 15px 20px;
    border-radius: 15px;
    box-shadow: 0 5px 15px rgba(0,0,0,0.1);
}

/* Cards */
.card-box {
    border-radius: 20px;
    padding: 25px;
    color: white;
    transition: 0.3s;
}

.card-box:hover {
    transform: translateY(-5px);
}

.bg1 { background: linear-gradient(135deg, #22c55e, #16a34a); }
.bg2 { background: linear-gradient(135deg, #3b82f6, #1d4ed8); }
.bg3 { background: linear-gradient(135deg, #ef4444, #b91c1c); }

</style>
</head>

<body>

<!-- Sidebar -->
<div class="sidebar">
    <h4>🐾 PetCare</h4>
    <hr>
    <a href="index.php"><i class="bi bi-speedometer2"></i> Dashboard</a>
    <a href="hewan.php"><i class="bi bi-heart"></i> Data Hewan</a>
    <a href="penitipan.php"><i class="bi bi-house"></i> Penitipan</a>
    <a href="logout.php"><i class="bi bi-box-arrow-right"></i> Logout</a>
</div>

<!-- Content -->
<div class="content">

    <!-- Topbar -->
    <div class="topbar d-flex justify-content-between align-items-center mb-4">
        <h5>Dashboard</h5>
        <span>👋 Selamat datang, Admin</span>
    </div>

    <!-- Cards -->
    <div class="row g-4">

        <div class="col-md-4">
            <div class="card-box bg1">
                <h4><i class="bi bi-heart"></i> Data Hewan</h4>
                <p>Kelola semua data hewan</p>
                <a href="hewan.php" class="btn btn-light btn-sm">Buka</a>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card-box bg2">
                <h4><i class="bi bi-house"></i> Penitipan</h4>
                <p>Kelola transaksi penitipan</p>
                <a href="penitipan.php" class="btn btn-light btn-sm">Buka</a>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card-box bg3">
                <h4><i class="bi bi-box-arrow-right"></i> Logout</h4>
                <p>Keluar dari sistem</p>
                <a href="logout.php" class="btn btn-light btn-sm">Keluar</a>
            </div>
        </div>

    </div>

</div>

</body>
</html>