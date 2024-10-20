<?php
include 'db.php'; // Memasukkan koneksi database
session_start();

// Ambil semua transaksi dari database
$sql = "SELECT * FROM tbl_transaksi";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Kelola Transaksi</title>
</head>
<body>
    <h2>Daftar Transaksi</h2>
    <table border="1">
        <tr>
            <th>ID Transaksi</th>
            <th>NIK</th>
            <th>No. Polisi</th>
            <th>Tanggal Booking</th>
            <th>Tanggal Ambil</th>
            <th>Tanggal Kembali</th>
            <th>Status</th>
            <th>Aksi</th>
        </tr>
        <?php while ($row = $result->fetch_assoc()) : ?>
        <tr>
            <td><?php echo $row['id_transaksi']; ?></td>
            <td><?php echo $row['nik']; ?></td>
            <td><?php echo $row['nopol']; ?></td>
            <td><?php echo $row['tgl_booking']; ?></td>
            <td><?php echo $row['tgl_ambil']; ?></td>
            <td><?php echo $row['tgl_kembali']; ?></td>
            <td><?php echo $row['status']; ?></td>
            <td>
                <form action="update_status.php" method="post">
                    <input type="hidden" name="id_transaksi" value="<?php echo $row['id_transaksi']; ?>">
                    <select name="status">
                        <option value="approve">Approve</option>
                        <option value="ambil">Ambil</option>
                        <option value="kembali">Kembali</option>
                    </select>
                    <input type="submit" value="Update">
                </form>
            </td>
        </tr>
        <?php endwhile; ?>
    </table>
</body>
</html>
