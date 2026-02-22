<?php
session_start();
require 'config/connection.php';

if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $npm = $_POST['npm'];
    $nama = $_POST['nama'];
    $jurusan = $_POST['jurusan'];
    $email = $_POST['email'];

    try {
        $sql = "INSERT INTO mahasiswa (npm, nama, jurusan, email) VALUES (?, ?, ?, ?)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$npm, $nama, $jurusan, $email]);

        echo "<script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: 'Data mahasiswa berhasil ditambahkan',
                    confirmButtonColor: '#3085d6'
                }).then(() => {
                    window.location = 'mahasiswa.php';
                });
            });
        </script>";

    } catch (PDOException $e) {
        $error = $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Tambah Mahasiswa</title>

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

.form-card {
    background: white;
    border-radius: 20px;
    padding: 30px;
    margin-top: 20px;
    box-shadow: 0 5px 15px rgba(0,0,0,0.05);
}
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
        <h5 class="mb-0">Tambah Mahasiswa</h5>

        <div class="dropdown">
            <a class="dropdown-toggle text-dark text-decoration-none" href="#" role="button" data-bs-toggle="dropdown">
                <i class="fa fa-user-circle"></i> <?= $_SESSION['user']; ?>
            </a>

            <ul class="dropdown-menu dropdown-menu-end">
                <li><a class="dropdown-item" href="dashboard.php"><i class="fa fa-home"></i> Dashboard</a></li>
                <li><hr class="dropdown-divider"></li>
                <li><a class="dropdown-item text-danger" href="#" onclick="confirmLogout()">
                    <i class="fa fa-sign-out-alt"></i> Logout
                </a></li>
            </ul>
        </div>
    </div>

    <div class="form-card">

        <?php if(isset($error)): ?>
            <div class="alert alert-danger"><?= $error ?></div>
        <?php endif; ?>

        <form method="POST">

            <div class="row">

                <div class="col-md-6 mb-3">
                    <label>NPM</label>
                    <input type="text" name="npm" class="form-control" required>
                </div>

                <div class="col-md-6 mb-3">
                    <label>Nama</label>
                    <input type="text" name="nama" class="form-control" required>
                </div>

                <div class="col-md-6 mb-3">
                    <label>Jurusan</label>
                    <input type="text" name="jurusan" class="form-control" required>
                </div>

                <div class="col-md-6 mb-3">
                    <label>Email</label>
                    <input type="email" name="email" class="form-control">
                </div>

            </div>

            <div class="mt-3">
                <button type="submit" class="btn btn-success">
                    <i class="fa fa-save"></i> Simpan
                </button>

                <a href="mahasiswa.php" class="btn btn-secondary">
                    <i class="fa fa-arrow-left"></i> Kembali
                </a>
            </div>

        </form>

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