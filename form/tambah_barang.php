<?php
include './config.php';

// Menyimpan Barang Baru
if (isset($_POST['add_barang'])) {
    $namabrg = $_POST['namabrg'];
    $stok = $_POST['stok'];
    $stock_awal = $_POST['stock_awal'];
    $rata_rata = $_POST['rata_rata'];

    $sql = "INSERT INTO barang (namabrg, stok, stock_awal, rata_rata) VALUES (?, ?, ?, ?)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$namabrg, $stok, $stock_awal, $rata_rata]);

    header('Location: ./index.php?pages=barang');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Input Barang</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h1>Input Barang</h1>

        <form method="POST">
            <div class="form-group">
                <label for="namabrg">Nama Barang</label>
                <input type="text" name="namabrg" class="form-control" id="namabrg" required>
            </div>
            <div class="form-group">
                <label for="stok">Stok</label>
                <input type="number" name="stok" class="form-control" id="stok" required>
            </div>
            <div class="form-group">
                <label for="stock_awal">Stock Awal</label>
                <input type="number" name="stock_awal" class="form-control" id="stock_awal" required>
            </div>
            <div class="form-group">
                <label for="rata_rata">Rata-rata</label>
                <input type="number" name="rata_rata" class="form-control" id="rata_rata" step="0.01" required>
            </div>
            <button type="submit" name="add_barang" class="btn btn-primary">Tambah Barang</button>
            <a href="./index.php?pages=barang" class="btn btn-secondary">Kembali</a>
        </form>
    </div>
</body>
</html>
