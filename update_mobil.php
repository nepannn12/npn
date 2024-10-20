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

// Periksa jika nopol telah diberikan
if (isset($_GET['nopol'])) {
    $nopol = $_GET['nopol'];
    // Query untuk mendapatkan data mobil berdasarkan nopol
    $sql = "SELECT * FROM tbl_mobil WHERE nopol='$nopol'";
    $result = $conn->query($sql);

    // Jika data mobil ditemukan
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
    } else {
        die("Mobil tidak ditemukan.");
    }
} else {
    die("Nopol tidak ditentukan.");
}

// Periksa jika form telah disubmit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $brand = $_POST['brand'];
    $type = $_POST['type'];
    $tahun = $_POST['tahun'];
    $harga = $_POST['harga'];
    $status = $_POST['status'];

    // Handle file upload jika ada foto baru
    $foto = $row['foto']; // Menggunakan foto lama jika tidak ada upload baru
    if (!empty($_FILES["foto"]["name"])) {
        $target_dir = "uploads/";
        $target_file = $target_dir . basename($_FILES["foto"]["name"]);
        $foto = basename($_FILES["foto"]["name"]);

        // Cek apakah file adalah gambar
        $check = getimagesize($_FILES["foto"]["tmp_name"]);
        if ($check === false) {
            die("File bukan gambar.");
        }

        // Pindahkan file gambar ke direktori uploads
        if (!move_uploaded_file($_FILES["foto"]["tmp_name"], $target_file)) {
            die("Maaf, gagal mengupload gambar.");
        }
    }

    // Update data mobil di database
    $sql = "UPDATE tbl_mobil SET brand='$brand', type='$type', tahun='$tahun', harga='$harga', foto='$foto', status='$status' WHERE nopol='$nopol'";
    
    if ($conn->query($sql) === TRUE) {
        // Redirect ke display_mobil.php setelah update berhasil
        header("Location: display_mobil.php");
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Mobil</title>
</head>
<body>
    <h2>Edit Mobil</h2>
    <form action="update_mobil.php?nopol=<?php echo urlencode($nopol); ?>" method="POST" enctype="multipart/form-data">
        <label for="brand">Brand:</label><br>
        <input type="text" id="brand" name="brand" value="<?php echo htmlspecialchars($row['brand']); ?>" required><br><br>

        <label for="type">Type:</label><br>
        <input type="text" id="type" name="type" value="<?php echo htmlspecialchars($row['type']); ?>" required><br><br>

        <label for="tahun">Tahun:</label><br>
        <input type="text" id="tahun" name="tahun" value="<?php echo htmlspecialchars($row['tahun']); ?>" required><br><br>

        <label for="harga">Harga:</label><br>
        <input type="text" id="harga" name="harga" value="<?php echo htmlspecialchars($row['harga']); ?>" required><br><br>

        <label for="foto">Foto (kosongkan jika tidak ingin mengganti):</label><br>
        <input type="file" id="foto" name="foto"><br><br>

        <label for="status">Status:</label><br>
        <select id="status" name="status">
            <option value="tersedia" <?php if ($row['status'] == 'tersedia') echo 'selected'; ?>>Tersedia</option>
            <option value="tidak" <?php if ($row['status'] == 'tidak') echo 'selected'; ?>>Tidak Tersedia</option>
        </select><br><br>

        <input type="submit" value="Update Mobil">
    </form>
</body>
</html>

<?php
$conn->close();
?>
