<?php
include './config.php';

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
                        <td><?php echo $keluar['idkeluar']; ?></td>
                        <td><?php echo $keluar['namabrg']; ?></td>
                        <td><?php echo $keluar['tgl']; ?></td>
                        <td><?php echo $keluar['jumlah']; ?></td>
                        <td>
                            <a href="delete_barang_keluar.php?idkeluar=<?php echo $keluar['idkeluar']; ?>" class="btn btn-danger" onclick="return confirm('Yakin ingin menghapus?');">Hapus</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
