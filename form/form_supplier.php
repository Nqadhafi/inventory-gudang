<?php
include './config.php';

if (isset($_GET['deletesup'])) {
    $idsupplier = $_GET['deletesup'];

    // Cek apakah supplier memiliki data terkait di tabel lain
    $checkSql = "SELECT COUNT(*) FROM barang_masuk WHERE idsupplier = ?";
    $stmt = $pdo->prepare($checkSql);
    $stmt->execute([$idsupplier]);
    $count = $stmt->fetchColumn();

    if ($count > 0) {
        // Jika ada referensi, jangan hapus dan beri pesan
        $error_message = "Supplier tidak dapat dihapus karena memiliki data barang masuk yang terkait.";
    } else {
        // Jika tidak ada referensi, lakukan penghapusan
        $sql = "DELETE FROM supplier WHERE idsupplier = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$idsupplier]);

        $success_message = "Supplier berhasil dihapus.";
        header('Location: ./?pages=supplier&success=' . urlencode($success_message)); // Redirect setelah menghapus
        exit;
    }
}

// Mengambil semua supplier
$sql = "SELECT * FROM supplier";
$suppliers = $pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Supplier</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h1>Data Supplier</h1>
        
        <?php if (isset($error_message)): ?>
            <div class="alert alert-danger" role="alert">
                <?php echo htmlspecialchars($error_message); ?>
            </div>
        <?php endif; ?>

        <?php if (isset($_GET['success'])): ?>
            <div class="alert alert-success" role="alert">
                <?php echo htmlspecialchars($_GET['success']); ?>
            </div>
        <?php endif; ?>

        <a href="./?tambah=supplier" class="btn btn-primary mb-3">Tambah Supplier</a>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID Supplier</th>
                    <th>Nama Supplier</th>
                    <th>No HP</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($suppliers as $supplier): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($supplier['idsupplier']); ?></td>
                        <td><?php echo htmlspecialchars($supplier['nama_supp']); ?></td>
                        <td><?php echo htmlspecialchars($supplier['nohp']); ?></td>
                        <td>
                            <a href="./?supplier=<?php echo $supplier['idsupplier']; ?>" class="btn btn-warning">Edit</a>
                            <a href="./?pages=supplier&deletesup=<?php echo $supplier['idsupplier']; ?>" class="btn btn-danger" onclick="return confirm('Yakin ingin menghapus?');">Hapus</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <a href="./form/laporan_supplier.php" class="btn btn-success mb-3" target="_blank">Unduh Laporan PDF</a>
    </div>
</body>
</html>
