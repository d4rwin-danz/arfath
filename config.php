<?php
error_reporting(E_ALL & ~E_NOTICE);
ini_set('display_errors', 1);

$host = "localhost";
$user = "root";
$pass = "";
$db   = "databaseloginweb";

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}
?>