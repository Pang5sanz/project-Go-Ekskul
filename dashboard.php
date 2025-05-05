<?php
session_start();
require 'koneksi.php';
require 'functions.php';

if (!isset($_SESSION['user'])) {
    header("Location: index.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
    <style>
        * {
            font-family: 'Segoe UI', sans-serif;
        }

        body {
            margin: 0;
            padding: 0;
            background: linear-gradient(to right, #d0f5d8, #c5dffc);
        }

        .topbar {
            background-color: #1f6fb2;
            padding: 10px 30px;
            color: white;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .topbar .profile {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .topbar .profile img {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            object-fit: cover;
        }

        .topbar .logout-btn {
            background-color: #002f66;
            color: white;
            border: none;
            padding: 8px 16px;
            border-radius: 20px;
            cursor: pointer;
            font-weight: bold;
        }

        .container {
            display: flex;
            min-height: 90vh;
        }

        .left, .right {
            flex: 1;
            display: flex;
            flex-direction: column;
            justify-content: center;
            padding: 50px;
        }

        .left form {
            max-width: 400px;
        }

        .left label {
            margin-bottom: 5px;
            font-weight: 500;
        }

        .left input, .left select {
            width: 100%;
            padding: 12px 18px;
            border-radius: 25px;
            border: none;
            margin-bottom: 20px;
            font-size: 15px;
        }

        .left button, .left input[type="submit"] {
            width: 50%;
            padding: 12px;
            background-color: #002f66;
            color: white;
            font-size: 15px;
            border: none;
            border-radius: 25px;
            cursor: pointer;
        }

        .right img {
            width: 80%;
            max-width: 400px;
            margin: auto;
        }

        ul.pendaftar {
            list-style: none;
            padding-left: 0;
        }

        ul.pendaftar li {
            margin-bottom: 8px;
            padding: 10px;
            background: #ffffffaa;
            border-radius: 8px;
        }

        @media (max-width: 768px) {
            .container {
                flex-direction: column;
            }

            .left, .right {
                width: 100%;
                padding: 30px;
            }
        }

        /* Notifikasi bubble */
        .notif-popup {
            display: none;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background-color: #1f6fb2;
            color: white;
            padding: 20px 30px;
            border-radius: 30px;
            font-size: 16px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
            z-index: 9999;
            animation: fadeInOut 3s ease-in-out;
        }

        @keyframes fadeInOut {
            0% { opacity: 0; }
            10% { opacity: 1; }
            90% { opacity: 1; }
            100% { opacity: 0; }
        }
    </style>
</head>
<body>

<div id="notif" class="notif-popup">Berhasil mendaftar ekskul!</div>

<div class="topbar">
    <div class="profile">
        <img src="img/login-img.png" alt="User">
        <span>Welcome <?= htmlspecialchars($_SESSION['user']); ?></span>
    </div>
    <form method="post" action="logout.php">
        <button class="logout-btn">Log Out</button>
    </form>
</div>

<div class="container">
    <?php if ($_SESSION['role'] == 'siswa'): ?>
    <div class="left">
        <form method="POST" action="daftar.php">
            <label>Nama Lengkap</label>
            <input type="text" name="nama" required>

            <label>Kelas</label>
            <input type="text" name="kelas" required>

            <label>Pilih Ekskul</label>
            <select name="ekskul" required>
                <option value="">-- Pilih Ekskul --</option>
                <?php
                $list = getEkskulList($conn);
                foreach ($list as $e) {
                    echo "<option value='{$e['id']}'>{$e['nama_ekskul']}</option>";
                }
                ?>
            </select>

            <input type="submit" name="daftar" value="Daftar Ekskul">
        </form>
    </div>
    <div class="right">
        <img src="img/siswa.png" alt="Ilustrasi siswa">
    </div>
    <?php else: ?>
    <div class="left">
        <h3>Daftar Pendaftar Ekskul</h3>
        <ul class="pendaftar">
            <?php
            $pendaftar = getPendaftar($conn);
            foreach ($pendaftar as $p) {
                echo "<li><strong>{$p['nama_lengkap']}</strong> - {$p['kelas']} - <em>{$p['nama_ekskul']}</em></li>";
            }
            ?>
        </ul>
    </div>
    <div class="right">
        <img src="img/siswa.png" alt="Ilustrasi siswa">
    </div>
    <?php endif; ?>
</div>

<?php if (isset($_GET['sukses'])): ?>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const notif = document.getElementById("notif");
        if (notif) {
            notif.style.display = "block";
            setTimeout(() => notif.style.display = "none", 3000);
        }
    });
</script>
<?php endif; ?>

</body>
</html>
