<?php
include 'db.php'; // Memasukkan koneksi database

$cars = [];
if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['tanggal_sewa'])) {
    $tanggal_sewa = $_GET['tanggal_sewa'];
    // Mencari mobil yang tersedia (ini hanya contoh sederhana, bisa disesuaikan)
    $sql = "SELECT * FROM tbl_mobil WHERE status='tersedia'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $cars[] = $row;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Pencarian Mobil</title>
</head>
<body>
    <form action="" method="get">
        <h2>Pencarian Mobil</h2>
        <label for="tanggal_sewa">Tanggal Sewa:</label>
        <input type="date" id="tanggal_sewa" name="tanggal_sewa" required><br>

        <input type="submit" value="Cari Mobil">
    </form>

    <?php if (!empty($cars)): ?>
        <h3>Mobil Tersedia:</h3>
        <ul>
            <?php foreach ($cars as $car): ?>
                <li><?php echo $car['brand'] . ' - ' . $car['nopol']; ?></li>
            <?php endforeach; ?>
        </ul>
    <?php else: ?>
        <p>Tidak ada mobil yang tersedia.</p>
    <?php endif; ?>
</body>
</html>
