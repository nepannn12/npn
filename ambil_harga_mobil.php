<?php
include 'db.php'; // Memasukkan koneksi database

if (isset($_GET['nopol'])) {
    $nopol = $_GET['nopol'];

    // Mengambil harga mobil berdasarkan nopol
    $sql = "SELECT harga FROM tbl_mobil WHERE nopol = '$nopol'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $data = $result->fetch_assoc();
        echo json_encode(['harga_per_hari' => $data['harga']]);
    } else {
        echo json_encode(['harga_per_hari' => 0]); // Jika mobil tidak ditemukan
    }
} else {
    echo json_encode(['harga_per_hari' => 0]);
}
?>
