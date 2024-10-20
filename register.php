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

// Proses form jika disubmit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nik = $_POST['nik'];
    $nama = $_POST['nama'];
    $jk = $_POST['jk'];
    $alamat = $_POST['alamat'];
    $user = $_POST['user'];
    $no_hp = $_POST['no_hp'];
    $pass = password_hash($_POST['pass'], PASSWORD_DEFAULT); // Meng-hash password

    // Validasi NIK
    if (strlen($nik) > 10) {
        echo "NIK tidak boleh lebih dari 10 karakter.";
        exit();
    }

    // Menyimpan data anggota ke database
    $sql = "INSERT INTO tbl_member (nik, nama, jk, alamat, user, no_hp, pass) 
            VALUES ('$nik', '$nama', '$jk', '$alamat', '$user', '$no_hp', '$pass')";

    if ($conn->query($sql) === TRUE) {
        echo "Pendaftaran berhasil! Silakan <a href='login.php'>masuk</a>.";
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
    <title>Registrasi Anggota</title>
</head>
<body>
    <h2>Form Registrasi Anggota</h2>
    <form action="register.php" method="POST">
        <label for="nik">NIK:</label><br>
        <input type="text" id="nik" name="nik" maxlength="10" required><br><br>

        <label for="nama">Nama:</label><br>
        <input type="text" id="nama" name="nama" required><br><br>

        <label for="jk">Jenis Kelamin:</label><br>
        <select id="jk" name="jk" required>
            <option value="L">Laki-laki</option>
            <option value="P">Perempuan</option>
        </select><br><br>

        <label for="alamat">Alamat:</label><br>
        <textarea id="alamat" name="alamat" required></textarea><br><br>

        <label for="user">Username:</label><br>
        <input type="text" id="user" name="user" required><br><br>

        <label for="no_hp">Nomor Telepon:</label><br>
        <input type="text" id="no_hp" name="no_hp" required><br><br>

        <label for="pass">Password:</label><br>
        <input type="password" id="pass" name="pass" required><br><br>

        <input type="submit" value="Daftar">
    </form>
</body>
</html>

<?php
$conn->close();
?>
