<?php
session_start();
require 'config/connection.php';

if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit;
}

$total = $pdo->query("SELECT COUNT(*) FROM mahasiswa")->fetchColumn();
$jurusan = $pdo->query("SELECT COUNT(DISTINCT jurusan) FROM mahasiswa")->fetchColumn();
?>

<!DOCTYPE html>
<html>
<head>
<title>Dashboard - Sistem Kampus</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<style>
body {
    margin: 0;
    font-family: 'Segoe UI', sans-serif;
    background: #f4f6f9;
}

.sidebar {
    width: 240px;
    height: 100vh;
    background: #1e1e2f;
    position: fixed;
    padding-top: 20px;
    color: white;
}

.sidebar h4 {
    text-align: center;
    margin-bottom: 30px;
}

.sidebar a {
    display: block;
    padding: 12px 20px;
    color: #ccc;
    text-decoration: none;
    transition: 0.3s;
}

.sidebar a:hover {
    background: #2c2c3e;
    color: white;
}

.main {
    margin-left: 240px;
    padding: 20px;
}

.topbar {
    background: white;
    padding: 15px 20px;
    border-radius: 10px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    box-shadow: 0 5px 15px rgba(0,0,0,0.05);
}

.card-stat {
    border-radius: 20px;
    padding: 25px;
    color: white;
    transition: 0.3s;
}

.card-stat:hover {
    transform: translateY(-5px);
}

.bg-blue { background: linear-gradient(135deg,#4e73df,#224abe); }
.bg-green { background: linear-gradient(135deg,#1cc88a,#13855c); }
.bg-orange { background: linear-gradient(135deg,#f6c23e,#dda20a); }

</style>
</head>
<body>

<div class="sidebar">
    <h4><i class="fa fa-graduation-cap"></i> Kampus</h4>

    <a href="dashboard.php"><i class="fa fa-home"></i> Dashboard</a>
    <a href="mahasiswa.php"><i class="fa fa-users"></i> Data Mahasiswa</a>
</div>

<div class="main">

    <div class="topbar">
        <h5 class="mb-0">Dashboard</h5>

        <div class="dropdown">
            <a class="dropdown-toggle text-dark text-decoration-none" href="#" role="button" data-bs-toggle="dropdown">
                <i class="fa fa-user-circle"></i> <?= $_SESSION['user']; ?>
            </a>

            <ul class="dropdown-menu dropdown-menu-end">
                <li><a class="dropdown-item" href="profil.php"><i class="fa fa-user"></i> Profil</a></li>
                <li><hr class="dropdown-divider"></li>
                <li><a class="dropdown-item text-danger" href="#" onclick="confirmLogout()">
                    <i class="fa fa-sign-out-alt"></i> Logout
                </a></li>
            </ul>
        </div>
    </div>

    <div class="row mt-4 g-4">

        <div class="col-md-4">
            <div class="card-stat bg-blue shadow">
                <h6><i class="fa fa-users"></i> Total Mahasiswa</h6>
                <h2><?= $total ?></h2>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card-stat bg-green shadow">
                <h6><i class="fa fa-book"></i> Total Jurusan</h6>
                <h2><?= $jurusan ?></h2>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card-stat bg-orange shadow">
                <h6><i class="fa fa-calendar"></i> Hari Ini</h6>
                <h2><?= date('d M Y') ?></h2>
            </div>
        </div>

    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<script>
function confirmLogout() {
    Swal.fire({
        title: 'Yakin ingin logout?',
        text: "Anda harus login kembali.",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        confirmButtonText: 'Ya, Logout',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = "logout.php";
        }
    });
}
</script>

</body>
</html>