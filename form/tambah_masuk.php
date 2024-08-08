<?php
include './config.php';

// Menyimpan Barang Masuk Baru
if (isset($_POST['add_barang_masuk'])) {
    $idbrg = $_POST['idbrg'];
    $idsupplier = $_POST['idsupplier'];
    $jabatan = $_POST['jabatan'];
    $tgl = $_POST['tgl'];
    $jumlah = $_POST['jumlah'];

    $sql = "INSERT INTO barang_masuk (idbrg, idsupplier, jabatan, tgl, jumlah) VALUES (?, ?, ?, ?, ?)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$idbrg, $idsupplier, $jabatan, $tgl, $jumlah]);

    // Update stok barang
    $sql_update = "UPDATE barang SET stok = stok + ? WHERE idbrg = ?";
    $stmt_update = $pdo->prepare($sql_update);
    $stmt_update->execute([$jumlah, $idbrg]);

    header('Location: ./index.php?pages=input');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Input Barang Masuk</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h1>Input Barang Masuk</h1>

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
                <label for="idsupplier">Supplier</label>
                <select name="idsupplier" class="form-control" required>
                    <option value="">Pilih Supplier</option>
                    <?php
                    $sql_supplier = "SELECT * FROM supplier";
                    $suppliers = $pdo->query($sql_supplier)->fetchAll(PDO::FETCH_ASSOC);
                    ?>
                    <?php foreach ($suppliers as $supplier): ?>
                        <option value="<?php echo $supplier['idsupplier']; ?>"><?php echo $supplier['nama_supp']; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <label for="jabatan">Jabatan</label>
                <input type="text" name="jabatan" class="form-control" id="jabatan" required>
            </div>
            <div class="form-group">
                <label for="tgl">Tanggal</label>
                <input type="date" name="tgl" class="form-control" id="tgl" required>
            </div>
            <div class="form-group">
                <label for="jumlah">Jumlah</label>
                <input type="number" name="jumlah" class="form-control" id="jumlah" required>
            </div>
            <button type="submit" name="add_barang_masuk" class="btn btn-primary">Tambah Barang Masuk</button>
            <a href="./index.php?pages=input" class="btn btn-secondary">Kembali</a>
        </form>
    </div>
</body>
</html>
