<?php
include './config.php';

// Menyimpan Barang Keluar Baru
if (isset($_POST['add_barang_keluar'])) {
    $idbrg = $_POST['idbrg'];
    $jumlah = $_POST['jumlah'];
    $tgl = $_POST['tgl'];

    $sql = "INSERT INTO barang_keluar (idbrg, jumlah, tgl) VALUES (?, ?, ?)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$idbrg, $jumlah, $tgl]);

    // Update stok barang
    $sql_update = "UPDATE barang SET stok = stok - ? WHERE idbrg = ?";
    $stmt_update = $pdo->prepare($sql_update);
    $stmt_update->execute([$jumlah, $idbrg]);

    header('Location: ./index.php?pages=output');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Input Barang Keluar</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h1>Input Barang Keluar</h1>

        <form method="POST">
            <div class="form-group">
                <label for="idbrg">Barang</label>
                <select name="idbrg" class="form-control" required>
                    <option value="">Pilih Barang</option>
                    <?php
                    $sql_barang = "SELECT * FROM barang";
                    $barangs = $pdo->query($sql_barang)->fetchAll(PDO::FETCH_ASSOC);
                    ?>
                    <?php foreach ($barangs as $barang): ?>
                        <option value="<?php echo $barang['idbrg']; ?>"><?php echo $barang['namabrg']; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <label for="tgl">Tanggal</label>
                <input type="date" name="tgl" class="form-control" id="tgl" required>
            </div>
            <div class="form-group">
                <label for="jumlah">Jumlah</label>
                <input type="number" name="jumlah" class="form-control" id="jumlah" required>
            </div>
            <button type="submit" name="add_barang_keluar" class="btn btn-primary">Tambah Barang Keluar</button>
            <a href="./index.php?pages=output" class="btn btn-secondary">Kembali</a>
        </form>
    </div>
</body>
</html>
