<?php
// kirim_komentar.php
session_start();
header("Content-Type: application/json; charset=utf-8");
include "koneksi.php";

// pastikan login
if (!isset($_SESSION['user_id'])) {
    echo json_encode(["success" => false, "error" => "not_logged_in"]);
    exit();
}

$input = json_decode(file_get_contents("php://input"), true);
$isi = trim($input['komentar'] ?? '');
$parent = isset($input['parent_id']) && $input['parent_id'] !== null && $input['parent_id'] !== '' ? (int)$input['parent_id'] : null;
$user_id = (int) $_SESSION['user_id'];

if ($isi === '') {
    echo json_encode(["success" => false, "error" => "empty"]);
    exit();
}

$stmt = $conn->prepare("INSERT INTO komentar (user_id, isi, parent_id) VALUES (?, ?, ?)");
if (!$stmt) {
    echo json_encode(["success" => false, "error" => $conn->error]);
    exit();
}
$stmt->bind_param("isi", $user_id, $isi, $parent);
$ok = $stmt->execute();

if ($ok) {
    $insert_id = $stmt->insert_id;
    echo json_encode(["success" => true, "id" => $insert_id]);
} else {
    echo json_encode(["success" => false, "error" => $stmt->error]);
}
$stmt->close();
$conn->close();
?>