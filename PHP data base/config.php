<?php 
$username = "localhost";
$password = "root";
$password = "";
$dbname = "databaseloginweb";

$conn = mysqli_connect($dbhost, $username, $password, $databaseloginweb);
if ($conn->connect_error) {
    die("Connection failed: ". $conn->connect_error);
}
?>