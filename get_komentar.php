<?php
header("Content-Type: application/json");
include "koneksi.php";

$result = $conn->query("SELECT username, komentar FROM users WHERE komentar IS NOT NULL AND komentar != '' ORDER BY id DESC");

$komentar = [];

while ($row = $result->fetch_assoc()) {
    $komentar[] = [
        "username" => $row["username"],
        "komentar" => $row["komentar"]
    ];
}

echo json_encode([
    "success" => true,
    "data" => $komentar
]);

$conn->close();
?>