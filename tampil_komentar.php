<?php
include "koneksi.php";

$res = $conn->query("SELECT username, komentar FROM users WHERE komentar != '' ORDER BY id DESC");

if ($res->num_rows > 0) {
    while ($r = $res->fetch_assoc()) {
        echo "<div><b>".htmlspecialchars($r['username'])."</b>: "
           . nl2br(htmlspecialchars($r['komentar'])) 
           . "</div>";
    }
} else {
    echo "Belum ada komentar.";
}
?>