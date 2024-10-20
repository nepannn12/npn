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

// Ambil data member berdasarkan NIK dari sesi
$nik = $_SESSION['nik'];
$sql = "SELECT * FROM tbl_member WHERE nik = '$nik'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Ambil data member
    $member = $result->fetch_assoc();
} else {
    echo "Data tidak ditemukan.";
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Member Dashboard</title>
    <!-- Tambahkan link Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .sidebar {
            height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            z-index: 100;
            padding-top: 20px;
        }
    </style>
</head>
<body>
    <div class="sidebar bg-light">
        <h4 class="text-center">Member Dashboard</h4>
        <ul class="nav flex-column">
            <li class="nav-item">
                <a class="nav-link active" href="member_dashboard.php">Home</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="display_mobil_member.php">Daftar Mobil</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="transaksi.php">Transaksi Rental</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="profil_member.php">Profil Saya</a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-danger" href="logout.php">Keluar</a>
            </li>
        </ul>
    </div>

    <div class="container mt-5" style="margin-left: 200px;">
        <h2 class="text-center">Selamat Datang, <?php echo $member['nama']; ?></h2>
        
    </div>

    <!-- Tambahkan link Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
</body>
</html>

<?php
$conn->close();
?>
