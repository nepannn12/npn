<?php
include 'db.php'; // Memasukkan koneksi database
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_transaksi = $_POST['id_transaksi'];
    $status = $_POST['status'];

    // Update status transaksi
    $sql = "UPDATE tbl_transaksi SET status='$status' WHERE id_transaksi='$id_transaksi'";
    
    if ($conn->query($sql) === TRUE) {
        echo "Status transaksi berhasil diupdate!";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
?>
<a href="kelola_transaksi.php">Kembali ke Daftar Transaksi</a>
