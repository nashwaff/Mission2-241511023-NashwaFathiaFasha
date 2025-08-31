<?php
$host = "localhost";
$username = "root"; 
$password = "";     
$database = "akademik_db";

$conn = mysqli_connect($host, $username, $password, $database);

if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

//Delete
if (isset($_GET['delete_nim'])) {
    $nim_to_delete = mysqli_real_escape_string($conn, $_GET['delete_nim']);
    $sql_delete = "DELETE FROM mahasiswa WHERE nim = '$nim_to_delete'";
    if (mysqli_query($conn, $sql_delete)) {
        header("Location: index.php");
        exit();
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}

//Searching
$sql = "SELECT nim, nama, umur FROM mahasiswa";
if (isset($_GET['search_query']) && !empty($_GET['search_query'])) {
    $search_query = mysqli_real_escape_string($conn, $_GET['search_query']);
    $sql .= " WHERE nama LIKE '%$search_query%' OR nim LIKE '%$search_query%'";
}
$sql .= " ORDER BY nim ASC";

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Daftar Mahasiswa</title>
    <style>
        form {
            margin-bottom: 15px; /* kasih jarak antara search dan tabel */
        }
        table {
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid black;
            padding: 5px;
        }
    </style>
</head>
<body>
    <h2>Daftar Mahasiswa</h2>

    <form action="" method="get">
        <input type="text" name="search_query" placeholder="Cari nama atau NIM..." 
               value="<?= htmlspecialchars($_GET['search_query'] ?? '') ?>">
        <button type="submit">Cari</button>
    </form>
    
    <?php if ($result->num_rows > 0): ?>
        <table>
            <thead>
                <tr>
                    <th>NIM</th>
                    <th>Nama</th>
                    <th>Umur</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php while($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?= htmlspecialchars($row["nim"]); ?></td>
                        <td><?= htmlspecialchars($row["nama"]); ?></td>
                        <td><?= htmlspecialchars($row["umur"]); ?></td>
                        <td>
                            <a href="detail_mahasiswa.php?nim=<?= urlencode($row["nim"]) ?>">View Detail</a> | 
                            <a href="?delete_nim=<?= urlencode($row["nim"]) ?>" 
                               onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?');">Hapus</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>Tidak ada data mahasiswa.</p>
    <?php endif; ?>
</body>
</html>

<?php
$conn->close();
?>