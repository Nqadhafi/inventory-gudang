<?php
include './config.php';

// Logika untuk menghapus barang masuk
if (isset($_GET['idmasuk'])) {
    $idmasuk = $_GET['idmasuk'];

    // Ambil informasi barang masuk sebelum dihapus
    $sql = "SELECT * FROM barang_masuk WHERE idmasuk = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$idmasuk]);
    $barangMasuk = $stmt->fetch(PDO::FETCH_ASSOC);

    // Cek apakah data barang masuk ditemukan
    if ($barangMasuk) {
        // Hapus barang masuk
        $sqlDelete = "DELETE FROM barang_masuk WHERE idmasuk = ?";
        $stmtDelete = $pdo->prepare($sqlDelete);
        $stmtDelete->execute([$idmasuk]);

        // Update stok barang
        $sqlUpdate = "UPDATE barang SET stok = stok - ? WHERE idbrg = ?";
        $stmtUpdate = $pdo->prepare($sqlUpdate);
        $stmtUpdate->execute([$barangMasuk['jumlah'], $barangMasuk['idbrg']]);

        // Redirect dengan pesan sukses
        header('Location: ./?pages=input&success=' . urlencode("Barang masuk berhasil dihapus."));
        exit;
    } else {
        // Redirect dengan pesan error jika data tidak ditemukan
        header('Location: ./?pages=input&error=' . urlencode("Data barang masuk tidak ditemukan."));
        exit;
    }
}

// Mengambil semua barang masuk
$sql = "SELECT bm.*, b.namabrg, s.nama_supp FROM barang_masuk bm JOIN barang b ON bm.idbrg = b.idbrg JOIN supplier s ON bm.idsupplier = s.idsupplier";
$barang_masuk = $pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Barang Masuk</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h1>Data Barang Masuk</h1>
        
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

        <a href="./?tambah=input" class="btn btn-primary mb-3">Tambah Barang Masuk</a>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID Masuk</th>
                    <th>Barang</th>
                    <th>Supplier</th>
                    <th>Jabatan</th>
                    <th>Tanggal</th>
                    <th>Jumlah</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($barang_masuk as $masuk): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($masuk['idmasuk']); ?></td>
                        <td><?php echo htmlspecialchars($masuk['namabrg']); ?></td>
                        <td><?php echo htmlspecialchars($masuk['nama_supp']); ?></td>
                        <td><?php echo htmlspecialchars($masuk['jabatan']); ?></td>
                        <td><?php echo htmlspecialchars($masuk['tgl']); ?></td>
                        <td><?php echo htmlspecialchars($masuk['jumlah']); ?></td>
                        <td>
                            <a href="./?pages=input&idmasuk=<?php echo $masuk['idmasuk']; ?>" class="btn btn-danger" onclick="return confirm('Yakin ingin menghapus?');">Hapus</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <a href="./form/laporan_masuk.php" class="btn btn-success mb-3">Unduh Laporan PDF</a>
    </div>
</body>
</html>
