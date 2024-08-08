<?php
include './config.php';

// Cek apakah ada parameter idsupplier yang diberikan
if (isset($_GET['supplier'])) {
    $idsupplier = $_GET['supplier'];

    // Mengambil data supplier berdasarkan id
    $sql = "SELECT * FROM supplier WHERE idsupplier = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$idsupplier]);
    $supplier = $stmt->fetch(PDO::FETCH_ASSOC);

    // Jika supplier tidak ditemukan, redirect atau tampilkan pesan error
    if (!$supplier) {
        header('Location: index.php');
        exit;
    }
} else {
    header('Location: index.php');
    exit;
}

// Proses pembaruan data supplier
if (isset($_POST['update_supplier'])) {
    $nama_supp = $_POST['nama_supp'];
    $nohp = $_POST['nohp'];

    $sql = "UPDATE supplier SET nama_supp = ?, nohp = ? WHERE idsupplier = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$nama_supp, $nohp, $idsupplier]);

    header('Location: ./?pages=supplier'); // Redirect setelah berhasil update
    exit; // Hentikan eksekusi
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Supplier</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h1>Edit Supplier</h1>

        <form method="POST">
            <div class="form-group">
                <label for="nama_supp">Nama Supplier</label>
                <input type="text" name="nama_supp" class="form-control" id="nama_supp" value="<?php echo htmlspecialchars($supplier['nama_supp']); ?>" required>
            </div>
            <div class="form-group">
                <label for="nohp">No HP</label>
                <input type="text" name="nohp" class="form-control" id="nohp" value="<?php echo htmlspecialchars($supplier['nohp']); ?>" required>
            </div>
            <button type="submit" name="update_supplier" class="btn btn-primary">Update Supplier</button>
            <a href="./?pages=supplier" class="btn btn-secondary">Kembali</a>
        </form>
    </div>
</body>
</html>
