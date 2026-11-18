<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
include "config.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];

    $stmt = $conn->prepare("SELECT password FROM users WHERE username = ?");
    if (!$stmt) {
        die("Error prepare: " . $conn->error);
    }

    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if (!$result) {
        die("Error execute: " . $stmt->error);
    }

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if (password_verify($password, $row["password"])) {
            session_start();
            $_SESSION["username"] = $username;
            $_SESSION["waktu_login"] = date("Y-m-d H:i:s");

            $update = $conn->prepare("UPDATE users SET last_login = NOW() WHERE username = ?");
            if (!$update) die("Error update: " . $conn->error);
            $update->bind_param("s", $username);
            $update->execute();

            echo "SUCCESS|" . $_SESSION["waktu_login"];
        } else {
            echo "WRONG";
        }
    } else {
        echo "NOT_FOUND";
    }
}
?>