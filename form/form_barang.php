<?php
include './config.php';

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
                        <td><?php echo $barang['idbrg']; ?></td>
                        <td><?php echo $barang['namabrg']; ?></td>
                        <td><?php echo $barang['stok']; ?></td>
                        <td><?php echo $barang['stock_awal']; ?></td>
                        <td><?php echo $barang['rata_rata']; ?></td>
                        <td>
                            <a href="index.php?edit=<?php echo $barang['idbrg']; ?>" class="btn btn-warning">Edit</a>
                            <a href="delete_barang.php?idbrg=<?php echo $barang['idbrg']; ?>" class="btn btn-danger" onclick="return confirm('Yakin ingin menghapus?');">Hapus</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
