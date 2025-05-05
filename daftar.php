<?php
session_start();
require 'koneksi.php';
require 'functions.php';
if (isset($_POST['daftar'])) {
    $nama = $_POST['nama'];
    $kelas = $_POST['kelas'];
    $ekskul = $_POST['ekskul'];
    $userId = $_SESSION['id'];
    if (daftarEkskul($userId, $nama, $kelas, $ekskul, $conn)) {
        echo "<script>alert('Berhasil mendaftar ekskul!');window.location='dashboard.php';</script>";
    } else {
        echo "Gagal mendaftar.";
    }
}
?>