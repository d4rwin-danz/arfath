<?php
session_start();
include 'koneksi.php';

// Gunakan user_id dari sesi login, atau sementara 1 jika belum ada login
$user_id = $_SESSION['user_id'] ?? 1;
$komentar = $_POST['komentar'] ?? '';

if (!empty($komentar)) {
    $stmt = $conn->prepare("UPDATE users SET komentar = ? WHERE id = ?");
    $stmt->bind_param("si", $komentar, $user_id);
    if ($stmt->execute()) {
        echo "Komentar berhasil disimpan!";
    } else {
        echo "Gagal menyimpan komentar!";
    }
    $stmt->close();
} else {
    echo "Komentar kosong!";
}
?>