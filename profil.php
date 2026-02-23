<?php
session_start();
require 'config/connection.php';

if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit;
}

$stmt = $pdo->prepare("SELECT * FROM activity_logs WHERE user = ? ORDER BY id DESC LIMIT 20");
$stmt->execute([$_SESSION['user']]);
$logs = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html>
<head>
<title>Profil</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body style="background:#f4f6f9">

<div class="container mt-5">

    <div class="card shadow">
        <div class="card-body">

            <h4>Profil Pengguna</h4>
            <p><strong>Username:</strong> <?= $_SESSION['user']; ?></p>

            <hr>

            <h5>Activity Log</h5>

            <table class="table table-bordered mt-3">
                <thead class="table-dark">
                    <tr>
                        <th>Aktivitas</th>
                        <th>Waktu</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($logs as $log): ?>
                    <tr>
                        <td><?= htmlspecialchars($log['activity']); ?></td>
                        <td><?= $log['created_at']; ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

            <a href="dashboard.php" class="btn btn-secondary mt-3">Kembali</a>

        </div>
    </div>

</div>

</body>
</html>