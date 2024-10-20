<?php
include 'db.php'; // Memasukkan koneksi database

if (isset($_GET['id_transaksi'])) {
    $id_transaksi = $_GET['id_transaksi'];

    // Ambil kekurangan dari tbl_transaksi
    $sql_transaksi = "SELECT kekurangan FROM tbl_transaksi WHERE id_transaksi = '$id_transaksi'";
    $result_transaksi = $conn->query($sql_transaksi);
    
    // Ambil denda dari tbl_kembali
    $sql_denda = "SELECT denda FROM tbl_kembali WHERE id_kembali = (SELECT id_kembali FROM tbl_transaksi WHERE id_transaksi = '$id_transaksi')";
    $result_denda = $conn->query($sql_denda);

    if ($result_transaksi->num_rows > 0) {
        $data_transaksi = $result_transaksi->fetch_assoc();
        $total_kekurangan = $data_transaksi['kekurangan']; // Total bayar diambil dari kekurangan
    } else {
        $total_kekurangan = 0; // Jika tidak ditemukan, set ke 0
    }

    if ($result_denda->num_rows > 0) {
        $data_denda = $result_denda->fetch_assoc();
        $total_denda = $data_denda['denda'];
    } else {
        $total_denda = 0; // Jika tidak ditemukan, set ke 0
    }

    // Menghitung total pembayaran
    $total_pembayaran = $total_kekurangan + $total_denda;

    // Mengembalikan response JSON
    echo json_encode([
        'total' => $total_kekurangan, // Total bayar diambil dari kekurangan
        'denda' => $total_denda
    ]);
} else {
    echo json_encode(['total' => 0, 'denda' => 0]);
}
?>
