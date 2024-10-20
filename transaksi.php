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

// Mendapatkan data nopol untuk dropdown
$sql_mobil = "SELECT nopol, brand FROM tbl_mobil WHERE status='tersedia'";
$result_mobil = $conn->query($sql_mobil);

// Mendapatkan data NIK untuk dropdown
$sql_member = "SELECT nik, nama FROM tbl_member";
$result_member = $conn->query($sql_member);

// Proses form jika disubmit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nik = $_POST['nik'];
    $nopol = $_POST['nopol'];
    $tgl_booking = $_POST['tgl_booking'];
    $tgl_ambil = $_POST['tgl_ambil'];
    $tgl_kembali = $_POST['tgl_kembali'];
    $supir = isset($_POST['supir']) ? 1 : 0;
    $total = $_POST['total'];
    $downpayment = $_POST['downpayment'];
    $kekurangan = $total - $downpayment;
    $status = 'booking'; // Status awal

    // Menyimpan data transaksi ke database
    $sql = "INSERT INTO tbl_transaksi (nik, nopol, tgl_booking, tgl_ambil, tgl_kembali, supir, total, downpayment, kekurangan, status) 
            VALUES ('$nik', '$nopol', '$tgl_booking', '$tgl_ambil', '$tgl_kembali', '$supir', '$total', '$downpayment', '$kekurangan', '$status')";

    if ($conn->query($sql) === TRUE) {
        // Redirect atau tampilkan pesan sukses
        echo "Transaksi berhasil dibuat!";
        // header("Location: display_transaksi.php"); // Redirect jika diperlukan
        // exit();
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
    <title>Form Transaksi</title>
</head>
<body>
    <h2>Form Transaksi Rental Mobil</h2>
    <form action="transaksi.php" method="POST">
        <label for="nik">NIK Anggota:</label><br>
        <select id="nik" name="nik" required>
            <option value="">Pilih Anggota</option>
            <?php
            if ($result_member->num_rows > 0) {
                while ($row = $result_member->fetch_assoc()) {
                    echo "<option value='" . htmlspecialchars($row['nik']) . "'>" . htmlspecialchars($row['nama']) . "</option>";
                }
            }
            ?>
        </select><br><br>

        <label for="nopol">Nomor Polisi Mobil:</label><br>
        <select id="nopol" name="nopol" required>
            <option value="">Pilih Mobil</option>
            <?php
            if ($result_mobil->num_rows > 0) {
                while ($row = $result_mobil->fetch_assoc()) {
                    echo "<option value='" . htmlspecialchars($row['nopol']) . "'>" . htmlspecialchars($row['nopol']) . " - " . htmlspecialchars($row['brand']) . "</option>";
                }
            }
            ?>
        </select><br><br>

        <label for="tgl_booking">Tanggal Booking:</label><br>
        <input type="date" id="tgl_booking" name="tgl_booking" required><br><br>

        <label for="tgl_ambil">Tanggal Ambil:</label><br>
        <input type="date" id="tgl_ambil" name="tgl_ambil" required><br><br>

        <label for="tgl_kembali">Tanggal Kembali:</label><br>
        <input type="date" id="tgl_kembali" name="tgl_kembali" required><br><br>

        <label for="supir">Dengan Supir:</label>
        <input type="checkbox" id="supir" name="supir" value="1"><br><br>

        <label for="total">Total:</label><br>
        <input type="number" id="total" name="total" step="0.01" required><br><br>

        <label for="downpayment">Downpayment:</label><br>
        <input type="number" id="downpayment" name="downpayment" step="0.01" required><br><br>

        <input type="submit" value="Buat Transaksi">
    </form>
</body>
</html>

<?php
$conn->close();
?>
