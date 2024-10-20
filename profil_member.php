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
</head>
<body>
    <div class="container mt-5">
        <h2 class="text-center">Dashboard Anggota</h2>
        <div class="card">
            <div class="card-header">
                <h5><?php echo $member['nama']; ?> (NIK: <?php echo $member['nik']; ?>)</h5>
            </div>
            <div class="card-body">
                <p><strong>Jenis Kelamin:</strong> <?php echo $member['jk'] == 'L' ? 'Laki-laki' : 'Perempuan'; ?></p>
                <p><strong>Alamat:</strong> <?php echo $member['alamat']; ?></p>
                <p><strong>Nomor Telepon:</strong> <?php echo $member['no_hp']; ?></p>
                <p><strong>Username:</strong> <?php echo $member['user']; ?></p>
                <a href="update_member.php?nik=<?php echo $member['nik']; ?>" class="btn btn-primary">Perbarui Informasi</a>
                <a href="member_dashboard.php" class="btn btn-danger">Keluar</a>
            </div>
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
