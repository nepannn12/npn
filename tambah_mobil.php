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

// Periksa apakah form disubmit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nopol = $_POST['nopol'];
    $brand = $_POST['brand'];
    $type = $_POST['type'];
    $tahun = $_POST['tahun'];
    $harga = $_POST['harga'];
    $status = $_POST['status'];
    
    // Handle file upload
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($_FILES["foto"]["name"]);
    $foto = basename($_FILES["foto"]["name"]);

    // Cek apakah file adalah gambar
    $check = getimagesize($_FILES["foto"]["tmp_name"]);
    if($check !== false) {
        // Cek apakah nopol sudah ada
        $check_nopol_sql = "SELECT * FROM tbl_mobil WHERE nopol='$nopol'";
        $check_nopol_result = $conn->query($check_nopol_sql);

        if ($check_nopol_result->num_rows > 0) {
            echo "Nomor Polisi sudah terdaftar. Silakan gunakan nomor lain.";
        } else {
            // Pindahkan file yang diupload
            if (move_uploaded_file($_FILES["foto"]["tmp_name"], $target_file)) {
                // Siapkan query SQL untuk menyisipkan data
                $sql = "INSERT INTO tbl_mobil (nopol, brand, type, tahun, harga, foto, status) 
                        VALUES ('$nopol', '$brand', '$type', '$tahun', '$harga', '$foto', '$status')";

                if ($conn->query($sql) === TRUE) {
                    // Jika insert berhasil, redirect ke halaman display
                    header("Location: display_mobil.php");
                    exit(); // Pastikan tidak ada kode lain yang dieksekusi setelah redirect
                } else {
                    echo "Error: " . $sql . "<br>" . $conn->error;
                }
            } else {
                echo "Maaf, mobil tidak bisa ditambahkan.";
            }
        }
    } else {
        echo "File bukan gambar.";
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Tambah Mobil</title>
</head>
<body>
    <h2>Tambah Mobil Baru</h2>
    <form action="tambah_mobil.php" method="POST" enctype="multipart/form-data">
        <label for="nopol">Nomor Polisi:</label><br>
        <input type="text" id="nopol" name="nopol" required><br><br>

        <label for="brand">Brand:</label><br>
        <input type="text" id="brand" name="brand" required><br><br>

        <label for="type">Type:</label><br>
        <input type="text" id="type" name="type" required><br><br>

        <label for="tahun">Tahun:</label><br>
        <input type="text" id="tahun" name="tahun" required><br><br>

        <label for="harga">Harga:</label><br>
        <input type="text" id="harga" name="harga" required><br><br>

        <label for="foto">Foto:</label><br>
        <input type="file" id="foto" name="foto" required><br><br>

        <label for="status">Status:</label><br>
        <select id="status" name="status">
            <option value="tersedia">Tersedia</option>
            <option value="tidak">Tidak Tersedia</option>
        </select><br><br>

        <input type="submit" value="Tambah Mobil">
    </form>
</body>
</html>
