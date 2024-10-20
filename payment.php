<?php
include 'db.php'; // Memasukkan koneksi database
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Mengambil data dari form
    $id_transaksi = $_POST['id_transaksi'];
    $total_bayar = $_POST['total_bayar'];
    $status_bayar = $_POST['status_bayar'];

    // Menyimpan data pembayaran ke tabel tbl_bayar
    $sql = "INSERT INTO tbl_bayar (id_kembali, tgl_bayar, total_bayar, status_bayar) VALUES ('$id_transaksi', NOW(), '$total_bayar', '$status_bayar')";
    
    if ($conn->query($sql) === TRUE) {
        echo "Pembayaran berhasil!";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Pembayaran</title>
</head>
<body>
    <form action="" method="post">
        <h2>Pembayaran</h2>
        <label for="id_transaksi">ID Transaksi:</label>
        <input type="text" id="id_transaksi" name="id_transaksi" required><br>

        <label for="total_bayar">Total Bayar:</label>
        <input type="number" id="total_bayar" name="total_bayar" required step="0.01"><br>

        <label for="status_bayar">Status Pembayaran:</label>
        <select id="status_bayar" name="status_bayar">
            <option value="belum lunas">Belum Lunas</option>
            <option value="lunas">Lunas</option>
        </select><br>

        <input type="submit" value="Bayar">
    </form>
</body>
</html>
