<?php
session_start();
require 'config/connection.php';

if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit;
}

$search = $_GET['search'] ?? '';

if ($search) {
    $stmt = $pdo->prepare("SELECT * FROM mahasiswa WHERE nama LIKE ? ORDER BY id DESC");
    $stmt->execute(["%$search%"]);
} else {
    $stmt = $pdo->query("SELECT * FROM mahasiswa ORDER BY id DESC");
}

$data = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>
<head>
<title>Data Mahasiswa</title>

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

.table-card {
    background: white;
    border-radius: 15px;
    padding: 20px;
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
        <h5 class="mb-0">Data Mahasiswa</h5>

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

    <div class="table-card">

        <div class="d-flex justify-content-between mb-3">
            <a href="tambah.php" class="btn btn-success">
                <i class="fa fa-plus"></i> Tambah Mahasiswa
            </a>

            <form method="GET" style="width:250px;">
                <input type="text" name="search" value="<?= htmlspecialchars($search) ?>"
                       placeholder="Cari nama..." class="form-control">
            </form>
        </div>

        <table class="table table-striped table-hover">
                    <thead class="table-dark">
            <tr>
                <th>NPM</th>
                <th>Nama</th>
                <th>Jurusan</th>
                <th>Email</th>
                <th>Foto</th>
                <th width="150">Aksi</th>
            </tr>
        </thead>
            <tbody>
<?php foreach($data as $row): ?>
<tr>
    <td><?= htmlspecialchars($row['npm']); ?></td>
    <td><?= htmlspecialchars($row['nama']); ?></td>
    <td><?= htmlspecialchars($row['jurusan']); ?></td>
    <td><?= htmlspecialchars($row['email']); ?></td>

    <td>
<?php
if (!empty($row['foto']) && file_exists('uploads/' . $row['foto'])) {
    echo '<img src="uploads/'.$row['foto'].'"
          width="60"
          height="60"
          style="object-fit:cover;border-radius:8px;cursor:pointer;"
          onclick="previewImage(\'uploads/'.$row['foto'].'\')">';
} else {
    echo '<span class="text-muted">-</span>';
}
?>
</td>

    <td>
        <a href="edit.php?id=<?= $row['id']; ?>" class="btn btn-warning btn-sm">
            <i class="fa fa-edit"></i>
        </a>

        <button class="btn btn-danger btn-sm"
                onclick="confirmDelete(<?= $row['id']; ?>)">
            <i class="fa fa-trash"></i>
        </button>
    </td>
</tr>
<?php endforeach; ?>
</tbody>
        </table>

    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<script>
function previewImage(src) {
    Swal.fire({
        imageUrl: src,
        imageWidth: 400,
        imageAlt: 'Foto Mahasiswa',
        showConfirmButton: false,
        showCloseButton: true,
        background: '#f4f6f9'
    });
}

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

function confirmDelete(id) {
    Swal.fire({
        title: 'Yakin hapus data?',
        text: "Data tidak bisa dikembalikan!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        confirmButtonText: 'Ya, Hapus',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = "hapus.php?id=" + id;
        }
    });
}
</script>

</body>
</html>