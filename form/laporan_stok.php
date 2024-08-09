<?php
require '../vendor/autoload.php'; // Pastikan path ini benar jika menggunakan composer

use Dompdf\Dompdf;
use Dompdf\Options;

include '../config.php';

// Mengambil semua data barang
$sql = "SELECT * FROM barang";
$barangs = $pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);

// Inisialisasi DOMPDF
$options = new Options();
$options->set('isRemoteEnabled', true);
$dompdf = new Dompdf($options);

// Generate HTML untuk laporan
$html = '<h1 style="text-align: center;">Laporan Stok Barang</h1>';
$html .= '<table border="1" width="100%" style="border-collapse: collapse; text-align: center;">';
$html .= '<thead>';
$html .= '<tr>';
$html .= '<th>ID Barang</th>';
$html .= '<th>Nama Barang</th>';
$html .= '<th>Stok</th>';
$html .= '<th>Stock Awal</th>';
$html .= '<th>Rata-rata</th>';
$html .= '</tr>';
$html .= '</thead>';
$html .= '<tbody>';

foreach ($barangs as $barang) {
    $html .= '<tr>';
    $html .= '<td>' . htmlspecialchars($barang['idbrg']) . '</td>';
    $html .= '<td>' . htmlspecialchars($barang['namabrg']) . '</td>';
    $html .= '<td>' . htmlspecialchars($barang['stok']) . '</td>';
    $html .= '<td>' . htmlspecialchars($barang['stock_awal']) . '</td>';
    $html .= '<td>' . htmlspecialchars($barang['rata_rata']) . '</td>';
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
