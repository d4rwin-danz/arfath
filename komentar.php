<?php
session_start();
header("Content-Type: application/json");

// Pastikan user sudah login
if (!isset($_SESSION["username"])) {
    echo json_encode(["success" => false, "error" => "User belum login"]);
    exit();
}

$komentar = "";
$data = json_decode(file_get_contents("php://input"), true);

if (isset($data["komentar"])) {
    $komentar = $data["komentar"];
}

$conn = new mysqli("localhost", "root", "", "databaseloginweb");

if ($conn->connect_error) {
    echo json_encode(["success" => false, "error" => "Koneksi gagal"]);
    exit();
}

$username = $_SESSION["username"];

// Update komentar user
$stmt = $conn->prepare("UPDATE users SET komentar = ? WHERE username = ?");
$stmt->bind_param("ss", $komentar, $username);

if ($stmt->execute()) {
    echo json_encode(["success" => true, "username" => $username]);
} else {
    echo json_encode(["success" => false, "error" => "Gagal menyimpan komentar"]);
}

$stmt->close();
$conn->close();
?>