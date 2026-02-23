<?php
session_start();
require 'config/connection.php';

// Cek dulu apakah user ada sebelum log
if (isset($_SESSION['user'])) {

    require 'log_activity.php';
    logActivity($pdo, $_SESSION['user'], "Logout dari sistem");

}

// Hapus semua session
$_SESSION = [];
session_destroy();

// Redirect ke login
header("Location: login.php");
exit;
?>
