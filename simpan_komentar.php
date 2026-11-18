<?php
header("Content-Type: application/json");
include "koneksi.php";

// Ambil data dari fetch
$input = json_decode(file_get_contents("php://input"), true);

$username = $input["username"] ?? "";
$komentar = $input["komentar"] ?? "";

if (empty($username) || empty($komentar)) {
    echo json_encode(["success" => false, "message" => "Data tidak lengkap."]);
    exit;
}

// Periksa apakah user ada
$cek = $conn->prepare("SELECT id FROM users WHERE username = ?");
$cek->bind_param("s", $username);
$cek->execute();
$result = $cek->get_result();

if ($result->num_rows === 0) {
    echo json_encode(["success" => false, "message" => "User tidak ditemukan."]);
    exit;
}

// Update komentar di kolom users
$stmt = $conn->prepare("UPDATE users SET komentar = ? WHERE username = ?");
$stmt->bind_param("ss", $komentar, $username);

if ($stmt->execute()) {
    echo json_encode(["success" => true, "message" => "Komentar berhasil disimpan."]);
} else {
    echo json_encode(["success" => false, "message" => "Gagal menyimpan komentar."]);
}

$stmt->close();
$conn->close();
?>