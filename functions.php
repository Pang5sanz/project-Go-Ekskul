<?php
function daftarEkskul($userId, $nama, $kelas, $ekskulId, $conn) {
    $sql = "INSERT INTO pendaftaran (user_id, nama_lengkap, kelas, ekskul_id) VALUES (?, ?, ?, ?)";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "issi", $userId, $nama, $kelas, $ekskulId);
    return mysqli_stmt_execute($stmt);
}

function getEkskulList($conn) {
    $result = mysqli_query($conn, "SELECT * FROM ekskul");
    return mysqli_fetch_all($result, MYSQLI_ASSOC);
}

function getPendaftar($conn) {
    $sql = "SELECT p.nama_lengkap, p.kelas, e.nama_ekskul FROM pendaftaran p JOIN ekskul e ON p.ekskul_id = e.id";
    $result = mysqli_query($conn, $sql);
    return mysqli_fetch_all($result, MYSQLI_ASSOC);
}
?>