<?php
include 'db.php'; // Memasukkan koneksi database
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Mengambil data dari form
    $id_transaksi = $_POST['id_transaksi'];
    $kondisi_mobil = $_POST['kondisi_mobil'];
    $denda = $_POST['denda'];

    // Mencatat pengembalian
    $sql = "INSERT INTO tbl_kembali (id_transaksi, tgl_kembali, kondisi_mobil, denda) VALUES ('$id_transaksi', NOW(), '$kondisi_mobil', '$denda')";
    
    if ($conn->query($sql) === TRUE) {
        echo "Pengembalian mobil berhasil dicatat!";
        
        // Update status transaksi menjadi 'kembali'
        $update_sql = "UPDATE tbl_transaksi SET status='kembali' WHERE id_transaksi='$id_transaksi'";
        $conn->query($update_sql);
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Ambil semua ID transaksi dari database
$sql_transaksi = "SELECT id_transaksi FROM tbl_transaksi";
$result_transaksi = $conn->query($sql_transaksi);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Pengembalian Mobil</title>
</head>
<body>
    <form action="" method="post">
        <h2>Pengembalian Mobil</h2>
        
        <label for="id_transaksi">ID Transaksi:</label>
        <select id="id_transaksi" name="id_transaksi" required>
            <option value="">Pilih ID Transaksi</option>
            <?php while ($row = $result_transaksi->fetch_assoc()) : ?>
                <option value="<?php echo $row['id_transaksi']; ?>"><?php echo $row['id_transaksi']; ?></option>
            <?php endwhile; ?>
        </select><br>

        <label for="kondisi_mobil">Kondisi Mobil:</label>
        <textarea id="kondisi_mobil" name="kondisi_mobil" required></textarea><br>

        <label for="denda">Denda:</label>
        <input type="number" id="denda" name="denda" value="0" step="0.01"><br>

        <input type="submit" value="Kembali">
    </form>
</body>
</html>
