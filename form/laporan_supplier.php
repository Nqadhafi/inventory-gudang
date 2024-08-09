<?php
require '../vendor/autoload.php'; // Pastikan path ini benar jika menggunakan composer

use Dompdf\Dompdf;
use Dompdf\Options;

include '../config.php';

// Mengambil semua supplier
$sql = "SELECT * FROM supplier";
$suppliers = $pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);

// Inisialisasi DOMPDF
$options = new Options();
$options->set('isRemoteEnabled', true);
$dompdf = new Dompdf($options);

// Generate HTML untuk laporan
$html = '<h1 style="text-align: center;">Laporan Data Supplier</h1>';
$html .= '<table border="1" width="100%" style="border-collapse: collapse; text-align: center;">';
$html .= '<thead>';
$html .= '<tr>';
$html .= '<th>ID Supplier</th>';
$html .= '<th>Nama Supplier</th>';
$html .= '<th>No HP</th>';
$html .= '</tr>';
$html .= '</thead>';
$html .= '<tbody>';

foreach ($suppliers as $supplier) {
    $html .= '<tr>';
    $html .= '<td>' . htmlspecialchars($supplier['idsupplier']) . '</td>';
    $html .= '<td>' . htmlspecialchars($supplier['nama_supp']) . '</td>';
    $html .= '<td>' . htmlspecialchars($supplier['nohp']) . '</td>';
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
$dompdf->stream("laporan_supplier.pdf", ["Attachment" => false]);
