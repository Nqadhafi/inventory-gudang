<?php
include './config.php';

// Logika untuk menghapus barang keluar
if (isset($_GET['idkeluar'])) {
    $idkeluar = $_GET['idkeluar'];

    // Ambil informasi barang keluar sebelum dihapus
    $sql = "SELECT * FROM barang_keluar WHERE idkeluar = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$idkeluar]);
    $barangKeluar = $stmt->fetch(PDO::FETCH_ASSOC);

    // Cek apakah data barang keluar ditemukan
    if ($barangKeluar) {
        // Hapus barang keluar
        $sqlDelete = "DELETE FROM barang_keluar WHERE idkeluar = ?";
        $stmtDelete = $pdo->prepare($sqlDelete);
        $stmtDelete->execute([$idkeluar]);

        // Update stok barang
        $sqlUpdate = "UPDATE barang SET stok = stok + ? WHERE idbrg = ?";
        $stmtUpdate = $pdo->prepare($sqlUpdate);
        $stmtUpdate->execute([$barangKeluar['jumlah'], $barangKeluar['idbrg']]);

        // Redirect dengan pesan sukses
        header('Location: ./?pages=output&success=' . urlencode("Barang keluar berhasil dihapus."));
        exit;
    } else {
        // Redirect dengan pesan error jika data tidak ditemukan
        header('Location: ./?pages=output&error=' . urlencode("Data barang keluar tidak ditemukan."));
        exit;
    }
}

// Mengambil semua barang keluar
$sql = "SELECT bk.*, b.namabrg FROM barang_keluar bk JOIN barang b ON bk.idbrg = b.idbrg";
$barang_keluar = $pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Barang Keluar</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h1>Data Barang Keluar</h1>
        
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

        <a href="./?tambah=output" class="btn btn-primary mb-3">Tambah Barang Keluar</a>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID Keluar</th>
                    <th>Barang</th>
                    <th>Tanggal</th>
                    <th>Jumlah</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($barang_keluar as $keluar): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($keluar['idkeluar']); ?></td>
                        <td><?php echo htmlspecialchars($keluar['namabrg']); ?></td>
                        <td><?php echo htmlspecialchars($keluar['tgl']); ?></td>
                        <td><?php echo htmlspecialchars($keluar['jumlah']); ?></td>
                        <td>
                            <a href="./?pages=output&idkeluar=<?php echo $keluar['idkeluar']; ?>" class="btn btn-danger" onclick="return confirm('Yakin ingin menghapus?');">Hapus</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <a href="./form/laporan_keluar.php" class="btn btn-success mb-3" target="_blank">Unduh Laporan PDF</a>
    </div>
</body>
</html>
