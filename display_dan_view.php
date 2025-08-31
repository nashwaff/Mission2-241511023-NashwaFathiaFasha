<?php
//Konfigurasi koneksi
$host = "localhost";
$username = "root"; //ganti jika user MySQL berbeda
$password = "";     //ganti jika ada password
$database = "akademik_db";

//Membuat koneksi
$conn = mysqli_connect($host, $username, $password, $database);

//Cek koneksi
if (!$conn) {
    die("Koneksi gagal: " . $conn->connect_error);  
}

//Query ambil semua data mahasiswa
$sql = "SELECT nim, nama, umur FROM mahasiswa ORDER BY nim ASC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Daftar Mahasiswa</title>
</head>
<body>
    <h2>Daftar Mahasiswa</h2>

    <?php if ($result->num_rows > 0): ?>
        <table border="1" cellpadding="5" cellspacing="0">
            <tr>
                <th>NIM</th>
                <th>Nama</th>
                <th>Umur</th>
                <th>Aksi</th>
            </tr>
            <?php while($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $row["nim"]; ?></td>
                    <td><?php echo $row["nama"]; ?></td>
                    <td><?php echo $row["umur"]; ?></td>
                    <td>
                        <a href="detail_mahasiswa.php?nim=<?= urlencode($row["nim"]) ?>">View Detail</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </table>
    <?php else: ?>
        <p>Tidak ada data mahasiswa.</p>
    <?php endif; ?>

</body>
</html>
<?php
$conn->close();
?>