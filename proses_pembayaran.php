<?php
include 'db.php'; // Memasukkan koneksi database
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Mengambil data dari form
    $id_transaksi = $_POST['id_transaksi'];
    $status_bayar = $_POST['status_bayar'];

    // Mengambil id_kembali dari tabel tbl_kembali berdasarkan id_transaksi
    $sql_kembali = "SELECT id_kembali FROM tbl_kembali WHERE id_transaksi = '$id_transaksi'";
    $result_kembali = $conn->query($sql_kembali);

    if ($result_kembali->num_rows > 0) {
        $data_kembali = $result_kembali->fetch_assoc();
        $id_kembali = $data_kembali['id_kembali'];

        // Mencatat pembayaran
        $sql = "INSERT INTO tbl_bayar (id_kembali, tgl_bayar, total_bayar, status_bayar) VALUES ('$id_kembali', NOW(), (SELECT kekurangan FROM tbl_transaksi WHERE id_transaksi = '$id_transaksi'), '$status_bayar')";
        
        if ($conn->query($sql) === TRUE) {
            echo "Pembayaran berhasil dicatat!";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    } else {
        echo "Error: id_kembali tidak ditemukan untuk id_transaksi: $id_transaksi";
    }
}
?>
<a href="form_pembayaran.php">Kembali ke Form Pembayaran</a>
