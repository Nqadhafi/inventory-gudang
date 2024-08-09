<?php
include './config.php';

// Logika untuk menghapus barang
if (isset($_GET['idbrg'])) {
    $idbrg = $_GET['idbrg'];

    // Cek apakah ada transaksi terkait di tabel barang_keluar
    $sqlCheck = "SELECT COUNT(*) FROM barang_keluar WHERE idbrg = ?";
    $stmtCheck = $pdo->prepare($sqlCheck);
    $stmtCheck->execute([$idbrg]);
    $count = $stmtCheck->fetchColumn();

    if ($count > 0) {
        // Jika ada transaksi terkait, beri pesan error
        header('Location: ./?pages=barang&error=' . urlencode("Tidak dapat menghapus barang, karena masih ada transaksi terkait."));
        exit;
    } else {
        // Jika tidak ada transaksi terkait, hapus barang
        $sqlDelete = "DELETE FROM barang WHERE idbrg = ?";
        $stmtDelete = $pdo->prepare($sqlDelete);

        if ($stmtDelete->execute([$idbrg])) {
            // Redirect dengan pesan sukses
            header('Location: ./?pages=barang&success=' . urlencode("Barang berhasil dihapus."));
            exit;
        } else {
            // Redirect dengan pesan error jika gagal menghapus
            header('Location: ./?pages=barang&error=' . urlencode("Gagal menghapus barang."));
            exit;
        }
    }
}

// Mengambil semua barang
$sql = "SELECT * FROM barang";
$barangs = $pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Barang</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h1>Data Barang</h1>

        <!-- Pesan sukses atau error -->
        <?php if (isset($_GET['success'])): ?>
            <div class="alert alert-success" role="alert">
                <?php echo htmlspecialchars($_GET['success']); ?>
            </div>
        <?php endif; ?>

        <?php if (isset($_GET['error'])): ?>
            <div class="alert alert-danger" role="alert">
                <?php echo htmlspecialchars($_GET['error']); ?>
            </div>
        <?php endif; ?>

        <a href="?tambah=barang" class="btn btn-primary mb-3">Tambah Barang</a>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID Barang</th>
                    <th>Nama Barang</th>
                    <th>Stok</th>
                    <th>Stock Awal</th>
                    <th>Rata-rata</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($barangs as $barang): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($barang['idbrg']); ?></td>
                        <td><?php echo htmlspecialchars($barang['namabrg']); ?></td>
                        <td><?php echo htmlspecialchars($barang['stok']); ?></td>
                        <td><?php echo htmlspecialchars($barang['stock_awal']); ?></td>
                        <td><?php echo htmlspecialchars($barang['rata_rata']); ?></td>
                        <td>
                            <a href="./index.php?edit=<?php echo htmlspecialchars($barang['idbrg']); ?>" class="btn btn-warning">Edit</a>
                            <a href="./?pages=barang&idbrg=<?php echo htmlspecialchars($barang['idbrg']); ?>" class="btn btn-danger" onclick="return confirm('Yakin ingin menghapus?');">Hapus</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
