<?php
include 'db.php'; // Memasukkan koneksi database
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Mengambil data dari form
    $nik = $_SESSION['nik'];
    $nopol = $_POST['nopol'];
    $tgl_ambil = $_POST['tgl_ambil'];
    $tgl_kembali = $_POST['tgl_kembali'];
    $supir = $_POST['supir'];
    $downpayment = $_POST['downpayment']; // Diisi oleh pengguna

    // Mengambil harga mobil dari database berdasarkan nopol
    $sql_harga = "SELECT harga FROM tbl_mobil WHERE nopol = '$nopol'";
    $result_harga = $conn->query($sql_harga);

    if ($result_harga->num_rows > 0) {
        $data_harga = $result_harga->fetch_assoc();
        $harga_per_hari = $data_harga['harga'];

        // Menghitung durasi sewa dalam hari
        $tgl_ambil_date = new DateTime($tgl_ambil);
        $tgl_kembali_date = new DateTime($tgl_kembali);
        $durasi_sewa = $tgl_kembali_date->diff($tgl_ambil_date)->days;

        // Menghitung total sewa
        $total = $harga_per_hari * $durasi_sewa;

        // Menghitung kekurangan
        $kekurangan = $total - $downpayment; // Kekurangan

        // Menyimpan data ke database
        $sql = "INSERT INTO tbl_transaksi (nik, nopol, tgl_booking, tgl_ambil, tgl_kembali, supir, total, downpayment, kekurangan, status) VALUES ('$nik', '$nopol', NOW(), '$tgl_ambil', '$tgl_kembali', '$supir', '$total', '$downpayment', '$kekurangan', 'booking')";

        if ($conn->query($sql) === TRUE) {
            echo "Reservasi berhasil! Silakan lanjutkan pembayaran.";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    } else {
        echo "Mobil dengan nomor polisi $nopol tidak ditemukan.";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Reservasi Mobil</title>
    <script>
        function ambilHarga() {
            var nopol = document.getElementById('nopol').value;
            if (nopol) {
                // Menggunakan AJAX untuk mengambil harga mobil
                var xhr = new XMLHttpRequest();
                xhr.open('GET', 'ambil_harga_mobil.php?nopol=' + nopol, true);
                xhr.onload = function () {
                    if (this.status === 200) {
                        var response = JSON.parse(this.responseText);
                        document.getElementById('total').value = response.harga_per_hari;
                    }
                };
                xhr.send();
            } else {
                document.getElementById('total').value = '';
            }
        }
    </script>
</head>
<body>
    <form action="" method="post">
        <h2>Reservasi Mobil</h2>
        <label for="nopol">No. Polisi Mobil:</label>
        <input type="text" id="nopol" name="nopol" required maxlength="10" onchange="ambilHarga()"><br>

        <label for="tgl_ambil">Tanggal Ambil:</label>
        <input type="date" id="tgl_ambil" name="tgl_ambil" required><br>

        <label for="tgl_kembali">Tanggal Kembali:</label>
        <input type="date" id="tgl_kembali" name="tgl_kembali" required><br>

        <label for="supir">Apakah Butuh Supir?</label>
        <select id="supir" name="supir">
            <option value="0">Tidak</option>
            <option value="1">Ya</option>
        </select><br>

        <label for="total">Total Sewa:</label>
        <input type="text" id="total" name="total" value="<?php echo isset($total) ? $total : ''; ?>" readonly><br>

        <label for="downpayment">Uang Muka:</label>
        <input type="number" id="downpayment" name="downpayment" required step="0.01"><br>

        <input type="submit" value="Reservasi">
    </form>
</body>
</html>
