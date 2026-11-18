<?php
include("config.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $username = $_POST['username'] ?? '';
  $password = $_POST['password'] ?? '';

  if (empty($username) || empty($password)) {
    die("Username dan password wajib diisi!");
  }

  // Hash password
  $hashed = password_hash($password, PASSWORD_DEFAULT);

  // Cek apakah username sudah ada
  $check = $conn->prepare("SELECT * FROM users WHERE username = ?");
  $check->bind_param("s", $username);
  $check->execute();
  $result = $check->get_result();

  if ($result->num_rows > 0) {
    echo "EXISTS";
  } else {
    $stmt = $conn->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
    $stmt->bind_param("ss", $username, $hashed);
    if ($stmt->execute()) {
      echo "SUCCESS";
    } else {
      echo "ERROR";
    }
  }

  $conn->close();
} else {
  echo "Gunakan form untuk mengirim data (POST)";
}
?>