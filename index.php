<?php
session_start();
require 'koneksi.php';

$error = '';

if (isset($_POST['login'])) {
    $user = $_POST['username'];
    $pass = $_POST['password'];

    $sql = "SELECT * FROM users WHERE username=? AND password=?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "ss", $user, $pass);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $data = mysqli_fetch_assoc($result);

    if ($data) {
        $_SESSION['user'] = $data['username'];
        $_SESSION['id'] = $data['id'];
        $_SESSION['role'] = $data['role'];
        header("Location: dashboard.php");
        exit;
    } else {
        $error = 'Login gagal! Username atau password salah.';
    }
}


?>

<style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
        font-family: 'Segoe UI', sans-serif;
    }

    html, body {
        height: 100%;
        width: 100%;
    }

    .container {
        display: flex;
        height: 100vh;
        width: 100vw;
    }

    .left {
        flex: 1;
        background: linear-gradient(#cdffd8, #94b9ff);
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .left img {
        max-width: 90%;
        max-height: 90%;
    }

    .right {
        flex: 1;
        background-color: #cce0f5;
        display: flex;
        flex-direction: column;
        justify-content: center;
        padding: 0 80px;
    }

    .right h2 {
        font-size: 32px;
        font-weight: bold;
        color: #222;
        margin-bottom: 30px;
    }

    .form-group {
        margin-bottom: 20px;
    }

    .form-group input {
        width: 100%;
        padding: 14px 18px;
        border: none;
        border-radius: 25px;
        background-color: white;
        font-size: 15px;
    }

    .btn-login {
        width: 100%;
        padding: 14px;
        background-color: #1c74d9;
        color: white;
        font-size: 16px;
        border: none;
        border-radius: 25px;
        cursor: pointer;
        transition: background-color 0.3s ease;
        margin-bottom: 10px;
    }

    .btn-login:hover {
        background-color: #155ab0;
    }

    .register-link {
        text-align: center;
        font-size: 14px;
    }

    .register-link a {
        text-decoration: none;
        color: #004aad;
    }

    .error {
        color: red;
        font-size: 14px;
        margin-bottom: 15px;
        text-align: center;
    }

    @media (max-width: 768px) {
        .container {
            flex-direction: column;
        }

        .right, .left {
            flex: none;
            width: 100%;
            height: 50%;
            padding: 20px;
        }

        .right {
            padding: 40px 30px;
        }
    }
</style>

<div class="container">
    <div class="left">
        <img src="img/siswa.png" alt="Siswa diskusi">
    </div>
    <div class="right">
        <h2>Login</h2>
        <?php if (!empty($error)) echo "<div class='error'>$error</div>"; ?>
        <form method="POST">
            <div class="form-group">
                <input type="text" name="username" placeholder="Username" required>
            </div>
            <div class="form-group">
                <input type="password" name="password" placeholder="Password" required>
            </div>
            <button type="submit" name="login" class="btn-login">Login</button>
        </form>
        <div class="register-link">
            <p>ga da akun? <a href="register.php">bikin yuk</a></p>
        </div>
    </div>
</div>
