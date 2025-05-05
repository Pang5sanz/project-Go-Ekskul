<?php
require 'koneksi.php';

$success = '';
$error = '';

if (isset($_POST['register'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $check_sql = "SELECT * FROM users WHERE username = ?";
    $check_stmt = mysqli_prepare($conn, $check_sql);
    mysqli_stmt_bind_param($check_stmt, "s", $username);
    mysqli_stmt_execute($check_stmt);
    $check_result = mysqli_stmt_get_result($check_stmt);

    if (mysqli_num_rows($check_result) > 0) {
        $error = "Username sudah digunakan.";
    } else {
        $sql = "INSERT INTO users (username, password, role) VALUES (?, ?, 'siswa')";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "ss", $username, $password);
        mysqli_stmt_execute($stmt);
        $success = "Registrasi berhasil. <a href='index.php'>Login</a>";
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
        background: #cce0f5;
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

    .btn-register {
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

    .btn-register:hover {
        background-color: #155ab0;
    }

    .login-link {
        text-align: center;
        font-size: 14px;
    }

    .login-link a {
        text-decoration: none;
        color: #004aad;
    }

    .error {
        color: red;
        font-size: 14px;
        margin-bottom: 15px;
        text-align: center;
    }

    .success {
        color: green;
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
        <h2>Daftar</h2>
        <?php
        if (!empty($error)) echo "<div class='error'>$error</div>";
        if (!empty($success)) echo "<div class='success'>$success</div>";
        ?>
        <form method="POST">
            <div class="form-group">
                <input type="text" name="username" placeholder="Username" required>
            </div>
            <div class="form-group">
                <input type="password" name="password" placeholder="Password" required>
            </div>
            <button type="submit" name="register" class="btn-register">Daftar</button>
        </form>
        <div class="login-link">
            <p>sudah punya akun? <a href="index.php">login yuk</a></p>
        </div>
    </div>
</div>
