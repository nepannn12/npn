<?php
// Mulai sesi
session_start();

// Hapus semua variabel sesi
$_SESSION = array();

// Hapus sesi
session_destroy();

// Arahkan ke halaman login
header("Location: login.php");
exit();
?>
