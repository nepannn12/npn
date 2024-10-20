<?php
// Mulai sesi
session_start();

// Cek apakah pengguna sudah login
if (!isset($_SESSION['nik'])) {
    header("Location: login.php");
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

// Proses form jika disubmit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama = $_POST['nama'];
    $jk = $_POST['jk'];
    $alamat = $_POST['alamat'];
    $user = $_POST['user'];
    $no_hp = $_POST['no_hp'];

    // Update data anggota di database
    $sql_update = "UPDATE tbl_member SET nama='$nama', jk='$jk', alamat='$alamat', user='$user', no_hp='$no_hp' WHERE nik='$nik'";

    if ($conn->query($sql_update) === TRUE) {
        echo "Informasi berhasil diperbarui!";
        // Redirect kembali ke dashboard
        header("Location: member_dashboard.php");
        exit();
    } else {
        echo "Error: " . $sql_update . "<br>" . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perbarui Informasi Anggota</title>
    <!-- Tambahkan link Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2 class="text-center">Perbarui Informasi Anggota</h2>
        <form action="update_member.php" method="POST">
            <div class="mb-3">
                <label for="nama" class="form-label">Nama</label>
                <input type="text" class="form-control" id="nama" name="nama" value="<?php echo $member['nama']; ?>" required>
            </div>
            <div class="mb-3">
                <label for="jk" class="form-label">Jenis Kelamin</label>
                <select class="form-select" id="jk" name="jk" required>
                    <option value="L" <?php echo $member['jk'] == 'L' ? 'selected' : ''; ?>>Laki-laki</option>
                    <option value="P" <?php echo $member['jk'] == 'P' ? 'selected' : ''; ?>>Perempuan</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="alamat" class="form-label">Alamat</label>
                <textarea class="form-control" id="alamat" name="alamat" required><?php echo $member['alamat']; ?></textarea>
            </div>
            <div class="mb-3">
                <label for="user" class="form-label">Username</label>
                <input type="text" class="form-control" id="user" name="user" value="<?php echo $member['user']; ?>" required>
            </div>
            <div class="mb-3">
                <label for="no_hp" class="form-label">Nomor Telepon</label>
                <input type="text" class="form-control" id="no_hp" name="no_hp" value="<?php echo $member['no_hp']; ?>" required>
            </div>
            <button type="submit" class="btn btn-primary">Perbarui</button>
            <a href="member_dashboard.php" class="btn btn-secondary">Kembali</a>
        </form>
    </div>

    <!-- Tambahkan link Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
</body>
</html>

<?php
$conn->close();
?>
