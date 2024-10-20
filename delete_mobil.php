<?php
// Connect to the database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "rental";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Delete car by nopol
$nopol = $_GET['nopol'];
$sql = "DELETE FROM tbl_mobil WHERE nopol='$nopol'";

if ($conn->query($sql) === TRUE) {
    echo "Mobil berhasil dihapus!";
    header("Location: display_mobil.php");
    exit();
} else {
    echo "Error deleting record: " . $conn->error;
}

$conn->close();
?>
