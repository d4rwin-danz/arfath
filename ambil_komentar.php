<?php
header("Content-Type: application/json; charset=utf-8");
include "koneksi.php";

$sql = "SELECT id, username, komentar 
        FROM users 
        WHERE komentar IS NOT NULL AND komentar != '' 
        ORDER BY id DESC";

$res = $conn->query($sql);

$out = [];

if ($res) {
    while ($r = $res->fetch_assoc()) {
        $out[] = [
            "username" => $r["username"],
            "komentar" => $r["komentar"]
        ];
    }
}

echo json_encode($out);
$conn->close();
?>