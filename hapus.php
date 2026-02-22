<?php
require 'config/connection.php';

$id = $_GET['id'] ?? null;

if ($id) {
    $stmt = $pdo->prepare("DELETE FROM mahasiswa WHERE id=?");
    $stmt->execute([$id]);
}

header("Location: mahasiswa.php");
exit;
