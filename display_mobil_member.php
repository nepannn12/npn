<?php
// Mulai sesi
session_start();

// Cek apakah pengguna sudah login
if (!isset($_SESSION['nik'])) {
    header("Location: login.php"); // Redirect ke halaman login jika belum login
    exit();
}

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
$sql = "SELECT * FROM tbl_mobil WHERE status = 'tersedia'";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Mobil</title>
    <!-- Tambahkan link Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .card {
            margin: 10px 0;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <h2 class="text-center">Daftar Mobil Tersedia</h2>
        
        <?php
        if ($result->num_rows > 0) {
            // Loop untuk menampilkan semua mobil
            while($row = $result->fetch_assoc()) {
                echo '<div class="card">';
                echo '  <div class="card-body">';
                echo '    <h5 class="card-title">' . $row['brand'] . ' - ' . $row['type'] . '</h5>';
                echo '    <p class="card-text">Nopol: ' . $row['nopol'] . '</p>';
                echo '    <p class="card-text">Tahun: ' . $row['tahun'] . '</p>';
                echo '    <p class="card-text">Harga: Rp ' . number_format($row['harga'], 2, ',', '.') . '/hari</p>';
                echo '    <img src="uploads/' . $row['foto'] . '" class="img-fluid" style="width: 200px;" alt="Foto Mobil">';
                echo '    <a href="sewa_mobil.php?nopol=' . $row['nopol'] . '" class="btn btn-primary mt-3">Sewa Sekarang</a>';
                echo '  </div>';
                echo '</div>';
            }
        } else {
            echo '<div class="alert alert-warning" role="alert">Tidak ada mobil yang tersedia saat ini.</div>';
        }
        ?>

        <div class="text-center mt-4">
            <a href="member_dashboard.php" class="btn btn-secondary">Kembali ke Dashboard</a>
        </div>
    </div>

    <!-- Tambahkan link Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
</body>
</html>

<?php
$conn->close();
?>
