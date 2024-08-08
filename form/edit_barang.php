<?php
include './config.php';

// Mendapatkan ID barang dari query string
$idbrg = $_GET['edit'] ?? null;

// Jika ID tidak ada, redirect atau tampilkan error
if (!$idbrg) {
    header('Location: ./index.php');
    exit;
}

// Mendapatkan data barang untuk ditampilkan di form
$sql = "SELECT * FROM barang WHERE idbrg = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$idbrg]);
$barang = $stmt->fetch(PDO::FETCH_ASSOC);

// Jika barang tidak ditemukan, redirect
if (!$barang) {
    header('Location: index.php');
    exit;
}

// Mengupdate Barang
if (isset($_POST['update_barang'])) {
    $namabrg = $_POST['namabrg'];
    $stok = $_POST['stok'];
    $stock_awal = $_POST['stock_awal'];
    $rata_rata = $_POST['rata_rata'];

    $sql = "UPDATE barang SET namabrg=?, stok=?, stock_awal=?, rata_rata=? WHERE idbrg=?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$namabrg, $stok, $stock_awal, $rata_rata, $idbrg]);

    header('Location: ./?pages=barang');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Barang</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h1>Edit Barang</h1>

        <form method="POST">
            <input type="hidden" name="idbrg" value="<?php echo $barang['idbrg']; ?>">
            <div class="form-group">
                <label for="namabrg">Nama Barang</label>
                <input type="text" name="namabrg" class="form-control" id="namabrg" value="<?php echo $barang['namabrg']; ?>" required>
            </div>
            <div class="form-group">
                <label for="stok">Stok</label>
                <input type="number" name="stok" class="form-control" id="stok" value="<?php echo $barang['stok']; ?>" required>
            </div>
            <div class="form-group">
                <label for="stock_awal">Stock Awal</label>
                <input type="number" name="stock_awal" class="form-control" id="stock_awal" value="<?php echo $barang['stock_awal']; ?>" required>
            </div>
            <div class="form-group">
                <label for="rata_rata">Rata-rata</label>
                <input type="number" name="rata_rata" class="form-control" id="rata_rata" value="<?php echo $barang['rata_rata']; ?>" step="0.01" required>
            </div>
            <button type="submit" name="update_barang" class="btn btn-primary">Update Barang</button>
            <a href="./?pages=barang" class="btn btn-secondary">Kembali</a>
        </form>
    </div>
</body>
</html>
