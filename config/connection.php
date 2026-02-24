<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

$host = "localhost";
$dbname = "kampus";
$username = "kampususer";
$password = "password123";

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    die("Koneksi gagal: " . $e->getMessage());
}
?>