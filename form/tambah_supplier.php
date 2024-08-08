<?php
include './config.php';

// Menyimpan Supplier Baru
if (isset($_POST['add_supplier'])) {
    $nama_supp = $_POST['nama_supp'];
    $nohp = $_POST['nohp'];

    $sql = "INSERT INTO supplier (nama_supp, nohp) VALUES (?, ?)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$nama_supp, $nohp]);

    header('Location: ./?pages=supplier');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Input Supplier</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h1>Input Supplier</h1>

        <form method="POST">
            <div class="form-group">
                <label for="nama_supp">Nama Supplier</label>
                <input type="text" name="nama_supp" class="form-control" id="nama_supp" required>
            </div>
            <div class="form-group">
                <label for="nohp">No HP</label>
                <input type="text" name="nohp" class="form-control" id="nohp" required>
            </div>
            <button type="submit" name="add_supplier" class="btn btn-primary">Tambah Supplier</button>
            <a href="?pages=supplier" class="btn btn-secondary">Kembali</a>
        </form>
    </div>
</body>
</html>
