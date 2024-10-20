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

// Proses login jika disubmit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user = $_POST['user'];
    $pass = $_POST['pass'];

    // Mencari pengguna di tbl_user
    $sql_user = "SELECT * FROM tb_user WHERE user = '$user'";
    $result_user = $conn->query($sql_user);

    // Jika ditemukan di tbl_user
    if ($result_user->num_rows > 0) {
        $row_user = $result_user->fetch_assoc();
        // Memeriksa password
        if (password_verify($pass, $row_user['pass'])) {
            // Login berhasil, simpan informasi pengguna dalam session
            session_start();
            $_SESSION['user'] = $user;
            $_SESSION['lvl'] = $row_user['lvl'];

            // Arahkan ke halaman yang sesuai berdasarkan level
            switch ($row_user['lvl']) {
                case 'admin':
                    header("Location: admin_dashboard.php");
                    break;
                case 'petugas':
                    header("Location: petugas_dashboard.php");
                    break;
            }
            exit();
        } else {
            echo "Password salah.";
        }
    } else {
        // Jika tidak ditemukan di tbl_user, coba di tbl_member
        $sql_member = "SELECT * FROM tb_member WHERE user = '$user'";
        $result_member = $conn->query($sql_member);

        if ($result_member->num_rows > 0) {
            $row_member = $result_member->fetch_assoc();
            // Memeriksa password
            if (password_verify($pass, $row_member['pass'])) {
                // Login berhasil, simpan informasi pengguna dalam session
                session_start();
                $_SESSION['user'] = $row_member['user'];
                $_SESSION['nik'] = $row_member['nik'];
                $_SESSION['lvl'] = 'member';  // Set level ke member

                // Arahkan ke member dashboard
                header("Location: member_dashboard.php");
                exit();
            } else {
                echo "Password salah untuk member.";
            }
        } else {
            echo "Pengguna tidak ditemukan.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>
<body>
    <h2>Form Login</h2>
    <form action="login.php" method="POST">
        <label for="user">Username:</label><br>
        <input type="text" id="user" name="user" required><br><br>

        <label for="pass">Password:</label><br>
        <input type="password" id="pass" name="pass" required><br><br>

        <input type="submit" value="Login">
    </form>
</body>
</html>

<?php
$conn->close();
?>
