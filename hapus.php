<?php
require 'config/connection.php';

$stmt = $pdo->prepare("SELECT foto FROM mahasiswa WHERE id=?");
$stmt->execute([$id]);
$data = $stmt->fetch(PDO::FETCH_ASSOC);

if ($data['foto'] && file_exists('uploads/' . $data['foto'])) {
    unlink('uploads/' . $data['foto']);
}

$id = $_GET['id'] ?? null;

if ($id) {
    $stmt = $pdo->prepare("DELETE FROM mahasiswa WHERE id=?");
    $stmt->execute([$id]);
}

header("Location: mahasiswa.php");
exit;
