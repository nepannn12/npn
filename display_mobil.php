<?php
// Koneksi ke database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "rental";

$conn = new mysqli($servername, $username, $password, $dbname);

// Periksa koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Query untuk mendapatkan daftar mobil
$sql = "SELECT * FROM tbl_mobil";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Mobil</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #000;
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        img {
            max-width: 100px; /* Membatasi lebar gambar */
        }
    </style>
</head>
<body>
    <h2>Daftar Mobil</h2>
    <a href="tambah_mobil.php">Tambah Mobil Baru</a><br><br>

    <table>
        <tr>
            <th>Nopol</th>
            <th>Brand</th>
            <th>Type</th>
            <th>Tahun</th>
            <th>Harga</th>
            <th>Foto</th>
            <th>Status</th>
            <th>Action</th>
        </tr>

        <?php
        if ($result->num_rows > 0) {
            // Loop untuk menampilkan semua mobil
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . htmlspecialchars($row["nopol"]) . "</td>";
                echo "<td>" . htmlspecialchars($row["brand"]) . "</td>";
                echo "<td>" . htmlspecialchars($row["type"]) . "</td>";
                echo "<td>" . htmlspecialchars($row["tahun"]) . "</td>";
                echo "<td>" . htmlspecialchars(number_format($row["harga"], 2)) . "</td>";
                echo "<td><img src='uploads/" . htmlspecialchars($row["foto"]) . "' alt='Foto Mobil'></td>";
                echo "<td>" . htmlspecialchars($row["status"]) . "</td>";
                echo "<td>
                        <a href='update_mobil.php?nopol=" . htmlspecialchars($row["nopol"]) . "'>Edit</a> |
                        <a href='delete_mobil.php?nopol=" . htmlspecialchars($row["nopol"]) . "' onclick='return confirm(\"Apakah Anda yakin ingin menghapus mobil ini?\")'>Delete</a>
                      </td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='8'>Tidak ada data mobil</td></tr>";
        }

        // Tutup koneksi
        $conn->close();
        ?>
    </table>
</body>
</html>
