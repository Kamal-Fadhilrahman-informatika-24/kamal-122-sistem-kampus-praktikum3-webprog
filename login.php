<?php
session_start();
require 'config/connection.php';

if (isset($_SESSION['user'])) {
    header("Location: dashboard.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->execute([$username]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user'] = $user['username'];
        header("Location: dashboard.php");
        exit;
    } else {
        $error = "Username atau password salah!";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Login - Sistem Kampus</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">


<style>
body {
    height: 100vh;
    margin: 0;
    font-family: 'Segoe UI', sans-serif;
    background: linear-gradient(-45deg, #0f2027, #1e3c72, #2a5298, #134e5e);
    background-size: 400% 400%;
    animation: gradientFlow 12s ease infinite;
    display: flex;
    justify-content: center;
    align-items: center;
}

/* Animasi gradien */
@keyframes gradientFlow {
    0% { background-position: 0% 50%; }
    50% { background-position: 100% 50%; }
    100% { background-position: 0% 50%; }
}

.glass-card {
    width: 420px;
    padding: 45px;
    border-radius: 20px;
    background: rgba(255, 255, 255, 0.08);
    backdrop-filter: blur(20px);
    -webkit-backdrop-filter: blur(20px);
    border: 1px solid rgba(255,255,255,0.2);
    box-shadow: 0 20px 40px rgba(0,0,0,0.3);
    color: white;
}

.glass-card h3 {
    font-weight: bold;
    text-align: center;
    margin-bottom: 30px;
    color: #ffd700;
}

.form-control {
    border-radius: 12px;
    border: none;
    padding: 10px;
}

.form-control:focus {
    box-shadow: 0 0 0 2px rgba(255, 215, 0, 0.5);
}

.btn-login {
    background: #ffd700;
    color: #1a1a1a;
    border-radius: 12px;
    font-weight: bold;
    transition: 0.3s;
}

.btn-login:hover {
    background: #e6c200;
    transform: translateY(-2px);
}
</style>
</head>

<body>

<div class="glass-card">

    <h3><i class="fa fa-graduation-cap"></i> Sistem Kampus</h3>

    <?php if(isset($error)): ?>
        <div class="alert alert-danger"><?= $error ?></div>
    <?php endif; ?>

    <form method="POST">

        <div class="mb-3">
            <label>Username</label>
            <input type="text" name="username" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Password</label>
            <div class="input-group">
                <input type="password" name="password" id="password" class="form-control" required>
                <button type="button" class="btn btn-light" onclick="togglePassword()">
                    <i class="fa fa-eye"></i>
                </button>
            </div>
        </div>

        <button type="submit" class="btn btn-login w-100 mt-3">
            <i class="fa fa-sign-in-alt"></i> Login
        </button>

    </form>

</div>

<script>
function togglePassword() {
    var input = document.getElementById("password");
    input.type = input.type === "password" ? "text" : "password";
}
</script>

</body>
</html>