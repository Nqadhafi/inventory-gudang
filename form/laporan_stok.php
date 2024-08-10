<?php
require '../vendor/autoload.php'; // Pastikan path ini benar jika menggunakan composer

use Dompdf\Dompdf;
use Dompdf\Options;

include '../config.php';

// Mengambil semua data barang
$sql = "SELECT * FROM barang";
$barangs = $pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);

$options = new Options();
$options->set('isRemoteEnabled', true);
$dompdf = new Dompdf($options);

// Generate HTML untuk laporan
$html = '<h1 style="text-align: center;">Laporan Stok Barang</h1>';
$html .= '<table border="1" width="100%" style="border-collapse: collapse; text-align: center;">';
$html .= '<thead>';
$html .= '<tr>';
$html .= '<th>No</th>';
$html .= '<th>ID Barang</th>';
$html .= '<th>Nama Barang</th>';
$html .= '<th>Stok Awal</th>';
$html .= '<th>Stok Masuk</th>';
$html .= '<th>Stok Keluar</th>';
$html .= '<th>Stok Akhir</th>';
$html .= '</tr>';
$html .= '</thead>';
$html .= '<tbody>';

$no = 1;
foreach ($barangs as $barang) {
    // Menghitung stok masuk untuk barang ini
    $sqlMasuk = "SELECT SUM(jumlah) as total_masuk FROM barang_masuk WHERE idbrg = ?";
    $stmtMasuk = $pdo->prepare($sqlMasuk);
    $stmtMasuk->execute([$barang['idbrg']]);
    $stokMasuk = $stmtMasuk->fetch(PDO::FETCH_ASSOC)['total_masuk'] ?: 0;

    // Menghitung stok keluar untuk barang ini
    $sqlKeluar = "SELECT SUM(jumlah) as total_keluar FROM barang_keluar WHERE idbrg = ?";
    $stmtKeluar = $pdo->prepare($sqlKeluar);
    $stmtKeluar->execute([$barang['idbrg']]);
    $stokKeluar = $stmtKeluar->fetch(PDO::FETCH_ASSOC)['total_keluar'] ?: 0;

    // Menghitung stok akhir
    $stokAkhir = $barang['stock_awal'] + $stokMasuk - $stokKeluar;

    $html .= '<tr>';
    $html .= '<td>' . $no++ . '</td>';
    $html .= '<td>' . htmlspecialchars($barang['idbrg']) . '</td>';
    $html .= '<td>' . htmlspecialchars($barang['namabrg']) . '</td>';
    $html .= '<td>' . htmlspecialchars($barang['stock_awal']) . '</td>';
    $html .= '<td>' . htmlspecialchars($stokMasuk) . '</td>';
    $html .= '<td>' . htmlspecialchars($stokKeluar) . '</td>';
    $html .= '<td>' . htmlspecialchars($stokAkhir) . '</td>';
    $html .= '</tr>';
}

$html .= '</tbody>';
$html .= '</table>';

// Load HTML ke DOMPDF
$dompdf->loadHtml($html);

// Set ukuran dan orientasi halaman
$dompdf->setPaper('A4', 'portrait');

// Render PDF
$dompdf->render();

// Kirimkan output PDF ke browser
$dompdf->stream("laporan_stok_barang.pdf", ["Attachment" => false]);
