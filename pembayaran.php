<?php
include 'db.php'; // Memasukkan koneksi database
session_start();

// Ambil semua ID transaksi dari database untuk dropdown
$sql_transaksi = "SELECT id_transaksi FROM tbl_transaksi";
$result_transaksi = $conn->query($sql_transaksi);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Pembayaran</title>
    <script>
        function ambilDetailPembayaran() {
            var idTransaksi = document.getElementById('id_transaksi').value;
            if (idTransaksi) {
                // Menggunakan AJAX untuk mengambil detail pembayaran
                var xhr = new XMLHttpRequest();
                xhr.open('GET', 'ambil_detail_pembayaran.php?id_transaksi=' + idTransaksi, true);
                xhr.onload = function () {
                    if (this.status === 200) {
                        var response = JSON.parse(this.responseText);
                        document.getElementById('total_bayar').innerText = response.total; // Total diambil dari kekurangan
                        document.getElementById('denda').innerText = response.denda;
                        document.getElementById('table_detail').style.display = 'table';
                    }
                };
                xhr.send();
            } else {
                document.getElementById('total_bayar').innerText = '';
                document.getElementById('denda').innerText = '';
                document.getElementById('table_detail').style.display = 'none';
            }
        }
    </script>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 10px;
            text-align: left;
        }
    </style>
</head>
<body>
    <form action="proses_pembayaran.php" method="post">
        <h2>Pembayaran</h2>
        
        <label for="id_transaksi">ID Transaksi:</label>
        <select id="id_transaksi" name="id_transaksi" required onchange="ambilDetailPembayaran()">
            <option value="">Pilih ID Transaksi</option>
            <?php while ($row = $result_transaksi->fetch_assoc()) : ?>
                <option value="<?php echo $row['id_transaksi']; ?>"><?php echo $row['id_transaksi']; ?></option>
            <?php endwhile; ?>
        </select><br>

        <h3>Detail Pembayaran</h3>
        <table id="table_detail" style="display:none;">
            <tr>
                <th>Total Bayar</th>
                <th>Denda</th>
            </tr>
            <tr>
                <td id="total_bayar"></td> <!-- Total bayar diambil dari kekurangan -->
                <td id="denda"></td>
            </tr>
        </table>

        <label for="status_bayar">Status Pembayaran:</label>
        <select id="status_bayar" name="status_bayar">
            <option value="belum lunas">Belum Lunas</option>
            <option value="lunas">Lunas</option>
        </select><br>

        <input type="submit" value="Bayar">
    </form>
</body>
</html>
